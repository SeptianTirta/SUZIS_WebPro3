<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\MobilController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransaksiController;

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

// Rute uji coba untuk mengambil data mobil berformat JSON
Route::get('/mobil', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Koneksi ke API Sigma Automobil Berhasil!',
        'data' => \App\Models\Mobil::with('tipe')->latest()->get()
    ]);
});

// Rute khusus untuk memproses Login dari Mobile
Route::post('/login', [AuthController::class, 'login']);

// Rute yang butuh Token Login ditaruh di dalam grup ini
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/booking', [TransaksiController::class, 'store']);
    Route::get('/pesanan', [TransaksiController::class, 'index']); // Tambahkan baris ini
});
