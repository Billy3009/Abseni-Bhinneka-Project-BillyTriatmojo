
@extends('layouts.app')

@section('content')
<style>
    .rekap-tabs {
        display: flex;
        gap: 8px;
        padding: 6px;
        background: #e9eef5;
        border-radius: 14px;
        width: fit-content;
        max-width: 100%;
    }

    .rekap-tab {
        border: none;
        border-radius: 10px;
        padding: 11px 22px;
        color: #64748b;
        background: transparent;
        font-weight: 600;
        transition: background .25s, color .25s, box-shadow .25s;
    }

    .rekap-tab.active {
        color: #fff;
        background: #2563eb;
        box-shadow: 0 4px 12px #2563eb30;
    }

    .rekap-viewport {
        overflow: hidden;
        width: 100%;
    }

    .rekap-track {
        display: flex;
        align-items: flex-start;
        width: 200%;
        transition: transform .45s cubic-bezier(.22, 1, .36, 1);
    }

    .rekap-panel {
        width: 50%;
        min-width: 0;
        padding: 2px;
    }

    .rekap-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, .06);
    }

    .rekap-stat {
        transition: transform .25s, box-shadow .25s;
    }

    .rekap-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, .09);
    }

    .rekap-table th {
        white-space: nowrap;
    }

    @media (max-width: 576px) {
        .rekap-tab {
            padding: 10px 14px;
            font-size: 14px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .rekap-track, .rekap-tab, .rekap-stat {
            transition: none !important;
        }
    }
</style>

<div class="container-fluid py-4">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Rekap Absensi</h2>
        <p class="text-muted mb-0">
            Pantau kehadiran guru dan siswa di Absensi Bhinneka.
        </p>
    </div>

    {{-- Tombol tab --}}
    <div class="rekap-tabs mb-4" role="tablist">
        <button type="button"
                class="rekap-tab active"
                id="tab-siswa"
                role="tab"
                aria-selected="true"
                aria-controls="panel-siswa"
                data-target="siswa">
            <i class="bi bi-mortarboard me-1"></i>
            Absensi Siswa
        </button>

        <button type="button"
                class="rekap-tab"
                id="tab-guru"
                role="tab"
                aria-selected="false"
                aria-controls="panel-guru"
                data-target="guru">
            <i class="bi bi-people me-1"></i>
            Absensi Guru
        </button>
    </div>

    {{-- Area slide --}}
    <div class="rekap-viewport">
        <div class="rekap-track" id="rekap-track">

            {{-- PANEL SISWA --}}
            <section class="rekap-panel"
                     id="panel-siswa"
                     role="tabpanel"
                     aria-labelledby="tab-siswa">

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card rekap-card rekap-stat h-100">
                            <div class="card-body p-4">
                            <p class="text-muted mb-2">Total Siswa</p>
                            <h3 class="fw-bold mb-0">{{ $totalSiswa }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card rekap-card rekap-stat h-100">
                            <div class="card-body p-4">
                                <p class="text-muted mb-2">Hadir</p>
                                <h3 class="fw-bold text-success mb-0">{{ $totalHadir }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card rekap-card rekap-stat h-100">
                            <div class="card-body p-4">
                                <p class="text-muted mb-2">Tidak Hadir</p>
                                <h3 class="fw-bold text-danger mb-0">{{ $totalTidakHadir }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card rekap-card mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Filter Absensi Siswa</h5>

                        <form action="{{ route('rekap-absensi') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal"
                                       class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Jenjang</label>
                                <select name="jenjang" class="form-select">
                                    <option value="">Semua Jenjang</option>
                                    <option>TK</option>
                                    <option>SD</option>
                                    <option>SMP</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas"
                                       class="form-control"
                                       placeholder="Contoh: 6A">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Cari Nama</label>
                                <input type="text" name="search"
                                       class="form-control"
                                       placeholder="Nama siswa">
                            </div>

                            <div class="col-12">
                            <button type="submit" class="btn btn-primary">
    <i class="bi bi-search me-1"></i>
    Filter
</button>
<a href="{{ route('rekap-absensi') }}" class="btn btn-outline-secondary ms-2">
    Reset
</a>
                                <small class="text-muted ms-2">
                                    Filter aktif setelah database terhubung.
                                </small>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card rekap-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Daftar Kehadiran Siswa</h5>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle rekap-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Siswa</th>
                                        <th>Jenjang</th>
                                        <th>Kelas</th>
                                        <th>Waktu Hadir</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
    @forelse ($rekapSiswa as $absen)
        <tr>
            <td>{{ $rekapSiswa->firstItem() + $loop->index }}</td>
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
            <td colspan="7" class="text-center text-muted py-5">
                Belum ada data absensi siswa.
            </td>
        </tr>
    @endforelse
</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            {{-- PANEL GURU --}}
            <section class="rekap-panel"
                     id="panel-guru"
                     role="tabpanel"
                     aria-labelledby="tab-guru"
                     aria-hidden="true"
                     inert>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card rekap-card rekap-stat h-100">
                            <div class="card-body p-4">
                                <p class="text-muted mb-2">Total Guru</p>
                                <h3 class="fw-bold text-danger mb-0">{{ $totalGuru }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card rekap-card rekap-stat h-100">
                            <div class="card-body p-4">
                                <p class="text-muted mb-2">Hadir</p>
                                <h3 class="fw-bold text-success mb-0">{{ $totalHadir }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card rekap-card rekap-stat h-100">
                            <div class="card-body p-4">
                                <p class="text-muted mb-2">Tidak Hadir</p>
                                <h3 class="fw-bold text-danger mb-0">{{ $totalTidakHadir }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card rekap-card mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Filter Absensi Guru</h5>

                        
<form action="{{ route('rekap-absensi') }}" method="GET" class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Tanggal</label>
        <input type="date"
               name="tanggal_guru"
               value="{{ request('tanggal_guru') }}"
               class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Cari Nama Guru</label>
        <input type="text"
               name="search_guru"
               value="{{ request('search_guru') }}"
               class="form-control"
               placeholder="Nama guru">
    </div>

    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search me-1"></i>
            Filter
        </button>
        <a href="{{ route('rekap-absensi') }}"
           class="btn btn-outline-secondary ms-2">Reset</a>
    </div>
</form>

                    </div>
                </div>

                <div class="card rekap-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Daftar Kehadiran Guru</h5>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle rekap-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Guru</th>
                                        <th>Waktu Hadir</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
<tbody>
    @forelse ($rekapGuru as $absen)
        <tr>
            <td>{{ $rekapGuru->firstItem() + $loop->index }}</td>
            <td>
                {{ $absen->tanggal
                    ? \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y')
                    : '-' }}
            </td>
            <td>
                {{ $absen->nama_guru ?? $absen->user?->name ?? '-' }}
            </td>
            <td>
                {{ $absen->waktu
                    ? \Carbon\Carbon::parse($absen->waktu)->format('H:i')
                    : '-' }}
            </td>
            <td>{{ ucfirst($absen->status ?? '-') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center text-muted py-5">
                Belum ada data absensi guru.
            </td>
        </tr>
    @endforelse
</tbody>

                            </table>
                           {{ $rekapGuru->links() }}
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('rekap-track');
    const tabs = document.querySelectorAll('.rekap-tab');
    const panelSiswa = document.getElementById('panel-siswa');
    const panelGuru = document.getElementById('panel-guru');

    function pindahTab(jenis) {
        const siswaAktif = jenis === 'siswa';

        track.style.transform = siswaAktif
            ? 'translateX(0)'
            : 'translateX(-50%)';

        tabs.forEach(function (tab) {
            const aktif = tab.dataset.target === jenis;

            tab.classList.toggle('active', aktif);
            tab.setAttribute('aria-selected', aktif ? 'true' : 'false');
            tab.tabIndex = aktif ? 0 : -1;
        });

        panelSiswa.setAttribute('aria-hidden', siswaAktif ? 'false' : 'true');
        panelGuru.setAttribute('aria-hidden', siswaAktif ? 'true' : 'false');

        panelSiswa.inert = !siswaAktif;
        panelGuru.inert = siswaAktif;
    }

    tabs.forEach(function (tab, index) {
        tab.addEventListener('click', function () {
            pindahTab(tab.dataset.target);
        });

        tab.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
                event.preventDefault();

                const nextIndex = event.key === 'ArrowRight'
                    ? (index + 1) % tabs.length
                    : (index - 1 + tabs.length) % tabs.length;

                tabs[nextIndex].focus();
                pindahTab(tabs[nextIndex].dataset.target);
            }
        });
    });

    pindahTab('siswa');
});
</script>
@endsection
