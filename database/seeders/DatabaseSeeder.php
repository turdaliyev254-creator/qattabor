<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Regular User
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Food & Drink', 'icon' => '🍔', 'color' => '#F59E0B'],
            ['name' => 'Hotels', 'icon' => '🏨', 'color' => '#3B82F6'],
            ['name' => 'Entertainment', 'icon' => '🎭', 'color' => '#8B5CF6'],
            ['name' => 'Shopping', 'icon' => '🛍️', 'color' => '#EC4899'],
            ['name' => 'Parks', 'icon' => '🌳', 'color' => '#10B981'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'icon' => $cat['icon'],
                'color' => $cat['color'],
            ]);
        }

        // Create Locations
        $locations = ['Tashkent', 'Samarkand', 'Bukhara', 'Khiva', 'Fergana'];
        foreach ($locations as $loc) {
            Location::create([
                'name' => $loc,
                'slug' => Str::slug($loc),
            ]);
        }

        // Create Places
        $foodCategory = Category::where('name', 'Food & Drink')->first();
        $hotelCategory = Category::where('name', 'Hotels')->first();
        $tashkent = Location::where('name', 'Tashkent')->first();
        $samarkand = Location::where('name', 'Samarkand')->first();

        Place::create([
            'category_id' => $foodCategory->id,
            'location_id' => $tashkent->id,
            'name' => 'Osh Markazi',
            'slug' => 'osh-markazi',
            'description' => 'Best Plov center in the city.',
            'address' => '1, Iftikhor street, Tashkent',
            'is_popular' => true,
            'is_featured' => true,
            'image_url' => 'https://images.unsplash.com/photo-1626202158825-63a27c4e5974?q=80&w=2940&auto=format&fit=crop',
        ]);

        Place::create([
            'category_id' => $hotelCategory->id,
            'location_id' => $samarkand->id,
            'name' => 'Registan Plaza',
            'slug' => 'registan-plaza',
            'description' => 'Luxury hotel near Registan square.',
            'address' => '53, Shohrukh street, Samarkand',
            'is_popular' => true,
            'is_featured' => false,
            'image_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2940&auto=format&fit=crop',
        ]);
    }
}
