<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\QuoteItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('quotes', QuoteController::class);
    Route::post('/quotes/{quote}/duplicate', [QuoteController::class, 'duplicate'])->name('quotes.duplicate');

    Route::resource('quote-items', QuoteItemController::class);
    Route::post('/quote-items/{quoteItem}/duplicate', [QuoteItemController::class, 'duplicate'])->name('quote-items.duplicate');
    Route::post('/quote-items/addCatalogueProduct/{quoteId}', [QuoteItemController::class, 'addCatalogueProduct'])->name('quote-items.addCatalogueProduct');

    Route::resource('proposals', ProposalController::class);

    Route::resource('users', UserController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('reports', UserController::class);
    Route::resource('products', ProductController::class);
    Route::get('api/get-product-types', [ProductController::class, 'getProductTypes'])->name('products.getProductTypes');
    Route::get('api/get-product-sub-types/{typeId}', [ProductController::class, 'getProductSubTypes'])->name('products.getProductSubTypes');
    Route::get('api/get-products/{typeId}/{subTypeId}', [ProductController::class, 'getProducts'])->name('products.getProducts');

});

require __DIR__.'/auth.php';
