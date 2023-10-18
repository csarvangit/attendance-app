<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/* ================== LOGIN ================== */
Route::post('login', [App\Http\Controllers\UserController::class, 'login'])->name('login');

/* ================== ADMIN API Routes ================== */
Route::post('/admin/register', [App\Http\Controllers\UserController::class, 'register'])->name('register');

Route::post('/admin/shifttime/add', [App\Http\Controllers\ShiftTimeController::class, 'store'])->name('store');
Route::post('/admin/shifttime/edit', [App\Http\Controllers\ShiftTimeController::class, 'update'])->name('update');

Route::post('/admin/role/add', [App\Http\Controllers\UserRoleController::class, 'store'])->name('store');
Route::post('/admin/role/edit', [App\Http\Controllers\UserRoleController::class, 'update'])->name('update');
Route::post('/admin/shifttimewithusers', [App\Http\Controllers\UserController::class, 'addUserShift'])->name('addUserShift');
Route::get('/admin/staff/profile/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
Route::post('/admin/staff/profile/edit', [App\Http\Controllers\UserController::class, 'editProfile'])->name('editProfile');


/* ================== Authenticate API Routes ================== */
//Route::post('/staff/attendance/create', ['middleware' => 'checkHost', 'uses' => 'AttendanceController@create']); 

/* ================== STAFFs API Routes ================== */
Route::post('/staff/attendance/in', [App\Http\Controllers\AttendanceController::class, 'in'])->name('in');
Route::post('/staff/attendance/out/', [App\Http\Controllers\AttendanceController::class, 'out'])->name('out');
Route::post('/staff/attendance/logs/{id}', [App\Http\Controllers\AttendanceController::class, 'logs'])->name('logs');
Route::post('/staff/islogin/{id}', [App\Http\Controllers\AttendanceController::class, 'islogin'])->name('islogin');
Route::post('/staff/getshift/{id}', [App\Http\Controllers\ShiftTimeController::class, 'getUserShiftTime'])->name('getUserShiftTime');

Route::get('/staff/profile/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('myprofile');
Route::post('/staff/profile/edit', [App\Http\Controllers\UserController::class, 'editProfile'])->name('editMyprofile');



/* ================== LOGOUT ================== */
Route::post('logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');