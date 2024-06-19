<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\{
    DashboardController,
    AuthController,
    ProductController
};
use App\Http\Controllers\User\{
    CartController,
    ProductListController
};

Route::get('/', [UserController::class,'index'])->name('home');
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Admin routes
Route::middleware(['redirectAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
    Route::get('/logout', [AuthController::class, 'index'])->name('logout');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::post('/products/store',[ProductController::class,'store'])->name('products.store');
    Route::put('/products/update/{id}',[ProductController::class,'update'])->name('products.update');
    Route::delete('/products/image/{id}',[ProductController::class,'deleteImage'])->name('products.image.delete');
    Route::delete('/products/destroy/{id}',[ProductController::class,'destroy'])->name('products.destroy');
});

Route::prefix('cart')->controller(CartController::class)->group(function () {
    Route::get('view','view')->name('cart.view');
    Route::post('store/{product}','store')->name('cart.store');
    Route::patch('update/{product}','update')->name('cart.update');
    Route::delete('delete/{product}','delete')->name('cart.delete');
});

Route::prefix('products')->controller(ProductListController::class)->group(function ()  {
    Route::get('/','index')->name('products.index');
});