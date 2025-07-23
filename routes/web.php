<?php

use App\Exports\OrdersExport;
use App\Http\Controllers\OrderController;
use Maatwebsite\Excel\Facades\Excel;

// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/order', [OrderController::class, 'showForm'])->name('order.form');
Route::post('/order/{order}', [OrderController::class, 'addItem'])->name('order.addItem');
Route::post('/order/{order}/submit', [OrderController::class, 'submit'])->name('order.submit');
Route::get('/order/{order}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');
Route::post('/order/{order}/pay', [OrderController::class, 'pay'])->name('order.pay');
Route::get('/sales/export', function () {
    return Excel::download(new OrdersExport, 'orders.xlsx');
})->name('sales.export');

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/order', [OrderController::class, 'create']);
// Route::post('/order/{order}/add-item', [App\Http\Controllers\OrderController::class, 'addItem'])->name('order.addItem');
// Route::post('/order/{order}/add-item', [OrderController::class, 'addItem'])->name('order.addItem');
// Route::post('/order/{order}/submit', [OrderController::class, 'submitOrder'])->name('order.submit');
// Route::post('/order/{order}/remove-item/{item}', [OrderController::class, 'removeItem'])->name('order.removeItem');
