<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [HomeController::class, 'allCategories'])->name('categories.all');

Route::post('/language/{locale}', function ($locale) {
    if (in_array($locale, config('app.available_locales'))) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return response()->json(['success' => true, 'locale' => $locale]);
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
