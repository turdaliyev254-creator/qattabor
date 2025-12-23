<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Furniture', 'image' => 'sofa.png'],
            ['name' => 'Supermarket', 'image' => 'supermarket.png'],
            ['name' => 'SPA', 'image' => 'spa.png'],
            ['name' => 'Studio', 'image' => 'camera.png'],
            ['name' => 'Playground', 'image' => 'playground.png'],
            ['name' => 'Car', 'image' => 'car.png'],
            ['name' => 'Cottage', 'image' => 'mountain-hut.png'],
            ['name' => 'Hotel', 'image' => 'hotel.png'],
            ['name' => 'Food', 'image' => 'dining-plate.png'],
            ['name' => 'Salon', 'image' => 'barbershop-and-beauty-salon.png'],
            ['name' => 'Clothing', 'image' => 'clothes-hanger.png'],
            ['name' => 'Medicine', 'image' => 'hospital.png'],
            ['name' => 'School', 'image' => 'school.png'],
            ['name' => 'Kindergarten', 'image' => 'kids-playing.png'],
            ['name' => 'Sports', 'image' => 'soccer-ball.png'],
            ['name' => 'Government organizations', 'image' => 'building.png'],
            ['name' => 'Home appliances', 'image' => 'home-appliances.png'],
            ['name' => 'Hobbies and creativity', 'image' => 'workshop.png'],
            ['name' => 'Tour agency', 'image' => 'hot-air-balloon.png'],
            ['name' => 'Electronics', 'image' => 'laptop.png'],
            ['name' => 'Construction and repair', 'image' => 'workshop-pegboard.png'],
            ['name' => 'Beauty and care', 'image' => 'barbershop-and-beauty-salon.png'],
            ['name' => 'Zoo', 'image' => 'zoo.png'],
            ['name' => 'Book', 'image' => 'book.png'],
            ['name' => 'Real estate', 'image' => 'house.png'],
            ['name' => 'Mosque', 'image' => 'mosque.png'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'image' => $category['image'],
            ]);
        }
    }
}
