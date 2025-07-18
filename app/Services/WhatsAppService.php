<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('FONNTE_API_KEY', 'ieXoaKKBZ1Jdzajh6u6c');
        $this->baseUrl = 'https://api.fonnte.com/send';
    }

    /**
     * Mengirim pesan WhatsApp
     * 
     * @param string $phoneNumber - Nomor telepon tujuan
     * @param string $message - Pesan yang akan dikirim
     * @return array - Response dari API
     */
    public function sendMessage($phoneNumber, $message)
    {
        // Format nomor telepon
        $formattedNumber = $this->formatPhoneNumber($phoneNumber);
        
        if (!$formattedNumber) {
            Log::warning('Invalid phone number format: ' . $phoneNumber);
            return [
                'success' => false,
                'message' => 'Format nomor telepon tidak valid'
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey
            ])->post($this->baseUrl, [
                'target' => $formattedNumber,
                'message' => $message,
                'countryCode' => '62',
            ]);

            Log::info('WhatsApp API Response: ' . $response->body());
            
            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['status']) && $responseData['status']) {
                    Log::info('WhatsApp sent successfully to: ' . $formattedNumber);
                    return [
                        'success' => true,
                        'message' => 'Pesan berhasil dikirim',
                        'data' => $responseData
                    ];
                } else {
                    Log::error('WhatsApp API error: ' . ($responseData['reason'] ?? 'Unknown error'));
                    return [
                        'success' => false,
                        'message' => $responseData['reason'] ?? 'Terjadi kesalahan pada API WhatsApp'
                    ];
                }
            } else {
                Log::error('WhatsApp API failed with status: ' . $response->status());
                return [
                    'success' => false,
                    'message' => 'Gagal mengirim pesan, status: ' . $response->status()
                ];
            }

        } catch (\Exception $e) {
            Log::error('WhatsApp sending failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Format nomor telepon ke format internasional
     * 
     * @param string $phoneNumber
     * @return string|null
     */
    private function formatPhoneNumber($phoneNumber)
    {
        if (empty($phoneNumber)) {
            return null;
        }

        // Hapus semua karakter non-digit
        $nomor = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Jika nomor kosong setelah cleaning
        if (empty($nomor)) {
            return null;
        }

        // Jika diawali dengan 0, ganti dengan 62
        if (substr($nomor, 0, 1) === '0') {
            $nomor = '62' . substr($nomor, 1);
        }
        
        // Jika belum diawali dengan 62, tambahkan
        if (substr($nomor, 0, 2) !== '62') {
            $nomor = '62' . $nomor;
        }

        return $nomor;
    }

    /**
     * Kirim pesan notifikasi persetujuan user
     * 
     * @param object $user - User object
     * @return array
     */
    public function sendUserApprovalNotification($user)
    {
        $phoneNumber = $user->profile->no_telepon ?? null;
        
        if (!$phoneNumber) {
            Log::warning('No phone number found for user: ' . $user->id);
            return [
                'success' => false,
                'message' => 'Nomor telepon tidak ditemukan'
            ];
        }

        // Ambil nama user, jika tidak ada gunakan "Bapak/Ibu"
        $namaUser = $user->nama ?? $user->name ?? 'Bapak/Ibu';

        $message = "Halo {$namaUser}, akun Anda telah disetujui. Silakan login ke sistem.";
        
        return $this->sendMessage($phoneNumber, $message);
    }

    /**
     * Kirim pesan notifikasi penolakan user
     * 
     * @param object $user - User object
     * @param string $reason - Alasan penolakan (optional)
     * @return array
     */
    public function sendUserRejectionNotification($user, $reason = null)
    {
        $phoneNumber = $user->profile->no_telepon ?? null;
        
        if (!$phoneNumber) {
            Log::warning('No phone number found for user: ' . $user->id);
            return [
                'success' => false,
                'message' => 'Nomor telepon tidak ditemukan'
            ];
        }

        $namaUser = $user->nama ?? $user->name ?? 'Bapak/Ibu';

        $message = "Halo {$namaUser}, mohon maaf akun Anda tidak dapat disetujui.";
        
        if ($reason) {
            $message .= " Alasan: {$reason}";
        }
        
        $message .= " Silakan hubungi admin untuk informasi lebih lanjut.";
        
        return $this->sendMessage($phoneNumber, $message);
    }

    /**
     * Kirim notifikasi pengajuan surat selesai
     * 
     * @param object $pengajuan - PengajuanSurat object
     * @return array
     */
    public function sendPengajuanCompletedNotification($pengajuan)
    {
        $phoneNumber = $pengajuan->user->profile->no_telepon ?? null;
        
        if (!$phoneNumber) {
            Log::warning('No phone number found for pengajuan: ' . $pengajuan->id);
            return [
                'success' => false,
                'message' => 'Nomor telepon tidak ditemukan'
            ];
        }

        // Ambil nama user, jika tidak ada gunakan "Bapak/Ibu"
        $namaUser = $pengajuan->user->nama ?? $pengajuan->user->name ?? 'Bapak/Ibu';

        $message = "Halo {$namaUser}, pengajuan surat Anda  telah selesai diproses. Silakan kunjungi kelurahan untuk mengambil surat .";
        
        if ($pengajuan->catatan_admin) {
            $message .= " Catatan: {$pengajuan->catatan_admin}";
        }
        
        return $this->sendMessage($phoneNumber, $message);
    }

    /**
     * Kirim notifikasi pengajuan surat ditolak
     * 
     * @param object $pengajuan - PengajuanSurat object
     * @return array
     */
    public function sendPengajuanRejectedNotification($pengajuan)
    {
        $phoneNumber = $pengajuan->user->profile->no_telepon ?? null;
        
        if (!$phoneNumber) {
            Log::warning('No phone number found for pengajuan: ' . $pengajuan->id);
            return [
                'success' => false,
                'message' => 'Nomor telepon tidak ditemukan'
            ];
        }

        // Ambil nama user, jika tidak ada gunakan "Bapak/Ibu"
        $namaUser = $pengajuan->user->nama ?? $pengajuan->user->name ?? 'Bapak/Ibu';

        $message = "Halo {$namaUser}, mohon maaf pengajuan surat Anda tidak dapat diproses.";
        
        if ($pengajuan->catatan_admin) {
            $message .= " Alasan: {$pengajuan->catatan_admin}";
        }
        
        $message .= " Silakan hubungi admin untuk informasi lebih lanjut.";
        
        return $this->sendMessage($phoneNumber, $message);
    }


    /**
 * Kirim notifikasi pengajuan surat sedang diproses
 * 
 * @param object $pengajuan - PengajuanSurat object
 * @return array
 */

    public function sendPengajuanProcessingNotification($pengajuan)
    {
        $phoneNumber = $pengajuan->user->profile->no_telepon ?? null;
        
        if (!$phoneNumber) {
            Log::warning('No phone number found for pengajuan: ' . $pengajuan->id);
            return [
                'success' => false,
                'message' => 'Nomor telepon tidak ditemukan'
            ];
        }

        $namaUser = $pengajuan->user->nama ?? $pengajuan->user->name ?? 'Bapak/Ibu';

        $message = "Halo {$namaUser}, pengajuan surat Anda dengan  sedang diproses dan . Silakan login ke sistem untuk melihat status pengajuan.";
        
        return $this->sendMessage($phoneNumber, $message);
    }

    /**
 * Kirim notifikasi pengajuan surat berhasil dibuat
 * 
 * @param object $pengajuan - PengajuanSurat object
 * @return array
 */
public function sendPengajuanCreatedNotification($pengajuan)
{
    $phoneNumber = $pengajuan->user->profile->no_telepon ?? null;
    
    if (!$phoneNumber) {
        Log::warning('No phone number found for pengajuan: ' . $pengajuan->id);
        return [
            'success' => false,
            'message' => 'Nomor telepon tidak ditemukan'
        ];
    }

    // Ambil nama user, jika tidak ada gunakan "Bapak/Ibu"
    $namaUser = $pengajuan->user->nama ?? $pengajuan->user->name ?? 'Bapak/Ibu';

    $message = "Halo {$namaUser}, pengajuan surat Anda dengan keperluan '{$pengajuan->keperluan}' berhasil dikirim dan sedang menunggu review admin. Terima kasih.";
    
    return $this->sendMessage($phoneNumber, $message);
}
}