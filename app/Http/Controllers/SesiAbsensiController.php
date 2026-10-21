<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\SesiAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SesiAbsensiController extends Controller
{
    /**
     * Guru memulai sesi absensi.
     */
    public function mulai(JadwalPelajaran $jadwal)
    {
        $user = auth()->user();

        // Hanya guru yang boleh memulai absensi
        // untuk jadwal miliknya sendiri.
        abort_unless(
            $user->role === 'guru' &&
            (int) $jadwal->guru_id === (int) $user->id,
            403,
            'Kamu tidak berhak membuka sesi ini.'
        );

        // Tutup sesi aktif sebelumnya untuk jadwal ini.
        SesiAbsensi::where('jadwal_pelajaran_id', $jadwal->id)
            ->where('status', 'aktif')
            ->update(['status' => 'ditutup']);

        // Buat token QR baru yang sulit ditebak.
        $sesi = SesiAbsensi::create([
            'jadwal_pelajaran_id' => $jadwal->id,
            'token_qr' => Str::random(64),
            'mulai_at' => now(),
            'berakhir_at' => now()->addMinutes(90),
            'status' => 'aktif',
        ]);

        return redirect()
            ->route('absensi-guru.qr', $sesi->id)
            ->with('success', 'Sesi absensi berhasil dimulai.');
    }

    /**
     * Guru menutup sesi absensi.
     */
    public function tutup(SesiAbsensi $sesi)
    {
        $user = auth()->user();

        abort_unless(
            $user->role === 'guru' &&
            (int) $sesi->jadwalPelajaran->guru_id === (int) $user->id,
            403,
            'Kamu tidak berhak menutup sesi ini.'
        );

        $sesi->update([
            'status' => 'ditutup',
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Sesi absensi berhasil ditutup.');
    }

    public function qr(SesiAbsensi $sesi)
{
    $user = auth()->user();

    abort_unless(
        in_array($user->role, ['guru', 'admin'], true),
        403
    );

    if ($user->role === 'guru') {
        abort_unless(
            (int) $sesi->jadwalPelajaran->guru_id === (int) $user->id,
            403
        );
    }

    // Pastikan sesi masih aktif dan belum kedaluwarsa.
    if (
        $sesi->status !== 'aktif' ||
        now()->greaterThanOrEqualTo($sesi->berakhir_at)
    ) {
        abort(403, 'Sesi absensi sudah ditutup atau kedaluwarsa.');
    }

    return view('absensi-guru.qr', compact('sesi'));
}
}
