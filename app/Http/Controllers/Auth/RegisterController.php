<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'nik' => 'required|string|unique:profiles|size:16',
            'no_kk' => 'required|string|unique:profiles|size:16',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_akte' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pas_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'pending'
        ]);

        // Handle file uploads
        $fileFields = ['foto_ktp', 'foto_kk', 'foto_akte', 'pas_photo'];
        $uploadedFiles = [];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $uploadedFiles[$field] = $request->file($field)->store('profile_documents', 'public');
            }
        }

        // Create profile
        Profile::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'foto_ktp' => $uploadedFiles['foto_ktp'] ?? null,
            'foto_kk' => $uploadedFiles['foto_kk'] ?? null,
            'foto_akte' => $uploadedFiles['foto_akte'] ?? null,
            'pas_photo' => $uploadedFiles['pas_photo'] ?? null,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan tunggu persetujuan admin untuk dapat login.');
    }
}




