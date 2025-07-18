<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\WhatsAppService;

class UserController extends Controller
{

    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

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
    $validator = Validator::make($request->all(), [
        'keperluan' => 'required|string|max:255',
        'keterangan' => 'nullable|string',
        'jenis_surat' => 'required|image|mimes:jpg,jpeg,png|max:5048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $jenissuratPath = null;

    if ($request->hasFile('jenis_surat')) {
        $jenissuratPath = $request->file('jenis_surat')->store('jenis_surat', 'public');
    }

    $pengajuan = PengajuanSurat::create([
        'user_id' => auth()->id(),
        'keperluan' => $request->keperluan,
        'keterangan' => $request->keterangan,
        'status' => 'pending',
        'tanggal_pengajuan' => now(),
        'jenis_surat' => $jenissuratPath,
    ]);

    // Load relasi user dan profile untuk pengajuan yang baru dibuat
    $pengajuan->load('user.profile');

    // Kirim notifikasi WhatsApp
    $whatsAppResult = $this->whatsAppService->sendPengajuanCreatedNotification($pengajuan);
    
    if ($whatsAppResult['success']) {
        return redirect()->route('user.dashboard')->with('success', 'Pengajuan surat pengantar berhasil diajukan dan notifikasi WhatsApp telah dikirim!');
    } else {
        return redirect()->route('user.dashboard')->with('success', 'Pengajuan surat pengantar berhasil diajukan, namun gagal mengirim notifikasi WhatsApp: ' . $whatsAppResult['message']);
    }
}

    public function showPengajuan($id)
    {
        $pengajuan = PengajuanSurat::where('user_id', auth()->id())->findOrFail($id);
        return view('user.show-pengajuan', compact('pengajuan'));
    }
}