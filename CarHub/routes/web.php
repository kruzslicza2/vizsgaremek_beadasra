<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return redirect('/cars');
});

Route::get('/reg', [UserController::class, 'RegForm']);
Route::post('/reg', [UserController::class, 'RegButton']);
Route::get('/login', [UserController::class, 'Login'])->name('login');
Route::post('/login', [UserController::class, 'LoginButton']);
Route::get('/logout', [UserController::class, 'Logout']);
Route::post('/password/remind', [UserController::class, 'sendPasswordReminder'])->name('password.remind');

// Public routes
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
Route::get('/user/{user}/cars', [CarController::class, 'userCars'])->name('user.cars');
Route::get('/api/brands/{brand}/models', [CarModelController::class, 'getModelsByBrand'])->name('api.models.by.brand');

Route::middleware(['auth'])->group(function () {
    // Autó műveletek
    Route::get('/feltoltes', [CarController::class, 'create'])->name('cars.create');
    Route::post('/feltoltes', [CarController::class, 'store']);
    Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    Route::delete('/cars/{car}/images/{image}', [CarController::class, 'deleteImage'])->name('cars.deleteImage');
    Route::get('/my-cars', [CarController::class, 'myCars'])->name('cars.my');

    // Márka műveletek
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');

    // Modell műveletek
    Route::get('/brands/{brand}/models', [CarModelController::class, 'index'])->name('models.index');
    Route::post('/brands/{brand}/models', [CarModelController::class, 'store'])->name('models.store');
    Route::delete('/brands/{brand}/models/{model}', [CarModelController::class, 'destroy'])->name('models.destroy');

    // Üzenet műveletek
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{car}', [MessageController::class, 'store'])->name('messages.store');

    // Kedvencek műveletek
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{car}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::delete('/favorites/{car}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Profil műveletek
    Route::get('/profile', [UserController::class, 'Profile'])->name('profile.show');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');

    // Admin
    Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        // Felhasználók törlése
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.delete');

        // Hirdetések törlése adminoknak
        Route::delete('/cars/{car}', [AdminController::class, 'destroyCar'])->name('admin.cars.delete');
        Route::get('/cars', [AdminController::class, 'manageCars'])->name('admin.cars');
        // Márka tölrés
        Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
        // Felhasználó kezelés külön menü
        Route::get('/users', [AdminController::class, 'listUsers'])->name('admin.users');
    });
});
