<?php

use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('checkout');
});


Route::get('/checkout', [StripeController::class, 'checkout'])->name('checkout');
Route::get('/payment-success', [StripeController::class, 'success'])->name('payment-success');
Route::get('/payment-cancel', [StripeController::class, 'cancel'])->name('payment-cancel');