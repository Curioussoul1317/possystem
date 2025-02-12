<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanPaymentController;
use App\Models\Loan;
 use App\Http\Controllers\BannersController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('welcome');
})->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
 
// Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
 
// 

// // Registration Routes
// Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Password Reset Routes
// Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// // Password Confirmation Routes
// Route::get('/password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
// Route::post('/password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'confirm']);

// // Email Verification Routes
// Route::get('/email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
// Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
// Route::post('/email/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');






Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Basic CRUD routes
    Route::resource('inventory', InventoryController::class);

    // Image management routes
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::post('{inventory}/images/order', [InventoryController::class, 'updateImageOrder'])
            ->name('images.order');
            
        Route::post('{inventory}/images/primary', )
            ->name('images.primary');
 
        Route::post('images/{image}/primary', [InventoryController::class, 'setPrimary'])
            ->name('images.primary');
            
        Route::delete('images/{image}', [InventoryController::class, 'deleteImage'])
            ->name('images.delete');
            
        Route::post('{inventory}/stock/adjust', [InventoryController::class, 'adjustStock'])
            ->name('stock.adjust');
    });


        // Brand routes
    Route::prefix('brands')->name('brands.')->group(function () {
        Route::get('/', [BrandsController::class, 'index'])->name('index');
        // Route::get('/create', [BrandsController::class, 'create'])->name('create');
        Route::post('/', [BrandsController::class, 'store'])->name('store');
        Route::get('/{brand}/edit', [BrandsController::class, 'edit'])->name('edit');
        Route::put('/{brand}', [BrandsController::class, 'update'])->name('update');
        Route::delete('/{brand}', [BrandsController::class, 'destroy'])->name('destroy');
    });

    // Category routes
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('create');
        Route::post('/', [CategoriesController::class, 'store'])->name('store');
        Route::get('/{categories}/edit', [CategoriesController::class, 'edit'])->name('edit');
        Route::put('/{categories}', [CategoriesController::class, 'update'])->name('update');
        Route::delete('/{categories}', [CategoriesController::class, 'destroy'])->name('destroy');

        // Additional category management routes
        Route::post('/order', [CategoriesController::class, 'updateOrder'])->name('order.update');
        Route::get('/{categories}/subcategories', [CategoriesController::class, 'getSubcategories'])->name('subcategories');
    });



      Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/', [SalesController::class, 'index'])->name('index');
        Route::get('/create', [SalesController::class, 'create'])->name('create');
        Route::post('/', [SalesController::class, 'store'])->name('store');
        Route::get('/{sale}', [SalesController::class, 'show'])->name('show');
        Route::get('/{sale}/invoice', [SalesController::class, 'generateInvoice'])->name('invoice');
        Route::post('/{sale}/void', [SalesController::class, 'voidSale'])->name('void');
        
        // Product search route for POS
        // Route::get('/sales/search/products', [SalesController::class, 'searchProducts'])->name('search.products');
      
    });
   Route::get('/sales/search/products', [SalesController::class, 'searchProducts'])->name('search.products');

 
    Route::get('/customers', [CustomersController::class, 'index'])->name('customers.index');
Route::get('/customers/create', [CustomersController::class, 'create'])->name('customers.create');
Route::post('/customers', [CustomersController::class, 'store'])->name('customers.store');
Route::get('/customers/{customers}/edit', [CustomersController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{customers}', [CustomersController::class, 'update'])->name('customers.update');
Route::delete('/customers/{customers}', [CustomersController::class, 'destroy'])->name('customers.destroy');

// Additional custom routes if needed:
Route::get('/customers/search', [CustomersController::class, 'search'])->name('customers.search');
Route::get('/customers/export', [CustomersController::class, 'export'])->name('customers.export');


 Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');




    Route::get('/cart', [CartsController::class, 'index'])->name('cart.index');
    Route::post('/cart/items', [CartsController::class, 'addItem'])->name('cart.add');
    Route::patch('/cart/items/{cartItem}', [CartsController::class, 'updateItemQuantity'])->name('cart.update');
    Route::delete('/cart/items/{cartItem}', [CartsController::class, 'removeItem'])->name('cart.remove'); 
    Route::post('/cart/{cartid}', [CartsController::class, 'updateStatus'])->name('cart.updateStatus');
    Route::delete('/cart/{cart}', [CartsController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart/{id}', [CartsController::class, 'show'])->name('cart.show'); 
    Route::get('/check-new-orders', [CartsController::class, 'checkNewOrders']);
    // Checkout Routes
    Route::get('/checkout', [CartsController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout/process', [CartsController::class, 'processCheckout'])->name('cart.processPayment');


     
    // Expense routes
    Route::resource('expenses', ExpenseController::class);
Route::get('expenses/category/{category}', [ExpenseController::class, 'byCategory'])->name('expenses.category');
    Route::get('expenses/report/monthly', [ExpenseController::class, 'monthlyReport']);
    
    // Loan routes
    Route::resource('loans', LoanController::class);
   Route::get('loans/status/{status}', [LoanController::class, 'byStatus'])->name('loans.status');
   
     Route::post('loans/{loan}/approve', [LoanController::class, 'approve']);
    Route::post('loans/{loan}/reject', [LoanController::class, 'reject']);
    
    // Loan payment routes
    Route::resource('loan-payments', LoanPaymentController::class);
   Route::get('loans/{loan}/payments', [LoanPaymentController::class, 'loanPayments'])->name('loans.payments');
 Route::get('loans/{loan}/make-payment', [LoanPaymentController::class, 'create'])->name('loan-payments.create');



Route::resource('banners', BannersController::class);

});