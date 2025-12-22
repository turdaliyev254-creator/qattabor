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
                'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
        echo "✅ Admin user created: admin@qattabor.uz / admin123\n";

        // Create Test User
        User::firstOrCreate(
            ['email' => 'user@qattabor.uz'],
            [
                'name' => 'Test User',
                'email_verified_at' => now(),
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
        echo "✅ Test user created: user@qattabor.uz / user123\n\n";

        // Create comprehensive categories with multilingual names
        $categories = [
            // Food & Dining
            [
                'name' => 'Food & Restaurants',
                'icon' => '🍽️',
                'color' => '#FF6B6B',
                'subcategories' => [
                    'Fine Dining', 'Fast Food', 'Cafes & Coffee', 'Bakeries & Pastry',
                    'Traditional Food', 'Asian Cuisine', 'Italian Cuisine', 'Street Food'
                ]
            ],
            // Shopping
            [
                'name' => 'Shopping & Markets',
                'icon' => '🛒',
                'color' => '#4ECDC4',
                'subcategories' => [
                    'Shopping Malls', 'Supermarkets', 'Local Markets', 'Boutiques',
                    'Electronics Stores', 'Bookstores', 'Clothing Stores', 'Gift Shops'
                ]
            ],
            // Entertainment
            [
                'name' => 'Entertainment & Leisure',
                'icon' => '🎪',
                'color' => '#45B7D1',
                'subcategories' => [
                    'Cinemas', 'Theaters', 'Concert Halls', 'Night Clubs',
                    'Bowling Alleys', 'Amusement Parks', 'Museums', 'Art Galleries'
                ]
            ],
            // Health & Wellness
            [
                'name' => 'Health & Wellness',
                'icon' => '💊',
                'color' => '#96CEB4',
                'subcategories' => [
                    'Hospitals', 'Clinics', 'Pharmacies', 'Dental Care',
                    'Gyms & Fitness', 'Yoga Studios', 'Spa & Massage', 'Medical Labs'
                ]
            ],
            // Education
            [
                'name' => 'Education & Learning',
                'icon' => '📚',
                'color' => '#FFEAA7',
                'subcategories' => [
                    'Universities', 'Schools', 'Language Schools', 'Training Centers',
                    'Libraries', 'Kindergartens', 'Music Schools', 'Art Schools'
                ]
            ],
            // Beauty & Care
            [
                'name' => 'Beauty & Personal Care',
                'icon' => '💇',
                'color' => '#FD79A8',
                'subcategories' => [
                    'Hair Salons', 'Barber Shops', 'Beauty Salons', 'Nail Salons',
                    'Cosmetics Stores', 'Perfume Shops', 'Spa Centers', 'Tattoo Studios'
                ]
            ],
            // Sports & Recreation
            [
                'name' => 'Sports & Recreation',
                'icon' => '⚽',
                'color' => '#74B9FF',
                'subcategories' => [
                    'Sports Centers', 'Swimming Pools', 'Tennis Courts', 'Football Fields',
                    'Basketball Courts', 'Martial Arts', 'Dance Studios', 'Climbing Gyms'
                ]
            ],
            // Hotels & Accommodation
            [
                'name' => 'Hotels & Stays',
                'icon' => '🏨',
                'color' => '#A29BFE',
                'subcategories' => [
                    'Luxury Hotels', 'Budget Hotels', 'Hostels', 'Guest Houses',
                    'Apartments', 'Resorts', 'Boutique Hotels', 'Motels'
                ]
            ],
            // Transportation
            [
                'name' => 'Transportation & Travel',
                'icon' => '🚗',
                'color' => '#6C5CE7',
                'subcategories' => [
                    'Car Rentals', 'Travel Agencies', 'Bus Stations', 'Train Stations',
                    'Airports', 'Taxi Services', 'Auto Services', 'Parking Lots'
                ]
            ],
            // Parks & Nature
            [
                'name' => 'Parks & Nature',
                'icon' => '🌳',
                'color' => '#00B894',
                'subcategories' => [
                    'City Parks', 'National Parks', 'Botanical Gardens', 'Zoos',
                    'Aquariums', 'Nature Reserves', 'Picnic Areas', 'Walking Trails'
                ]
            ],
            // Religious Places
            [
                'name' => 'Religious Places',
                'icon' => '🕌',
                'color' => '#FDCB6E',
                'subcategories' => [
                    'Mosques', 'Churches', 'Temples', 'Synagogues',
                    'Religious Centers', 'Pilgrimage Sites', 'Monasteries', 'Prayer Rooms'
                ]
            ],
            // Financial Services
            [
                'name' => 'Banks & Finance',
                'icon' => '🏦',
                'color' => '#0984E3',
                'subcategories' => [
                    'Banks', 'ATMs', 'Exchange Offices', 'Insurance Companies',
                    'Investment Firms', 'Credit Unions', 'Financial Advisors', 'Loan Offices'
                ]
            ],
            // Professional Services
            [
                'name' => 'Professional Services',
                'icon' => '💼',
                'color' => '#2D3436',
                'subcategories' => [
                    'Law Firms', 'Accounting Services', 'Real Estate', 'Consulting',
                    'Translation Services', 'Marketing Agencies', 'IT Services', 'Architects'
                ]
            ],
            // Automotive
            [
                'name' => 'Automotive Services',
                'icon' => '🔧',
                'color' => '#636E72',
                'subcategories' => [
                    'Car Repair', 'Car Wash', 'Auto Parts', 'Tire Services',
                    'Oil Change', 'Car Dealerships', 'Motorcycle Shops', 'Towing Services'
                ]
            ],
            // Home & Garden
            [
                'name' => 'Home & Garden',
                'icon' => '🏡',
                'color' => '#55EFC4',
                'subcategories' => [
                    'Furniture Stores', 'Home Decor', 'Garden Centers', 'Hardware Stores',
                    'Appliance Stores', 'Lighting Stores', 'Florists', 'Home Improvement'
                ]
            ],
            // Pet Services
            [
                'name' => 'Pet Services',
                'icon' => '🐾',
                'color' => '#FF7675',
                'subcategories' => [
                    'Veterinary Clinics', 'Pet Stores', 'Pet Grooming', 'Dog Training',
                    'Animal Shelters', 'Pet Hotels', 'Pet Food Stores', 'Aquarium Shops'
                ]
            ],
            // Technology
            [
                'name' => 'Technology & Electronics',
                'icon' => '💻',
                'color' => '#00CEC9',
                'subcategories' => [
                    'Computer Stores', 'Mobile Shops', 'Tech Repair', 'Gaming Stores',
                    'Camera Shops', 'Software Companies', 'Internet Cafes', 'Electronics Repair'
                ]
            ],
            // Events & Venues
            [
                'name' => 'Events & Venues',
                'icon' => '🎉',
                'color' => '#FAB1A0',
                'subcategories' => [
                    'Wedding Venues', 'Conference Centers', 'Banquet Halls', 'Event Planners',
                    'Party Supplies', 'Catering Services', 'Photo Studios', 'Sound & Lighting'
                ]
            ],
        ];

        echo "📂 Creating categories and subcategories...\n";
        foreach ($categories as $categoryData) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryData['name'])],
                [
                    'name' => $categoryData['name'],
                    'slug' => Str::slug($categoryData['name']),
                    'icon' => $categoryData['icon'],
                    'color' => $categoryData['color'],
                ]
            );
            
            echo "  ✓ {$category->icon} {$category->name}\n";

            // Create subcategories
            foreach ($categoryData['subcategories'] as $subName) {
                Subcategory::firstOrCreate(
                    [
                        'slug' => Str::slug($subName),
                        'category_id' => $category->id
                    ],
                    [
                        'name' => $subName,
                        'slug' => Str::slug($subName),
                        'category_id' => $category->id,
                    ]
                );
            }
        }

        echo "\n✅ Created " . Category::count() . " categories\n";
        echo "✅ Created " . Subcategory::count() . " subcategories\n\n";

        // Create Locations
        echo "📍 Creating locations...\n";
        $this->call(LocationSeeder::class);

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
