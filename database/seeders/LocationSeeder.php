<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            // Republic of Karakalpakstan
            ['name' => 'Nukus', 'region' => 'Karakalpakstan'],
            
            // Regions (Viloyatlar)
            ['name' => 'Andijan', 'region' => 'Andijan Region'],
            ['name' => 'Bukhara', 'region' => 'Bukhara Region'],
            ['name' => 'Fergana', 'region' => 'Fergana Region'],
            ['name' => 'Jizzakh', 'region' => 'Jizzakh Region'],
            ['name' => 'Namangan', 'region' => 'Namangan Region'],
            ['name' => 'Navoiy', 'region' => 'Navoiy Region'],
            ['name' => 'Qashqadaryo', 'region' => 'Qashqadaryo Region'],
            ['name' => 'Samarkand', 'region' => 'Samarkand Region'],
            ['name' => 'Sirdaryo', 'region' => 'Sirdaryo Region'],
            ['name' => 'Surxondaryo', 'region' => 'Surxondaryo Region'],
            ['name' => 'Tashkent Region', 'region' => 'Tashkent Region'],
            ['name' => 'Xorazm', 'region' => 'Xorazm Region'],
            
            // Tashkent City (Capital - Independent City)
            ['name' => 'Tashkent', 'region' => 'Tashkent City'],
            
            // Major cities in each region
            ['name' => 'Asaka', 'region' => 'Andijan Region'],
            ['name' => 'Kagan', 'region' => 'Bukhara Region'],
            ['name' => 'Margilan', 'region' => 'Fergana Region'],
            ['name' => 'Kokand', 'region' => 'Fergana Region'],
            ['name' => 'Qarshi', 'region' => 'Qashqadaryo Region'],
            ['name' => 'Termez', 'region' => 'Surxondaryo Region'],
            ['name' => 'Urgench', 'region' => 'Xorazm Region'],
            ['name' => 'Khiva', 'region' => 'Xorazm Region'],
            ['name' => 'Chirchiq', 'region' => 'Tashkent Region'],
            ['name' => 'Angren', 'region' => 'Tashkent Region'],
            ['name' => 'Gulistan', 'region' => 'Sirdaryo Region'],
            ['name' => 'Zarafshan', 'region' => 'Navoiy Region'],
        ];

        foreach ($locations as $location) {
            $slug = Str::slug($location['name']);
            
            // Check if location already exists
            $exists = DB::table('locations')->where('slug', $slug)->exists();
            
            if (!$exists) {
                DB::table('locations')->insert([
                    'name' => $location['name'],
                    'slug' => $slug,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
