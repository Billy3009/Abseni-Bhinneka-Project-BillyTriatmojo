@extends('layouts.app')

@section('title','Kelola Akun')

@section('content')

<div class="card shadow border-0 rounded-4">

<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

<h4 class="mb-0">

<i class="bi bi-people-fill"></i>

Kelola Akun

</h4>

<form>

<div class="input-group">

<input
type="text"
class="form-control"
placeholder="Cari nama atau username...">

<button class="btn btn-light">

<i class="bi bi-search"></i>

</button>

</div>

</form>

</div>

<div class="card-body">

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

<form method="GET">

<div class="row mb-4">

<div class="col-md-5">

<input
type="text"
name="search"
class="form-control"
placeholder="Cari nama atau username..."
value="{{ request('search') }}">

</div>

<div class="col-md-3">

<select name="role" class="form-select">

<option value="">Semua Role</option>

<option value="guru">Guru</option>

<option value="kepala_sekolah">Kepala Sekolah</option>

<option value="siswa">Siswa</option>

</select>

</div>

<div class="col-md-3">

<select name="status" class="form-select">

<option value="">Semua Status</option>

<option value="aktif">Aktif</option>

<option value="pending">Pending</option>

<option value="ditolak">Ditolak</option>

</select>

</div>

<div class="col-md-1">

<button class="btn btn-primary w-100">

<i class="bi bi-search"></i>

</button>

</div>

</div>

</form>

<table class="table table-hover align-middle">

<thead>

<tr>

<th>No</th>

<th>Nama</th>

<th>Username</th>

<th>Role</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

@foreach($users as $user)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $user->name }}</td>

<td>{{ $user->username }}</td>

<td>

@if($user->role=="guru")

<span class="badge bg-info">

Guru

</span>

@elseif($user->role=="kepala_sekolah")

<span class="badge bg-dark">

Kepala Sekolah

</span>

@else

<span class="badge bg-success">

Siswa

</span>

@endif

</td>

<td>

@if($user->status=="aktif")

<span class="badge bg-success">

Aktif

</span>

@elseif($user->status=="pending")

<span class="badge bg-warning">

Pending

</span>

@else

<span class="badge bg-danger">

Ditolak

</span>

@endif

</td>

<td>

@if($user->status=="pending")

<form action="{{ route('users.approve',$user->id) }}"
method="POST"
class="d-inline">

@csrf

<button class="btn btn-success btn-sm">

<i class="bi bi-check-lg"></i>

</button>

</form>

<form action="{{ route('users.reject',$user->id) }}"
method="POST"
class="d-inline">

@csrf

<button class="btn btn-danger btn-sm">

<i class="bi bi-x-lg"></i>

</button>

</form>

@endif

<button
class="btn btn-primary btn-sm detailBtn"

data-name="{{ $user->name }}"
data-username="{{ $user->username }}"
data-role="{{ $user->role }}"
data-status="{{ $user->status }}"
data-identitas="{{ $user->nik_nip_nis }}"
data-jenjang="{{ $user->jenjang }}"
data-kelas="{{ $user->kelas }}">

<i class="bi bi-eye"></i>

</button>

<button class="btn btn-warning btn-sm">

<i class="bi bi-pencil"></i>

</button>

<button class="btn btn-secondary btn-sm">

<i class="bi bi-trash"></i>

</button>

</td>

</tr>

@endforeach

</tbody>

</table>

<div class="mt-3">

{{ $users->links() }}

</div>

</div>

</div>

<div class="modal fade" id="detailModal">

<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">

<h5>Detail Pengguna</h5>

<button class="btn-close" data-bs-dismiss="modal"></button>

</div>

<div class="modal-body" id="detailBody">

</div>

</div>

</div>

</div>

@endsection


document.querySelectorAll(".detailBtn").forEach(button=>{

button.onclick=function(){

document.getElementById("detailBody").innerHTML=`

<p><b>Nama :</b> ${this.dataset.name}</p>

<p><b>Username :</b> ${this.dataset.username}</p>

<p><b>Role :</b> ${this.dataset.role}</p>

<p><b>Status :</b> ${this.dataset.status}</p>

<p><b>NIP/NIS :</b> ${this.dataset.identitas}</p>

<p><b>Jenjang :</b> ${this.dataset.jenjang??'-'}</p>

<p><b>Kelas :</b> ${this.dataset.kelas??'-'}</p>

`;

new bootstrap.Modal(document.getElementById("detailModal")).show();

}

});