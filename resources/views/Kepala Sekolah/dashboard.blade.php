```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Absensi Bhinneka</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .header {
            background: linear-gradient(135deg, #164e9b, #0891b2);
            color: white;
            padding: 28px 6%;
            border-radius: 0 0 28px 28px;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 26px;
        }

        .header p {
            margin: 0;
            color: #e0f2fe;
        }

        .container {
            max-width: 1200px;
            margin: 28px auto;
            padding: 0 20px;
        }

        .profile {
            background: white;
            padding: 22px;
            border-radius: 18px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px #0f172a0a;
        }

        .profile h2 {
            margin: 0 0 8px;
            font-size: 21px;
        }

        .profile p {
            margin: 5px 0;
            color: #64748b;
        }

        .section-title {
            margin: 28px 0 16px;
            font-size: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 18px;
            box-shadow: 0 4px 16px #0f172a0a;
        }

        .card h3 {
            margin: 0 0 12px;
            color: #164e9b;
        }

        .detail {
            margin: 7px 0;
            font-size: 14px;
        }

        .muted {
            color: #64748b;
        }

        .button {
            display: inline-block;
            border: 0;
            border-radius: 10px;
            padding: 10px 14px;
            margin-top: 12px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .button-primary {
            color: white;
            background: #2563eb;
        }

        .button-secondary {
            color: #164e9b;
            background: #dbeafe;
        }

        .button-danger {
            color: white;
            background: #dc2626;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 18px;
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            background: white;
            padding: 24px;
            border-radius: 16px;
            color: #64748b;
            text-align: center;
        }

        .session-status {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .session-item {
            border-top: 1px solid #e2e8f0;
            padding-top: 16px;
            margin-top: 16px;
        }

        .logout-form {
            display: inline;
        }

        @media (max-width: 700px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <header class="header">
        <h1>Absensi Bhinneka</h1>
        <p>Dashboard Guru</p>
    </header>

    <main class="container">

        @if (session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <section class="profile">
            <h2>Halo, {{ $user->name }}!</h2>
            <p>Selamat datang di sistem Absensi Bhinneka.</p>
            <p>NIP/NIK: {{ $user->nik_nip_nis ?? '-' }}</p>
            <p>Jenjang: {{ $user->jenjang ?? '-' }}</p>
        </section>

        <h2 class="section-title">Jadwal Mengajar Saya</h2>

        @forelse ($jadwals as $jadwal)
            <article class="card" style="margin-bottom: 18px;">
                <h3>
                    {{ $jadwal->mataPelajaran->nama_pelajaran ?? 'Mata pelajaran belum diatur' }}
                </h3>

                <p class="detail">
                    <strong>Kelas:</strong>
                    {{ $jadwal->jenjang }} - {{ $jadwal->kelas }}
                </p>

                <p class="detail">
                    <strong>Hari:</strong> {{ $jadwal->hari }}
                </p>

                <p class="detail">
                    <strong>Jam:</strong>
                    {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                </p>

                <form method="POST"
                      action="{{ route('absensi-guru.mulai', $jadwal->id) }}"
                      onsubmit="return confirm('Mulai