<?php

use App\Exports\OrdersExport;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

// Order flow
Route::get('/order', [OrderController::class, 'showForm'])->name('order.form');
Route::post('/order/{order}/add-item', [OrderController::class, 'addItem'])->name('order.addItem');
Route::post('/order/item/{item}/remove', [OrderController::class, 'removeItem'])->name('order.removeItem');
Route::post('/order/item/{item}/edit', [OrderController::class, 'editItem'])->name('order.editItem');
Route::post('/order/{order}/submit', [OrderController::class, 'submit'])->name('order.submit');
Route::post('/order/{order}/submit', [OrderController::class, 'submit'])->name('order.submit');
// Route::get('/order/{order}/invoice/download', [OrderController::class, 'downloadInvoice'])->name('order.downloadInvoice');
Route::get('/order/{order}/invoice/download', [OrderController::class, 'downloadInvoicePdf'])->name('order.downloadInvoice');

Route::get('/order/{order}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');
Route::post('/order/{order}/pay', [OrderController::class, 'pay'])->name('order.pay');

// Payment routes
Route::get('/order/{order}/payment', [OrderController::class, 'showPayment'])->name('order.payment');
Route::post('/order/{order}/process-payment', [OrderController::class, 'processPayment'])->name('order.processPayment');
Route::post('/order/{order}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('order.confirmPayment');

// Export sales to Excel
Route::get('/sales/export', function () {
    return Excel::download(new OrdersExport, 'orders.xlsx');
})->name('sales.export');
