<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $profile = $user->profile;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'nik' => 'required|string|size:16|unique:profiles,nik,' . $profile->id,
            'no_kk' => 'required|string|size:16|unique:profiles,no_kk,' . $profile->id,
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_akte' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pas_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update user name
        $user->update(['name' => $request->name]);

        // Handle file uploads
        $fileFields = ['foto_ktp', 'foto_kk', 'foto_akte', 'pas_photo'];
        $updateData = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                if ($profile->$field) {
                    Storage::disk('public')->delete($profile->$field);
                }
                // Store new file
                $updateData[$field] = $request->file($field)->store('profile_documents', 'public');
            }
        }

        $profile->update($updateData);

        return redirect()->back()->with('success', 'Profile berhasil diperbarui!');
    }
}