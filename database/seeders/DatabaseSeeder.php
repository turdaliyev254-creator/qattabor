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

        // Create Categories
        echo "📂 Creating categories...\n";
        
        $categories = [
            ['name' => 'Furniture', 'icon' => 'sofa.png'],
            ['name' => 'Supermarket', 'icon' => 'supermarket.png'],
            ['name' => 'SPA', 'icon' => 'spa.png'],
            ['name' => 'Studio', 'icon' => 'camera.png'],
            ['name' => 'Playground', 'icon' => 'playground.png'],
            ['name' => 'Car', 'icon' => 'car.png'],
            ['name' => 'Cottage', 'icon' => 'mountain-hut.png'],
            ['name' => 'Hotel', 'icon' => 'hotel.png'],
            ['name' => 'Food', 'icon' => 'dining-plate.png'],
            ['name' => 'Salon', 'icon' => 'barbershop-and-beauty-salon.png'],
            ['name' => 'Clothing', 'icon' => 'clothes-hanger.png'],
            ['name' => 'Medicine', 'icon' => 'hospital.png'],
            ['name' => 'School', 'icon' => 'school.png'],
            ['name' => 'Kindergarten', 'icon' => 'kids-playing.png'],
            ['name' => 'Sports', 'icon' => 'soccer-ball.png'],
            ['name' => 'Government organizations', 'icon' => 'building.png'],
            ['name' => 'Home appliances', 'icon' => 'home-appliances.png'],
            ['name' => 'Hobbies and creativity', 'icon' => 'workshop.png'],
            ['name' => 'Tour agency', 'icon' => 'hot-air-balloon.png'],
            ['name' => 'Electronics', 'icon' => 'laptop.png'],
            ['name' => 'Construction and repair', 'icon' => 'workshop-pegboard.png'],
            ['name' => 'Beauty and care', 'icon' => 'barbershop-and-beauty-salon.png'],
            ['name' => 'Zoo', 'icon' => 'zoo.png'],
            ['name' => 'Book', 'icon' => 'book.png'],
            ['name' => 'Real estate', 'icon' => 'house.png'],
            ['name' => 'Mosque', 'icon' => 'mosque.png'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => Str::slug($categoryData['name'])],
                [
                    'name' => $categoryData['name'],
                    'slug' => Str::slug($categoryData['name']),
                    'icon' => $categoryData['icon'],
                ]
            );
        }
        echo "✅ Created " . Category::count() . " categories\n\n";

        echo "\n🎉 Database seeding completed successfully!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "🔐 Admin Login:\n";
        echo "   Email: admin@qattabor.uz\n";
        echo "   Password: admin123\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "🌐 Access: http://127.0.0.1:8000/admin\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }
}
