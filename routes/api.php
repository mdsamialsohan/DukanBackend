<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth'])->group(function () {
    Route::post('NewCustomer', [\App\Http\Controllers\CustomerController::class, 'store'])->name('NewCustomer');
    Route::get('customer/{customerId}/ledger', [\App\Http\Controllers\CustomerController::class, 'ledger']);
    Route::get('customers', [\App\Http\Controllers\CustomerController::class, 'index'])->name('customers');
    Route::get('Product',[\App\Http\Controllers\ProductController::class,'index']);
    Route::post('AddProduct',[\App\Http\Controllers\ProductController::class,'Create']);
    Route::get('ProductCat',[\App\Http\Controllers\ProductCat::class,'index'])->name('ProductCat');
    Route::post('AddProductCat',[\App\Http\Controllers\ProductCat::class,'Create'])->name('AddProductCat');
    Route::get('ProductBrand',[\App\Http\Controllers\BrandController::class,'index']) ->name('ProductBrand');
    Route::post('AddProductBrand',[\App\Http\Controllers\BrandController::class,'Create'])  ->name('AddProductBrand');
    Route::get('ProductUnit',[\App\Http\Controllers\ProductUnitController::class,'index']);
    Route::post('AddProductUnit',[\App\Http\Controllers\ProductUnitController::class,'Create']);

    Route::get('VendorList',[\App\Http\Controllers\VendorController::class,'index']);
    Route::post('NewVendor',[\App\Http\Controllers\VendorController::class,'Create']);

    Route::get('PurchaseExpList',[\App\Http\Controllers\PurchaseExpenseListController::class,'index']);
    Route::post('AddPurchaseExpList',[\App\Http\Controllers\PurchaseExpenseListController::class,'Create']);

    Route::post('Purchase',[\App\Http\Controllers\PurchaseMemoController::class,'store']);
    Route::post('DebtPay',[\App\Http\Controllers\PurchaseMemoController::class,'Debt']);

    Route::post('sell',[\App\Http\Controllers\SellDtlsController::class,'store']);
    Route::post('DuePay',[\App\Http\Controllers\SellDtlsController::class,'Due']);
    Route::get('sellMemoDetails/{sellMemoID}',[\App\Http\Controllers\SellDtlsController::class,'getSellMemoDetails']);

    Route::get('Account',[\App\Http\Controllers\AccountController::class,'index']);
    Route::post('NewAccount',[\App\Http\Controllers\AccountController::class,'store']);
    Route::post('BalanceTransfer',[\App\Http\Controllers\AccountController::class,'transfer']);
    Route::post('CashDeclare',[\App\Http\Controllers\AccountController::class,'Declare']);
});




