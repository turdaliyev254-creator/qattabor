<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Facades\Artisan;

class DiagnosticsController extends Controller
{
    public function checkBanners()
    {
        $output = '<!DOCTYPE html><html><head><title>Banner Diagnostics</title>';
        $output .= '<style>body{font-family:Arial,sans-serif;max-width:1000px;margin:20px auto;padding:20px;}';
        $output .= 'h1{color:#4f46e5;}h2{color:#6366f1;border-bottom:2px solid #e0e7ff;padding-bottom:10px;}';
        $output .= '.success{color:#22c55e;background:#f0fdf4;padding:10px;border-radius:5px;margin:10px 0;}';
        $output .= '.error{color:#ef4444;background:#fef2f2;padding:10px;border-radius:5px;margin:10px 0;}';
        $output .= '.info{color:#3b82f6;background:#eff6ff;padding:10px;border-radius:5px;margin:10px 0;}';
        $output .= 'img{max-width:300px;border:1px solid #ddd;margin:10px 0;}</style></head><body>';
        
        $output .= '<h1>🔍 QattaBor Banner Diagnostics</h1>';
        
        // Check storage link
        $storageLinkExists = is_link(public_path('storage'));
        $output .= '<h2>1. Storage Symlink Status</h2>';
        
        if ($storageLinkExists) {
            $output .= '<div class="success">✅ public/storage symlink EXISTS</div>';
            $output .= '<p><strong>Target:</strong> ' . readlink(public_path('storage')) . '</p>';
        } else {
            $output .= '<div class="error">❌ public/storage symlink MISSING!</div>';
            $output .= '<p><strong>Fix:</strong> Run <code>php artisan storage:link</code> on your server</p>';
        }
        
        // Check banners directory
        $bannersPath = storage_path('app/public/banners');
        $output .= '<h2>2. Banners Directory</h2>';
        
        if (is_dir($bannersPath)) {
            $files = array_diff(scandir($bannersPath), ['.', '..']);
            $output .= '<div class="success">✅ storage/app/public/banners EXISTS</div>';
            $output .= '<p><strong>Files found:</strong> ' . count($files) . '</p>';
            
            if (count($files) > 0) {
                $output .= '<ul>';
                foreach ($files as $file) {
                    $fileSize = filesize($bannersPath . '/' . $file);
                    $output .= '<li>' . htmlspecialchars($file) . ' (' . number_format($fileSize / 1024, 2) . ' KB)</li>';
                }
                $output .= '</ul>';
            }
        } else {
            $output .= '<div class="error">❌ storage/app/public/banners does NOT exist!</div>';
            $output .= '<p>Create this directory and upload banner images.</p>';
        }
        
        // Check database banners
        $banners = Banner::active()->get();
        $output .= '<h2>3. Database Banners</h2>';
        $output .= '<div class="info">Active banners in database: ' . $banners->count() . '</div>';
        
        if ($banners->count() === 0) {
            $output .= '<p>No active banners found. Add banners in the admin panel at <a href="/admin/banners">/admin/banners</a></p>';
        } else {
            foreach ($banners as $index => $banner) {
                $imagePath = storage_path('app/public/' . $banner->image);
                $imageExists = file_exists($imagePath);
                $imageUrl = asset('storage/' . $banner->image);
                
                $output .= '<h3>Banner ' . ($index + 1) . ': ' . htmlspecialchars($banner->title) . '</h3>';
                $output .= '<p><strong>Database path:</strong> ' . htmlspecialchars($banner->image) . '</p>';
                $output .= '<p><strong>Full path:</strong> ' . htmlspecialchars($imagePath) . '</p>';
                $output .= '<p><strong>File exists:</strong> ' . ($imageExists ? '<span style="color:#22c55e">✅ YES</span>' : '<span style="color:#ef4444">❌ NO</span>') . '</p>';
                $output .= '<p><strong>Public URL:</strong> <a href="' . $imageUrl . '" target="_blank">' . htmlspecialchars($imageUrl) . '</a></p>';
                
                if ($imageExists && $storageLinkExists) {
                    $output .= '<p><strong>Preview:</strong></p>';
                    $output .= '<img src="' . $imageUrl . '" alt="' . htmlspecialchars($banner->title) . '">';
                } elseif (!$imageExists) {
                    $output .= '<div class="error">❌ Image file not found on server!</div>';
                } elseif (!$storageLinkExists) {
                    $output .= '<div class="error">❌ Cannot display - symlink missing!</div>';
                }
                
                $output .= '<hr>';
            }
        }
        
        // Environment info
        $output .= '<h2>4. Environment Information</h2>';
        $output .= '<p><strong>APP_URL:</strong> ' . config('app.url') . '</p>';
        $output .= '<p><strong>Laravel version:</strong> ' . app()->version() . '</p>';
        $output .= '<p><strong>PHP version:</strong> ' . PHP_VERSION . '</p>';
        $output .= '<p><strong>Server:</strong> ' . $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' . '</p>';
        
        // Quick fixes
        $output .= '<h2>5. Quick Fixes</h2>';
        
        if (!$storageLinkExists) {
            $output .= '<div class="error">';
            $output .= '<p><strong>To fix symlink issue:</strong></p>';
            $output .= '<ol>';
            $output .= '<li>SSH: <code>cd /path/to/project && php artisan storage:link</code></li>';
            $output .= '<li>cPanel Terminal: <code>php artisan storage:link</code></li>';
            $output .= '<li>Web: Upload and visit <a href="/create-storage-link.php">create-storage-link.php</a></li>';
            $output .= '</ol>';
            $output .= '</div>';
        }
        
        $output .= '<p style="margin-top:30px;"><a href="/" style="background:#4f46e5;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;">← Back to Home</a></p>';
        
        $output .= '</body></html>';
        
        return $output;
    }
    
    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        
        return "✅ All caches cleared! Refresh your website now.";
    }
}
