<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
// Tambahkan 2 baris ini
use Midtrans\Config;
use Midtrans\Snap;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'mobil_id' => 'required|integer',
            'no_hp' => 'required|string',
            'alamat_pengiriman' => 'required|string'
        ]);

        $transaksi = Transaksi::create([
            'user_id' => $request->user()->id,
            'mobil_id' => $request->mobil_id,
            'kode_booking' => 'BKG-APP-' . strtoupper(uniqid()),
            'no_hp' => $request->no_hp,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'booking_fee' => 5000000,
            'bukti_bayar' => '-',
            'status' => 'Pending',
        ]);

        // --- LOGIKA MIDTRANS DIMULAI DI SINI ---
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');

        $params = array(
            'transaction_details' => array(
                'order_id' => $transaksi->kode_booking,
                'gross_amount' => 5000000,
            ),
            'customer_details' => array(
                'first_name' => $request->user()->nama,
                'email' => $request->user()->email,
                'phone' => $request->no_hp,
            ),
        );

        $snapToken = Snap::getSnapToken($params);

        // Buat Redirect URL (Ganti dengan URL production jika sudah live)
        $isProduction = config('services.midtrans.is_production');
        $baseUrl = $isProduction ? 'https://app.midtrans.com/snap/v2/vtweb/' : 'https://app.sandbox.midtrans.com/snap/v2/vtweb/';
        $redirectUrl = $baseUrl . $snapToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil masuk sistem!',
            'data' => $transaksi,
            'redirect_url' => $redirectUrl // URL ini yang akan dikirim ke Flutter
        ], 201);
    }

    public function index(Request $request)
    {
        // Mengambil transaksi milik user yang sedang login menggunakan token Sanctum
        $riwayat = Transaksi::with('mobil')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data riwayat transaksi berhasil diambil',
            'data' => $riwayat
        ], 200);
    }
}
