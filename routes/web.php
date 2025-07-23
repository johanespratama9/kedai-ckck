<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/order', [OrderController::class, 'create']);
// Route::post('/order/{order}/add-item', [App\Http\Controllers\OrderController::class, 'addItem'])->name('order.addItem');
// Route::post('/order/{order}/add-item', [OrderController::class, 'addItem'])->name('order.addItem');
// Route::post('/order/{order}/submit', [OrderController::class, 'submitOrder'])->name('order.submit');
// Route::post('/order/{order}/remove-item/{item}', [OrderController::class, 'removeItem'])->name('order.removeItem');
