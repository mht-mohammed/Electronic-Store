<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\DiscountController;

// Redirect الصفحة الرئيسية
Route::get('/', fn() => redirect('/admin/dashboard'));

// Redirect صفحة Breeze الافتراضية
Route::get('/dashboard', fn() => redirect('/admin/dashboard'))->middleware(['auth']);

// ===== Admin Routes =====
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

     // Dashboard
     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

     // المنتجات
     Route::resource('products', ProductController::class);

     // التصنيفات
     Route::resource('categories', CategoryController::class);

     // الطلبات
     Route::resource('orders', OrderController::class)
          ->only(['index', 'show', 'update', 'destroy']);
     Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])
          ->name('orders.status');

     // العملاء
     Route::resource('customers', CustomerController::class)
          ->only(['index', 'show', 'destroy']);
     Route::patch('customers/{customer}/toggle', [CustomerController::class, 'toggle'])
          ->name('customers.toggle');

     // التقييمات
     Route::resource('reviews', ReviewController::class)
          ->only(['index', 'show', 'destroy']);
     Route::patch('reviews/{review}/status', [ReviewController::class, 'updateStatus'])
          ->name('reviews.status');

     // الخصومات
     Route::resource('discounts', DiscountController::class);
});

Route::get('/dashboard', fn() => redirect('/admin/dashboard'))->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
