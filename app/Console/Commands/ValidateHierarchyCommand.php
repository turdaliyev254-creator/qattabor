<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Place;
use Illuminate\Console\Command;

class ValidateHierarchyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qattabor:validate-hierarchy {--fix : Automatically fix orphaned records}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate the hierarchy integrity of categories, subcategories, and places';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Validating hierarchy integrity...');
        $this->newLine();

        $issues = [];
        $orphanedSubcategories = [];
        $orphanedPlaces = [];

        // Check subcategories
        $this->info('Checking subcategories...');
        $subcategories = Subcategory::all();
        foreach ($subcategories as $subcategory) {
            $categoryExists = Category::where('id', $subcategory->category_id)->exists();
            if (!$categoryExists) {
                $orphanedSubcategories[] = $subcategory;
                $issues[] = "Subcategory #{$subcategory->id} ('{$subcategory->name}') has invalid category_id: {$subcategory->category_id}";
            }
        }

        // Check places
        $this->info('Checking places...');
        $places = Place::all();
        foreach ($places as $place) {
            $categoryExists = Category::where('id', $place->category_id)->exists();
            $subcategoryExists = $place->subcategory_id ? Subcategory::where('id', $place->subcategory_id)->exists() : true;
            
            if (!$categoryExists) {
                $orphanedPlaces[] = ['place' => $place, 'issue' => 'category'];
                $issues[] = "Place #{$place->id} ('{$place->name}') has invalid category_id: {$place->category_id}";
            }
            
            if (!$subcategoryExists) {
                $orphanedPlaces[] = ['place' => $place, 'issue' => 'subcategory'];
                $issues[] = "Place #{$place->id} ('{$place->name}') has invalid subcategory_id: {$place->subcategory_id}";
            }
        }

        $this->newLine();
        
        // Display results
        if (empty($issues)) {
            $this->info('✓ All records are valid! No orphaned records found.');
            return 0;
        }

        $this->error('✗ Found ' . count($issues) . ' issue(s):');
        foreach ($issues as $issue) {
            $this->line('  - ' . $issue);
        }

        $this->newLine();

        // Summary
        $this->table(
            ['Type', 'Count'],
            [
                ['Orphaned Subcategories', count($orphanedSubcategories)],
                ['Orphaned Places', count($orphanedPlaces)],
                ['Total Issues', count($issues)],
            ]
        );

        // Fix option
        if ($this->option('fix')) {
            $this->newLine();
            
            if (!$this->confirm('Do you want to automatically fix these orphaned records?', true)) {
                $this->info('Fix cancelled.');
                return 1;
            }

            $this->info('Fixing orphaned records...');
            $this->newLine();

            $fixed = 0;

            // Get first available category for fallback
            $firstCategory = Category::orderBy('id')->first();
            
            if (!$firstCategory) {
                $this->error('Cannot fix: No categories found in database!');
                return 1;
            }

            // Fix orphaned subcategories
            foreach ($orphanedSubcategories as $subcategory) {
                $subcategory->category_id = $firstCategory->id;
                $subcategory->save();
                $this->info("  ✓ Fixed Subcategory #{$subcategory->id} → Assigned to Category #{$firstCategory->id} ('{$firstCategory->name}')");
                $fixed++;
            }

            // Fix orphaned places
            foreach ($orphanedPlaces as $item) {
                $place = $item['place'];
                $issue = $item['issue'];

                if ($issue === 'category') {
                    // Get first subcategory from first category
                    $firstSubcategory = Subcategory::where('category_id', $firstCategory->id)->orderBy('id')->first();
                    
                    if ($firstSubcategory) {
                        $place->category_id = $firstCategory->id;
                        $place->subcategory_id = $firstSubcategory->id;
                        $this->info("  ✓ Fixed Place #{$place->id} → Assigned to Category #{$firstCategory->id}, Subcategory #{$firstSubcategory->id}");
                    } else {
                        $place->category_id = $firstCategory->id;
                        $place->subcategory_id = null;
                        $this->info("  ✓ Fixed Place #{$place->id} → Assigned to Category #{$firstCategory->id} (no subcategory available)");
                    }
                } else {
                    // Fix subcategory issue - get first subcategory from the place's category
                    $firstSubcategoryInCategory = Subcategory::where('category_id', $place->category_id)->orderBy('id')->first();
                    
                    if ($firstSubcategoryInCategory) {
                        $place->subcategory_id = $firstSubcategoryInCategory->id;
                        $this->info("  ✓ Fixed Place #{$place->id} → Assigned to Subcategory #{$firstSubcategoryInCategory->id}");
                    } else {
                        $place->subcategory_id = null;
                        $this->info("  ✓ Fixed Place #{$place->id} → Cleared subcategory (none available in category)");
                    }
                }

                $place->save();
                $fixed++;
            }

            $this->newLine();
            $this->info("✓ Successfully fixed {$fixed} record(s)!");
            return 0;
        } else {
            $this->newLine();
            $this->comment('Run with --fix flag to automatically repair orphaned records:');
            $this->comment('  php artisan qattabor:validate-hierarchy --fix');
            return 1;
        }
    }
}
