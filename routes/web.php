<?php
// admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SubscriptionHistoryController;
// public
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;

// users
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\SubscriptionPagoController;
use App\Http\Controllers\SuscriptionStripeController;
use App\Http\Controllers\SubscriptionMollieController;

Route::get('/', function () {
    return view('welcome');
});
// paypal
Route::middleware(['auth', 'verified'])->get('/checkout', [PlanController::class, 'index'])->name('plan.index');
Route::middleware(['auth', 'verified'])->post('/subscription/capture', [SubscriptionPagoController::class, 'capturePaypalOrder'])->name('paypal.capture');
Route::middleware(['auth', 'verified'])->get('/checkout/thanks', [SubscriptionPagoController::class, 'viewThanks'])->name('checkout.thanks');
Route::middleware(['auth', 'verified'])->post('/paypal/webhook', [SubscriptionPagoController::class, 'paypalWebhook']);

// strpie
Route::middleware(['auth', 'verified'])->post('/stripe/checkout', [SuscriptionStripeController::class, 'createStripeCheckout'])->name('stripe.checkout');
Route::middleware(['auth', 'verified'])->get('/stripe/success', [SuscriptionStripeController::class, 'stripeSuccess'])->name('stripe.success');
Route::middleware(['auth', 'verified'])->get('/stripe/cancel', [SuscriptionStripeController::class, 'stripeCancel'])->name('stripe.cancel');
Route::middleware(['auth', 'verified'])->post('/webhook/stripe', [SuscriptionStripeController::class, 'stripeWebhook'])->name('stripe.webhook');

// mollie
Route::middleware(['auth', 'verified'])->post('/mollie/checkout', [SubscriptionMollieController::class, 'createMollieCheckout'])->name('mollie.checkout');
Route::middleware(['auth', 'verified'])->get('/mollie/success', [SubscriptionMollieController::class, 'mollieSuccess'])->name('mollie.success');
Route::middleware(['auth', 'verified'])->post('/mollie/webhook', [SubscriptionMollieController::class, 'mollieWebhook'])->name('mollie.webhook');


require __DIR__.'/auth.php';
// User
Route::middleware(['auth', 'verified', 'userMiddleware', 'hasPlan'])->group(function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

// admin routes
Route::middleware(['auth','adminMiddleware'])->group(function(){

    Route::get('/admin/dashboard',[AdminController::class,'index'])->name('admin.dashboard');
    // CRUD de planes para admin
    Route::get('/admin/plans', [PlansController::class, 'index'])->name('admin.plans.index');
    Route::post('/admin/plans', [PlansController::class, 'store'])->name('admin.plans.store');
    Route::get('/admin/plans/{plan}/edit', [PlansController::class, 'edit'])->name('admin.plans.edit');
    Route::put('/admin/plans/{plan}', [PlansController::class, 'update'])->name('admin.plans.update');
    Route::delete('/admin/plans/{plan}', [PlansController::class, 'destroy'])->name('admin.plans.destroy');
    // disabled and enable plan
    Route::patch('/admin/plans/{plan}/toggle-active', [PlansController::class, 'toggleActive'])->name('admin.plans.toggleActive');

    // CRUD de métodos de pago
    Route::get('/admin/payment-methods', [PaymentMethodController::class, 'index'])->name('admin.payment_methods.index');
    Route::post('/admin/payment-methods', [PaymentMethodController::class, 'store'])->name('admin.payment_methods.store');
    Route::get('/admin/payment-methods/{id}/edit', [PaymentMethodController::class, 'edit'])->name('admin.payment_methods.edit');
    Route::put('/admin/payment-methods/{id}', [PaymentMethodController::class, 'update'])->name('admin.payment_methods.update');
    Route::delete('/admin/payment-methods/{id}', [PaymentMethodController::class, 'destroy'])->name('admin.payment_methods.destroy');
    Route::patch('/admin/payment-methods/{id}/toggle-active', [PaymentMethodController::class, 'toggleActive'])->name('admin.payment_methods.toggleActive');

    // CRUD de monedas
    Route::get('/admin/currencies', [CurrencyController::class, 'index'])->name('admin.currencies.index');
    Route::post('/admin/currencies', [CurrencyController::class, 'store'])->name('admin.currencies.store');
    Route::get('/admin/currencies/{currency}/edit', [CurrencyController::class, 'edit'])->name('admin.currencies.edit');
    Route::put('/admin/currencies/{currency}', [CurrencyController::class, 'update'])->name('admin.currencies.update');
    Route::delete('/admin/currencies/{currency}', [CurrencyController::class, 'destroy'])->name('admin.currencies.destroy');
    Route::patch('/admin/currencies/{currency}/toggle-active', [CurrencyController::class, 'toggleActive'])->name('admin.currencies.toggleActive');

    // CRUD de suscripciones
    Route::get('/admin/subscriptions', [SubscriptionController::class, 'index'])->name('admin.subscriptions.index');
    Route::get('/admin/subscriptions/{subscription}/edit', [SubscriptionController::class, 'edit'])->name('admin.subscriptions.edit');
    Route::put('/admin/subscriptions/{subscription}', [SubscriptionController::class, 'update'])->name('admin.subscriptions.update');
    Route::delete('/admin/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('admin.subscriptions.destroy');

    // Historial de suscripciones
    Route::get('/admin/subscription-history', [SubscriptionHistoryController::class, 'index'])->name('admin.subscription_history.index');

});