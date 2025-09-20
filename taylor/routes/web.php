<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('welcome');
}); 

Route::middleware(['query.mode'])->group(function () {
    Route::get('/smth', function () {
        return 'Hello World)';
    });
});


Route::get('/page', [PageController::class, 'index'])->name('page.index');
Route::get('/page/about', [PageController::class, 'about'])->name('page.about');
Route::get('/page/atelier', [PageController::class, 'atelier'])->name('page.atelier');
Route::get('/page/faq', [PageController::class, 'faq'])->name('page.faq');
