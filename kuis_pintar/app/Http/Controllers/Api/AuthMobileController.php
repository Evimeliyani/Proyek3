<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthMobileController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'client'   => ['required', 'in:mobile_siswa'],
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'kelas'    => ['nullable', 'string', 'max:50'],
            'sekolah'  => ['nullable', 'string', 'max:150'],
        ]);

        $user = User::create([
            'name'    => $data['name'],
            'email'   => $data['email'],
            'role'    => 'siswa',
            'kelas'   => $data['kelas'] ?? null,
            'sekolah' => $data['sekolah'] ?? null,
            'password'=> Hash::make($data['password']),
        ]);

        $token = $user->createToken('mobile_siswa')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi siswa sukses',
            'token'   => $token,
            'user'    => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'kelas' => $user->kelas,
                'sekolah' => $user->sekolah,
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'client'   => ['required', 'in:mobile_siswa'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])
            ->where('role', 'siswa')
            ->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        $token = $user->createToken('mobile_siswa')->plainTextToken;

        return response()->json([
            'message' => 'Login siswa sukses',
            'token'   => $token,
            'user'    => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'kelas' => $user->kelas,
                'sekolah' => $user->sekolah,
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout mobile sukses'
        ]);
    }
}
