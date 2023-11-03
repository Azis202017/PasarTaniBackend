<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\UangController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/koperasi', [UserController::class, 'ambilKoperasi']);

    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/permintaan', [PermintaanController::class, 'index']);

    Route::post('/permintaan/add', [PermintaanController::class, 'store']);
    Route::delete('/permintaan/delete/{id}', [PermintaanController::class, 'destroy']);
    Route::post('/permintaan/edit/{id}', [PermintaanController::class, 'edit']);

    Route::get('/permintaan/{id}', [PermintaanController::class, 'detailPermintaan']);

    Route::post('/status/add', [StatusController::class, 'store']);
    Route::delete('/status/delete/{id}', [StatusController::class, 'destroy']);

    Route::get('/saldo', [UangController::class, 'index']);
    Route::post('/saldo/tarik/{id}', [UangController::class,'tarikUang']);
    Route::post('/saldo/kirim/{id}', [UangController::class,'kirimPemasukan']);

});
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('check-email', [ForgotPasswordController::class,'checkEmail']);
Route::post('forgot-password', [ForgotPasswordController::class,'sendPasswordForgetLink']);



