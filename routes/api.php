<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuscriptionStripeController;

Route::post('/stripe/webhook', [SuscriptionStripeController::class, 'stripeWebhook']);
