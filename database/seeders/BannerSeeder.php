<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        echo "🎨 Creating sample banners...\n";

        // Create sample banners directory if it doesn't exist
        $bannerPath = storage_path('app/public/banners');
        if (!File::exists($bannerPath)) {
            File::makeDirectory($bannerPath, 0755, true);
            echo "  ✓ Created banners directory\n";
        }

        // Get existing banner images from directory
        $existingImages = File::files($bannerPath);
        $imageFiles = array_slice($existingImages, 0, 3); // Take first 3 images

        // Create placeholder banners
        $banners = [
            [
                'title' => 'Welcome to QattaBor',
                'image' => count($imageFiles) > 0 ? 'banners/' . basename($imageFiles[0]->getPathname()) : 'banners/sample-banner-1.jpg',
                'link' => null,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Explore Categories',
                'image' => count($imageFiles) > 1 ? 'banners/' . basename($imageFiles[1]->getPathname()) : 'banners/sample-banner-2.jpg',
                'link' => null,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Popular Places',
                'image' => count($imageFiles) > 2 ? 'banners/' . basename($imageFiles[2]->getPathname()) : 'banners/sample-banner-3.jpg',
                'link' => null,
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $bannerData) {
            Banner::create($bannerData);
            echo "  ✓ {$bannerData['title']}\n";
        }

        echo "✅ Created " . count($banners) . " sample banners\n";
        echo "📝 Note: Upload actual banner images at /admin/banners\n";
    }
}
