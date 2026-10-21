<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Absensi | Absensi Bhinneka</title>
    <style>
        :root{--navy:#102a56;--blue:#2563eb;--cyan:#06b6d4;--ink:#17233c;--muted:#718096;--line:#e7edf5;--bg:#f4f7fb;--white:#fff}
        *{box-sizing:border-box}body{margin:0;background:var(--bg);font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif;color:var(--ink)}
        .layout{min-height:100vh;display:flex}.sidebar{min-height:100vh;width:250px;background:linear-gradient(180deg,#102a56,#123e73);color:#fff;padding:28px 18px;display:flex;flex-direction:column;flex-shrink:0}
        .brand{display:flex;align-items:center;gap:12px;padding:0 10px 32px}.brand-logo{width:43px;height:43px;border-radius:14px;background:linear-gradient(135deg,#22d3ee,#3b82f6);display:grid;place-items:center;font-size:20px;font-weight:900;color:white;box-shadow:0 8px 20px #0002}.brand strong{display:block;font-size:16px;letter-spacing:.2px}.brand small{color:#b9d4f5;font-size:11px}
        .nav-label{font-size:10px;font-weight:800;letter-spacing:1.6px;color:#91b3dc;padding:0 12px;margin:5px 0 12px}.nav-link{display:flex;align-items:center;gap:12px;color:#d7e6fa;text-decoration:none;padding:12px 14px;border-radius:12px;font-size:13px;margin-bottom:5px}.nav-link.active,.nav-link:hover{background:#ffffff1c;color:#fff}.nav-icon{width:20px;text-align:center;font-size:17px}.sidebar-bottom{margin-top:auto;border-top:1px solid #ffffff20;padding:20px 10px 0;color:#c6d9f1;font-size:12px;line-height:1.7}.sidebar-logout{width:100%;display:flex;align-items:center;gap:10px;margin-top:18px;padding:12px 14px;border:1px solid #ffffff26;border-radius:12px;background:#ffffff10;color:#fff;font:inherit;font-size:13px;font-weight:750;text-align:left;cursor:pointer}.sidebar-logout:hover{background:#ffffff20}.sidebar-logout span{width:20px;text-align:center;font-size:17px}
        .main{flex:1;min-width:0;padding:28px 34px 40px}.topbar{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:26px}.topbar-right{display:flex;align-items:center;gap:10px;flex-wrap:wrap}.eyebrow{font-size:11px;color:var(--muted);font-weight:700;letter-spacing:1.5px;text-transform:uppercase}.topbar h1{font-size:25px;margin:5px 0 0;color:#14294b}.user-chip{display:flex;align-items:center;gap:11px;background:#fff;border:1px solid var(--line);padding:9px 14px;border-radius:15px}.avatar{width:39px;height:39px;border-radius:13px;background:linear-gradient(135deg,#cffafe,#bfdbfe);color:#1d4ed8;display:grid;place-items:center;font-weight:800}.user-chip strong{display:block;font-size:13px}.user-chip small{color:var(--muted);font-size:11px}
        .welcome{position:relative;overflow:hidden;background:linear-gradient(115deg,#1d4ed8 0%,#087fbd 58%,#06b6d4 100%);color:#fff;padding:29px 30px;border-radius:23px;box-shadow:0 15px 32px #1d4ed826;margin-bottom:25px}.welcome:after{content:"";position:absolute;width:230px;height:230px;border:35px solid #ffffff16;border-radius:50%;right:-55px;top:-100px}.welcome:before{content:"";position:absolute;width:110px;height:110px;background:#ffffff0d;border-radius:30px;right:125px;bottom:-70px;transform:rotate(35deg)}.welcome-content{position:relative;z-index:1;max-width:680px}.welcome .tag{display:inline-flex;align-items:center;gap:7px;background:#ffffff20;border:1px solid #ffffff2e;border-radius:999px;padding:6px 11px;font-size:11px;font-weight:700}.welcome h2{font-size:27px;margin:15px 0 8px;letter-spacing:-.6px}.welcome p{font-size:13px;line-height:1.7;color:#e2f6ff;margin:0;max-width:570px}
        .stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin-bottom:28px}.stat{background:#fff;border:1px solid var(--line);border-radius:18px;padding:20px;display:flex;align-items:center;gap:14px;box-shadow:0 4px 12px #17345b05}.stat-icon{width:47px;height:47px;border-radius:15px;display:grid;place-items:center;font-size:21px;flex-shrink:0}.blue{background:#dbeafe;color:#2563eb}.cyan{background:#cffafe;color:#0891b2}.green{background:#dcfce7;color:#16a34a}.stat small{font-size:11px;color:var(--muted);font-weight:650}.stat strong{display:block;font-size:25px;margin-top:3px;color:#182a48}
        .section-head{display:flex;align-items:end;justify-content:space-between;gap:16px;margin:4px 0 16px}.section-head h2{font-size:18px;margin:0 0 5px}.section-head p{font-size:12px;color:var(--muted);margin:0}.tools{display:flex;gap:9px;flex-wrap:wrap}.search{border:1px solid #dfe7f1;background:#fff;border-radius:11px;padding:10px 12px;font:inherit;font-size:12px;outline:none;min-width:210px}.search:focus{border-color:#60a5fa;box-shadow:0 0 0 3px #dbeafe}
        .schedule-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}.schedule-card,.session-card{background:#fff;border:1px solid var(--line);border-radius:18px;padding:20px;box-shadow:0 4px 12px #17345b05;min-width:0}.card-top{display:flex;align-items:flex-start;justify-content:space-between;gap:12px}.subject{font-size:16px;font-weight:800;margin:0 0 6px;color:#1c2e4d}.class-meta{font-size:12px;color:var(--muted)}.pill{font-size:10px;font-weight:800;padding:6px 9px;border-radius:999px;background:#eff6ff;color:#2563eb;white-space:nowrap}.details{display:grid;grid-template-columns:1fr 1fr;gap:11px;margin:18px 0;padding:14px;background:#f7faff;border-radius:13px}.detail-label{display:block;font-size:10px;color:#8290a5;margin-bottom:5px}.detail-value{font-size:12px;font-weight:750;color:#293a58}.card-actions{display:flex;gap:9px}.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;border:0;border-radius:10px;padding:10px 13px;font:inherit;font-size:12px;font-weight:750;text-decoration:none;cursor:pointer}.btn-primary{background:linear-gradient(100deg,#2563eb,#0891b2);color:#fff;flex:1}.btn-primary:hover{filter:brightness(.96)}.btn-light{background:#eef4fb;color:#334968}.btn-danger{background:#fff1f2;color:#be123c}.empty{grid-column:1/-1;background:#fff;border:1px dashed #cbd5e1;border-radius:18px;text-align:center;padding:35px 20px;color:var(--muted)}.empty .empty-icon{font-size:28px;margin-bottom:8px}.empty strong{display:block;color:#31415d;margin-bottom:5px}.session-section{margin-top:30px}.session-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.session-card{border-left:4px solid #06b6d4}.session-top{display:flex;align-items:center;justify-content:space-between;gap:10px}.live{font-size:10px;font-weight:800;color:#15803d;background:#dcfce7;border-radius:999px;padding:6px 9px}.session-card p{font-size:12px;color:var(--muted);line-height:1.6}.session-card form{margin-top:14px}.footer-note{font-size:11px;color:#8a98ad;text-align:center;margin-top:32px}
        @media(max-width:950px){.sidebar{width:215px}.main{padding:24px}.stats{grid-template-columns:1fr 1fr}.schedule-grid,.session-list{grid-template-columns:1fr}}
        @media(max-width:650px){.layout{display:block}.sidebar{min-height:auto;width:100%;padding:15px;display:flex;flex-direction:column}.brand{padding:0 4px 14px}.sidebar nav{display:block}.nav-label{display:block}.sidebar-bottom{display:block;margin-top:12px;padding:12px 4px 0}.main{padding:20px 15px 30px}.topbar{align-items:flex-start}.topbar h1{font-size:21px}.topbar-right{justify-content:flex-end;gap:7px}.user-chip{padding:7px}.user-chip small{display:none}.welcome{padding:24px 21px}.welcome h2{font-size:23px}.stats{grid-template-columns:1fr;gap:10px}.stat{padding:15px}.section-head{align-items:flex-start;flex-direction:column}.tools,.search{width:100%}.details{gap:8px;padding:12px}.card-actions{flex-direction:column}.btn-primary{min-height:40px}}
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand"><div class="brand-logo">B</div><div><strong>BHINNEKA</strong><small>Sistem Informasi Absensi</small></div></div>
        <div class="nav-label">MENU UTAMA</div>
        <nav>
            <a class="nav-link " href="{{ route('dashboard') }}"><span class="nav-icon">▦</span>Dashboard</a>
            <a class="nav-link " href="{{ route('guru.jadwal') }}"><span class="nav-icon">▤</span>Jadwal Mengajar</a>
            <a class="nav-link active" href="{{ route('guru.sesi') }}"><span class="nav-icon">◉</span>Sesi Absensi</a>
        </nav>
        <div class="sidebar-bottom">Masuk sebagai <strong>{{ $user->name ?? auth()->user()->name }}</strong><br>Pastikan sesi absensi ditutup setelah selesai mengajar.<form class="logout-form" method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin logout dan kembali ke halaman login?')">@csrf<button class="sidebar-logout" type="submit"><span>↪</span> Logout</button></form></div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div><div class="eyebrow">Area Guru</div><h1>Sesi Absensi</h1></div>
            <div class="topbar-right"><div class="user-chip"><div class="avatar">{{ strtoupper(substr($user->name ?? auth()->user()->name, 0, 1)) }}</div><div><strong>{{ $user->name ?? auth()->user()->name }}</strong><small>Guru Pengajar</small></div></div></div>
        </header>

        <section class="welcome" style="padding:22px 26px">
            <div class="welcome-content"><h2 style="margin:0 0 6px">Sesi Absensi</h2><p>Pantau sesi yang sedang aktif, tampilkan QR, atau tutup sesi jika sudah selesai.</p></div>
        </section>
        <section class="session-section" id="sesi" style="margin-top:0">
            <div class="section-head"><div><h2>Sesi Absensi Aktif</h2><p>Sesi yang masih berjalan ditampilkan di bawah ini.</p></div></div>
            <div class="session-list">
                @forelse(($sesiAktif ?? collect()) as $sesi)
                    <article class="session-card">
                        <div class="session-top"><h3 class="subject">{{ $sesi->jadwalPelajaran->mataPelajaran->nama_pelajaran ?? 'Mata pelajaran' }}</h3><span class="live">● AKTIF</span></div>
                        <p>{{ $sesi->jadwalPelajaran->jenjang ?? '-' }} · Kelas {{ $sesi->jadwalPelajaran->kelas ?? '-' }}<br>
                        Dimulai: {{ $sesi->mulai_at ? \Illuminate\Support\Carbon::parse($sesi->mulai_at)->format('H:i') : '-' }} · Berakhir: {{ $sesi->berakhir_at ? \Illuminate\Support\Carbon::parse($sesi->berakhir_at)->format('H:i') : '-' }}</p>
                        <div class="card-actions">
                            <a class="btn btn-light" href="{{ route('absensi-guru.qr', $sesi->id) }}">▦ Lihat QR</a>
                            <form method="POST" action="{{ route('absensi-guru.tutup', $sesi->id) }}" onsubmit="return confirm('Yakin ingin menutup sesi absensi ini?')">
                                @csrf
                                <button class="btn btn-danger" type="submit">Tutup Sesi</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="empty"><div class="empty-icon">◷</div><strong>Belum ada sesi absensi aktif</strong><span>Mulai absensi dari salah satu jadwal mengajarmu.</span></div>
                @endforelse
            </div>
        </section>


        <div class="footer-note">© {{ date('Y') }} Absensi Bhinneka · Sesi Absensi</div>
    </main>
</div>

</body>
</html>