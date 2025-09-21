<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'index'])->name('home');

Route::get('/page', [PageController::class, 'index'])->name('page.index');
Route::get('/page/about', [PageController::class, 'about'])->name('page.about');
Route::get('/page/atelier', [PageController::class, 'atelier'])->name('page.atelier');
Route::get('/page/faq', [PageController::class, 'faq'])->name('page.faq');

Route::get('/health', fn () => 'OK');

//
Route::get('/page/match', action: [PageController::class, 'match'])->name('page.match');
Route::get('/page/catalog', action: [PageController::class, 'catalog'])->name('page.catalog');
Route::get('/page/select', action: [PageController::class, 'select'])->name('page.select');
//
Route::post('/page/result', [PageController::class, 'result'])->name('page.result');


