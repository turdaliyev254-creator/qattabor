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

        // Create your original categories with icons and add subcategories
        echo "📂 Creating categories and subcategories...\n";
        
        $categories = [
            [
                'name' => 'Furniture',
                'icon' => 'sofa.png',
                'subcategories' => ['Living Room', 'Bedroom', 'Office', 'Kitchen', 'Garden', 'Kids', 'Custom Made', 'Antique']
            ],
            [
                'name' => 'Supermarket',
                'icon' => 'supermarket.png',
                'subcategories' => ['Groceries', 'Bakery', 'Dairy', 'Meat', 'Vegetables', 'Frozen Foods', 'Beverages', 'Household']
            ],
            [
                'name' => 'SPA',
                'icon' => 'spa.png',
                'subcategories' => ['Massage', 'Sauna', 'Facial', 'Body Treatment', 'Manicure', 'Pedicure', 'Hammam', 'Aromatherapy']
            ],
            [
                'name' => 'Studio',
                'icon' => 'camera.png',
                'subcategories' => ['Photo Studio', 'Video Studio', 'Recording Studio', 'Dance Studio', 'Art Studio', 'Yoga Studio', 'Pilates', 'Fitness']
            ],
            [
                'name' => 'Playground',
                'icon' => 'playground.png',
                'subcategories' => ['Kids Play', 'Indoor', 'Outdoor', 'Trampoline', 'Bouncy Castle', 'Game Zone', 'Sports Area', 'Birthday Party']
            ],
            [
                'name' => 'Car',
                'icon' => 'car.png',
                'subcategories' => ['Car Wash', 'Car Repair', 'Auto Parts', 'Tire Service', 'Oil Change', 'Car Rental', 'Dealerships', 'Parking']
            ],
            [
                'name' => 'Cottage',
                'icon' => 'mountain-hut.png',
                'subcategories' => ['Weekend Rental', 'Daily Rental', 'Events', 'With Pool', 'Mountain View', 'Lake View', 'Luxury', 'Budget']
            ],
            [
                'name' => 'Hotel',
                'icon' => 'hotel.png',
                'subcategories' => ['Luxury Hotels', 'Budget Hotels', 'Hostels', 'Guest Houses', 'Apartments', 'Resorts', 'Boutique Hotels', 'Motels']
            ],
            [
                'name' => 'Food',
                'icon' => 'dining-plate.png',
                'subcategories' => ['Restaurants', 'Fast Food', 'Cafes', 'Bakery', 'Traditional', 'Asian', 'Italian', 'Street Food']
            ],
            [
                'name' => 'Salon',
                'icon' => 'barbershop-and-beauty-salon.png',
                'subcategories' => ['Hair Salon', 'Barber Shop', 'Beauty Salon', 'Nail Salon', 'Makeup', 'Brow Studio', 'Lash Extensions', 'Tattoo']
            ],
            [
                'name' => 'Clothing',
                'icon' => 'clothes-hanger.png',
                'subcategories' => ['Men Fashion', 'Women Fashion', 'Kids Clothing', 'Sports Wear', 'Shoes', 'Accessories', 'Boutique', 'Outlet']
            ],
            [
                'name' => 'Medicine',
                'icon' => 'hospital.png',
                'subcategories' => ['Hospitals', 'Clinics', 'Pharmacies', 'Dental', 'Laboratory', 'Emergency', 'Pediatric', 'Eye Care']
            ],
            [
                'name' => 'School',
                'icon' => 'school.png',
                'subcategories' => ['Public School', 'Private School', 'International', 'Language School', 'Music School', 'Art School', 'Sports School', 'Online']
            ],
            [
                'name' => 'Kindergarten',
                'icon' => 'kids-playing.png',
                'subcategories' => ['Public', 'Private', 'Montessori', 'Bilingual', 'Daycare', 'Nursery', 'Preschool', 'After School']
            ],
            [
                'name' => 'Sports',
                'icon' => 'soccer-ball.png',
                'subcategories' => ['Gym', 'Swimming Pool', 'Tennis', 'Football', 'Basketball', 'Martial Arts', 'Yoga', 'Dance']
            ],
            [
                'name' => 'Government organizations',
                'icon' => 'building.png',
                'subcategories' => ['City Hall', 'Police', 'Post Office', 'Tax Office', 'Registry', 'Employment', 'Social Services', 'Immigration', 'Ishonch telefonlari']
            ],
            [
                'name' => 'Home appliances',
                'icon' => 'home-appliances.png',
                'subcategories' => ['Refrigerators', 'Washing Machines', 'TVs', 'Air Conditioners', 'Vacuum Cleaners', 'Microwaves', 'Small Appliances', 'Repair']
            ],
            [
                'name' => 'Hobbies and creativity',
                'icon' => 'workshop.png',
                'subcategories' => ['Art Supplies', 'Craft Shops', 'Music Store', 'Books', 'Board Games', 'Model Kits', 'Sewing', 'DIY']
            ],
            [
                'name' => 'Tour agency',
                'icon' => 'hot-air-balloon.png',
                'subcategories' => ['Domestic Tours', 'International', 'Adventure', 'Cultural', 'Eco Tourism', 'City Tours', 'Package Tours', 'Visa Services']
            ],
            [
                'name' => 'Electronics',
                'icon' => 'laptop.png',
                'subcategories' => ['Computers', 'Laptops', 'Phones', 'Tablets', 'Accessories', 'Gaming', 'Smart Home', 'Repair']
            ],
            [
                'name' => 'Construction and repair',
                'icon' => 'workshop-pegboard.png',
                'subcategories' => ['Builders', 'Electricians', 'Plumbers', 'Painters', 'Carpenters', 'Renovations', 'Materials', 'Design']
            ],
            [
                'name' => 'Beauty and care',
                'icon' => 'barbershop-and-beauty-salon.png',
                'subcategories' => ['Cosmetics', 'Skincare', 'Perfume', 'Hair Care', 'Body Care', 'Organic', 'Professional', 'Men Care']
            ],
            [
                'name' => 'Zoo',
                'icon' => 'zoo.png',
                'subcategories' => ['City Zoo', 'Safari Park', 'Aquarium', 'Bird Park', 'Petting Zoo', 'Reptile House', 'Wildlife', 'Conservation']
            ],
            [
                'name' => 'Book',
                'icon' => 'book.png',
                'subcategories' => ['Bookstores', 'Libraries', 'Used Books', 'Academic', 'Children Books', 'Comics', 'E-books', 'Book Cafe']
            ],
            [
                'name' => 'Real estate',
                'icon' => 'house.png',
                'subcategories' => ['Apartments Sale', 'Houses Sale', 'Rent', 'Commercial', 'Land', 'New Buildings', 'Real Estate Agency', 'Mortgage']
            ],
            [
                'name' => 'Mosque',
                'icon' => 'mosque.png',
                'subcategories' => ['Friday Mosque', 'Neighborhood Mosque', 'Historical', 'Modern', 'Educational', 'Charity', 'Community Center', 'Islamic School']
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryData['name'])],
                [
                    'name' => $categoryData['name'],
                    'slug' => Str::slug($categoryData['name']),
                    'icon' => $categoryData['icon'],
                ]
            );

            echo "  ✓ " . $category->name . "\n";

            // Create subcategories with icons
            $subcategoryIcons = [
                // Furniture
                'Living Room' => 'armchair.png', 'Bedroom' => 'bed.png', 'Office' => 'office-chair.png', 
                'Kitchen' => 'kitchen.png', 'Garden' => 'garden.png', 'Kids' => 'toy-horse.png', 
                'Custom Made' => 'carpenter.png', 'Antique' => 'antique-clock.png',
                // Supermarket  
                'Groceries' => 'shopping-cart.png', 'Bakery' => 'bread.png', 'Dairy' => 'milk.png',
                'Meat' => 'meat.png', 'Vegetables' => 'vegetables.png', 'Frozen Foods' => 'frozen-food.png',
                'Beverages' => 'drinks.png', 'Household' => 'cleaning-spray.png',
                // SPA
                'Massage' => 'spa.png', 'Sauna' => 'sauna.png', 'Facial' => 'beauty.png',
                'Body Treatment' => 'spa.png', 'Manicure' => 'nail-polish.png', 'Pedicure' => 'pedicure.png',
                'Hammam' => 'sauna.png', 'Aromatherapy' => 'aromatherapy.png',
                // Studio
                'Photo Studio' => 'camera.png', 'Video Studio' => 'video-camera.png', 
                'Recording Studio' => 'microphone.png', 'Dance Studio' => 'ballet-shoes.png',
                'Art Studio' => 'palette.png', 'Yoga Studio' => 'yoga.png', 
                'Pilates' => 'pilates.png', 'Fitness' => 'dumbbell.png',
                // Playground
                'Kids Play' => 'playground.png', 'Indoor' => 'indoor-playground.png', 
                'Outdoor' => 'swing.png', 'Trampoline' => 'trampoline.png',
                'Bouncy Castle' => 'bouncy-castle.png', 'Game Zone' => 'game-console.png',
                'Sports Area' => 'soccer-ball.png', 'Birthday Party' => 'birthday-cake.png',
                // Car
                'Car Wash' => 'car-wash.png', 'Car Repair' => 'car-repair.png', 
                'Auto Parts' => 'gears.png', 'Tire Service' => 'tire.png',
                'Oil Change' => 'oil.png', 'Car Rental' => 'car.png', 
                'Dealerships' => 'car-dealer.png', 'Parking' => 'parking.png',
                // Cottage
                'Weekend Rental' => 'cottage.png', 'Daily Rental' => 'house.png', 
                'Events' => 'party.png', 'With Pool' => 'swimming-pool.png',
                'Mountain View' => 'mountain.png', 'Lake View' => 'lake.png', 
                'Luxury' => 'luxury.png', 'Budget' => 'budget.png',
                // Hotel
                'Luxury Hotels' => 'luxury-hotel.png', 'Budget Hotels' => 'budget-hotel.png', 
                'Hostels' => 'hostel.png', 'Guest Houses' => 'guest-house.png',
                'Apartments' => 'apartment.png', 'Resorts' => 'resort.png', 
                'Boutique Hotels' => 'boutique-hotel.png', 'Motels' => 'motel.png',
                // Food
                'Restaurants' => 'restaurant.png', 'Fast Food' => 'fast-food.png', 
                'Cafes' => 'coffee.png', 'Traditional' => 'traditional-food.png',
                'Asian' => 'asian-food.png', 'Italian' => 'pizza.png', 
                'Street Food' => 'street-food.png',
                // Salon
                'Hair Salon' => 'hair-salon.png', 'Barber Shop' => 'barbershop.png', 
                'Beauty Salon' => 'beauty-salon.png', 'Nail Salon' => 'nail-salon.png',
                'Makeup' => 'makeup.png', 'Brow Studio' => 'eyebrow.png', 
                'Lash Extensions' => 'eyelash.png', 'Tattoo' => 'tattoo.png',
                // Government organizations
                'City Hall' => 'building.png', 'Police' => 'police.png', 
                'Post Office' => 'post-office.png', 'Tax Office' => 'tax.png',
                'Registry' => 'registry.png', 'Employment' => 'employment.png',
                'Social Services' => 'social-services.png', 'Immigration' => 'passport.png',
                'Ishonch telefonlari' => 'phone.png',
            ];

            foreach ($categoryData['subcategories'] as $subName) {
                $icon = $subcategoryIcons[$subName] ?? null;
                
                Subcategory::firstOrCreate(
                    [
                        'slug' => Str::slug($subName),
                        'category_id' => $category->id
                    ],
                    [
                        'name' => $subName,
                        'slug' => Str::slug($subName),
                        'category_id' => $category->id,
                        'icon' => $icon,
                    ]
                );
            }
        }

        echo "\n✅ Created " . Category::count() . " categories\n";
        echo "✅ Created " . Subcategory::count() . " subcategories\n\n";

        // Create Locations
        echo "📍 Creating locations...\n";
        $this->call(LocationSeeder::class);

        // Create Fergana Places
        echo "\n🏙️  Creating places for Fergana city...\n";
        $this->call(FerganaPlaceSeeder::class);

        // Create Ishonch telefonlari
        echo "\n📞 Creating Ishonch telefonlari...\n";
        $this->call(IshonchTelefonlariSeeder::class);

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
