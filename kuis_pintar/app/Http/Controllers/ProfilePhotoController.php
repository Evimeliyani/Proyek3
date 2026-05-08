<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilePhotoController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = $request->user();

        $path = $request->file('photo')->store('profile', 'public');

        $user->profile_photo = 'storage/' . $path;
        $user->save();

        return response()->json([
            'message' => 'Foto profil berhasil diupload',
            'profile_photo' => asset('storage/' . $path),
        ]);
    }
}