<div class="navbar-custom d-flex justify-content-between align-items-center">

<div>

<h4>

Halo,

{{ Auth::user()->name }}

👋

</h4>

<small>

Selamat Datang di Aplikasi Absensi Bhinneka

</small>

</div>

<div>

<i class="bi bi-calendar3"></i>

{{ now()->format('d F Y') }}

</div>

</div>