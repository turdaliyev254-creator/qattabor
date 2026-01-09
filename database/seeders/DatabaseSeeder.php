<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Location;
use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        echo "🌱 Starting database seeding...\n\n";

        // Seed Regions and Locations
        echo "📍 Seeding regions and locations...\n";
        $this->call(LocationSeeder::class);

        // Seed Categories
        echo "\n📂 Seeding categories...\n";
        $this->seedCategories();

        // Seed Banners
        echo "\n🎨 Seeding banners...\n";
        $this->call(BannerSeeder::class);

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@qattabor.uz'],
            [
                'name' => 'Izzatillo',
                'phone' => '+998999139757',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
        echo "✅ Admin user created: admin@qattabor.uz / admin123\n";

        // Create Test User
        $user = User::firstOrCreate(
            ['email' => 'user@qattabor.uz'],
            [
                'name' => 'Test User',
                'email_verified_at' => now(),
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
        echo "✅ Test user created: user@qattabor.uz / user123\n\n";

        echo "\n🎉 Database seeding completed successfully!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "🔐 Admin Login:\n";
        echo "   Email: admin@qattabor.uz\n";
        echo "   Password: admin123\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "🌐 Access: http://127.0.0.1:8000/admin\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }

    private function seedCategories()
    {
        $categories = [
            ['name' => 'Furniture', 'slug' => 'furniture', 'icon' => 'sofa.png'],
            ['name' => 'Supermarkets', 'slug' => 'supermarkets', 'icon' => 'supermarket.png'],
            ['name' => 'Hotels', 'slug' => 'hotels', 'icon' => 'hotel.png'],
            ['name' => 'Restaurants', 'slug' => 'restaurants', 'icon' => 'dining-plate.png'],
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'icon' => 'playground.png'],
            ['name' => 'Beauty & Spa', 'slug' => 'beauty-spa', 'icon' => 'barbershop-and-beauty-salon.png'],
            ['name' => 'Tourism', 'slug' => 'tourism', 'icon' => 'mountain-hut.png'],
            ['name' => 'Services', 'slug' => 'services', 'icon' => 'car.png'],
            ['name' => 'Health', 'slug' => 'health', 'icon' => 'spa.png'],
            ['name' => 'Photo & Video', 'slug' => 'photo-video', 'icon' => 'camera.png'],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);
            echo "  ✓ {$category->name}\n";

            // Add subcategories for some categories
            if ($category->slug === 'restaurants') {
                $subcategories = [
                    ['name' => 'Fast Food', 'slug' => 'fast-food', 'icon' => '🍔'],
                    ['name' => 'Cafe', 'slug' => 'cafe', 'icon' => '☕'],
                    ['name' => 'Fine Dining', 'slug' => 'fine-dining', 'icon' => '🍽️'],
                ];
                foreach ($subcategories as $subData) {
                    $subData['category_id'] = $category->id;
                    Subcategory::create($subData);
                }
            } elseif ($category->slug === 'hotels') {
                $subcategories = [
                    ['name' => 'Hotels', 'slug' => 'hotels', 'icon' => '🏨'],
                    ['name' => 'Hostels', 'slug' => 'hostels', 'icon' => '🏠'],
                    ['name' => 'Resorts', 'slug' => 'resorts', 'icon' => '🏖️'],
                ];
                foreach ($subcategories as $subData) {
                    $subData['category_id'] = $category->id;
                    Subcategory::create($subData);
                }
            }
        }
    }
}
