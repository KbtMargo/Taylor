<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
}); 

Route::middleware(['query.mode'])->group(function () {
    Route::get('/smth', function () {
        return 'Hello World)';
    });
});
