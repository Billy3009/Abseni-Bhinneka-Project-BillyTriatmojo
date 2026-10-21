<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru | Absensi Bhinneka</title>
    <style>
        :root{--navy:#102a56;--blue:#2563eb;--cyan:#06b6d4;--ink:#17233c;--muted:#718096;--line:#e7edf5;--bg:#f4f7fb;--white:#fff}
        *{box-sizing:border-box}body{margin:0;background:var(--bg);font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif;color:var(--ink)}
        .layout{min-height:100vh;display:flex}.sidebar{width:250px;background:linear-gradient(180deg,#102a56,#123e73);color:#fff;padding:28px 18px;display:flex;flex-direction:column;flex-shrink:0}
        .brand{display:flex;align-items:center;gap:12px;padding:0 10px 32px}.brand-logo{width:43px;height:43px;border-radius:14px;background:linear-gradient(135deg,#22d3ee,#3b82f6);display:grid;place-items:center;font-size:20px;font-weight:900;color:white;box-shadow:0 8px 20px #0002}.brand strong{display:block;font-size:16px;letter-spacing:.2px}.brand small{color:#b9d4f5;font-size:11px}
        .nav-label{font-size:10px;font-weight:800;letter-spacing:1.6px;color:#91b3dc;padding:0 12px;margin:5px 0 12px}.nav-link{display:flex;align-items:center;gap:12px;color:#d7e6fa;text-decoration:none;padding:12px 14px;border-radius:12px;font-size:13px;margin-bottom:5px;transition:.2s}.nav-link.active,.nav-link:hover{background:#ffffff1c;color:#fff;transform:translateX(2px)}.nav-icon{width:20px;text-align:center;font-size:17px}.sidebar-bottom{margin-top:auto;border-top:1px solid #ffffff20;padding:20px 10px 0;color:#c6d9f1;font-size:12px;line-height:1.7}
        .logout-form{margin-top:15px}.btn-logout{display:flex;width:100%;align-items:center;justify-content:center;gap:8px;background:#ffffff12;color:#fff;border:1px solid #ffffff30;border-radius:12px;padding:11px 14px;font:inherit;font-size:12px;font-weight:800;cursor:pointer;transition:.2s}.btn-logout:hover{background:#be123c;border-color:#be123c;transform:translateY(-1px)}
        .main{flex:1;min-width:0;padding:28px 34px 40px}.topbar{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:25px}.eyebrow{font-size:11px;color:var(--muted);font-weight:800;letter-spacing:1.5px;text-transform:uppercase}.topbar h1{font-size:25px;margin:5px 0 0;color:#14294b}.topbar-right{display:flex;align-items:center;gap:10px}.user-chip{display:flex;align-items:center;gap:11px;background:#fff;border:1px solid var(--line);padding:9px 14px;border-radius:15px}.avatar{width:39px;height:39px;border-radius:13px;background:linear-gradient(135deg,#cffafe,#bfdbfe);color:#1d4ed8;display:grid;place-items:center;font-weight:800}.user-chip strong{display:block;font-size:13px}.user-chip small{color:var(--muted);font-size:11px}
        .hero{position:relative;overflow:hidden;background:linear-gradient(115deg,#1d4ed8,#087fbd 58%,#06b6d4);color:#fff;padding:29px 30px;border-radius:23px;box-shadow:0 15px 32px #1d4ed826;margin-bottom:22px}.hero:after{content:"";position:absolute;width:220px;height:220px;border:32px solid #ffffff16;border-radius:50%;right:-55px;top:-105px}.hero:before{content:"";position:absolute;width:100px;height:100px;background:#ffffff0d;border-radius:28px;right:120px;bottom:-65px;transform:rotate(35deg)}.hero-content{position:relative;z-index:1;max-width:690px}.tag{display:inline-flex;background:#ffffff20;border:1px solid #ffffff2e;border-radius:999px;padding:6px 11px;font-size:10px;font-weight:800;letter-spacing:.7px}.hero h2{font-size:27px;margin:15px 0 8px;letter-spacing:-.6px}.hero p{font-size:13px;line-height:1.7;color:#e2f6ff;margin:0;max-width:570px}.hero-bottom{display:flex;align-items:center;gap:8px;margin-top:18px;font-size:12px;color:#e0f2fe}.live-dot{width:8px;height:8px;background:#86efac;border-radius:50%;box-shadow:0 0 0 4px #86efac30}
        .section-title{font-size:16px;font-weight:850;margin:25px 0 13px}.stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:15px}.stat{background:#fff;border:1px solid var(--line);border-radius:18px;padding:19px;display:flex;align-items:center;gap:13px;box-shadow:0 4px 12px #17345b05;transition:.2s}.stat:hover{transform:translateY(-3px);box-shadow:0 12px 25px #17345b0d}.stat-icon{width:46px;height:46px;border-radius:14px;display:grid;place-items:center;font-size:21px;flex-shrink:0}.blue{background:#dbeafe;color:#2563eb}.cyan{background:#cffafe;color:#0891b2}.green{background:#dcfce7;color:#16a34a}.stat small{font-size:11px;color:var(--muted);font-weight:700}.stat strong{display:block;font-size:26px;margin-top:3px;color:#182a48}
        .content-grid{display:grid;grid-template-columns:minmax(0,1.25fr) minmax(260px,.75fr);gap:16px;margin-top:18px}.panel{background:#fff;border:1px solid var(--line);border-radius:18px;padding:21px;min-width:0;box-shadow:0 4px 12px #17345b05}.panel-heading{display:flex;align-items:center;gap:10px;margin-bottom:15px}.panel-icon{width:38px;height:38px;border-radius:12px;background:#eff6ff;color:#2563eb;display:grid;place-items:center;font-size:18px}.panel-heading h3{font-size:14px;margin:0 0 3px}.panel-heading p{font-size:11px;color:var(--muted);margin:0}.activity{display:flex;align-items:flex-start;gap:12px;padding:13px 0;border-top:1px solid #edf1f7}.activity:first-of-type{border-top:0}.activity-mark{width:32px;height:32px;border-radius:10px;display:grid;place-items:center;background:#ecfeff;color:#0891b2;flex-shrink:0}.activity strong{font-size:12px;display:block;margin:1px 0 4px}.activity p{font-size:11px;color:var(--muted);line-height:1.6;margin:0}.status{font-size:10px;font-weight:800;color:#15803d;background:#dcfce7;border-radius:999px;padding:5px 8px;white-space:nowrap;margin-left:auto}.empty{padding:17px 12px;text-align:center;color:var(--muted);font-size:12px;line-height:1.6;background:#f8fafc;border-radius:12px}.empty strong{display:block;color:#334155;margin-bottom:4px}
        .quick-actions{display:grid;gap:10px}.quick-link{display:flex;align-items:center;gap:12px;padding:13px;border:1px solid var(--line);border-radius:13px;text-decoration:none;color:var(--ink);transition:.2s}.quick-link:hover{border-color:#93c5fd;background:#f8fbff;transform:translateY(-1px)}.quick-link-icon{width:38px;height:38px;display:grid;place-items:center;background:#eff6ff;color:#2563eb;border-radius:11px;font-size:18px}.quick-link strong{font-size:12px;display:block}.quick-link small{font-size:10px;color:var(--muted);display:block;margin-top:4px}.arrow{margin-left:auto;color:#94a3b8;font-size:18px}.tip{margin-top:13px;padding:14px;border-radius:13px;background:#fffbeb;border:1px solid #fde68a;color:#92400e;font-size:11px;line-height:1.6}.tip strong{display:block;margin-bottom:3px}.footer-note{font-size:11px;color:#8a98ad;text-align:center;margin-top:27px}
        .modal-backdrop{position:fixed;inset:0;background:#0f172a99;display:none;align-items:center;justify-content:center;padding:20px;z-index:50;backdrop-filter:blur(4px)}.modal-backdrop.show{display:flex;animation:fade .18s ease}.modal{width:min(100%,390px);background:#fff;border-radius:22px;padding:25px;box-shadow:0 24px 70px #0003;animation:pop .2s ease}.modal-symbol{width:48px;height:48px;border-radius:15px;background:#fff1f2;color:#be123c;display:grid;place-items:center;font-size:23px;margin-bottom:15px}.modal h3{margin:0 0 7px;font-size:19px}.modal p{margin:0;color:#64748b;font-size:13px;line-height:1.6}.modal-actions{display:flex;gap:10px;margin-top:22px}.modal-actions button{flex:1;border-radius:11px;padding:11px;border:1px solid #e2e8f0;background:#fff;font:inherit;font-size:12px;font-weight:800;cursor:pointer}.modal-actions .confirm{background:#e11d48;border-color:#e11d48;color:#fff}.modal-actions .confirm:hover{background:#be123c}@keyframes fade{from{opacity:0}to{opacity:1}}@keyframes pop{from{opacity:0;transform:translateY(8px) scale(.98)}to{opacity:1;transform:translateY(0) scale(1)}}
        @media(max-width:900px){.sidebar{width:220px}.main{padding:23px}.content-grid{grid-template-columns:1fr}.stats{grid-template-columns:repeat(2,minmax(0,1fr))}.stats .stat:last-child{grid-column:1/-1}}
        @media(max-width:620px){.layout{display:block}.sidebar{width:100%;padding:14px 16px;display:block}.brand{padding:0 4px}.sidebar nav,.nav-label,.sidebar-bottom{display:none}.main{padding:20px 15px 30px}.topbar{align-items:flex-start}.topbar h1{font-size:21px}.user-chip{padding:6px 8px;gap:7px}.avatar{width:34px;height:34px}.user-chip small{display:none}.hero{padding:23px 20px;border-radius:19px}.hero h2{font-size:23px}.stats{grid-template-columns:1fr;gap:10px}.stats .stat:last-child{grid-column:auto}.stat{padding:15px}.content-grid{gap:12px}.panel{padding:16px}.modal-actions{flex-direction:column}}
    </style>
</head>
<body>
@php
    $guruUser = $user ?? auth()->user();
    $jadwalList = collect($jadwals ?? []);
    $sesiList = collect($sesiAktif ?? []);
    $hariIni = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'][now()->dayOfWeekIso];
    $jadwalHariIni = $jadwalList->filter(fn ($item) => strtolower((string) $item->hari) === strtolower($hariIni));
    $sesiTerbaru = $sesiList->sortByDesc('mulai_at')->take(3);
@endphp
<div class="layout">
    <aside class="sidebar">
        <div class="brand"><div class="brand-logo">B</div><div><strong>BHINNEKA</strong><small>Sistem Informasi Absensi</small></div></div>
        <div class="nav-label">MENU UTAMA</div>
        <nav>
            <a class="nav-link active" href="{{ route('dashboard') }}"><span class="nav-icon">▦</span>Dashboard</a>
            <a class="nav-link" href="{{ route('guru.jadwal') }}"><span class="nav-icon">▤</span>Jadwal Mengajar</a>
            <a class="nav-link" href="{{ route('guru.sesi') }}"><span class="nav-icon">◉</span>Sesi Absensi</a>
        </nav>
        <div class="sidebar-bottom">Masuk sebagai <strong>{{ $guruUser->name }}</strong><br>Kelola aktivitas mengajar dengan mudah.
            <form class="logout-form" id="sidebarLogoutForm" method="POST" action="{{ route('logout') }}">@csrf<button class="btn-logout" type="button" data-logout-open>↪ &nbsp; Logout</button></form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div><div class="eyebrow">Area Guru</div><h1>Dashboard</h1></div>
            <div class="topbar-right"><div class="user-chip"><div class="avatar">{{ strtoupper(substr($guruUser->name ?? 'G', 0, 1)) }}</div><div><strong>{{ $guruUser->name }}</strong><small>Guru Pengajar</small></div></div></div>
        </header>

        <section class="hero">
            <div class="hero-content">
                <span class="tag">✦ &nbsp; RINGKASAN AKTIVITAS</span>
                <h2>Halo, {{ $guruUser->name }}! 👋</h2>
                <p>Selamat datang di pusat informasi mengajarmu. Pantau aktivitas hari ini dari satu tempat tanpa perlu mengulang daftar jadwal di halaman utama.</p>
                <div class="hero-bottom"><span class="live-dot"></span><span>{{ $hariIni }}, {{ now()->translatedFormat('d F Y') }}</span><span>·</span><span id="liveClock">{{ now()->format('H:i') }}</span></div>
            </div>
        </section>

        <div class="section-title">Ringkasan hari ini</div>
        <section class="stats">
            <article class="stat"><div class="stat-icon blue">▤</div><div><small>Jadwal Hari Ini</small><strong>{{ $jadwalHariIni->count() }}</strong></div></article>
            <article class="stat"><div class="stat-icon cyan">◷</div><div><small>Sesi Absensi Aktif</small><strong>{{ $sesiList->count() }}</strong></div></article>
            <article class="stat"><div class="stat-icon green">✓</div><div><small>Total Jadwal Mengajar</small><strong>{{ $jadwalList->count() }}</strong></div></article>
        </section>

        <section class="content-grid">
            <div class="panel">
                <div class="panel-heading"><div class="panel-icon">◉</div><div><h3>Aktivitas sesi terbaru</h3><p>Ringkasan sesi absensi yang masih aktif</p></div></div>
                @forelse($sesiTerbaru as $sesi)
                    <div class="activity">
                        <div class="activity-mark">▦</div>
                        <div style="min-width:0;flex:1"><strong>{{ $sesi->jadwalPelajaran->mataPelajaran->nama_pelajaran ?? 'Mata pelajaran' }}</strong><p>{{ $sesi->jadwalPelajaran->jenjang ?? '-' }} · Kelas {{ $sesi->jadwalPelajaran->kelas ?? '-' }}<br>Dimulai {{ $sesi->mulai_at ? \Illuminate\Support\Carbon::parse($sesi->mulai_at)->format('H:i') : '-' }}</p></div>
                        <span class="status">AKTIF</span>
                    </div>
                @empty
                    <div class="empty"><strong>Belum ada sesi aktif</strong>Kalau kamu memulai sesi absensi, ringkasannya akan muncul di sini.</div>
                @endforelse
            </div>

            <div class="panel">
                <div class="panel-heading"><div class="panel-icon">⚡</div><div><h3>Akses cepat</h3><p>Pilih halaman sesuai kebutuhanmu</p></div></div>
                <div class="quick-actions">
                    <a class="quick-link" href="{{ route('guru.jadwal') }}"><span class="quick-link-icon">▤</span><span><strong>Jadwal Mengajar</strong><small>Lihat seluruh jadwal dan mulai absensi</small></span><span class="arrow">›</span></a>
                    <a class="quick-link" href="{{ route('guru.sesi') }}"><span class="quick-link-icon">◉</span><span><strong>Sesi Absensi</strong><small>Kelola sesi dan buka QR Code</small></span><span class="arrow">›</span></a>
                </div>
                <div class="tip"><strong>💡 Pengingat</strong>Pastikan sesi absensi ditutup setelah kegiatan belajar selesai agar status sesi tetap akurat.</div>
            </div>
        </section>
        <div class="footer-note">© {{ date('Y') }} Absensi Bhinneka · Panel Guru</div>
    </main>
</div>

<div class="modal-backdrop" id="logoutModal" role="dialog" aria-modal="true" aria-labelledby="logoutTitle">
    <div class="modal"><div class="modal-symbol">↪</div><h3 id="logoutTitle">Yakin ingin logout?</h3><p>Kamu akan keluar dari akun guru dan kembali ke halaman login.</p><div class="modal-actions"><button type="button" id="cancelLogout">Batal</button><button type="button" class="confirm" id="confirmLogout">Ya, logout</button></div></div>
</div>
<script>
    const clock = document.getElementById('liveClock');
    const logoutModal = document.getElementById('logoutModal');
    const logoutForm = document.getElementById('sidebarLogoutForm');
    document.querySelectorAll('[data-logout-open]').forEach(button => button.addEventListener('click', () => logoutModal.classList.add('show')));
    document.getElementById('cancelLogout').addEventListener('click', () => logoutModal.classList.remove('show'));
    document.getElementById('confirmLogout').addEventListener('click', () => logoutForm.submit());
    logoutModal.addEventListener('click', event => { if (event.target === logoutModal) logoutModal.classList.remove('show'); });
    document.addEventListener('keydown', event => { if (event.key === 'Escape') logoutModal.classList.remove('show'); });
    function updateClock(){ if(clock) clock.textContent = new Intl.DateTimeFormat('id-ID',{hour:'2-digit',minute:'2-digit',hour12:false}).format(new Date()); }
    updateClock(); setInterval(updateClock, 30000);
</script>
</body>
</html>
