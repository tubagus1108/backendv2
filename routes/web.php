<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\Auth\AuthController;
use App\Http\Controllers\WEB\Dashboard\DashboardController;
use App\Http\Controllers\WEB\Transactions\TransactionsController;
use App\Http\Controllers\WEB\Users\UsersController;
use App\Http\Middleware\WebHandle;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('login',[AuthController::class,'indexLogin'])->name('login');
Route::post('login-post',[AuthController::class,'indexPost'])->name('login-post');
Route::middleware([WebHandle::class],'auth')->group(function(){
    // DASHBOARD
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    // USERS
    Route::prefix('users')->group(function(){
        Route::get('users',[UsersController::class,'indexUsers'])->name('index-users');
        Route::get('users-datatable',[UsersController::class,'UserDatatable'])->name('datatable-users');
        Route::get('/{id}/approve',[UsersController::class,'ApproveUsers']);
    });
    // TRANSACTIONS
    Route::get('transactions',[TransactionsController::class,'indexTransactions'])->name('index-transactions');
    // VENDOR
    //MANUAL
    //REPORTS
    //SETTINGS
    // LOGOUT
    Route::get('logout',[AuthController::class,'LogOut'])->name('logout');
});
