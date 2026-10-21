
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Data Siswa</h2>
            <p class="text-muted mb-0">Kelola dan pantau data siswa sekolah.</p>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <p class="text-muted mb-2">Total Siswa</p>
                    <h3 class="fw-bold mb-0">{{ $totalSiswa }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <p class="text-muted mb-2">Siswa Aktif</p>
                    <h3 class="fw-bold text-success mb-0">{{ $siswaAktif }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Pencarian dan filter --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ url('/data-siswa') }}">
                <div class="row g-3">

                    <div class="col-lg-4">
                        <label class="form-label">Cari Siswa</label>
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Nama, username, atau NIK/NIS"
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="col-lg-2">
                        <label class="form-label">Jenjang</label>
                        <select name="jenjang" class="form-select">
                            <option value="">Semua Jenjang</option>
                            @foreach (['TK', 'SD', 'SMP'] as $jenjang)
                                <option value="{{ $jenjang }}"
                                    @selected(request('jenjang') == $jenjang)>
                                    {{ $jenjang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2">
                        <label class="form-label">Kelas</label>
                        <input
                            type="text"
                            name="kelas"
                            class="form-control"
                            placeholder="Contoh: 6A"
                            value="{{ request('kelas') }}"
                        >
                    </div>

                    <div class="col-lg-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            @foreach (['pending', 'aktif', 'ditolak'] as $status)
                                <option value="{{ $status }}"
                                    @selected(request('status') == $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Cari
                        </button>
                        <a href="{{ url('/data-siswa') }}"
                           class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Tabel siswa --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Daftar Siswa</h5>
                <span class="text-muted small">
                    {{ $siswas->total() }} data
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Username</th>
                            <th>NIK/NIS</th>
                            <th>Jenjang</th>
                            <th>Kelas</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($siswas as $index => $siswa)
                            <tr>
                                <td>
                                    {{ $siswas->firstItem() + $index }}
                                </td>
                                <td class="fw-semibold">
                                    {{ $siswa->name }}
                                </td>
                                <td>{{ $siswa->username ?? '-' }}</td>
                                <td>{{ $siswa->nik_nip_nis ?? '-' }}</td>
                                <td>{{ $siswa->jenjang ?? '-' }}</td>
                                <td>{{ $siswa->kelas ?? '-' }}</td>
                                <td>
                                    @php
                                        $warnaStatus = match ($siswa->status) {
                                            'aktif' => 'success',
                                            'pending' => 'warning',
                                            'ditolak' => 'danger',
                                            default => 'secondary',
                                        };
                                    @endphp

                                    <span class="badge bg-{{ $warnaStatus }}">
                                        {{ ucfirst($siswa->status ?? 'Belum diatur') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <p class="text-muted mb-1">
                                        Belum ada data siswa.
                                    </p>
                                    <small>
                                        Coba ubah pencarian atau filter.
                                    </small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $siswas->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
