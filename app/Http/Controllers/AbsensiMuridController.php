<?php

namespace App\Http\Controllers;

use App\Models\AbsensiMurid;
use App\Models\SesiAbsensi;

class AbsensiMuridController extends Controller
{
    public function scan(string $token)
    {
        $user = auth()->user();

        abort_unless(
            $user->role === 'siswa',
            403,
            'Hanya murid yang dapat melakukan absensi.'
        );

        $sesi = SesiAbsensi::where('token_qr', $token)->firstOrFail();

        abort_unless(
            $sesi->status === 'aktif' &&
            now()->lessThan($sesi->berakhir_at),
            403,
            'QR absensi sudah tidak berlaku.'
        );

        $sudahAbsen = AbsensiMurid::where('sesi_absensi_id', $sesi->id)
            ->where('siswa_id', $user->id)
            ->exists();

        if ($sudahAbsen) {
            return redirect()->route('dashboard')
                ->with('success', 'Kamu sudah mengisi absensi sesi ini.');
        }

        AbsensiMurid::create([
            'sesi_absensi_id' => $sesi->id,
            'siswa_id' => $user->id,
            'status' => 'hadir',
            'waktu_absen' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Absensi berhasil dicatat!');
    }
}
