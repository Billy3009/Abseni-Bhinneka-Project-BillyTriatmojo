
@extends('layouts.app')

@section('title', 'Edit Akun')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white p-3 rounded-top-4">
            <h4 class="mb-0">
                <i class="bi bi-pencil-square"></i>
                Edit Akun Pengguna
            </h4>
        </div>

        <div class="card-body p-4">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Periksa kembali data berikut:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.update', $user->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control"
                           value="{{ old('username', $user->username) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">NIK/NIP/NIS</label>
                    <input type="text" name="nik_nip_nis" class="form-control"
                           value="{{ old('nik_nip_nis', $user->nik_nip_nis) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        @foreach ([
                            'admin' => 'Admin',
                            'guru' => 'Guru',
                            'kepala_sekolah' => 'Kepala Sekolah',
                            'siswa' => 'Siswa',
                        ] as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('role', $user->role) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenjang</label>
                    <select name="jenjang" class="form-select">
                        <option value="">Tidak ditentukan</option>
                        @foreach (['TK', 'SD', 'SMP'] as $jenjang)
                            <option value="{{ $jenjang }}"
                                @selected(old('jenjang', $user->jenjang) === $jenjang)>
                                {{ $jenjang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <input type="text" name="kelas" class="form-control"
                           value="{{ old('kelas', $user->kelas) }}"
                           placeholder="Contoh: XI RPL 1">
                </div>

                <div class="mb-4">
                    <label class="form-label">Status Akun</label>
                    <select name="status" class="form-select" required>
                        @foreach ([
                            'pending' => 'Pending',
                            'aktif' => 'Aktif',
                            'ditolak' => 'Ditolak',
                        ] as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('status', $user->status) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('users') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
