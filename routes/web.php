<?php
// admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SubscriptionHistoryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WineryController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\WineTypeController;
use App\Http\Controllers\Admin\VintageController;
use App\Http\Controllers\Admin\ConditionController;
use App\Http\Controllers\Admin\ProductInventoryController;
use App\Http\Controllers\ProductController;
// public
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;

// users
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\SubscriptionPagoController;
use App\Http\Controllers\SuscriptionStripeController;
use App\Http\Controllers\SubscriptionMollieController;
use App\Http\Controllers\ProductUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AddressUserController;
use App\Http\Controllers\PaypalOrderController;
use App\Http\Controllers\StripeOrderController;
use App\Http\Controllers\MollieOrderController;
// view orders
use App\Http\Controllers\UserOrderController;
// view suscripcion 
use App\Http\Controllers\SubscriptionStoreController;

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
// Route::post('/stripe/webhook', [SuscriptionStripeController::class, 'stripeWebhook'])->name('stripe.webhook');

// mollie
Route::middleware(['auth', 'verified'])->post('/mollie/checkout', [SubscriptionMollieController::class, 'createMollieCheckout'])->name('mollie.checkout');
Route::middleware(['auth', 'verified'])->get('/mollie/success', [SubscriptionMollieController::class, 'mollieSuccess'])->name('mollie.success');
Route::post('/mollie/webhook', [SubscriptionMollieController::class, 'mollieWebhook'])->name('mollie.webhook'); // Webhooks nunca llevan middleware de auth


require __DIR__.'/auth.php';

// User
Route::middleware(['auth', 'verified', 'userMiddleware', 'hasPlan'])->group(function () {
    // orders user
    Route::get('/user-exclusive/orders', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::get('/user-exclusive/orders/{order}', [UserOrderController::class, 'show'])->name('user.orders.show');
    // store products
    Route::get('/user/store', [ProductUserController::class, 'index'])->name('products.user.store');
    // Ruta del detalle del producto
    Route::get('/store/user/{slug}', [ProductUserController::class, 'show'])->name('products.show');
    // suscripcion
    Route::get('/user-exclusive/minhas-assinaturas', [SubscriptionStoreController::class, 'index'])->name('subscriptions.user.index');

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // json
    Route::get('/cart/json', [CartController::class, 'json'])->name('cart.json');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // checkout cart
    Route::get('/user/cart/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/waiting-room', [CheckoutController::class, 'waitingRoom'])->name('checkout.waiting_room');
    
    // paypal
    Route::post('/user/checkout/payment', [PaypalOrderController::class, 'startPayment'])->name('checkout.pay');
    Route::get('/checkout/paypal/success', [PaypalOrderController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('/checkout/paypal/cancel', [PaypalOrderController::class, 'paypalCancel'])->name('paypal.cancel');
    Route::get('/checkout/payment/paypal/Thanks', [PaypalOrderController::class, 'paypalThanks'])->name('paypal.thanks');

    // stripe
    Route::post('/user/checkout/stripe', [StripeOrderController::class, 'startPayment'])->name('stripe.start');
    Route::get('/checkout/stripe/success', [StripeOrderController::class, 'stripeSuccess'])->name('stripe.store.success');
    Route::get('/checkout/stripe/cancel', [StripeOrderController::class, 'stripeCancel'])->name('stripe.store.cancel');
    Route::get('/checkout/payment/thanks', [StripeOrderController::class, 'stripeThanks'])->name('stripe.store.thanks');
    Route::post('/checkout/stripe/webhook', [StripeOrderController::class, 'webhook'])->name('stripe.store.webhook');

    // mollie
    Route::post('/user/checkout/mollie', [MollieOrderController::class, 'startPayment'])->name('mollie.store.start');
    Route::get('/checkout/mollie/success', [MollieOrderController::class, 'success'])->name('mollie.store.success');
    Route::get('/checkout/mollie/cancel', [MollieOrderController::class, 'cancel'])->name('mollie.store.cancel');
    Route::get('/checkout/payment/mollie/thanks', [MollieOrderController::class, 'thanks'])->name('mollie.store.thanks');

    // user address
    Route::post('/user/address', [AddressUserController::class, 'storeAddress'])->name('addresses.store');
    Route::put('/addresses/{address}', [AddressUserController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressUserController::class, 'destroy'])->name('addresses.destroy');

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
    
    // CRUD Categorias
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{parent}/subcategories', [CategoryController::class, 'subcategories'])->name('categories.subcategories');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        
    // CRUD Wineries
        Route::get('vinicolas', [WineryController::class, 'index'])->name('wineries.index');
        Route::post('vinicolas', [WineryController::class, 'store'])->name('wineries.store');
        Route::get('vinicolas/{winery}/editar', [WineryController::class, 'edit'])->name('wineries.edit');
        Route::put('vinicolas/{winery}', [WineryController::class, 'update'])->name('wineries.update');
        Route::delete('vinicolas/{winery}', [WineryController::class, 'destroy'])->name('wineries.destroy');

    // CRUD Regions
        Route::get('regioes', [RegionController::class, 'index'])->name('regions.index');
        Route::post('regioes', [RegionController::class, 'store'])->name('regions.store');
        Route::get('regioes/{region}/editar', [RegionController::class, 'edit'])->name('regions.edit');
        Route::put('regioes/{region}', [RegionController::class, 'update'])->name('regions.update');
        Route::delete('regioes/{region}', [RegionController::class, 'destroy'])->name('regions.destroy');

    // CRUD Wine Types
        Route::get('tipos-de-vinho', [WineTypeController::class, 'index'])->name('wine_types.index');
        Route::post('tipos-de-vinho', [WineTypeController::class, 'store'])->name('wine_types.store');
        Route::get('tipos-de-vinho/{wineType}/editar', [WineTypeController::class, 'edit'])->name('wine_types.edit');
        Route::put('tipos-de-vinho/{wineType}', [WineTypeController::class, 'update'])->name('wine_types.update');
        Route::delete('tipos-de-vinho/{wineType}', [WineTypeController::class, 'destroy'])->name('wine_types.destroy');

    // CRUD Vintages
        Route::get('safras', [VintageController::class, 'index'])->name('vintages.index');
        Route::post('safras', [VintageController::class, 'store'])->name('vintages.store');
        Route::get('safras/{vintage}/editar', [VintageController::class, 'edit'])->name('vintages.edit');
        Route::put('safras/{vintage}', [VintageController::class, 'update'])->name('vintages.update');
        Route::delete('safras/{vintage}', [VintageController::class, 'destroy'])->name('vintages.destroy');

    // CRUD Conditions
        Route::get('admin/condicoes', [ConditionController::class, 'index'])->name('conditions.index');
        Route::post('admin/condicoes', [ConditionController::class, 'store'])->name('conditions.store');
        Route::get('admin/condicoes/{condition}/editar', [ConditionController::class, 'edit'])->name('conditions.edit');
        Route::put('admin/condicoes/{condition}', [ConditionController::class, 'update'])->name('conditions.update');
        Route::delete('admin/condicoes/{condition}', [ConditionController::class, 'destroy'])->name('conditions.destroy');

    // CRUD Products
        Route::get('admin/produtos', [ProductController::class, 'index'])->name('products.index');
        Route::get('admin/produtos/criar', [ProductController::class, 'create'])->name('products.create');
        Route::post('admin/produtos', [ProductController::class, 'store'])->name('products.store');
        Route::get('admin/produtos/{product}/editar', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('admin/produtos/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('admin/produtos/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
            // product gallery
        Route::post('/admin/products/{product}/gallery', [ProductController::class, 'uploadGalleryImage'])->name('products.gallery.upload');
        Route::delete('/admin/products/gallery/{gallery}', [ProductController::class, 'deleteGalleryImage'])->name('products.gallery.destroy');
            
            // admin/products/{product}/inventories
        Route::prefix('admin/products/{product}')->name('admin.products.')->middleware(['auth', 'adminMiddleware'])->group(function () {
            Route::get('inventories', [ProductInventoryController::class, 'index'])->name('inventories.index');
            Route::get('inventories/create', [ProductInventoryController::class, 'create'])->name('inventories.create');
            Route::post('inventories', [ProductInventoryController::class, 'store'])->name('inventories.store');
            Route::get('inventories/{inventory}/edit', [ProductInventoryController::class, 'edit'])->name('inventories.edit');
            Route::put('inventories/{inventory}', [ProductInventoryController::class, 'update'])->name('inventories.update');
            Route::delete('inventories/{inventory}', [ProductInventoryController::class, 'destroy'])->name('inventories.destroy');
        });

            // Lixeira / Soft Deletes
        Route::get('produtos/lixeira', [ProductController::class, 'trash'])->name('products.trash');
        Route::put('produtos/{id}/restaurar', [ProductController::class, 'restore'])->name('products.restore');
        Route::delete('produtos/{id}/excluir-definitivamente', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
            // disabled and enable product
        Route::patch('/admin/product/{product}/toggle-active', [ProductController::class, 'toggleActive'])->name('admin.product.toggleActive');

});