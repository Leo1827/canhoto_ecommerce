<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuscriptionStripeController;
use App\Http\Controllers\PaypalOrderController;

Route::post('/stripe/webhook', [SuscriptionStripeController::class, 'stripeWebhook']);


Route::post('/paypal/webhook', [PaypalOrderController::class, 'webhook'])->name('paypal.webhook');

