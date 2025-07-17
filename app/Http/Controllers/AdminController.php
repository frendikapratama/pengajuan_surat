<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Services\WhatsAppService;
class AdminController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }
    public function dashboard()
    {
        $pendingUsers = User::where('status', 'pending')->where('role', 'user')->count();
        $totalUsers = User::where('role', 'user')->count();
        $pendingPengajuan = PengajuanSurat::where('status', 'pending')->count();
        $totalPengajuan = PengajuanSurat::count();

        return view('admin.dashboard', compact('pendingUsers', 'totalUsers', 'pendingPengajuan', 'totalPengajuan'));
    }

    public function pendingUsers()
    {
        $users = User::with('profile')
            ->where('status', 'pending')
            ->where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pending-users', compact('users'));
    }

 public function approveUser($id)
    {
        $user = User::with('profile')->findOrFail($id);
        $user->update(['status' => 'approved']);

        $whatsAppResult = $this->whatsAppService->sendUserApprovalNotification($user);
        
        if ($whatsAppResult['success']) {
            return redirect()->back()->with('success', 'User berhasil disetujui dan notifikasi WhatsApp telah dikirim!');
        } else {
            return redirect()->back()->with('success', 'User berhasil disetujui, namun gagal mengirim notifikasi WhatsApp: ' . $whatsAppResult['message']);
        }
    }


    public function rejectUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        $whatsAppResult = $this->whatsAppService->sendUserRejectionNotification($user);
        
        if ($whatsAppResult['success']) {
            return redirect()->back()->with('success', 'User berhasil ditolak dan notifikasi WhatsApp telah dikirim!');
        } else {
            return redirect()->back()->with('success', 'User berhasil ditolak, namun gagal mengirim notifikasi WhatsApp: ' . $whatsAppResult['message']);
        }
    }


    public function showUserDetail($id)
    {
        $user = User::with('profile')->findOrFail($id);
        return view('admin.user-detail', compact('user'));
    }

    public function pengajuanSurat()
    {
        $pengajuanSurat = PengajuanSurat::with('user.profile')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pengajuan-surat', compact('pengajuanSurat'));
    }

    public function processPengajuan($id)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);
        $pengajuan->update(['status' => 'diproses']);

        return redirect()->back()->with('success', 'Pengajuan surat sedang diproses!');
    }

    public function completePengajuan(Request $request, $id)
    {
        $request->validate([
            'file_surat' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'catatan_admin' => 'nullable|string',
        ]);

        $pengajuan = PengajuanSurat::findOrFail($id);
        
        $filePath = $request->file('file_surat')->store('surat_keluar', 'public');

        $pengajuan->update([
            'status' => 'selesai',
            'file_surat' => $filePath,
            'catatan_admin' => $request->catatan_admin,
            'tanggal_selesai' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengajuan surat berhasil diselesaikan!');
    }

    public function rejectPengajuan(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string',
        ]);

        $pengajuan = PengajuanSurat::findOrFail($id);
        $pengajuan->update([
            'status' => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->back()->with('success', 'Pengajuan surat berhasil ditolak!');
    }

    public function showPengajuanDetail($id)
    {
        $pengajuan = PengajuanSurat::with('user.profile')->findOrFail($id);
        return view('admin.pengajuan-detail', compact('pengajuan'));
    }
}