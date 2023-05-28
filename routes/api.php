<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis\AuthController;
use App\Http\Controllers\Apis\RoleController;
use App\Http\Controllers\Apis\UserRoleController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify');
Route::get('/email/verify', [AuthController::class, 'notice'])->name('verification.notice');
Route::get('/email/resend', [AuthController::class, 'resend'])->name('verification.resend');

Route::get('/user', [AuthController::class, 'index']);

Route::controller(AuthController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout');
    Route::get('/refresh', 'refresh');
});

Route::controller(RoleController::class)->group(function() {
    Route::get('/roles', 'index');
});

Route::controller(UserRoleController::class)->group(function() {
    Route::get('/user/roles', 'index')->middleware('checkRole:operation,admin');
});

