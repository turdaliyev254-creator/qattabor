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

        // Create placeholder banners
        $banners = [
            [
                'title' => 'Welcome to QattaBor',
                'image' => 'banners/sample-banner-1.jpg',
                'link' => null,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Explore Categories',
                'image' => 'banners/sample-banner-2.jpg',
                'link' => route('categories.all'),
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Popular Places',
                'image' => 'banners/sample-banner-3.jpg',
                'link' => route('places.popular'),
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
