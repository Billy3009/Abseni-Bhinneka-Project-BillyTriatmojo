@extends('layouts.app')

@section('title','Dashboard Admin')

@section('content')

<div class="row g-4">

    <div class="col-lg-3 col-md-6">
        <div class="card card-stat">
            <div class="card-body text-center">
                <i class="bi bi-people-fill stat-icon text-primary"></i>

                <h2>{{ $totalUser }}</h2>

                <p class="text-muted mb-0">
                    Total User
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card card-stat">
            <div class="card-body text-center">
                <i class="bi bi-hourglass-split stat-icon text-warning"></i>

                <h2>{{ $pending }}</h2>

                <p class="text-muted mb-0">
                    Pending
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card card-stat">
            <div class="card-body text-center">
                <i class="bi bi-check-circle-fill stat-icon text-success"></i>

                <h2>{{ $aktif }}</h2>

                <p class="text-muted mb-0">
                    User Aktif
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card card-stat">
            <div class="card-body text-center">
                <i class="bi bi-x-circle-fill stat-icon text-danger"></i>

                <h2>{{ $ditolak }}</h2>

                <p class="text-muted mb-0">
                    Ditolak
                </p>
            </div>
        </div>
    </div>

</div>

<br>

<div class="card shadow border-0 rounded-4">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">

<i class="bi bi-clock-history"></i>

Akun Menunggu Persetujuan

</h5>

</div>

<div class="card-body">

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

<table class="table table-hover align-middle">

<thead>

<tr>

<th>Nama</th>

<th>Username</th>

<th>Role</th>

<th>Status</th>

<th width="180">Aksi</th>

</tr>

</thead>

<tbody>

@forelse($users as $user)

@if($user->status=="pending")

<tr>

<td>{{ $user->name }}</td>

<td>{{ $user->username }}</td>

<td>

<span class="badge bg-info">

{{ ucfirst(str_replace('_',' ',$user->role)) }}

</span>

</td>

<td>

<span class="badge bg-warning">

Pending

</span>

</td>

<td>

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

</td>

</tr>

@endif

@empty

<tr>

<td colspan="5" class="text-center">

Tidak ada akun pending.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endsection