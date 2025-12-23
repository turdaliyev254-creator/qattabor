<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Place;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Location;
use Illuminate\Support\Str;

class FerganaPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Fergana location
        $fergana = Location::where('slug', 'fergana')->first();
        
        if (!$fergana) {
            $this->command->error('Fergana location not found. Please run LocationSeeder first.');
            return;
        }

        $this->command->info('Seeding places for Fergana city...');

        // Get categories (original structure)
        $foodCategory = Category::where('name', 'Food')->first();
        $hotelCategory = Category::where('name', 'Hotel')->first();
        $medicineCategory = Category::where('name', 'Medicine')->first();
        $schoolCategory = Category::where('name', 'School')->first();
        $sportsCategory = Category::where('name', 'Sports')->first();
        $salonCategory = Category::where('name', 'Salon')->first();
        $supermarketCategory = Category::where('name', 'Supermarket')->first();
        $clothingCategory = Category::where('name', 'Clothing')->first();
        
        
        // Food Category Places
        if ($foodCategory) {
            $restaurants = $foodCategory->subcategories()->where('name', 'Restaurants')->first();
            $fastFood = $foodCategory->subcategories()->where('name', 'Fast Food')->first();
            $cafes = $foodCategory->subcategories()->where('name', 'Cafes')->first();
            $traditional = $foodCategory->subcategories()->where('name', 'Traditional')->first();
            
            $foodPlaces = [
                [
                    'category_id' => $foodCategory->id,
                    'subcategory_id' => $traditional ? $traditional->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Samarkand Darvoza Restaurant',
                    'slug' => Str::slug('Samarkand Darvoza Restaurant'),
                    'description' => 'Authentic Uzbek cuisine in a beautiful traditional setting. Famous for plov, shashlik, and lagman. Family-friendly atmosphere with live music on weekends.',
                    'image_url' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800',
                    'address' => 'Mustaqillik Avenue 55, Fergana',
                    'phone' => '+998 73 244 55 66',
                    'website' => null,
                    'latitude' => 40.3864,
                    'longitude' => 71.7824,
                    'is_popular' => true,
                    'is_featured' => true,
                ],
                [
                    'category_id' => $foodCategory->id,
                    'subcategory_id' => $cafes ? $cafes->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Coffee Dream',
                    'slug' => Str::slug('Coffee Dream Fergana'),
                    'description' => 'Cozy cafe with excellent coffee and desserts. Perfect place for meetings or relaxation. Free WiFi available.',
                    'image_url' => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=800',
                    'address' => 'Al-Fergani Street 123, Fergana',
                    'phone' => '+998 73 255 66 77',
                    'website' => 'https://coffeedream.uz',
                    'latitude' => 40.3894,
                    'longitude' => 71.7864,
                    'is_popular' => true,
                    'is_featured' => false,
                ],
                [
                    'category_id' => $foodCategory->id,
                    'subcategory_id' => $fastFood ? $fastFood->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Burger House',
                    'slug' => Str::slug('Burger House Fergana'),
                    'description' => 'Fast food restaurant specializing in burgers, fries, and milkshakes. Quick service and delivery available throughout Fergana city.',
                    'image_url' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=800',
                    'address' => 'Al-Fergani Street 78',
                    'phone' => '+998 73 266 77 88',
                    'website' => null,
                    'latitude' => 40.3914,
                    'longitude' => 71.7884,
                    'is_popular' => false,
                    'is_featured' => false,
                ],
            ];

            foreach ($foodPlaces as $place) {
                Place::create($place);
            }
        }

        // Hotel Category Places
        if ($hotelCategory) {
            $luxuryHotels = $hotelCategory->subcategories()->where('name', 'Luxury Hotels')->first();
            $budgetHotels = $hotelCategory->subcategories()->where('name', 'Budget Hotels')->first();
            
            $hotelPlaces = [
                [
                    'category_id' => $hotelCategory->id,
                    'subcategory_id' => $luxuryHotels ? $luxuryHotels->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Club 777 Hotel',
                    'slug' => Str::slug('Club 777 Hotel'),
                    'description' => 'Luxury 4-star hotel in central Fergana. Features modern rooms, restaurant, spa center, and conference halls. Perfect for business and leisure travelers.',
                    'image_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800',
                    'address' => 'Mustaqillik Avenue 88, Fergana',
                    'phone' => '+998 73 244 77 77',
                    'website' => 'https://club777.uz',
                    'latitude' => 40.3844,
                    'longitude' => 71.7844,
                    'is_popular' => true,
                    'is_featured' => true,
                ],
                [
                    'category_id' => $hotelCategory->id,
                    'subcategory_id' => $budgetHotels ? $budgetHotels->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Fergana Hotel',
                    'slug' => Str::slug('Fergana Hotel'),
                    'description' => 'Comfortable mid-range hotel near the city center. Clean rooms, friendly staff, and included breakfast. Free parking available.',
                    'image_url' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=800',
                    'address' => 'Amir Temur Street 45, Fergana',
                    'phone' => '+998 73 233 55 66',
                    'website' => null,
                    'latitude' => 40.3804,
                    'longitude' => 71.7904,
                    'is_popular' => false,
                    'is_featured' => false,
                ],
                [
                    'category_id' => $hotelCategory->id,
                    'subcategory_id' => $budgetHotels ? $budgetHotels->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Asia Hotel',
                    'slug' => Str::slug('Asia Hotel Fergana'),
                    'description' => 'Budget-friendly hotel with basic amenities. Clean rooms and convenient location near public transportation.',
                    'image_url' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800',
                    'address' => 'Al-Fergani Street 156, Fergana',
                    'phone' => '+998 73 222 33 44',
                    'website' => null,
                    'latitude' => 40.3924,
                    'longitude' => 71.7804,
                    'is_popular' => false,
                    'is_featured' => false,
                ],
            ];

            foreach ($hotelPlaces as $place) {
                Place::create($place);
            }
        }

        // Medicine Category Places
        if ($medicineCategory) {
            $hospitals = $medicineCategory->subcategories()->where('name', 'Hospitals')->first();
            $clinics = $medicineCategory->subcategories()->where('name', 'Clinics')->first();
            $dental = $medicineCategory->subcategories()->where('name', 'Dental')->first();
            
            $medicinePlaces = [
                [
                    'category_id' => $medicineCategory->id,
                    'subcategory_id' => $hospitals ? $hospitals->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Fergana Regional Hospital',
                    'slug' => Str::slug('Fergana Regional Hospital'),
                    'description' => 'Main regional hospital providing comprehensive medical services. 24/7 emergency department, surgery, and specialized departments for all medical needs.',
                    'image_url' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800',
                    'address' => 'Navoi Street 1, Fergana',
                    'phone' => '+998 73 244 11 22',
                    'website' => null,
                    'latitude' => 40.3754,
                    'longitude' => 71.7924,
                    'is_popular' => true,
                    'is_featured' => false,
                ],
                [
                    'category_id' => $medicineCategory->id,
                    'subcategory_id' => $clinics ? $clinics->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'MedLife Clinic',
                    'slug' => Str::slug('MedLife Clinic'),
                    'description' => 'Modern private clinic with experienced doctors. General practitioners, dentistry, laboratory services, and health checkups.',
                    'image_url' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=800',
                    'address' => 'Mustaqillik Avenue 156, Fergana',
                    'phone' => '+998 73 255 44 33',
                    'website' => 'https://medlife.uz',
                    'latitude' => 40.3884,
                    'longitude' => 71.7854,
                    'is_popular' => false,
                    'is_featured' => false,
                ],
                [
                    'category_id' => $medicineCategory->id,
                    'subcategory_id' => $dental ? $dental->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Dental Plus',
                    'slug' => Str::slug('Dental Plus Fergana'),
                    'description' => 'Specialized dental clinic with modern equipment. All types of dental services including orthodontics, implants, and teeth whitening.',
                    'image_url' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=800',
                    'address' => 'Al-Fergani Street 98, Fergana',
                    'phone' => '+998 73 266 55 44',
                    'website' => null,
                    'latitude' => 40.3834,
                    'longitude' => 71.7774,
                    'is_popular' => false,
                    'is_featured' => false,
                ],
            ];

            foreach ($medicinePlaces as $place) {
                Place::create($place);
            }
        }

        // School Category Places
        if ($schoolCategory) {
            $privateSchool = $schoolCategory->subcategories()->where('name', 'Private School')->first();
            $languageSchool = $schoolCategory->subcategories()->where('name', 'Language School')->first();
            
            $schoolPlaces = [
                [
                    'category_id' => $schoolCategory->id,
                    'subcategory_id' => $privateSchool ? $privateSchool->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Presidential School of Fergana',
                    'slug' => Str::slug('Presidential School of Fergana'),
                    'description' => 'Elite school offering advanced education programs. Modern facilities, experienced teachers, and comprehensive curriculum including foreign languages.',
                    'image_url' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800',
                    'address' => 'Mustaqillik Avenue 201, Fergana',
                    'phone' => '+998 73 277 88 99',
                    'website' => 'https://ps.fergana.uz',
                    'latitude' => 40.3964,
                    'longitude' => 71.7904,
                    'is_popular' => true,
                    'is_featured' => true,
                ],
                [
                    'category_id' => $schoolCategory->id,
                    'subcategory_id' => $languageSchool ? $languageSchool->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'English First Language Center',
                    'slug' => Str::slug('English First Language Center'),
                    'description' => 'Professional language learning center specializing in English. Experienced native speakers, interactive classes, and international certification preparation.',
                    'image_url' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800',
                    'address' => 'Al-Fergani Street 189, Fergana',
                    'phone' => '+998 73 288 99 00',
                    'website' => 'https://englishfirst.uz',
                    'latitude' => 40.3944,
                    'longitude' => 71.7944,
                    'is_popular' => false,
                    'is_featured' => false,
                ],
            ];

            foreach ($schoolPlaces as $place) {
                Place::create($place);
            }
        }

        // Sports Category Places
        if ($sportsCategory) {
            $gym = $sportsCategory->subcategories()->where('name', 'Gym')->first();
            $swimmingPool = $sportsCategory->subcategories()->where('name', 'Swimming Pool')->first();
            $football = $sportsCategory->subcategories()->where('name', 'Football')->first();
            
            $sportsPlaces = [
                [
                    'category_id' => $sportsCategory->id,
                    'subcategory_id' => $gym ? $gym->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Fitness Zone Gym',
                    'slug' => Str::slug('Fitness Zone Gym'),
                    'description' => 'Modern fitness center with latest equipment. Professional trainers, group classes, sauna, and personal training programs available.',
                    'image_url' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800',
                    'address' => 'Mustaqillik Avenue 178, Fergana',
                    'phone' => '+998 73 299 00 11',
                    'website' => 'https://fitnesszone.uz',
                    'latitude' => 40.3904,
                    'longitude' => 71.7944,
                    'is_popular' => true,
                    'is_featured' => false,
                ],
                [
                    'category_id' => $sportsCategory->id,
                    'subcategory_id' => $swimmingPool ? $swimmingPool->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Aqua Sport Complex',
                    'slug' => Str::slug('Aqua Sport Complex'),
                    'description' => 'Indoor swimming pool complex with olympic-size pool, kids pool, swimming lessons, and water aerobics classes.',
                    'image_url' => 'https://images.unsplash.com/photo-1576610616656-d3aa5d1f4534?w=800',
                    'address' => 'Navoi Street 89, Fergana',
                    'phone' => '+998 73 244 22 33',
                    'website' => null,
                    'latitude' => 40.3774,
                    'longitude' => 71.7984,
                    'is_popular' => false,
                    'is_featured' => false,
                ],
                [
                    'category_id' => $sportsCategory->id,
                    'subcategory_id' => $football ? $football->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Fergana Stadium',
                    'slug' => Str::slug('Fergana Stadium'),
                    'description' => 'Main city stadium for football matches and sports events. Home stadium for local football club. Open for public use during off-season.',
                    'image_url' => 'https://images.unsplash.com/photo-1459865264687-595d652de67e?w=800',
                    'address' => 'Sports Street 1, Fergana',
                    'phone' => '+998 73 233 44 55',
                    'website' => null,
                    'latitude' => 40.3814,
                    'longitude' => 71.7744,
                    'is_popular' => true,
                    'is_featured' => false,
                ],
            ];

            foreach ($sportsPlaces as $place) {
                Place::create($place);
            }
        }

        // Salon Category Places
        if ($salonCategory) {
            $hairSalon = $salonCategory->subcategories()->where('name', 'Hair Salon')->first();
            $barberShop = $salonCategory->subcategories()->where('name', 'Barber Shop')->first();
            $beautySalon = $salonCategory->subcategories()->where('name', 'Beauty Salon')->first();
            
            $salonPlaces = [
                [
                    'category_id' => $salonCategory->id,
                    'subcategory_id' => $beautySalon ? $beautySalon->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Luxury Beauty Salon',
                    'slug' => Str::slug('Luxury Beauty Salon'),
                    'description' => 'Premium beauty salon offering hair styling, makeup, manicure, pedicure, and facial treatments. Professional stylists and latest beauty trends.',
                    'image_url' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=800',
                    'address' => 'Mustaqillik Avenue 134, Fergana',
                    'phone' => '+998 73 255 77 88',
                    'website' => 'https://luxurybeauty.uz',
                    'latitude' => 40.3874,
                    'longitude' => 71.7834,
                    'is_popular' => true,
                    'is_featured' => false,
                ],
                [
                    'category_id' => $salonCategory->id,
                    'subcategory_id' => $barberShop ? $barberShop->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Gentleman Barber Shop',
                    'slug' => Str::slug('Gentleman Barber Shop'),
                    'description' => 'Classic barber shop for men. Professional haircuts, beard styling, hot towel shaves, and grooming services in a relaxed atmosphere.',
                    'image_url' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=800',
                    'address' => 'Al-Fergani Street 145, Fergana',
                    'phone' => '+998 73 266 88 99',
                    'website' => null,
                    'latitude' => 40.3924,
                    'longitude' => 71.7794,
                    'is_popular' => false,
                    'is_featured' => false,
                ],
            ];

            foreach ($salonPlaces as $place) {
                Place::create($place);
            }
        }

        // Supermarket Category Places
        if ($supermarketCategory) {
            $groceries = $supermarketCategory->subcategories()->where('name', 'Groceries')->first();
            
            $supermarketPlaces = [
                [
                    'category_id' => $supermarketCategory->id,
                    'subcategory_id' => $groceries ? $groceries->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Makro Supermarket',
                    'slug' => Str::slug('Makro Supermarket'),
                    'description' => 'Large supermarket chain offering groceries, fresh produce, household items, and electronics. Competitive prices and regular promotions.',
                    'image_url' => 'https://images.unsplash.com/photo-1578916171728-46686eac8d58?w=800',
                    'address' => 'Mustaqillik Avenue 99, Fergana',
                    'phone' => '+998 73 244 33 44',
                    'website' => 'https://makro.uz',
                    'latitude' => 40.3854,
                    'longitude' => 71.7814,
                    'is_popular' => true,
                    'is_featured' => false,
                ],
                [
                    'category_id' => $supermarketCategory->id,
                    'subcategory_id' => $groceries ? $groceries->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Korzinka Supermarket',
                    'slug' => Str::slug('Korzinka Supermarket'),
                    'description' => 'Popular supermarket chain with wide selection of local and imported products. Fresh bakery, deli, and convenient location.',
                    'image_url' => 'https://images.unsplash.com/photo-1604719312566-8912e9227c6a?w=800',
                    'address' => 'Al-Fergani Street 234, Fergana',
                    'phone' => '+998 73 277 55 66',
                    'website' => 'https://korzinka.uz',
                    'latitude' => 40.3984,
                    'longitude' => 71.7894,
                    'is_popular' => false,
                    'is_featured' => false,
                ],
            ];

            foreach ($supermarketPlaces as $place) {
                Place::create($place);
            }
        }

        // Clothing Category Places
        if ($clothingCategory) {
            $menFashion = $clothingCategory->subcategories()->where('name', 'Men Fashion')->first();
            $womenFashion = $clothingCategory->subcategories()->where('name', 'Women Fashion')->first();
            
            $clothingPlaces = [
                [
                    'category_id' => $clothingCategory->id,
                    'subcategory_id' => $womenFashion ? $womenFashion->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Fashion Boutique Elegance',
                    'slug' => Str::slug('Fashion Boutique Elegance'),
                    'description' => 'Upscale boutique featuring latest fashion trends for women. Designer clothes, accessories, and personalized styling service.',
                    'image_url' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800',
                    'address' => 'Mustaqillik Avenue 167, Fergana',
                    'phone' => '+998 73 288 77 88',
                    'website' => null,
                    'latitude' => 40.3894,
                    'longitude' => 71.7874,
                    'is_popular' => false,
                    'is_featured' => false,
                ],
                [
                    'category_id' => $clothingCategory->id,
                    'subcategory_id' => $menFashion ? $menFashion->id : null,
                    'location_id' => $fergana->id,
                    'name' => 'Men Style Outlet',
                    'slug' => Str::slug('Men Style Outlet'),
                    'description' => 'Men\'s clothing store with casual and formal wear. Quality brands at affordable prices. Shirts, suits, jeans, and shoes.',
                    'image_url' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=800',
                    'address' => 'Al-Fergani Street 112, Fergana',
                    'phone' => '+998 73 266 99 00',
                    'website' => null,
                    'latitude' => 40.3904,
                    'longitude' => 71.7824,
                    'is_popular' => false,
                    'is_featured' => false,
                ],
            ];

            foreach ($clothingPlaces as $place) {
                Place::create($place);
            }
        }

        $this->command->info('✅ Successfully seeded ' . Place::count() . ' places for Fergana city!');
    }
}
