
@extends('layouts.app')

@section('title', 'Data Guru')

@section('content')
<div class="container-fluid py-3">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-people-fill text-primary"></i>
                Data Guru
            </h3>
            <p class="text-muted mb-0">
                Informasi guru yang terdaftar di sekolah.
            </p>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Ringkasan --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-3">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Total Guru</p>
                        <h3 class="fw-bold mb-0">{{ $totalGuru }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-success bg-opacity-10 text-success p-3">
                        <i class="bi bi-person-check-fill fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Guru Aktif</p>
                        <h3 class="fw-bold mb-0">{{ $guruAktif }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Guru --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 p-4">
            <h5 class="fw-bold mb-1">Daftar Guru</h5>
            <p class="text-muted small mb-0">
                Cari dan filter data guru yang terdaftar.
            </p>
        </div>

        <div class="card-body px-4 pb-4">

            {{-- Pencarian dan Filter --}}
            <form action="{{ route('data-guru') }}" method="GET"
                  class="row g-2 mb-4">

                <div class="col-lg-5 col-md-12">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari nama, username, atau NIP/NIK..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-lg-2 col-md-4">
                    <select name="jenjang" class="form-select">
                        <option value="">Semua Jenjang</option>
                        @foreach (['TK', 'SD', 'SMP'] as $jenjang)
                            <option value="{{ $jenjang }}"
                                @selected(request('jenjang') === $jenjang)>
                                {{ $jenjang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-4">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach ([
                            'aktif' => 'Aktif',
                            'pending' => 'Pending',
                            'ditolak' => 'Ditolak',
                        ] as $value => $label)
                            <option value="{{ $value }}"
                                @selected(request('status') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-search"></i> Cari
                    </button>

                    <a href="{{ route('data-guru') }}"
                       class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>

            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Guru</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>NIP/NIK</th>
                            <th>Jenjang</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($gurus as $guru)
                            <tr>
                                <td>
                                    {{ $gurus->firstItem() + $loop->index }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $guru->name }}
                                </td>

                                <td>{{ $guru->username }}</td>

                                <td>{{ $guru->email }}</td>

                                <td>{{ $guru->nik_nip_nis ?: '-' }}</td>

                                <td>
                                    {{ $guru->jenjang ?: '-' }}
                                </td>

                                <td>
                                    @if ($guru->status === 'aktif')
                                        <span class="badge bg-success">
                                            Aktif
                                        </span>
                                    @elseif ($guru->status === 'pending')
                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-person-x fs-1 text-muted"></i>
                                    <p class="fw-semibold mt-2 mb-1">
                                        Data guru tidak ditemukan
                                    </p>
                                    <p class="text-muted small mb-0">
                                        Coba ubah kata pencarian atau filter.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $gurus->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
