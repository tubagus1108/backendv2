<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\Auth\AuthController;
use App\Http\Controllers\WEB\Dashboard\DashboardController;
use App\Http\Controllers\WEB\Transactions\TransactionsController;
use App\Http\Controllers\WEB\Users\UsersController;
use App\Http\Middleware\WebHandle;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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
Route::get('sitemap',function(){
    $sitemap = App::make("sitemap");
    $sitemap->add('https://adaremit.co.id/signup', '2012-08-25T20:10:00+02:00', '1.0', 'daily');
    $sitemap->add('https://adaremit.co.id/login', '2012-08-25T20:10:00+02:00', '1.0', 'daily');
    return $sitemap->render('xml');
});
Route::middleware([WebHandle::class],'auth')->group(function(){
    // DASHBOARD
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    // USERS
    Route::prefix('users')->group(function(){
        Route::get('users',[UsersController::class,'indexUsers'])->name('index-users');
        Route::get('users-datatable',[UsersController::class,'UserDatatable'])->name('datatable-users');
        Route::get('/{id}/approve',[UsersController::class,'ApproveUsers']);
        Route::post('approve/{id}',[UsersController::class,'approve'])->name('approve-user');
        Route::get('users-pending',[UsersController::class,'pendingUsers'])->name('pending-users');
        Route::get('user-pending-datatable-admin',[UsersController::class,'pendingDatatableAdmin'])->name('pending-datatable-admin');
        Route::get('user-pending-datatable-superadmin',[UsersController::class,'pendingDatatableSuperAdmin'])->name('pending-datatable-superadmin');
    });
    // TRANSACTIONS
    Route::prefix('transactions')->group(function(){
        Route::get('transactions-all',[TransactionsController::class,'TransactionsAll'])->name('transactions-all');
        Route::get('/{id}/detail',[TransactionsController::class,'DetailTransactions'])->name('detail-transactions');
        Route::get('admin-transactions-datatable',[TransactionsController::class,'ListDatatableTransaction'])->name('admin-transactions-datatable');
        Route::get('transactions-pending',[TransactionsController::class,'TransactionsPending'])->name('transactions-pending');
        Route::get('transactions-success',[TransactionsController::class,'TransactionsSuccess'])->name('transactions-success');
        Route::get('pending-datatable-admin',[TransactionsController::class,'pendingDatatableAdmin'])->name('transaction-admin-datatable');
        Route::get('pending-datatable-superadmin',[TransactionsController::class,'pendingDatatableSuperadmin'])->name('transaction-superadmin-datatable');
        Route::get('success-datatable-admin',[TransactionsController::class,'successatatableAdmin'])->name('transaction-success-admin-datatable');
        Route::get('success-datatable-superadmin',[TransactionsController::class,'successDatatableSuperadmin'])->name('transaction-success-superadmin-datatable');
        Route::get('{id}/approve-transactions',[TransactionsController::class,'ApproveTransaction'])->name('approve-transactions');
    });
    // VENDOR
    //MANUAL
    //REPORTS
    //SETTINGS
    // LOGOUT
    Route::get('logout',[AuthController::class,'LogOut'])->name('logout');
});
