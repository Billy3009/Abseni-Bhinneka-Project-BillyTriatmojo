
<div class="sidebar">

    <h4>
        <img src="{{ asset('images/ChatGPT Image 27 Jul 2026, 15.19.19.png') }}" width="70">
        <br><br>
        Absensi
        <br>
        Bhinneka
    </h4>

    <a href="{{ route('dashboard') }}">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    <a href="{{ route('users') }}">
        <i class="bi bi-people"></i>
        Kelola Akun
    </a>

    <a href="{{ route('data-guru') }}">
    <i class="bi bi-people-fill"></i>
    <span>Data Guru</span>
</a>

<a href="{{ route('data-siswa') }}">
    <i class="bi bi-mortarboard"></i>
    Data Siswa
</a>

    <a href="{{ route('rekap-absensi') }}">
    <i class="bi bi-file-earmark-bar-graph"></i>
    Rekap Absensi
</a>
<a href="{{ route('laporan-absensi') }}">
    <i class="bi bi-file-earmark-bar-graph"></i>
    Laporan
</a>
    {{-- Tombol Logout --}}
    <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <i class="bi bi-box-arrow-right"></i>
        Logout
    </a>

</div>

{{-- Modal Konfirmasi Logout --}}
<div class="modal fade" id="logoutModal" tabindex="-1"
     aria-labelledby="logoutModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-body text-center p-4">

                <i class="bi bi-box-arrow-right text-danger"
                   style="font-size: 3rem;"></i>

                <h4 class="fw-bold mt-3" id="logoutModalLabel">
                    Mau Logout?
                </h4>

                <p class="text-muted">
                    Apakah kamu yakin ingin keluar dari akunmu?
                </p>

                <div class="d-flex justify-content-center gap-2">

                    <button type="button"
                            class="btn btn-light border px-4"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-box-arrow-right"></i>
                            Ya, Logout
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
