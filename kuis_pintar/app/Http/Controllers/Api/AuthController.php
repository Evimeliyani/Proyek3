<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // POST /api/login
    public function login(Request $request)
    {
        $data = $request->validate([
            'client'   => ['required','in:web,mobile'],
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        // WEB hanya guru/admin
        if ($data['client'] === 'web' && !in_array($user->role, ['guru','admin'], true)) {
            return response()->json(['message' => 'Akun ini bukan guru/admin'], 403);
        }

        // MOBILE hanya siswa (nanti dipakai Flutter)
        if ($data['client'] === 'mobile' && $user->role !== 'siswa') {
            return response()->json(['message' => 'Akun ini bukan siswa'], 403);
        }

        // 1 token aktif per client
        $user->tokens()->where('name', $data['client'])->delete();

        $token = $user->createToken($data['client'])->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    // GET /api/me
    public function me(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }

    // POST /api/logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
}
