<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AtelierController;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/page', [PageController::class, 'index'])->name('page.index');
Route::get('/page/about', [PageController::class, 'about'])->name('page.about');
Route::get('/page/faq', [PageController::class, 'faq'])->name('page.faq');
Route::get('/page/match', [PageController::class, 'match'])->name('page.match');
Route::get('/page/catalog', [PageController::class, 'catalog'])->name('page.catalog');
Route::get('/page/select', [PageController::class, 'select'])->name('page.select');
Route::post('/page/result', [PageController::class, 'result'])->name('page.result');
Route::get('/page/atelier', [AtelierController::class, 'index'])->name('page.atelier');
Route::get('/page/atelier/{id}', [AtelierController::class, 'show'])->name('page.atelier.show');

Route::get('/page/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/page/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/page/blog/tag/{slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/page/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/page/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/page/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/page/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/page/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function(){
    Route::post('/page/blog/{post}/comments', [BlogController::class, 'comment'])->name('blog.comment');
});

require __DIR__.'/auth.php';
