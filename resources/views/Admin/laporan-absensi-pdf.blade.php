
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi Bhinneka</title>

    <style>
        @page {
            margin: 35px;
        }

        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #1e293b;
        }

        /* HEADER LAPORAN */
        .header {
            position: relative;
            height: 115px;
            margin-bottom: 12px;
        }

        .header-logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 110px;
            height: 110px;
        }

        .header-title {
            position: absolute;
            left: 0;
            right: 0;
            top: 28px;
            text-align: center;
        }

        .header-title h1 {
            font-size: 21px;
            font-weight: bold;
            line-height: 1.4;
            margin: 0;
        }

        .header-title p {
            font-size: 12px;
            margin: 8px 0 0;
        }

        hr {
            border: 0;
            border-top: 2px solid #334155;
            margin: 12px 0;
        }

        h2 {
            font-size: 13px;
            margin-top: 22px;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #cbd5e1;
            padding: 7px;
            text-align: left;
        }

        th {
            background-color: #e9eef5;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        /* TANDA TANGAN KEPALA SEKOLAH */
        .signature {
            width: 45%;
            margin-left: 55%;
            margin-top: 30px;
            text-align: center;
            page-break-inside: avoid;
        }

        .signature-space {
            height: 65px;
        }

        .signature-name {
            margin-bottom: 4px;
            font-weight: bold;
            text-decoration: underline;
        }

        .signature-nip {
            margin-top: 4px;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <img
            class="header-logo"
            src="{{ public_path('images/ChatGPT Image 27 Jul 2026, 15.19.19.png') }}"
            alt="Logo Sekolah"
        >

        
<div class="header-title">
    <h1>LAPORAN ABSENSI BHINNEKA</h1>
    <p>Laporan Kehadiran Siswa dan Guru</p>
    <p class="school-address">
    Perum Taman Walet-Blok SQ2 - No.2 Kel.Sindangsari - Kec.PasarKemis - Kab.Tangerang - Banten - 15560
    </p>
</div>
    </div>

    <hr>

    <!-- INFORMASI PERIODE -->
    <p>
        Periode:
        {{ $filter['tanggal_awal'] ?? 'Semua tanggal' }}
        sampai
        {{ $filter['tanggal_akhir'] ?? 'Semua tanggal' }}
    </p>

    <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>

    <!-- ABSENSI SISWA -->
    @if ($jenis !== 'guru')
        <h2>Absensi Siswa</h2>

        <table>
            <thead>
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
                        <td colspan="7" class="center">
                            Belum ada data absensi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <!-- ABSENSI GURU -->
    @if ($jenis !== 'siswa')
        <h2>Absensi Guru</h2>

        <table>
            <thead>
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
                        <td colspan="5" class="center">
                            Belum ada data absensi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <!-- TANDA TANGAN KEPALA SEKOLAH -->
    <div class="signature">
        <p style="margin-bottom: 4px;">Mengetahui,</p>
        <p style="margin-top: 0;">Kepala Sekolah</p>

        <div class="signature-space"></div>

        <p class="signature-name">
            ........................................
        </p>

        <p class="signature-nip">
            NIP. ................................
        </p>
    </div>

</body>
</html>
