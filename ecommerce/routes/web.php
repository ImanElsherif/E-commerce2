<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CategoryController::class, 'welcome'])->name('welcome');

Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::middleware('isAdmin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });

    // User Routes (Non-Admin users)
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');



Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);



Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index')->middleware('auth');



Route::get('/', [ProductController::class, 'filter'])->name('filter');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class);
});


Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('/userShow/{id}', [ProductController::class, 'userShow'])->name('userShow');
});



Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
});

Route::prefix('cart')->name('cart.')->middleware('auth')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{productId}', [CartController::class, 'add'])->name('add');
    Route::post('/update/{itemId}', [CartController::class, 'update'])->name('update');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/delete/{itemId}', [CartController::class, 'delete'])->name('delete');

});
