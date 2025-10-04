<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AtelierController;
use App\Http\Controllers\Atelier\PostController;
use App\Http\Controllers\Atelier\AtelierPhotoController; 
use App\Http\Controllers\Atelier\AtelierCommentController;
use App\Models\Atelier; 

    Route::get('/', [PageController::class, 'index'])->name('home');
    Route::controller(PageController::class)->name('page.')->group(function () {
    Route::get('/page', 'index')->name('index'); 
    Route::get('/page/about', 'about')->name('about');
    Route::get('/page/faq', 'faq')->name('faq');
    Route::get('/page/match', 'match')->name('match');
    Route::get('/page/catalog', 'catalog')->name('catalog');
    Route::get('/page/select', 'select')->name('select');
    Route::post('/page/result', 'result')->name('result');
});

    Route::controller(AtelierController::class)->name('page.')->group(function () {
    Route::get('/page/atelier', 'index')->name('atelier');
    Route::get('/page/atelier/{slug}', 'show')->name('atelier.show');
});

Route::prefix('ateliers/{atelier:slug}')->name('ateliers.')->group(function () {
    Route::get('photos', [AtelierPhotoController::class, 'index'])->name('photos.index');
});
Route::get('/page/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->name('profile.')->controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'edit')->name('edit');
    Route::patch('/profile', 'update')->name('update');
    Route::delete('/profile', 'destroy')->name('destroy');
});

require __DIR__.'/auth.php';


Route::middleware(['web','auth'])->prefix('atelier')->name('atelier.')->group(function () {
    Route::resource('posts', PostController::class); 
});

Route::middleware(['auth'])->prefix('ateliers/{atelier:slug}')->name('ateliers.')->group(function () {
    Route::resource('photos', AtelierPhotoController::class);
    Route::post('comments', [AtelierCommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{comment}', [AtelierCommentController::class, 'destroy'])->name('comments.destroy');
});

