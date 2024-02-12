<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController; 
use App\Http\Controllers\SpinController;
use App\Http\Controllers\FrameController;
use App\Http\Controllers\ChitFund\ChitFundController; 
use App\Http\Controllers\ChitFund\ChitFundUserImportController;

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

    /* Chit Fund */
    Route::get('/chitfund', [ChitFundController::class, 'chitfundIndex'])->name('chitfundIndex');
    Route::post('/chitfund/createplan', [ChitFundController::class, 'chitfundCreatePlan'])->name('chitfund.createPlan');
    Route::get('/chitfund/plan/{id}', [ChitFundController::class, 'chitfundShowPlan'])->name('chitfund.showPlan');
    Route::post('/chitfund/createuser', [ChitFundController::class, 'chitfundCreateUser'])->name('chitfund.createUser');
    Route::post('/chitfund/edituser', [ChitFundController::class, 'chitfundEditUser'])->name('chitfund.editUser');
    Route::get('/chitfund/adddue/{planid}/{id}', [ChitFundController::class, 'chitfundAddDue'])->name('chitfund.addDue');
    Route::get('/chitfund/user-details/{id}', [ChitFundController::class, 'chitfundUserDetails'])->name('chitfund.userDetails');
    Route::post('/chitfund/update/duestatus', [ChitFundController::class, 'updateDueStatus'])->name('chitfund.updateDueStatus');
    Route::get('/chitfund/print-invoice/{id}/{date}', [ChitFundController::class, 'printInvoice'])->name('chitfund.printInvoice');
    
    /* Chit Fund Users - Import from Excel*/
    //Route::get('/chitfund/import-user', [ChitFundUserImportController::class, 'chitfundImportIndex'])->name('chitfund.showimport'); 
    //Route::post('/chitfund/save-import-user', [ChitFundUserImportController::class, 'chitfundImportExcel'])->name('chitfund.importExcel');
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

/* Happy Customer - Frame Routes */
Route::get('/frame', [FrameController::class, 'frameIndex'])->name('frameIndex'); 
Route::post('/frame/saveframe', [FrameController::class, 'saveFrame'])->name('saveFrame');
Route::post('/frame/downloadframe', [FrameController::class, 'downloadFrame'])->name('downloadFrame');

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
