<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendTelegramBroadcast;
use App\Models\Region;
use App\Models\TelegramBroadcast;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TelegramBroadcastController extends Controller
{
    public function index()
    {
        $broadcasts = TelegramBroadcast::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_users' => User::whereNotNull('telegram_chat_id')->count(),
            'verified_users' => User::where('is_telegram_verified', true)->count(),
            'total_broadcasts' => TelegramBroadcast::count(),
            'completed_broadcasts' => TelegramBroadcast::where('status', 'completed')->count(),
        ];

        return view('admin.telegram.index', compact('broadcasts', 'stats'));
    }

    public function create()
    {
        $regions = Region::active()->ordered()->get();
        return view('admin.telegram.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required|string|max:1000',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:20480',
            'target_regions' => 'required|array',
            'target_regions.*' => 'string',
            'links.tg' => 'nullable|string|max:255',
            'links.inst' => 'nullable|string|max:255',
            'links.fb' => 'nullable|string|max:255',
            'links.yt' => 'nullable|string|max:255',
            'links.tel' => 'nullable|string|max:255',
            'links.web' => 'nullable|string|max:255',
        ]);

        $mediaType = 'text';
        $mediaFileId = null;

        // Handle media upload
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $extension = $file->getClientOriginalExtension();
            
            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $mediaType = 'photo';
            } elseif (in_array($extension, ['mp4', 'mov'])) {
                $mediaType = 'video';
            }

            // Store temporarily, we'll get file_id from Telegram on first send
            $path = $file->store('telegram/temp', 'public');
        }

        // Filter out empty links
        $links = array_filter($request->input('links', []), function($value) {
            return !empty($value);
        });

        $broadcast = TelegramBroadcast::create([
            'created_by' => auth()->id(),
            'media_type' => $mediaType,
            'caption' => $request->caption,
            'target_regions' => $request->target_regions,
            'links' => $links,
            'status' => 'draft',
        ]);

        // Store temp media path in session for the job to access
        if (isset($path)) {
            session(['broadcast_' . $broadcast->id . '_media_path' => $path]);
        }

        return redirect()
            ->route('admin.telegram.show', $broadcast)
            ->with('success', __('Broadcast created successfully'));
    }

    public function show(TelegramBroadcast $broadcast)
    {
        $broadcast->load('creator');
        
        // Get target user count
        $query = User::whereNotNull('telegram_chat_id')->where('is_telegram_verified', true);
        
        if (!in_array('all', $broadcast->target_regions ?? [])) {
            $query->whereIn('telegram_region_id', $broadcast->target_regions);
        }
        
        $targetUserCount = $query->count();

        return view('admin.telegram.show', compact('broadcast', 'targetUserCount'));
    }

    public function send(TelegramBroadcast $broadcast)
    {
        if ($broadcast->status !== 'draft') {
            return redirect()
                ->back()
                ->with('error', __('Only draft broadcasts can be sent'));
        }

        // Check if there's a temporary media file
        $mediaPath = session('broadcast_' . $broadcast->id . '_media_path');
        
        if ($mediaPath && $broadcast->media_type !== 'text') {
            // Upload to Telegram first to get file_id
            $telegram = new TelegramService();
            $adminChatId = config('services.telegram.admin_chat_id');
            
            $fullPath = Storage::disk('public')->path($mediaPath);
            
            if ($broadcast->media_type === 'photo') {
                $fileId = $telegram->sendPhoto($adminChatId, new \Illuminate\Http\File($fullPath), 'Test upload');
            } elseif ($broadcast->media_type === 'video') {
                $fileId = $telegram->sendVideo($adminChatId, new \Illuminate\Http\File($fullPath), 'Test upload');
            }
            
            if ($fileId && is_string($fileId)) {
                $broadcast->update(['media_file_id' => $fileId]);
            }
            
            // Clean up temp file
            Storage::disk('public')->delete($mediaPath);
            session()->forget('broadcast_' . $broadcast->id . '_media_path');
        }

        // Dispatch job
        SendTelegramBroadcast::dispatch($broadcast);

        return redirect()
            ->route('admin.telegram.index')
            ->with('success', __('Broadcast is being sent'));
    }

    public function destroy(TelegramBroadcast $broadcast)
    {
        if ($broadcast->status === 'sending') {
            return redirect()
                ->back()
                ->with('error', __('Cannot delete a broadcast that is being sent'));
        }

        $broadcast->delete();

        return redirect()
            ->route('admin.telegram.index')
            ->with('success', __('Broadcast deleted successfully'));
    }

    public function statistics()
    {
        $usersByRegion = User::whereNotNull('telegram_chat_id')
            ->where('is_telegram_verified', true)
            ->join('regions', 'users.telegram_region_id', '=', 'regions.id')
            ->selectRaw('regions.name, regions.name_uz, regions.name_ru, regions.name_en, COUNT(*) as count')
            ->groupBy('regions.id', 'regions.name', 'regions.name_uz', 'regions.name_ru', 'regions.name_en')
            ->get();

        $recentBroadcasts = TelegramBroadcast::where('status', 'completed')
            ->orderBy('sent_at', 'desc')
            ->limit(10)
            ->get();

        $totalSent = TelegramBroadcast::where('status', 'completed')->sum('sent_count');
        $totalFailed = TelegramBroadcast::where('status', 'completed')->sum('failed_count');

        return view('admin.telegram.statistics', compact('usersByRegion', 'recentBroadcasts', 'totalSent', 'totalFailed'));
    }

    public function webhook()
    {
        $telegram = new TelegramService();
        $webhookInfo = $telegram->getWebhookInfo();

        return view('admin.telegram.webhook', compact('webhookInfo'));
    }

    public function setWebhook(Request $request)
    {
        $request->validate([
            'webhook_url' => 'required|url',
        ]);

        $telegram = new TelegramService();
        $success = $telegram->setWebhook($request->webhook_url);

        if ($success) {
            return redirect()
                ->back()
                ->with('success', __('Webhook set successfully'));
        }

        return redirect()
            ->back()
            ->with('error', __('Failed to set webhook'));
    }
}
