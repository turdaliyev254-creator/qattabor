<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $aboutUs = Setting::get('about_us', [
            'en' => '',
            'uz' => '',
            'ru' => ''
        ]);

        $contact = Setting::get('contact', [
            'phone' => '',
            'email' => '',
            'address_en' => '',
            'address_uz' => '',
            'address_ru' => '',
            'facebook' => '',
            'instagram' => '',
            'telegram' => ''
        ]);

        $news = Setting::get('news', [
            'en' => '',
            'uz' => '',
            'ru' => ''
        ]);

        $telegramBot = Setting::where('key', 'telegram_bot')->value('value') ?? 'qattabor_bot';

        return view('admin.settings.index', compact('aboutUs', 'contact', 'news', 'telegramBot'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'about_us_en' => 'nullable|string',
            'about_us_uz' => 'nullable|string',
            'about_us_ru' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_address_en' => 'nullable|string',
            'contact_address_uz' => 'nullable|string',
            'contact_address_ru' => 'nullable|string',
            'contact_facebook' => 'nullable|url',
            'contact_instagram' => 'nullable|url',
            'contact_telegram' => 'nullable|url',
            'news_en' => 'nullable|string',
            'news_uz' => 'nullable|string',
            'news_ru' => 'nullable|string',
            'telegram_bot' => 'nullable|string',
        ]);

        // Save About Us
        Setting::set('about_us', [
            'en' => $request->about_us_en,
            'uz' => $request->about_us_uz,
            'ru' => $request->about_us_ru,
        ]);

        // Save Contact
        Setting::set('contact', [
            'phone' => $request->contact_phone,
            'email' => $request->contact_email,
            'address_en' => $request->contact_address_en,
            'address_uz' => $request->contact_address_uz,
            'address_ru' => $request->contact_address_ru,
            'facebook' => $request->contact_facebook,
            'instagram' => $request->contact_instagram,
            'telegram' => $request->contact_telegram,
        ]);

        // Save News
        Setting::set('news', [
            'en' => $request->news_en,
            'uz' => $request->news_uz,
            'ru' => $request->news_ru,
        ]);

        // Save Telegram Bot
        Setting::updateOrCreate(
            ['key' => 'telegram_bot'],
            ['value' => $request->telegram_bot ?? 'qattabor_bot']
        );

        return redirect()->route('admin.settings.index')
            ->with('success', __('Settings updated successfully'));
    }
}
