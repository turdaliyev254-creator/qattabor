<?php
/**
 * cPanel Storage Link Creator
 * 
 * Upload this file to your Laravel root directory
 * Then visit: https://your-domain.com/create-storage-link.php
 * 
 * This will create the storage symlink without needing SSH access
 */

echo '<!DOCTYPE html><html><head><title>Storage Link Creator</title>';
echo '<style>body{font-family:Arial,sans-serif;max-width:800px;margin:50px auto;padding:20px;}';
echo '.success{color:#22c55e;background:#f0fdf4;padding:15px;border-radius:8px;margin:10px 0;}';
echo '.error{color:#ef4444;background:#fef2f2;padding:15px;border-radius:8px;margin:10px 0;}';
echo '.info{color:#3b82f6;background:#eff6ff;padding:15px;border-radius:8px;margin:10px 0;}';
echo 'pre{background:#f3f4f6;padding:15px;border-radius:8px;overflow-x:auto;}';
echo '</style></head><body>';

echo '<h1>🔗 QattaBor Storage Link Creator</h1>';

// Check if we're in Laravel root
if (!file_exists('artisan')) {
    echo '<div class="error">❌ ERROR: This file must be in your Laravel root directory!</div>';
    echo '<p>Current directory: ' . __DIR__ . '</p>';
    exit;
}

echo '<div class="info">📁 Laravel root detected: ' . __DIR__ . '</div>';

// Check if public/storage already exists
$publicStorage = __DIR__ . '/public/storage';
$targetPath = __DIR__ . '/storage/app/public';

echo '<h2>Current Status:</h2>';

// Check public/storage
if (is_link($publicStorage)) {
    echo '<div class="success">✅ Symlink exists</div>';
    echo '<p>Target: ' . readlink($publicStorage) . '</p>';
} elseif (is_dir($publicStorage)) {
    echo '<div class="error">⚠️ public/storage exists as directory (not symlink)</div>';
} else {
    echo '<div class="info">ℹ️ public/storage does not exist</div>';
}

// Check target directory
if (is_dir($targetPath)) {
    echo '<div class="success">✅ storage/app/public exists</div>';
    
    // Count files in banners
    $bannersPath = $targetPath . '/banners';
    if (is_dir($bannersPath)) {
        $files = array_diff(scandir($bannersPath), ['.', '..']);
        echo '<p>Banner files found: ' . count($files) . '</p>';
        echo '<ul>';
        foreach ($files as $file) {
            echo '<li>' . htmlspecialchars($file) . '</li>';
        }
        echo '</ul>';
    }
} else {
    echo '<div class="error">❌ storage/app/public does not exist!</div>';
}

// Action
echo '<h2>Action:</h2>';

if (isset($_GET['create'])) {
    echo '<div class="info">🔨 Attempting to create symlink...</div>';
    
    // Remove existing if it's a directory
    if (is_dir($publicStorage) && !is_link($publicStorage)) {
        echo '<p>Removing existing directory...</p>';
        // Backup if has content
        if (count(scandir($publicStorage)) > 2) {
            rename($publicStorage, $publicStorage . '_backup_' . time());
            echo '<p>✅ Existing directory backed up</p>';
        } else {
            rmdir($publicStorage);
            echo '<p>✅ Empty directory removed</p>';
        }
    }
    
    // Create symlink
    if (!file_exists($publicStorage)) {
        if (symlink($targetPath, $publicStorage)) {
            echo '<div class="success">✅ SUCCESS! Storage symlink created!</div>';
            echo '<p>From: ' . $publicStorage . '</p>';
            echo '<p>To: ' . $targetPath . '</p>';
            echo '<p><a href="/">← Go to homepage</a></p>';
        } else {
            echo '<div class="error">❌ Failed to create symlink</div>';
            echo '<p>You may need to use SSH or contact your hosting support.</p>';
            echo '<h3>Alternative Solution:</h3>';
            echo '<p>Manually copy files:</p>';
            echo '<pre>FROM: storage/app/public/*
TO: public/storage/</pre>';
        }
    } else {
        echo '<div class="error">❌ public/storage already exists!</div>';
    }
    
} else {
    if (!is_link($publicStorage)) {
        echo '<p><a href="?create=1" style="display:inline-block;background:#3b82f6;color:white;padding:15px 30px;text-decoration:none;border-radius:8px;font-weight:bold;">🔗 Create Storage Link Now</a></p>';
    } else {
        echo '<div class="success">✅ Storage link is already set up correctly!</div>';
        echo '<p><a href="/">← Go to homepage</a></p>';
    }
    
    echo '<h3>Manual Instructions:</h3>';
    echo '<p>If the automatic method fails, run this in cPanel Terminal:</p>';
    echo '<pre>cd ' . __DIR__ . '
php artisan storage:link</pre>';
}

// Security warning
echo '<hr>';
echo '<div class="error"><strong>⚠️ SECURITY WARNING:</strong><br>';
echo 'Delete this file after use! Run: <code>rm create-storage-link.php</code></div>';

echo '</body></html>';
