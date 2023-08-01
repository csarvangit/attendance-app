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

//Route::post('login', 'API\UserController@login');
//Route::post('register', 'UserController@register');
//Route::post('register', [UserController::class, 'register']);

Route::post('login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::post('/admin/register', [App\Http\Controllers\UserController::class, 'register'])->name('register');
Route::post('/admin/shifttimewithusers', [App\Http\Controllers\UserController::class, 'addUserShift'])->name('addUserShift');


/* ================== Authenticate API Routes ================== */
//Route::post('/staff/attendance/create', ['middleware' => 'checkHost', 'uses' => 'AttendanceController@create']); 

Route::post('/staff/attendance/in', [App\Http\Controllers\AttendanceController::class, 'store'])->name('store');
Route::post('/staff/attendance/out/{id}', [App\Http\Controllers\AttendanceController::class, 'update'])->name('update');