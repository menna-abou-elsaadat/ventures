<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ReportController;

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

//--------------------------------Auth Modeule------------------------------
Route::controller(AuthController::class)->group(function(){
    Route::post('register','register')->name('register');
    Route::post('login','login')->name('login');
    Route::post('logout','logout')->middleware('auth:sanctum')->name('logout');
});

// ---------------------------------Transactions Module---------------------------------
Route::middleware('auth:sanctum')->controller(TransactionController::class)->prefix('transaction')->group(function(){
    Route::get('/','index')->name('index');
    Route::post('/create','create')->middleware('admin')->name('create');
});

//---------------------------------Payments Modeule------------------------------------
Route::middleware(['auth:sanctum','admin'])->controller(PaymentController::class)->prefix('payment')->group(function(){
    Route::post('/create','create')->name('create');
});
//-----------------------------------Report Module----------------------------------------
Route::post('/report',ReportController::class)->middleware(['auth:sanctum','admin'])->name('report');