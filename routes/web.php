<?php
// ...existing code...

Route::get('/fresh-seed-now', function() {
    try {
        // First, delete all existing data
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('places')->truncate();
        \DB::table('subcategories')->truncate();
        \DB::table('categories')->truncate();
        \DB::table('locations')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Now run the seeder
        \Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
        
        return "✅ Database cleared and seeded successfully! Now check your sidebar.";
    } catch (\Exception $e) {
        return "❌ Error: " . $e->getMessage();
    }
});

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [HomeController::class, 'allCategories'])->name('categories.all');
Route::get('/popular-places', [PlaceController::class, 'popularPlaces'])->name('places.popular');
Route::get('/categories/{category:slug}', [PlaceController::class, 'byCategory'])->name('places.by-category');
Route::get('/categories/{category:slug}/{subcategory:slug}', [PlaceController::class, 'bySubcategory'])->name('places.by-subcategory');
Route::get('/places/{place:slug}', [PlaceController::class, 'show'])->name('places.show');
Route::get('/map', [PlaceController::class, 'map'])->name('map.index');


// AI Search endpoint
Route::post('/search/ai', [SearchController::class, 'aiSearch'])->name('search.ai');

// Quick search for places
Route::get('/search-places', [SearchController::class, 'quickSearch'])->name('search.quick');

Route::middleware('auth')->group(function () {
    Route::get('/saved-places', [PlaceController::class, 'savedPlaces'])->name('places.saved');
    Route::post('/places/{place}/save', [PlaceController::class, 'save'])->name('places.save');
    Route::delete('/places/{place}/unsave', [PlaceController::class, 'unsave'])->name('places.unsave');
});

Route::post('/language/{locale}', function ($locale) {
    if (in_array($locale, config('app.available_locales'))) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('language.switch');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
    Route::resource('subcategories', \App\Http\Controllers\Admin\SubcategoryController::class)->names('admin.subcategories');
    Route::resource('places', \App\Http\Controllers\Admin\PlaceController::class)->names('admin.places');
});

require __DIR__.'/auth.php';
