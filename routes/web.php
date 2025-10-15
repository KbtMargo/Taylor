<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AtelierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Atelier\AtelierPhotoController;
use App\Http\Controllers\Atelier\AtelierCommentController;

Route::get('/', [PageController::class, 'index'])->name('home');

Route::controller(PageController::class)->prefix('page')->name('page.')->group(function () {
    Route::get('/index', 'index')->name('index');
    Route::get('/about', 'about')->name('about');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/catalog', 'catalog')->name('catalog');
    Route::get('/match', 'match')->name('match');
    Route::get('/select', 'select')->name('select');
    Route::post('/result', 'result')->name('result');
});

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/order/success', fn() => view('order.success'))->name('orders.success');

Route::get('/ateliers', [AtelierController::class, 'index'])->name('ateliers.index');
Route::get('/ateliers/{atelier:slug}', [AtelierController::class, 'show'])->name('ateliers.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth'])->prefix('ateliers/{atelier:slug}')->name('ateliers.')->group(function () {
    Route::resource('photos', AtelierPhotoController::class);
    Route::post('comments', [AtelierCommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{comment}', [AtelierCommentController::class, 'destroy'])->name('comments.destroy');
});

require __DIR__.'/auth.php';