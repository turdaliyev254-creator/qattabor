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

// Diagnostic routes (moved to controller for route caching compatibility)
Route::get('/check-banners', [\App\Http\Controllers\DiagnosticsController::class, 'checkBanners']);
Route::get('/clear-all-cache', [\App\Http\Controllers\DiagnosticsController::class, 'clearCache']);

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [HomeController::class, 'allCategories'])->name('categories.all');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/popular-places', [PlaceController::class, 'popularPlaces'])->name('places.popular');
Route::get('/categories/{category:slug}', [PlaceController::class, 'byCategory'])->name('places.by-category');
Route::get('/categories/{category:slug}/{subcategory:slug}', [PlaceController::class, 'bySubcategory'])->name('places.by-subcategory');
Route::get('/categories/{category:slug}/{subcategory:slug}/ajax', [PlaceController::class, 'ajaxFilterPlaces'])->name('places.ajax-filter');
Route::get('/places/{place:slug}', [PlaceController::class, 'show'])->name('places.show');
Route::get('/map', [PlaceController::class, 'map'])->name('map.index');

// Search routes
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::post('/search/ai', [SearchController::class, 'aiSearch'])->name('search.ai');
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

// Quick search for places
Route::get('/search-places', [SearchController::class, 'quickSearch'])->name('search.quick');

// Geolocation API
Route::post('/api/detect-region', [\App\Http\Controllers\Api\LocationController::class, 'detectRegion'])->name('api.detect-region');

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
    $user = auth()->user();
    
    // Redirect admin to admin dashboard
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    // Redirect place owners to owner dashboard
    if ($user->isOwner()) {
        return redirect()->route('owner.dashboard');
    }
    
    // Regular users go to user dashboard
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User Dashboard
    Route::get('/user/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/favorites', [\App\Http\Controllers\User\DashboardController::class, 'favorites'])->name('user.favorites');
    Route::get('/user/reviews', [\App\Http\Controllers\User\DashboardController::class, 'reviews'])->name('user.reviews');
    Route::get('/user/recently-viewed', [\App\Http\Controllers\User\DashboardController::class, 'recentlyViewed'])->name('user.recently-viewed');
    Route::get('/user/profile', [\App\Http\Controllers\User\ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/user/profile', [\App\Http\Controllers\User\ProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('/user/profile/avatar', [\App\Http\Controllers\User\ProfileController::class, 'deleteAvatar'])->name('user.profile.delete-avatar');
    
    // Owner Dashboard and Comments
    Route::get('/owner/dashboard', \App\Http\Controllers\Owner\DashboardController::class)->name('owner.dashboard');
    Route::get('/owner/export-activity', [\App\Http\Controllers\Owner\DashboardController::class, 'exportActivity'])->name('owner.export-activity');
    Route::post('/comments/{comment}/reply', [\App\Http\Controllers\Owner\CommentController::class, 'reply'])->name('owner.comments.reply');
    
    // Public Comments
    Route::post('/places/{place}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/export-activity', [AdminController::class, 'exportActivity'])->name('admin.export-activity');
    
    Route::resource('regions', \App\Http\Controllers\Admin\RegionController::class)->names('admin.regions');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
    
    // Nested resource routes for hierarchical navigation
    Route::resource('categories.subcategories', \App\Http\Controllers\Admin\SubcategoryController::class)
        ->except(['show'])
        ->shallow()
        ->names([
            'index' => 'admin.categories.subcategories.index',
            'create' => 'admin.categories.subcategories.create',
            'store' => 'admin.categories.subcategories.store',
            'edit' => 'admin.subcategories.edit',
            'update' => 'admin.subcategories.update',
            'destroy' => 'admin.subcategories.destroy',
        ]);
    
    Route::resource('subcategories.places', \App\Http\Controllers\Admin\PlaceController::class)
        ->except(['show'])
        ->shallow()
        ->names([
            'index' => 'admin.subcategories.places.index',
            'create' => 'admin.subcategories.places.create',
            'store' => 'admin.subcategories.places.store',
            'edit' => 'admin.places.edit',
            'update' => 'admin.places.update',
            'destroy' => 'admin.places.destroy',
        ]);
    
    // Brand routes (nested under subcategories)
    Route::resource('subcategories.brands', \App\Http\Controllers\Admin\BrandController::class)
        ->except(['show'])
        ->shallow()
        ->names([
            'index' => 'admin.subcategories.brands.index',
            'create' => 'admin.subcategories.brands.create',
            'store' => 'admin.subcategories.brands.store',
            'edit' => 'admin.brands.edit',
            'update' => 'admin.brands.update',
            'destroy' => 'admin.brands.destroy',
        ]);
    
    // Keep flat routes for backward compatibility
    // Define custom routes BEFORE resource route to prevent conflicts
    Route::get('subcategories/create-child', [\App\Http\Controllers\Admin\SubcategoryController::class, 'createChild'])->name('admin.subcategories.create-child');
    Route::get('subcategories/get-parents', [\App\Http\Controllers\Admin\SubcategoryController::class, 'getParents'])->name('admin.subcategories.get-parents');
    Route::resource('subcategories', \App\Http\Controllers\Admin\SubcategoryController::class)->names('admin.subcategories');
    Route::resource('places', \App\Http\Controllers\Admin\PlaceController::class)->names('admin.places');
    Route::delete('place-images/{image}', [\App\Http\Controllers\Admin\PlaceController::class, 'deleteImage'])->name('admin.place-images.delete');
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class)->names('admin.banners');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'show', 'destroy'])->names('admin.users');
    Route::post('users/{user}/update-role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('admin.users.update-role');
    
    // Ordering routes
    Route::post('categories/reorder', [\App\Http\Controllers\Admin\CategoryController::class, 'reorder'])->name('admin.categories.reorder');
    Route::patch('categories/{category}/update-order', [\App\Http\Controllers\Admin\CategoryController::class, 'updateOrder'])->name('admin.categories.update-order');
    Route::post('subcategories/reorder', [\App\Http\Controllers\Admin\SubcategoryController::class, 'reorder'])->name('admin.subcategories.reorder');
    Route::patch('subcategories/{subcategory}/update-order', [\App\Http\Controllers\Admin\SubcategoryController::class, 'updateOrder'])->name('admin.subcategories.update-order');
    Route::post('places/reorder', [\App\Http\Controllers\Admin\PlaceController::class, 'reorder'])->name('admin.places.reorder');
    Route::patch('places/{place}/update-order', [\App\Http\Controllers\Admin\PlaceController::class, 'updateOrder'])->name('admin.places.update-order');
    Route::post('places/{place}/reorder-images', [\App\Http\Controllers\Admin\PlaceController::class, 'reorderImages'])->name('admin.places.reorder-images');
    
    // Brand ordering routes
    Route::post('subcategories/{subcategory}/brands/reorder', [\App\Http\Controllers\Admin\BrandController::class, 'reorder'])->name('admin.brands.reorder');
    Route::patch('brands/{brand}/update-order', [\App\Http\Controllers\Admin\BrandController::class, 'updateOrder'])->name('admin.brands.update-order');
    
    // Brand API endpoint
    Route::get('api/subcategories/{subcategory}/brands', [\App\Http\Controllers\Admin\BrandController::class, 'getBrands'])->name('admin.api.brands');
    
    // Comments Management
    Route::get('/comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('admin.comments.index');
    Route::patch('/comments/{comment}/approve', [\App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('admin.comments.approve');
    Route::delete('/comments/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('admin.comments.destroy');
    
    // Site Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
});


require __DIR__.'/auth.php';
