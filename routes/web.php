<?php

use Illuminate\Support\Facades\Route;
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
