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

        // Seed Places
        echo "\n🏢 Seeding sample places...\n";
        $this->seedPlaces();

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

    private function seedPlaces()
    {
        $tashkentRegion = \App\Models\Region::where('name', 'Tashkent City')->first();
        if (!$tashkentRegion) {
            echo "⚠️  Tashkent region not found, skipping places seeding\n";
            return;
        }

        $tashkentCity = Location::where('region_id', $tashkentRegion->id)->first();
        if (!$tashkentCity) {
            echo "⚠️  Tashkent city not found, skipping places seeding\n";
            return;
        }

        $restaurantCategory = Category::where('slug', 'restaurants')->first();
        $supermarketCategory = Category::where('slug', 'supermarkets')->first();
        $hotelCategory = Category::where('slug', 'hotels')->first();
        $healthCategory = Category::where('slug', 'health')->first();

        $places = [];

        // Restaurants
        if ($restaurantCategory) {
            $cafeSubcategory = Subcategory::where('category_id', $restaurantCategory->id)->where('slug', 'cafe')->first();
            $fastFoodSubcategory = Subcategory::where('category_id', $restaurantCategory->id)->where('slug', 'fast-food')->first();
            
            $places = array_merge($places, [
                [
                    'name' => 'Choyhona Samarkand',
                    'slug' => 'choyhona-samarkand',
                    'description' => 'Traditional Uzbek restaurant with authentic national cuisine',
                    'category_id' => $restaurantCategory->id,
                    'subcategory_id' => $cafeSubcategory?->id,
                    'location_id' => $tashkentCity->id,
                    'address' => 'Amir Temur street, 15',
                    'phone' => '+998712345678',
                    'working_hours' => '09:00-23:00',
                    'rating' => 4.5,
                    'is_popular' => true,
                    'latitude' => 41.311151,
                    'longitude' => 69.279737,
                ],
                [
                    'name' => 'Bella Italia',
                    'slug' => 'bella-italia',
                    'description' => 'Italian restaurant with pizza and pasta',
                    'category_id' => $restaurantCategory->id,
                    'subcategory_id' => null,
                    'location_id' => $tashkentCity->id,
                    'address' => 'Mustaqillik street, 28',
                    'phone' => '+998712345679',
                    'working_hours' => '10:00-22:00',
                    'rating' => 4.3,
                    'is_popular' => true,
                    'latitude' => 41.315151,
                    'longitude' => 69.289737,
                ],
                [
                    'name' => 'Burger House',
                    'slug' => 'burger-house',
                    'description' => 'Fast food restaurant with burgers and fries',
                    'category_id' => $restaurantCategory->id,
                    'subcategory_id' => $fastFoodSubcategory?->id,
                    'location_id' => $tashkentCity->id,
                    'address' => 'Shota Rustaveli street, 45',
                    'phone' => '+998712345680',
                    'working_hours' => '24/7',
                    'rating' => 4.0,
                    'is_popular' => false,
                    'latitude' => 41.320151,
                    'longitude' => 69.285737,
                ],
            ]);
        }

        // Supermarkets
        if ($supermarketCategory) {
            $places = array_merge($places, [
                [
                    'name' => 'Korzinka Market',
                    'slug' => 'korzinka-market',
                    'description' => 'Large supermarket with fresh products and groceries',
                    'category_id' => $supermarketCategory->id,
                    'subcategory_id' => null,
                    'location_id' => $tashkentCity->id,
                    'address' => 'Bobur street, 12',
                    'phone' => '+998712345681',
                    'working_hours' => '08:00-23:00',
                    'rating' => 4.4,
                    'is_popular' => true,
                    'latitude' => 41.308151,
                    'longitude' => 69.275737,
                ],
                [
                    'name' => 'Makro Market',
                    'slug' => 'makro-market',
                    'description' => 'Wholesale and retail supermarket',
                    'category_id' => $supermarketCategory->id,
                    'subcategory_id' => null,
                    'location_id' => $tashkentCity->id,
                    'address' => 'Chilonzor district',
                    'phone' => '+998712345682',
                    'working_hours' => '08:00-22:00',
                    'rating' => 4.2,
                    'is_popular' => false,
                    'latitude' => 41.285151,
                    'longitude' => 69.225737,
                ],
            ]);
        }

        // Hotels
        if ($hotelCategory) {
            $places = array_merge($places, [
                [
                    'name' => 'Grand Hotel Tashkent',
                    'slug' => 'grand-hotel-tashkent',
                    'description' => 'Luxury 5-star hotel in the city center',
                    'category_id' => $hotelCategory->id,
                    'subcategory_id' => null,
                    'location_id' => $tashkentCity->id,
                    'address' => 'Islam Karimov street, 1',
                    'phone' => '+998712345683',
                    'working_hours' => '24/7',
                    'rating' => 4.8,
                    'is_popular' => true,
                    'latitude' => 41.316151,
                    'longitude' => 69.278737,
                ],
            ]);
        }

        // Health
        if ($healthCategory) {
            $places = array_merge($places, [
                [
                    'name' => 'Medion Clinic',
                    'slug' => 'medion-clinic',
                    'description' => 'Modern medical clinic with experienced doctors',
                    'category_id' => $healthCategory->id,
                    'subcategory_id' => null,
                    'location_id' => $tashkentCity->id,
                    'address' => 'Amir Temur street, 107',
                    'phone' => '+998712345684',
                    'working_hours' => '08:00-20:00',
                    'rating' => 4.6,
                    'is_popular' => true,
                    'latitude' => 41.313151,
                    'longitude' => 69.281737,
                ],
                [
                    'name' => 'Dorixona 36.6',
                    'slug' => 'dorixona-36-6',
                    'description' => '24/7 pharmacy with wide range of medications',
                    'category_id' => $healthCategory->id,
                    'subcategory_id' => null,
                    'location_id' => $tashkentCity->id,
                    'address' => 'Buyuk Ipak Yoli, 88',
                    'phone' => '+998712345685',
                    'working_hours' => '24/7',
                    'rating' => 4.1,
                    'is_popular' => false,
                    'latitude' => 41.305151,
                    'longitude' => 69.290737,
                ],
            ]);
        }

        foreach ($places as $placeData) {
            Place::create($placeData);
            echo "  ✓ {$placeData['name']}\n";
        }

        echo "✅ Created " . count($places) . " sample places\n";
    }
}
