<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiMurid extends Model
{
    protected $table = 'absensi_murids';

    protected $fillable = [
        'sesi_absensi_id',
        'siswa_id',
        'status',
        'waktu_absen',
    ];

    protected function casts(): array
    {
        return [
            'waktu_absen' => 'datetime',
        ];
    }

    public function sesiAbsensi(): BelongsTo
    {
        return $this->belongsTo(
            SesiAbsensi::class,
            'sesi_absensi_id'
        );
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'siswa_id'
        );
    }
}