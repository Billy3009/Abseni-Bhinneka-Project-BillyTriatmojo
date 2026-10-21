
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Laporan Absensi</h2>
        <p class="text-muted mb-0">
            Filter dan unduh laporan kehadiran siswa maupun guru.
        </p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Filter Laporan</h5>

            <form action="{{ route('laporan-absensi') }}" method="GET"
                  class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Jenis Laporan</label>
                    <select name="jenis" class="form-select">
                        <option value="keduanya"
                            {{ $jenis === 'keduanya' ? 'selected' : '' }}>
                            Siswa dan Guru
                        </option>
                        <option value="siswa"
                            {{ $jenis === 'siswa' ? 'selected' : '' }}>
                            Siswa
                        </option>
                        <option value="guru"
                            {{ $jenis === 'guru' ? 'selected' : '' }}>
                            Guru
                        </option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal"
                           value="{{ $filter['tanggal_awal'] ?? '' }}"
                           class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir"
                           value="{{ $filter['tanggal_akhir'] ?? '' }}"
                           class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Jenjang Siswa</label>
                    <select name="jenjang" class="form-select">
                        <option value="">Semua Jenjang</option>
                        @foreach (['TK', 'SD', 'SMP'] as $jenjang)
                            <option value="{{ $jenjang }}"
                                {{ ($filter['jenjang'] ?? '') === $jenjang ? 'selected' : '' }}>
                                {{ $jenjang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Kelas Siswa</label>
                    <input type="text" name="kelas"
                           value="{{ $filter['kelas'] ?? '' }}"
                           class="form-control"
                           placeholder="Contoh: 6A">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status Kehadiran</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach (['hadir', 'izin', 'sakit', 'alpa'] as $status)
                            <option value="{{ $status }}"
                                {{ ($filter['status'] ?? '') === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Tampilkan
                    </button>

                    <a href="{{ route('laporan-absensi') }}"
                       class="btn btn-outline-secondary ms-2">
                        Reset
                    </a>

                    <button type="submit" formtarget="_blank"
                            formaction="{{ route('laporan-absensi.pdf') }}"
                            class="btn btn-danger ms-2">
                        <i class="bi bi-file-earmark-pdf me-1"></i>
                        Unduh PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if ($jenis !== 'guru')
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Pratinjau Absensi Siswa</h5>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Siswa</th>
                                <th>Jenjang</th>
                                <th>Kelas</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rekapSiswa as $absen)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $absen->sesiAbsensi?->mulai_at
                                            ? \Carbon\Carbon::parse($absen->sesiAbsensi->mulai_at)->format('d-m-Y')
                                            : '-' }}
                                    </td>
                                    <td>{{ $absen->siswa?->name ?? '-' }}</td>
                                    <td>{{ $absen->siswa?->jenjang ?? '-' }}</td>
                                    <td>{{ $absen->siswa?->kelas ?? '-' }}</td>
                                    <td>
                                        {{ $absen->waktu_absen
                                            ? \Carbon\Carbon::parse($absen->waktu_absen)->format('H:i')
                                            : '-' }}
                                    </td>
                                    <td>{{ ucfirst($absen->status ?? '-') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Belum ada data absensi siswa.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if ($jenis !== 'siswa')
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Pratinjau Absensi Guru</h5>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Guru</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rekapGuru as $absen)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $absen->tanggal
                                            ? \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y')
                                            : '-' }}
                                    </td>
                                    <td>{{ $absen->nama_guru ?? $absen->user?->name ?? '-' }}</td>
                                    <td>
                                        {{ $absen->waktu
                                            ? \Carbon\Carbon::parse($absen->waktu)->format('H:i')
                                            : '-' }}
                                    </td>
                                    <td>{{ ucfirst($absen->status ?? '-') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Belum ada data absensi guru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
