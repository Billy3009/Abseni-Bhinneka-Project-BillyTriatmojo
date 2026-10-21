<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SesiAbsensi extends Model
{
    protected $table = 'sesi_absensis';

    protected $fillable = [
        'jadwal_pelajaran_id',
        'token_qr',
        'mulai_at',
        'berakhir_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'mulai_at' => 'datetime',
            'berakhir_at' => 'datetime',
        ];
    }

    public function jadwalPelajaran(): BelongsTo
    {
        return $this->belongsTo(
            JadwalPelajaran::class,
            'jadwal_pelajaran_id'
        );
    }
}