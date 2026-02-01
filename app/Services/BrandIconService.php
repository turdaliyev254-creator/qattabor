<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BrandIconService
{
    protected $manager;
    protected $storageDirectory = 'images/brands';

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Upload and process brand icon
     * 
     * @param UploadedFile $file
     * @return string filename
     */
    public function upload(UploadedFile $file): string
    {
        $mimeType = $file->getMimeType();
        $extension = $file->getClientOriginalExtension();
        
        // Generate unique filename
        $filename = time() . '_' . Str::random(10) . '.' . $extension;
        
        // Create directory if it doesn't exist
        $publicPath = public_path($this->storageDirectory);
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true);
        }
        
        $destinationPath = $publicPath . '/' . $filename;
        
        // Handle SVG files - just copy them as-is
        if ($mimeType === 'image/svg+xml' || $extension === 'svg') {
            $file->move($publicPath, $filename);
            return $filename;
        }
        
        // For PNG and JPG/JPEG - resize to 512x512
        try {
            $image = $this->manager->read($file->getPathname());
            
            // Resize and crop to 512x512 (cover mode)
            $image->cover(512, 512);
            
            // Save the processed image
            $image->save($destinationPath);
            
            return $filename;
        } catch (\Exception $e) {
            // Fallback: if intervention fails, just move the file
            $file->move($publicPath, $filename);
            return $filename;
        }
    }

    /**
     * Delete brand icon file
     * 
     * @param string $filename
     * @return bool
     */
    public function delete(string $filename): bool
    {
        $filePath = public_path($this->storageDirectory . '/' . $filename);
        
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        
        return false;
    }

    /**
     * Get the public URL for the icon
     * 
     * @param string $filename
     * @return string
     */
    public function getUrl(string $filename): string
    {
        return asset($this->storageDirectory . '/' . $filename);
    }

    /**
     * Check if icon file exists
     * 
     * @param string $filename
     * @return bool
     */
    public function exists(string $filename): bool
    {
        return file_exists(public_path($this->storageDirectory . '/' . $filename));
    }
}
