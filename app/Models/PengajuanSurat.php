<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surat';

    protected $fillable = [
        'user_id',
        'jenis_surat',
        'keperluan',
        'keterangan',
        'status',
        'catatan_admin',
        'file_surat',
        'tanggal_pengajuan',
        'tanggal_selesai'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_selesai' => 'datetime'
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk URL file surat
    public function getFileSuratUrlAttribute()
    {
        return $this->file_surat ? asset('storage/' . $this->file_surat) : null;
    }

    public function getJenisSuratUrlAttribute()
    {
        return $this->jenis_surat ? asset('storage/' . $this->jenis_surat) : null;
    }

    
    // Accessor untuk status badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'diproses' => '<span class="badge bg-info">Diproses</span>',
            'selesai' => '<span class="badge bg-success">Selesai</span>',
            'ditolak' => '<span class="badge bg-danger">Ditolak</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    // Method untuk check status
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isDiproses()
    {
        return $this->status === 'diproses';
    }

    public function isSelesai()
    {
        return $this->status === 'selesai';
    }

    public function isDitolak()
    {
        return $this->status === 'ditolak';
    }

    // Method untuk menghitung waktu proses
    public function getProcessingTimeAttribute()
    {
        if ($this->tanggal_selesai) {
            return $this->tanggal_pengajuan->diffForHumans($this->tanggal_selesai);
        }
        
        return $this->tanggal_pengajuan->diffForHumans();
    }

    // Method untuk format tanggal
    public function getFormattedTanggalPengajuanAttribute()
    {
        return $this->tanggal_pengajuan->format('d M Y H:i');
    }

    public function getFormattedTanggalSelesaiAttribute()
    {
        return $this->tanggal_selesai ? $this->tanggal_selesai->format('d M Y H:i') : null;
    }

    // Scope untuk filter berdasarkan status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    // Scope untuk filter berdasarkan periode
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('created_at', Carbon::now()->year);
    }
}