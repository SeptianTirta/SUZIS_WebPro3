<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
  public function showRegistrationForm()
  {
    return view('backend.v_login.register', [
      'judul' => 'Daftar Akun',
    ]);
  }

  public function register(Request $request)
  {
    // Validasi langsung di controller seperti LoginController
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
    ]);

    // Proses simpan data
    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => 'pelanggan', // Sesuaikan dengan default role kamu
      'status' => 1 // Sesuaikan jika kamu punya kolom status aktif (seperti di login ada cek status == 0)
    ]);

    // Redirect ke route login sesuai yang ada di LoginController kamu
    return redirect()->route('backend.login')->with('success', 'Registrasi berhasil! Silakan login.');
  }
}
