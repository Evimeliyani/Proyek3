<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'client'   => ['required', 'in:web_guru,mobile_siswa'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        $user = Auth::user();

        // aturan: mobile_siswa hanya boleh role siswa
        if ($data['client'] === 'mobile_siswa' && $user->role !== 'siswa') {
            Auth::logout();
            throw ValidationException::withMessages([
                'client' => ['Akun ini bukan akun siswa untuk mobile.'],
            ]);
        }

        // aturan: web_guru hanya boleh role guru/admin (sesuaikan role kamu)
        if ($data['client'] === 'web_guru' && !in_array($user->role, ['guru', 'admin'])) {
            Auth::logout();
            throw ValidationException::withMessages([
                'client' => ['Akun ini bukan akun guru untuk web.'],
            ]);
        }

        // token beda sesuai client
        $token = $user->createToken($data['client'])->plainTextToken;

        return response()->json([
            'message' => 'Login sukses',
            'token'   => $token,
            'user'    => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'kelas' => $user->kelas,
                'sekolah' => $user->sekolah,
            ]
        ]);
    }

    public function me(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout sukses']);
    }
}
