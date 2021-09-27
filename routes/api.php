<?php

use App\Http\Controllers\API\AUTH\UserController;
use App\Http\Controllers\API\Bank\BankAdminController;
use App\Http\Controllers\API\Currency\CurrencyController;
use App\Http\Controllers\API\PPATK\CitysController;
use App\Http\Controllers\API\PPATK\CountryController;
use App\Http\Controllers\API\PPATK\ProvincesController;
use App\Http\Controllers\API\Receipt\ReciptsController;
use App\Http\Controllers\API\Transaction\TransactionsController;
use App\Http\Controllers\API\Vendor\VendorKursManualController;
use App\Http\Controllers\API\Voucher\VoucherController;
use App\Http\Controllers\Migrasi\BiChecksController;
use App\Http\Controllers\Migrasi\MigrasiBankList;
use App\Http\Controllers\Migrasi\MigrasiBankListController;
use App\Http\Controllers\Migrasi\MigrasiCityPPATKController;
use App\Http\Controllers\Migrasi\MigrasiCurrencyController;
use App\Http\Controllers\Migrasi\MigrasiCountryController;
use App\Http\Controllers\Migrasi\MigrasiProvinceController;
use App\Models\MigrasiModel\MigrasiCountry;
use App\Models\MigrasiModel\MigrasiProvince;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('migrasi-banklist',[MigrasiBankListController::class,'migrasiBankList']);
// Route::get('migrasi-bicheck',[BiChecksController::class,'migrasiBiCheck']);
// Route::get('migrasi-country',[MigrasiCountryController::class,'migrasiCountry']);
// Route::get('migrasi-currency',[MigrasiCurrencyController::class,'migrasiCurrency']);
// Route::get('migrasi-province',[MigrasiProvinceController::class,'migrasiProvince']);
// Route::get('migrasi-city',[MigrasiCityPPATKController::class,'migrasiCity']);
Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class, 'login']);
Route::prefix('country')->group(function(){
    Route::get('get-country',[CountryController::class,'getCountries']);
    Route::post('create-country',[CountryController::class,'create_country']);
    Route::get('spesifikasi-country/{id}',[CountryController::class,'getSpesificCountry']);
    Route::post('update/{id}',[CountryController::class,'updateCountry']);
});
Route::prefix('province')->group(function(){
    Route::get('get-province',[ProvincesController::class,'getProvince']);
    Route::post('create-province',[ProvincesController::class,'addProv']);
    Route::get('spesifikasi-province/{id_country}',[ProvincesController::class,'getSpesificProv']);
    Route::post('update-province/{id}',[ProvincesController::class,'update_province']);
});
Route::prefix('city')->group(function(){
    Route::get('get-city',[CitysController::class,'getCity']);
    Route::post('create',[CitysController::class,'addCity']);
    Route::get('get-city/{id}',[CitysController::class,'getSpesificCity']);
    Route::get('spesifikasi-city/{id_province}',[CitysController::class,'getCitybyProv']);
});
Route::get('kursmanual',[VendorKursManualController::class,'kursmanual']);
Route::get('kursmanualbyid/{id}',[VendorKursManualController::class,'getKursManualID']);
Route::post('currency-add',[CurrencyController::class,'addCurrency']);
Route::prefix('service')->group(function(){
    Route::post('add',[BankAdminController::class,'addService']);
    Route::get('bank-list',[BankAdminController::class,'getBankList']);
});
Route::middleware(['auth:admin-api','api_admin'])->group(function(){
    Route::prefix('voucher')->group(function(){
        Route::post('create',[VoucherController::class, 'create_voucher']);
        Route::post('delete/{id}',[VoucherController::class, 'delete_voucher']);
        Route::get('retrieve/{start_date}/{end_date}',[VoucherController::class,'retrieve_voucher']);
    });
    Route::prefix('vendor-manual')->group(function(){
        Route::post('create-vendor',[VendorKursManualController::class,'addVendorkurs']);
    });
    Route::prefix('bank')->group(function(){
        Route::post('create',[BankAdminController::class,'addBank']);
        Route::get('get',[BankAdminController::class,'getBank']);
        Route::post('update/{id}',[BankAdminController::class,'updateBank']);
        Route::get('get-byid/{id}',[BankAdminController::class,'getBankID']);
        Route::post('delete/{id}',[BankAdminController::class, 'deleteBank']);
    });
    Route::prefix('currency')->group(function(){
        Route::get('currency', [CurrencyController::class, 'getCurrency']);
        Route::post('update/{id}',[CurrencyController::class,'updateCurrency']);
    });
    Route::prefix('receipt-admin')->group(function(){
        Route::post('create',[ReciptsController::class, 'create_recipts_admin']);
        Route::get('get-receipt/{id}',[ReciptsController::class,'getReceiptByUser']);
    });
    Route::prefix('user')->group(function(){
        Route::post('create-user',[UserController::class,'registerByadmin']);
        Route::post('approve_1/{user_id}',[UserController::class,'approveAdmin']);
        Route::post('approve_2/{user_id}',[UserController::class,'approveSuperAdmin']);
        Route::get('approve_1',[UserController::class,'getApproveadmin']);
        Route::get('approve_2',[UserController::class,'getApprovesuperadmin']);
        Route::get('user-kyc',[UserController::class,'getUserKYC']);
        Route::get('usersapprove/{start_date}/{end_date}',[UserController::class,'getUserApprove']);
        Route::get('usersdata/{start_date}/{end_date}',[UserController::class,'getUserData']);

    });
    Route::prefix('transaction-admin')->group(function(){
        Route::get('transaction_all',[TransactionsController::class,'getAllTrasaction']);
        Route::get('transaction_all_vendosend',[TransactionsController::class,'getAllTrasaction']);
        Route::get('transaction_all/{id}',[TransactionsController::class,'getAllIdTransaction']);
        Route::get('transaction_all_table/{start_date}/{end_date}',[TransactionsController::class,'getAllTrasactionTable']);
        Route::get('transaction_approve_1/{start_date}/{end_date}',[TransactionsController::class,'getApproveadmin']);
        Route::get('transaction_approve_2/{start_date}/{end_date}',[TransactionsController::class,'getApprovesuperadmin']);
        Route::get('report-transaction/{start_date}/{end_date}',[TransactionsController::class,'reportTransaction']);
        Route::get('transaction_complite',[TransactionsController::class,'getAllTrasactionComplit']);
        Route::get('transaction/detail/{id}',[TransactionsController::class,'getApproveadminDetail']);
        Route::post('transaction_approve_1/{id}',[TransactionsController::class,'approveAdmin']);
        Route::post('transaction_approve_2/{id}',[TransactionsController::class,'approveSuperAdmin']);
        Route::get('report-order/{start_date}/{end_date}',[TransactionsController::class,'reportOrder']);
        Route::get('order/{start_date}/{end_date}',[TransactionsController::class,'getOrder']);
    });
});
Route::middleware(['auth:api-user','api_user'])->group(function(){
    Route::get('get-user',[UserController::class,'getUser']);
    Route::prefix('receipt')->group(function(){
        Route::post('create',[ReciptsController::class, 'create_recipts']);
        Route::get('get-receipt',[ReciptsController::class, 'getReceipts']);
        Route::get('get-receipt/{country}',[ReciptsController::class, 'getRecipientCountry']);
        Route::post('update-receipt/{id}',[ReciptsController::class,'updateReceipt']);
    });
    Route::prefix('transaction')->group(function(){
        Route::post('transaction-user',[TransactionsController::class,'addTransaction']);
        Route::post('have-paid/{id}',[TransactionsController::class,'havePaid']);
    });

});
