
@extends('layouts.app')

@section('title', 'Kelola Akun')

@section('content')
<div class="card shadow border-0 rounded-4">

    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">
            <i class="bi bi-people-fill"></i>
            Kelola Akun
        </h4>
    </div>

    <div class="card-body">

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Pesan error validasi --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Pencarian dan filter --}}
        <form method="GET" action="{{ route('users') }}">
            <div class="row g-2 mb-4">

                <div class="col-md-5">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari nama atau username..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                        <option value="guru" @selected(request('role') === 'guru')>Guru</option>
                        <option value="kepala_sekolah" @selected(request('role') === 'kepala_sekolah')>Kepala Sekolah</option>
                        <option value="siswa" @selected(request('role') === 'siswa')>Siswa</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100" title="Cari">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

                @if(request()->hasAny(['search', 'role', 'status']))
                    <div class="col-12">
                        <a href="{{ route('users') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Reset Filter
                        </a>
                    </div>
                @endif

            </div>
        </form>

        {{-- Tabel pengguna --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th style="min-width: 150px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->username }}</td>

                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-primary">Admin</span>
                                @elseif($user->role === 'guru')
                                    <span class="badge bg-info text-dark">Guru</span>
                                @elseif($user->role === 'kepala_sekolah')
                                    <span class="badge bg-dark">Kepala Sekolah</span>
                                @else
                                    <span class="badge bg-success">Siswa</span>
                                @endif
                            </td>

                            <td>
                                @if($user->status === 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($user->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex flex-wrap gap-1">

                                    @if($user->status === 'pending')
                                        <form
                                            action="{{ route('users.approve', $user->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Setujui akun ini?')"
                                        >
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Setujui akun">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>

                                        <form
                                            action="{{ route('users.reject', $user->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Tolak akun ini?')"
                                        >
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title="Tolak akun">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Detail pengguna --}}
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm detailBtn"
                                        title="Lihat detail"
                                        data-name="{{ $user->name }}"
                                        data-username="{{ $user->username }}"
                                        data-role="{{ $user->role }}"
                                        data-status="{{ $user->status }}"
                                        data-identitas="{{ $user->nik_nip_nis ?? '' }}"
                                        data-jenjang="{{ $user->jenjang ?? '' }}"
                                        data-kelas="{{ $user->kelas ?? '' }}"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>

                                   
{{-- Tombol Edit Akun --}}
<a
    href="{{ route('users.edit', $user->id) }}"
    class="btn btn-warning btn-sm"
    title="Edit akun"
>
    <i class="bi bi-pencil"></i>
</a>


                                   
<form action="{{ route('users.destroy', $user->id) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->name }}? Akun yang dihapus tidak dapat dipulihkan.');">
    @csrf
    @method('DELETE')

    <button
        type="submit"
        class="btn btn-danger btn-sm"
        title="Hapus akun"
    >
        <i class="bi bi-trash"></i>
    </button>
</form>


                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Data pengguna tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        @endif

    </div>
</div>

{{-- Modal detail pengguna --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="bi bi-person-vcard"></i>
                    Detail Pengguna
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th style="width: 35%;">Nama</th>
                        <td id="detailName">-</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td id="detailUsername">-</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td id="detailRole">-</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td id="detailStatus">-</td>
                    </tr>
                    <tr>
                        <th>NIK/NIP/NIS</th>
                        <td id="detailIdentitas">-</td>
                    </tr>
                    <tr>
                        <th>Jenjang</th>
                        <td id="detailJenjang">-</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td id="detailKelas">-</td>
                    </tr>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const detailModalElement = document.getElementById('detailModal');

    if (!detailModalElement || typeof bootstrap === 'undefined') {
        return;
    }

    const detailModal = new bootstrap.Modal(detailModalElement);

    document.querySelectorAll('.detailBtn').forEach(function (button) {
        button.addEventListener('click', function () {
            document.getElementById('detailName').textContent = this.dataset.name || '-';
            document.getElementById('detailUsername').textContent = this.dataset.username || '-';
            document.getElementById('detailRole').textContent = this.dataset.role || '-';
            document.getElementById('detailStatus').textContent = this.dataset.status || '-';
            document.getElementById('detailIdentitas').textContent = this.dataset.identitas || '-';
            document.getElementById('detailJenjang').textContent = this.dataset.jenjang || '-';
            document.getElementById('detailKelas').textContent = this.dataset.kelas || '-';

            detailModal.show();
        });
    });
});
</script>
@endpush
