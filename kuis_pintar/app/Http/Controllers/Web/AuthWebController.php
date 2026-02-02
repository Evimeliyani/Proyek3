<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthWebController extends Controller
{
    // GET /login
    public function showLogin()
    {
        return view('web.login');
    }

    // POST /login
    public function submitLogin(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->with('error', 'Email atau password salah')->withInput();
        }

        // WEB hanya guru/admin
        if (!in_array($user->role, ['guru','admin'], true)) {
            return back()->with('error', 'Akun ini bukan guru/admin')->withInput();
        }

        // login session (WEB)
        Auth::login($user);
        $request->session()->regenerate();

        // OPTIONAL: kalau kamu butuh token untuk panggil API dari web (misal pakai JS fetch)
        // $user->tokens()->where('name','web')->delete();
        // $token = $user->createToken('web')->plainTextToken;
        // session(['api_token' => $token]);

        return redirect()->route('web.dashboard');
    }

    // POST /logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('web.login')->with('success', 'Logout berhasil');
    }
}
