<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleAuthController extends Controller
{
    // 1. Redirect ke Google
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    // 2. Callback dari Google
    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                Auth::guard('web')->login($user, true);
                $request->session()->regenerate();
                $request->session()->save(); // ← tambah ini
                return redirect()->route('beranda');
            } else {
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    $existingUser->update(['google_id' => $googleUser->id]);
                    Auth::guard('web')->login($existingUser, true);
                } else {
                    $newUser = User::create([
                        'nama'      => $googleUser->name,
                        'email'     => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'role'      => 2,
                        'password'  => null,
                        'no_hp'     => '-'
                    ]);
                    Auth::guard('web')->login($newUser, true);
                }

                $request->session()->regenerate();
                $request->session()->save(); // ← tambah ini
                return redirect()->route('beranda');
            }
        } catch (Exception $e) {
            dd([
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
            ]);
        }
    }
}
