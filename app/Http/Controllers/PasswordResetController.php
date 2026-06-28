<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
  // 1. Menampilkan form minta link reset
  public function requestForm()
  {
    return view('backend.v_login.forgot-password');
  }

  // 2. Memproses pengiriman email
  public function sendResetLink(Request $request)
  {
    // Validasi langsung seperti di AuthController milikmu
    $request->validate([
      'email' => 'required|email'
    ]);

    // Proses kirim email menggunakan sistem bawaan Laravel
    $status = Password::sendResetLink(
      $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {
      // Sengaja pakai key 'status' karena view default Laravel (dan view kita) mendeteksinya
      return back()->with('status', 'Link reset kata sandi telah dikirim ke email Anda.');
    }

    return back()->withErrors(['email' => 'Kami tidak dapat menemukan pengguna dengan email tersebut.']);
  }

  // 3. Menampilkan form input password baru (diakses dari link email)
  public function resetForm(Request $request, $token)
  {
    return view('backend.v_login.reset-password', [
      'token' => $token,
      'email' => $request->email
    ]);
  }

  // 4. Memproses update password di database
  public function updatePassword(Request $request)
  {
    $request->validate([
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function ($user, $password) {
        $user->forceFill([
          'password' => Hash::make($password)
        ])->setRememberToken(Str::random(60));

        $user->save();
        event(new PasswordReset($user));
      }
    );

    if ($status === Password::PASSWORD_RESET) {
      return redirect()->route('login')->with('success', 'Kata sandi berhasil direset. Silakan login.');
    }

    return back()->withErrors(['email' => 'Token tidak valid atau kedaluwarsa. Silakan minta link baru.']);
  }
}
