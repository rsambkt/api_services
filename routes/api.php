<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\PanggilController;

// Simrs
use App\Http\Controllers\simrs\referensi\CarabayarController;
use App\Http\Controllers\simrs\referensi\CarakeluarController;
use App\Http\Controllers\simrs\referensi\KeadaankeluarController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('validasi', 'validasi');
    Route::get('header', 'getheader');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});
Route::group(['middleware' => 'jwt.auth'], function () {
    //Login as other User
    // Route::apiResource('antrian', App\Http\Controllers\AntrianController::class);
    // Route::get('terbaru', [App\Http\Controllers\AntrianController::class, 'latestrow']);
    // Route::get('simpan', [App\Http\Controllers\AntrianController::class, 'insert']);
});
Route::group(['middleware' => 'is-allow'], function () {
    Route::apiResource('antrian', AntrianController::class);
    Route::apiResource('antrian', AntrianController::class);
    Route::apiResource('simrs/referensi/carabayar', CarabayarController::class);
    Route::apiResource('simrs/referensi/carakeluar', CarakeluarController::class);
    Route::apiResource('simrs/referensi/keadaankeluar', KeadaankeluarController::class);
    Route::get('terbaru', [AntrianController::class, 'latestrow']);
    Route::get('check', [AntrianController::class, 'check']);
    Route::get('all', [AntrianController::class, 'listantrian']);
});
Route::post('client', [ClientController::class, 'create']);