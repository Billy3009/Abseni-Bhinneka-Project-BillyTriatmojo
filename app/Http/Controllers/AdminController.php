<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\AbsensiMurid;
use App\Models\AbsensiGuru;
use App\Models\SesiAbsensi;
use App\Models\JadwalPelajaran;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin.
     */
    
public function dashboard()
{
    $user = auth()->user();

    // Dashboard khusus Admin
    if ($user->role === 'admin') {
        return view('admin.dashboard', [
            'totalUser' => User::count(),
            'pending' => User::where('status', 'pending')->count(),
            'aktif' => User::where('status', 'aktif')->count(),
            'ditolak' => User::where('status', 'ditolak')->count(),
            'users' => User::latest()->get(),
        ]);
    }

    // Dashboard khusus Guru
if ($user->role === 'guru') {
    $jadwals = JadwalPelajaran::with([
        'mataPelajaran',
        'guru',
    ])
        ->where('guru_id', $user->id)
        ->orderBy('hari')
        ->orderBy('jam_mulai')
        ->get();

    $jadwalIds = $jadwals->pluck('id');

    $sesiAktif = SesiAbsensi::with('jadwalPelajaran.mataPelajaran')
        ->whereIn('jadwal_pelajaran_id', $jadwalIds)
        ->where('status', 'aktif')
        ->where('berakhir_at', '>', now())
        ->latest('mulai_at')
        ->get();

    return view('guru.dashboard', compact(
        'user',
        'jadwals',
        'sesiAktif'
    ));
}

    // Dashboard khusus Kepala Sekolah
    if ($user->role === 'kepala_sekolah') {
        return view('kepala-sekolah.dashboard');
    }

    // Dashboard khusus Siswa
    if ($user->role === 'siswa') {
        return view('siswa.dashboard');
    }

    abort(403, 'Role pengguna tidak dikenali.');
}


    /**
     * Menampilkan dan memfilter daftar akun.
     */
    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users', compact('users'));
    }

    /**
     * Menampilkan halaman edit akun.
     */
    public function edit(User $user)
    {
        return view('admin.edit-user', compact('user'));
    }

    /**
     * Memvalidasi dan menyimpan perubahan akun.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],

            'nik_nip_nis' => ['nullable', 'string', 'max:255'],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'guru',
                    'kepala_sekolah',
                    'siswa',
                ]),
            ],

            'jenjang' => [
                'nullable',
                Rule::in(['TK', 'SD', 'SMP']),
            ],

            'kelas' => ['nullable', 'string', 'max:255'],

            'status' => [
                'required',
                Rule::in(['pending', 'aktif', 'ditolak']),
            ],
        ]);

        $user->update($validated);

        return redirect()
            ->route('users')
            ->with('success', 'Data akun berhasil diperbarui.');
    }

    /**
     * Menyetujui akun pengguna.
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => 'aktif',
        ]);

        return back()->with('success', 'Akun berhasil disetujui.');
    }

    /**
     * Menolak akun pengguna.
     */
    public function reject($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => 'ditolak',
        ]);

        return back()->with('success', 'Akun berhasil ditolak.');
    }

/**
 * Menghapus akun pengguna.
 */
public function destroy(User $user)
{
    // Mencegah admin menghapus akun yang sedang digunakan.
    if ($user->id === auth()->id()) {
        return back()->with(
            'error',
            'Akun yang sedang digunakan tidak dapat dihapus.'
        );
    }

    $user->delete();

    return redirect()
        ->route('users')
        ->with('success', 'Akun berhasil dihapus.');
}

/**
 * Menampilkan data guru untuk Admin dan Kepala Sekolah.
 */
public function dataGuru(Request $request)
{
    // Hanya Admin dan Kepala Sekolah yang boleh mengakses.
    abort_unless(
        in_array(auth()->user()->role, ['admin', 'kepala_sekolah']),
        403
    );

    $query = User::where('role', 'guru');
    

    // Pencarian nama, username, atau NIP/NIK.
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')
                ->orWhere('nik_nip_nis', 'like', '%' . $search . '%');
        });
    }

    // Filter jenjang.
    if ($request->filled('jenjang')) {
        $query->where('jenjang', $request->jenjang);
    }

    // Filter status akun.
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $totalGuru = User::where('role', 'guru')->count();

    $guruAktif = User::where('role', 'guru')
        ->where('status', 'aktif')
        ->count();

    $gurus = $query->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.data-guru', compact(
        'gurus',
        'totalGuru',
        'guruAktif'
    ));
}


/**
 * Menampilkan data siswa khusus Admin.
 */
public function dataSiswa(Request $request)
{
    // Hanya Admin yang boleh mengakses halaman ini.
    abort_unless(auth()->user()->role === 'admin', 403);

    $query = User::where('role', 'siswa');

    // Pencarian nama, username, atau NIS.
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')
                ->orWhere('nik_nip_nis', 'like', '%' . $search . '%');
        });
    }

    // Filter jenjang, kelas, dan status.
    if ($request->filled('jenjang')) {
        $query->where('jenjang', $request->jenjang);
    }

    if ($request->filled('kelas')) {
        $query->where('kelas', $request->kelas);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $totalSiswa = User::where('role', 'siswa')->count();

    $siswaAktif = User::where('role', 'siswa')
        ->where('status', 'aktif')
        ->count();

    $siswas = $query->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.data-siswa', compact(
        'siswas',
        'totalSiswa',
        'siswaAktif'
    ));
}


public function rekapAbsensi(Request $request)
{
    abort_unless(
        in_array(auth()->user()->role, ['admin', 'kepala_sekolah']),
        403
    );

    // Query absensi siswa
    $siswaQuery = AbsensiMurid::with(['siswa', 'sesiAbsensi']);

    if ($request->filled('tanggal')) {
        $siswaQuery->whereHas('sesiAbsensi', function ($q) use ($request) {
            $q->whereDate('mulai_at', $request->tanggal);
        });
    }

    if ($request->filled('jenjang')) {
        $siswaQuery->whereHas('siswa', function ($q) use ($request) {
            $q->where('jenjang', $request->jenjang);
        });
    }

    if ($request->filled('kelas')) {
        $siswaQuery->whereHas('siswa', function ($q) use ($request) {
            $q->where('kelas', 'like', '%' . $request->kelas . '%');
        });
    }

    if ($request->filled('search')) {
        $search = $request->search;

        $siswaQuery->whereHas('siswa', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('username', 'like', "%{$search}%");
        });
    }

    $rekapSiswa = $siswaQuery
        ->orderByDesc('created_at')
        ->paginate(10)
        ->withQueryString();

        $totalSiswa = \App\Models\User::where('role', 'siswa')->count();
        $totalHadir = (clone $siswaQuery)
        ->where('status', 'hadir')
        ->count();
    
    $totalTidakHadir = (clone $siswaQuery)
        ->whereIn('status', ['izin', 'sakit', 'alpa'])
        ->count();

    // Query absensi guru
    $guruQuery = AbsensiGuru::with('user');

    if ($request->filled('tanggal_guru')) {
        $guruQuery->whereDate('tanggal', $request->tanggal_guru);
    }

    if ($request->filled('search_guru')) {
        $searchGuru = $request->search_guru;

        $guruQuery->where(function ($q) use ($searchGuru) {
            $q->where('nama_guru', 'like', "%{$searchGuru}%")
              ->orWhereHas('user', function ($u) use ($searchGuru) {
                  $u->where('name', 'like', "%{$searchGuru}%");
              });
        });
    }

    $rekapGuru = $guruQuery
        ->orderByDesc('tanggal')
        ->paginate(10, ['*'], 'halaman_guru')
        ->withQueryString();

        $totalGuru = User::where('role', 'guru')->count();
    $guruHadir = (clone $guruQuery)->where('status', 'hadir')->count();
    $guruTidakHadir = (clone $guruQuery)
        ->whereIn('status', ['tidak hadir', 'tidak_hadir', 'alpa', 'izin', 'sakit'])
        ->count();

    
        return view('admin.rekap-absensi', compact(
            'rekapSiswa',
            'totalSiswa',
            'totalHadir',
            'totalTidakHadir',
            'rekapGuru',
            'totalGuru',
            'guruHadir',
            'guruTidakHadir'
        ));
    }
    
    public function jadwalGuru()
    {
        $user = auth()->user();
        abort_unless($user->role === 'guru', 403);
    
        $jadwals = JadwalPelajaran::with(['mataPelajaran', 'guru'])
            ->where('guru_id', $user->id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();
    
        $sesiAktif = SesiAbsensi::whereIn(
            'jadwal_pelajaran_id',
            $jadwals->pluck('id')
        )
            ->where('status', 'aktif')
            ->where('berakhir_at', '>', now())
            ->get();
    
        return view('guru.jadwal', compact(
            'user',
            'jadwals',
            'sesiAktif'
        ));
    }
    
    public function sesiGuru()
    {
        $user = auth()->user();
        abort_unless($user->role === 'guru', 403);
    
        $jadwalIds = JadwalPelajaran::where(
            'guru_id',
            $user->id
        )->pluck('id');
    
        $sesiAktif = SesiAbsensi::with(
            'jadwalPelajaran.mataPelajaran'
        )
            ->whereIn('jadwal_pelajaran_id', $jadwalIds)
            ->where('status', 'aktif')
            ->where('berakhir_at', '>', now())
            ->latest('mulai_at')
            ->get();
    
        $jadwals = JadwalPelajaran::where(
            'guru_id',
            $user->id
        )->get();
    
        return view('guru.sesi-absensi', compact(
            'user',
            'jadwals',
            'sesiAktif'
        ));
    }
    }
    