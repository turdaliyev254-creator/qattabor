<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\Region;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, seed regions with coordinates
        $regionsData = [
            ['name' => 'Tashkent City', 'name_uz' => 'Toshkent', 'name_ru' => 'Ташкент', 'name_en' => 'Tashkent', 'slug' => 'tashkent-city', 'order' => 1, 'is_active' => true, 'center_latitude' => 41.2995, 'center_longitude' => 69.2401],
            ['name' => 'Tashkent Region', 'name_uz' => 'Toshkent viloyati', 'name_ru' => 'Ташкентская область', 'name_en' => 'Tashkent Region', 'slug' => 'tashkent-region', 'order' => 2, 'is_active' => true, 'center_latitude' => 41.0082, 'center_longitude' => 69.5975],
            ['name' => 'Fergana Region', 'name_uz' => 'Fargona', 'name_ru' => 'Фергана', 'name_en' => 'Fergana', 'slug' => 'fergana', 'order' => 3, 'is_active' => true, 'center_latitude' => 40.3864, 'center_longitude' => 71.7864],
            ['name' => 'Kokand', 'name_uz' => 'Qoqon', 'name_ru' => 'Коканд', 'name_en' => 'Kokand', 'slug' => 'kokand', 'order' => 4, 'is_active' => true, 'center_latitude' => 40.5286, 'center_longitude' => 70.9428],
            ['name' => 'Namangan Region', 'name_uz' => 'Namangan', 'name_ru' => 'Наманган', 'name_en' => 'Namangan', 'slug' => 'namangan', 'order' => 5, 'is_active' => true, 'center_latitude' => 40.9983, 'center_longitude' => 71.6726],
            ['name' => 'Samarkand Region', 'name_uz' => 'Samarqand', 'name_ru' => 'Самарканд', 'name_en' => 'Samarkand', 'slug' => 'samarkand', 'order' => 6, 'is_active' => true, 'center_latitude' => 39.6270, 'center_longitude' => 66.9750],
            ['name' => 'Bukhara Region', 'name_uz' => 'Buxoro', 'name_ru' => 'Бухара', 'name_en' => 'Bukhara', 'slug' => 'bukhara', 'order' => 7, 'is_active' => true, 'center_latitude' => 39.7747, 'center_longitude' => 64.4286],
            ['name' => 'Andijan Region', 'name_uz' => 'Andijon', 'name_ru' => 'Андижан', 'name_en' => 'Andijan', 'slug' => 'andijan', 'order' => 8, 'is_active' => true, 'center_latitude' => 40.7821, 'center_longitude' => 72.3442],
            ['name' => 'Navoiy Region', 'name_uz' => 'Navoi', 'name_ru' => 'Навои', 'name_en' => 'Navoiy', 'slug' => 'navoiy', 'order' => 9, 'is_active' => true, 'center_latitude' => 42.5925, 'center_longitude' => 64.6178],
            ['name' => 'Xorazm Region', 'name_uz' => 'Xorazm', 'name_ru' => 'Хорезм', 'name_en' => 'Khorezm', 'slug' => 'xorazm', 'order' => 10, 'is_active' => true, 'center_latitude' => 41.3775, 'center_longitude' => 60.8639],
            ['name' => 'Surxondaryo Region', 'name_uz' => 'Surxondaryo', 'name_ru' => 'Сурхандарья', 'name_en' => 'Surkhandarya', 'slug' => 'surxondaryo', 'order' => 11, 'is_active' => true, 'center_latitude' => 37.9406, 'center_longitude' => 67.5706],
            ['name' => 'Qashqadaryo Region', 'name_uz' => 'Qashqadaryo', 'name_ru' => 'Кашкадарья', 'name_en' => 'Kashkadarya', 'slug' => 'qashqadaryo', 'order' => 12, 'is_active' => true, 'center_latitude' => 38.8456, 'center_longitude' => 65.7892],
            ['name' => 'Jizzakh Region', 'name_uz' => 'Jizzax', 'name_ru' => 'Джизак', 'name_en' => 'Jizzakh', 'slug' => 'jizzakh', 'order' => 13, 'is_active' => true, 'center_latitude' => 40.1158, 'center_longitude' => 67.8422],
        ];

        foreach ($regionsData as $region) {
            Region::updateOrCreate(
                ['slug' => $region['slug']],
                $region
            );
        }

        $this->command->info('Regions seeded successfully with coordinates!');

        // Now get all regions for location seeding
        $regions = Region::all();

        $locations = [
            // Tashkent City locations
            ['name' => 'Tashkent', 'slug' => 'tashkent', 'region_name' => 'Tashkent City'],
            
            // Tashkent Region locations
            ['name' => 'Chirchiq', 'slug' => 'chirchiq', 'region_name' => 'Tashkent Region'],
            ['name' => 'Angren', 'slug' => 'angren', 'region_name' => 'Tashkent Region'],
            ['name' => 'Olmaliq', 'slug' => 'olmaliq', 'region_name' => 'Tashkent Region'],
            
            // Fergana Region locations
            ['name' => 'Fergana', 'slug' => 'fergana', 'region_name' => 'Fergana Region'],
            ['name' => 'Margilan', 'slug' => 'margilan', 'region_name' => 'Fergana Region'],
            ['name' => 'Quvasoy', 'slug' => 'quvasoy', 'region_name' => 'Fergana Region'],
            
            // Kokand
            ['name' => 'Kokand', 'slug' => 'kokand', 'region_name' => 'Kokand'],
            
            // Namangan Region locations
            ['name' => 'Namangan', 'slug' => 'namangan', 'region_name' => 'Namangan Region'],
            ['name' => 'Chust', 'slug' => 'chust', 'region_name' => 'Namangan Region'],
            
            // Samarkand Region locations
            ['name' => 'Samarkand', 'slug' => 'samarkand', 'region_name' => 'Samarkand Region'],
            ['name' => 'Kattakurgan', 'slug' => 'kattakurgan', 'region_name' => 'Samarkand Region'],
            
            // Bukhara Region locations
            ['name' => 'Bukhara', 'slug' => 'bukhara', 'region_name' => 'Bukhara Region'],
            ['name' => 'Kogon', 'slug' => 'kogon', 'region_name' => 'Bukhara Region'],
            
            // Andijan Region locations
            ['name' => 'Andijan', 'slug' => 'andijan', 'region_name' => 'Andijan Region'],
            ['name' => 'Asaka', 'slug' => 'asaka', 'region_name' => 'Andijan Region'],
            
            // Navoiy Region locations
            ['name' => 'Navoiy', 'slug' => 'navoiy', 'region_name' => 'Navoiy Region'],
            ['name' => 'Zarafshan', 'slug' => 'zarafshan', 'region_name' => 'Navoiy Region'],
            
            // Xorazm Region locations
            ['name' => 'Urgench', 'slug' => 'urgench', 'region_name' => 'Xorazm Region'],
            ['name' => 'Khiva', 'slug' => 'khiva', 'region_name' => 'Xorazm Region'],
            
            // Surxondaryo Region locations
            ['name' => 'Termez', 'slug' => 'termez', 'region_name' => 'Surxondaryo Region'],
            ['name' => 'Denov', 'slug' => 'denov', 'region_name' => 'Surxondaryo Region'],
            
            // Qashqadaryo Region locations
            ['name' => 'Qarshi', 'slug' => 'qarshi', 'region_name' => 'Qashqadaryo Region'],
            ['name' => 'Shahrisabz', 'slug' => 'shahrisabz', 'region_name' => 'Qashqadaryo Region'],
            
            // Jizzakh Region locations
            ['name' => 'Jizzakh', 'slug' => 'jizzakh', 'region_name' => 'Jizzakh Region'],
            ['name' => 'Dustlik', 'slug' => 'dustlik', 'region_name' => 'Jizzakh Region'],
        ];

        foreach ($locations as $locationData) {
            // Find the region by name
            $region = $regions->firstWhere('name', $locationData['region_name']);
            
            if ($region) {
                Location::updateOrCreate(
                    ['slug' => $locationData['slug']],
                    [
                        'name' => $locationData['name'],
                        'slug' => $locationData['slug'],
                        'region_id' => $region->id,
                        'region' => $region->name, // Keep for backward compatibility
                    ]
                );
            }
        }

        $this->command->info('Locations seeded successfully!');
    }
}
