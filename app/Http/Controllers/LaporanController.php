<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbsensiMurid;
use App\Models\AbsensiGuru;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    private function cekAkses()
    {
        abort_unless(
            in_array(auth()->user()->role, ['admin', 'kepala_sekolah']),
            403
        );
    }

    private function ambilFilter(Request $request)
    {
        return $request->validate([
            'jenis' => 'nullable|in:siswa,guru,keduanya',
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_awal',
            'kelas' => 'nullable|string|max:50',
            'jenjang' => 'nullable|in:TK,SD,SMP',
            'status' => 'nullable|in:hadir,izin,sakit,alpa',
        ]);
    }

    private function querySiswa(array $filter)
    {
        $query = AbsensiMurid::with(['siswa', 'sesiAbsensi']);

        if (!empty($filter['tanggal_awal'])) {
            $query->whereHas('sesiAbsensi', function ($q) use ($filter) {
                $q->whereDate('mulai_at', '>=', $filter['tanggal_awal']);
            });
        }

        if (!empty($filter['tanggal_akhir'])) {
            $query->whereHas('sesiAbsensi', function ($q) use ($filter) {
                $q->whereDate('mulai_at', '<=', $filter['tanggal_akhir']);
            });
        }

        if (!empty($filter['kelas'])) {
            $query->whereHas('siswa', function ($q) use ($filter) {
                $q->where('kelas', 'like', '%' . $filter['kelas'] . '%');
            });
        }

        if (!empty($filter['jenjang'])) {
            $query->whereHas('siswa', function ($q) use ($filter) {
                $q->where('jenjang', $filter['jenjang']);
            });
        }

        if (!empty($filter['status'])) {
            $query->where('status', $filter['status']);
        }

        return $query->orderByDesc('created_at');
    }

    private function queryGuru(array $filter)
    {
        $query = AbsensiGuru::with('user');

        if (!empty($filter['tanggal_awal'])) {
            $query->whereDate('tanggal', '>=', $filter['tanggal_awal']);
        }

        if (!empty($filter['tanggal_akhir'])) {
            $query->whereDate('tanggal', '<=', $filter['tanggal_akhir']);
        }

        if (!empty($filter['status'])) {
            $query->where('status', $filter['status']);
        }

        return $query->orderByDesc('tanggal');
    }

    public function index(Request $request)
    {
        $this->cekAkses();

        $filter = $this->ambilFilter($request);
        $jenis = $filter['jenis'] ?? 'keduanya';

        $rekapSiswa = $jenis !== 'guru'
            ? $this->querySiswa($filter)->get()
            : collect();

        $rekapGuru = $jenis !== 'siswa'
            ? $this->queryGuru($filter)->get()
            : collect();

        return view('admin.laporan-absensi', compact(
            'filter',
            'jenis',
            'rekapSiswa',
            'rekapGuru'
        ));
    }

    public function downloadPdf(Request $request)
    {
        $this->cekAkses();

        $filter = $this->ambilFilter($request);
        $jenis = $filter['jenis'] ?? 'keduanya';

        $rekapSiswa = $jenis !== 'guru'
            ? $this->querySiswa($filter)->get()
            : collect();

        $rekapGuru = $jenis !== 'siswa'
            ? $this->queryGuru($filter)->get()
            : collect();

        $pdf = Pdf::loadView('admin.laporan-absensi-pdf', compact(
            'filter',
            'jenis',
            'rekapSiswa',
            'rekapGuru'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-absensi.pdf');
    }
}
