<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthWebController extends Controller
{
    public function showLogin()
    {
        // sesuaikan view kamu
        return view('web.login');
    }

    public function submitLogin(Request $request)
    {
        $data = $request->validate([
            'client'   => ['required', 'in:web_guru,mobile_siswa'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            if ($request->expectsJson()) {
                throw ValidationException::withMessages([
                    'email' => ['Email atau password salah.'],
                ]);
            }

            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        $request->session()->regenerate();
        $user = Auth::user();

        // RULE 1: mobile hanya siswa
        if ($data['client'] === 'mobile_siswa' && $user->role !== 'siswa') {
            Auth::logout();

            if ($request->expectsJson()) {
                throw ValidationException::withMessages([
                    'client' => ['Akun ini bukan akun siswa untuk mobile.'],
                ]);
            }

            return back()->withErrors(['client' => 'Akun ini bukan akun siswa untuk mobile.'])->withInput();
        }

        // RULE 2: web hanya guru/admin
        if ($data['client'] === 'web_guru' && !in_array($user->role, ['guru', 'admin'])) {
            Auth::logout();

            if ($request->expectsJson()) {
                throw ValidationException::withMessages([
                    'client' => ['Akun ini bukan akun guru untuk web.'],
                ]);
            }

            return back()->withErrors(['client' => 'Akun ini bukan akun guru untuk web.'])->withInput();
        }

        // Jika request JSON (Flutter/Postman) => return token
        if ($request->expectsJson()) {
            $token = $user->createToken($data['client'])->plainTextToken;

            return response()->json([
                'message' => 'Login sukses',
                'token'   => $token,
                'user'    => [
                    'id'      => $user->id,
                    'name'    => $user->name,
                    'email'   => $user->email,
                    'role'    => $user->role,
                    'kelas'   => $user->kelas,
                    'sekolah' => $user->sekolah,
                ],
            ]);
        }

        // Jika web browser => redirect
        return redirect()->route('web.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('web.login');
    }
}
