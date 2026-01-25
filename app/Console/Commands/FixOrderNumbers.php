<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Place;
use Illuminate\Console\Command;

class FixOrderNumbers extends Command
{
    protected $signature = 'qattabor:fix-order-numbers';
    protected $description = 'Fix order numbers to be scoped within parent categories/subcategories';

    public function handle()
    {
        $this->info('Starting to fix order numbers...');
        
        // Fix subcategories - each category should have its own numbering
        $this->info('Fixing subcategory order numbers...');
        $categories = Category::all();
        $subcategoriesFixed = 0;
        
        foreach ($categories as $category) {
            $subcategories = Subcategory::where('category_id', $category->id)
                ->orderBy('order')
                ->get();
            
            foreach ($subcategories as $index => $subcategory) {
                $newOrder = $index + 1;
                if ($subcategory->order !== $newOrder) {
                    $subcategory->order = $newOrder;
                    $subcategory->saveQuietly();
                    $subcategoriesFixed++;
                }
            }
        }
        
        $this->info("Fixed {$subcategoriesFixed} subcategories");
        
        // Fix places - each subcategory should have its own numbering
        $this->info('Fixing place order numbers...');
        $subcategories = Subcategory::all();
        $placesFixed = 0;
        
        foreach ($subcategories as $subcategory) {
            $places = Place::where('subcategory_id', $subcategory->id)
                ->orderBy('order')
                ->get();
            
            foreach ($places as $index => $place) {
                $newOrder = $index + 1;
                if ($place->order !== $newOrder) {
                    $place->order = $newOrder;
                    $place->saveQuietly();
                    $placesFixed++;
                }
            }
        }
        
        $this->info("Fixed {$placesFixed} places");
        
        $this->info('✅ Order numbers fixed successfully!');
        $this->info('Each category now has its own subcategory numbering (1, 2, 3...)');
        $this->info('Each subcategory now has its own place numbering (1, 2, 3...)');
        
        return Command::SUCCESS;
    }
}
