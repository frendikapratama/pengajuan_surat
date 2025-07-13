<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_telepon',
        'email',
        'nik',
        'no_kk',
        'foto_ktp',
        'foto_kk',
        'foto_akte',
        'pas_photo'
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk URL foto
    public function getFotoKtpUrlAttribute()
    {
        return $this->foto_ktp ? asset('storage/' . $this->foto_ktp) : null;
    }

    public function getFotoKkUrlAttribute()
    {
        return $this->foto_kk ? asset('storage/' . $this->foto_kk) : null;
    }

    public function getFotoAkteUrlAttribute()
    {
        return $this->foto_akte ? asset('storage/' . $this->foto_akte) : null;
    }

    public function getPasPhotoUrlAttribute()
    {
        return $this->pas_photo ? asset('storage/' . $this->pas_photo) : null;
    }

    // Method untuk check apakah foto ada
    public function hasFotoKtp()
    {
        return $this->foto_ktp && Storage::disk('public')->exists($this->foto_ktp);
    }

    public function hasFotoKk()
    {
        return $this->foto_kk && Storage::disk('public')->exists($this->foto_kk);
    }

    public function hasFotoAkte()
    {
        return $this->foto_akte && Storage::disk('public')->exists($this->foto_akte);
    }

    public function hasPasPhoto()
    {
        return $this->pas_photo && Storage::disk('public')->exists($this->pas_photo);
    }

    // Method untuk mendapatkan persentase kelengkapan dokumen
    public function getDocumentCompletenessAttribute()
    {
        $documents = ['foto_ktp', 'foto_kk', 'foto_akte', 'pas_photo'];
        $completed = 0;
        
        foreach ($documents as $document) {
            if ($this->$document) {
                $completed++;
            }
        }
        
        return ($completed / count($documents)) * 100;
    }

    // Method untuk format NIK
    public function getFormattedNikAttribute()
    {
        return substr($this->nik, 0, 6) . '-' . substr($this->nik, 6, 6) . '-' . substr($this->nik, 12, 4);
    }

    // Method untuk format No KK
    public function getFormattedNoKkAttribute()
    {
        return substr($this->no_kk, 0, 6) . '-' . substr($this->no_kk, 6, 6) . '-' . substr($this->no_kk, 12, 4);
    }
}