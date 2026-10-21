
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mx-auto" style="max-width: 500px;">
        <div class="card-body text-center p-4">
            <h3 class="mb-3">QR Code Absensi</h3>

            <p class="text-muted">
                Tunjukkan QR ini kepada murid untuk dipindai.
            </p>

            <div id="qrcode"
                 class="d-flex justify-content-center my-4"></div>

            <p class="small text-muted">
                QR berlaku sampai:
                {{ $sesi->berakhir_at->format('H:i') }}
            </p>

            <form method="POST"
                  action="{{ route('absensi-guru.tutup', $sesi->id) }}">
                @csrf

                <button type="submit" class="btn btn-danger">
                    Tutup Sesi Absensi
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    new QRCode(document.getElementById("qrcode"), {
        text: @json(url('/scan-absensi/' . $sesi->token_qr)),
        width: 250,
        height: 250
    });
</script>
PS C:\xampp\htdocs\Absensi_Bhinneka>  php artisan route:list --name=absensi-guru.mulai

  POST       jadwal/{jadwal}/absensi/mulai ............................................................ absensi-guru.mulai › SesiAbsensiController@mulai

                                                                                                                                      Showing [1] routes


@endsection
