<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $pengajuanSurat = PengajuanSurat::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.dashboard', compact('pengajuanSurat'));
    }

    public function createPengajuan()
    {
        return view('user.create-pengajuan');
    }

    public function storePengajuan(Request $request)
    {
        $request->validate([
            'keperluan' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        PengajuanSurat::create([
            'user_id' => auth()->id(),
            'jenis_surat' => 'Surat Pengantar',
            'keperluan' => $request->keperluan,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Pengajuan surat pengantar berhasil diajukan!');
    }

    public function showPengajuan($id)
    {
        $pengajuan = PengajuanSurat::where('user_id', auth()->id())->findOrFail($id);
        return view('user.show-pengajuan', compact('pengajuan'));
    }
}