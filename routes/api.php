<?php

use App\Http\Controllers\Api\Surat_Ket_MhwController;
use App\Http\Controllers\Api\UserController;
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

route::get('surat_ket_mhw', [Surat_Ket_MhwController::class, 'index']);
route::get('surat_ket_mhw/{id}', [Surat_Ket_MhwController::class, 'show']);
route::post('surat_ket_mhw', [Surat_Ket_MhwController::class, 'store']);
route::post('surat_ket_mhw/{id}', [Surat_Ket_MhwController::class, 'update']);
route::delete('surat_ket_mhw/{id}', [Surat_Ket_MhwController::class, 'destroy']);


route::get('user', [UserController::class, 'index']);
route::get('user/{id}', [UserController::class, 'show']);
route::post('user', [UserController::class, 'store']);

