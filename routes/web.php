<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController; 
use App\Http\Controllers\SpinController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/logs/', [AttendanceController::class, 'allLogs']);
    Route::get('/users/logs/{id}', [AttendanceController::class, 'userlog'])->name('userlog');

    Route::get('/user-export/{id}', [AttendanceController::class, 'exportAttendenceLogs'])->name('attendancelogs.export');
    Route::post('/user-export/', [AttendanceController::class, 'exportAttendenceLogs'])->name('attendancelogs.export');

    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

    Route::get('/users/shift/create/{id}', [UserController::class, 'createUserShift'])->name('shift.create');
    Route::post('/users/shift/store', [UserController::class, 'storeUserShift'])->name('shift.store');
    
    Route::get('/users/spins', [SpinController::class, 'index']);
    Route::get('/users/spins/update/{id}', [SpinController::class, 'updateInvoiceForm'])->name('updateInvoiceForm');
});

/* User Discount Spin Wheel Routes */
Route::get('/spin', function () {
    return redirect()->route('showForm');
});
Route::get('/spin-form', [SpinController::class, 'showForm'])->name('showForm');
Route::post('/spin-form', [SpinController::class, 'saveInvoiceForm'])->name('saveInvoiceForm');
Route::get('/spin/{invoice_number}', [SpinController::class, 'showSpinWheel'])->name('showSpinWheel');
Route::get('/spin/{invoice_number}/{discount}', [SpinController::class, 'saveSpinWheel'])->name('saveSpinWheel');

Route::group(['middleware' => 'prevent-back-button'],function(){	
	Route::get('/spin-thankyou', [SpinController::class, 'thankYou'])->name('thankYou');
});

/* ================== Clear Cache Routes ================== */
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

//Clear All 
Route::get('/clear', function() {
   Artisan::call('cache:clear');
   Artisan::call('config:clear');
   Artisan::call('config:cache');
   Artisan::call('view:clear');
   Artisan::call('route:clear');
   return "All Cleared!";
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});
