<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register | Aplikasi Absensi Bhinneka</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

<style>

*{
    font-family:'Segoe UI',sans-serif;
}

body{

    min-height:100vh;
    background:linear-gradient(135deg,#0D6EFD,#FFC107);
    display:flex;
    justify-content:center;
    align-items:center;
    padding:30px;

}

.register-card{

    width:100%;
    max-width:550px;
    border:none;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 20px 45px rgba(0,0,0,.25);
    transition:.4s;

}

.register-card:hover{

    transform:translateY(-6px);

}

.header{

    background:#0D6EFD;
    color:white;
    text-align:center;
    padding:30px;

}

.logo{

    display:flex;
    justify-content:center;
    margin-bottom:15px;

}

.logo img{

    width:95px;
    transition:.3s;

}

.logo img:hover{

    transform:scale(1.08);

}

.card-body{

    padding:35px;

}

.form-control,
.form-select{

    height:50px;
    border-radius:12px;
    border:2px solid #ddd;
    transition:.3s;

}

.form-control:focus,
.form-select:focus{

    border-color:#0D6EFD;
    box-shadow:0 0 15px rgba(13,110,253,.25);
    transform:scale(1.02);

}

.btn-register{

    height:50px;
    border-radius:12px;
    font-weight:bold;
    transition:.3s;

}

.btn-register:hover{

    transform:translateY(-3px);
    box-shadow:0 10px 20px rgba(13,110,253,.25);

}

#kelas-group{

    display:none;

}

.alert-info{

    border-radius:12px;

}

a{

    text-decoration:none;

}

</style>

</head>

<body>

<div class="card register-card">

<div class="header">

<div class="logo">
<img src="{{ asset('images/ChatGPT Image 27 Jul 2026, 15.19.19.png') }}">
</div>

<h3>Aplikasi Absensi Bhinneka</h3>

<small>Silakan lengkapi data pendaftaran</small>

</div>

<div class="card-body">

<div class="alert alert-info">

<b>Informasi</b><br>

Setelah melakukan pendaftaran, akun Anda akan berstatus <b>Pending</b> dan harus disetujui oleh Admin sebelum dapat digunakan untuk login.

</div>
@if ($errors->any())
<div class="alert alert-danger">

    <ul class="mb-0">

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>
@endif

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif


<form action="{{ route('register.store') }}" method="POST">
    @csrf
<div class="mb-3">

<label class="form-label">Role</label>

<select class="form-select" id="role" name="role" required>
    <option value="" selected disabled>-- Pilih Role --</option>
    <option value="guru">👨‍🏫 Guru</option>
    <option value="kepala_sekolah">👔 Kepala Sekolah</option>
    <option value="siswa">🎓 Siswa</option>
</select>

</div>

<div class="mb-3">

<label class="form-label" id="labelIdentitas">

NIP / NIS

</label>

<input
type="text"
name="nik_nip_nis"
class="form-control"
placeholder="Masukkan Nomor Identitas"
autocomplete="off"
required>

</div>

<div class="mb-3">

<label class="form-label">

Nama Lengkap

</label>

<input
type="text"
name="name"
class="form-control"
placeholder="Masukkan Nama Lengkap"
autocomplete="name"
required>

</div>
<div id="kelas-group" style="display:none;">

    <div class="mb-3">

        <label class="form-label">

            Jenjang

        </label>

        <select class="form-select" id="jenjang" name="jenjang">

<option value="" selected disabled>
-- Pilih Jenjang --
</option>

<option value="TK">TK</option>
<option value="SD">SD</option>
<option value="SMP">SMP</option>

</select>

    </div>

    <div class="mb-3">

        <label class="form-label">

            Kelas

        </label>

        <select class="form-select" id="kelas" name="kelas">

<option value="" selected disabled>
-- Pilih Kelas --
</option>

</select>

    </div>

</div>


<div class="mb-3">

<label class="form-label">

Username

</label>

<input
type="text"
name="username"
class="form-control"
placeholder="Masukkan Username"
autocomplete="username"
required>

</div>

<div class="mb-3">

<label class="form-label">

Password

</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Masukkan Password"
autocomplete="new-password"
required>

</div>

<div class="mb-4">

<label class="form-label">

Konfirmasi Password

</label>

<input
type="password"
name="password_confirmation"
class="form-control"
placeholder="Konfirmasi Password"
autocomplete="new-password"
required>

</div>

<button
type="submit"
class="btn btn-primary btn-register w-100">

<i class="bi bi-person-plus-fill"></i>

Register

</button>

</form>

<div class="text-center mt-4">

Sudah punya akun?

<a href="{{ route('login') }}">

Login

</a>

</div>

</div>

</div>

<script>

const role = document.getElementById("role");
const labelIdentitas = document.getElementById("labelIdentitas");

const kelasGroup = document.getElementById("kelas-group");
const jenjang = document.getElementById("jenjang");
const kelas = document.getElementById("kelas");

role.addEventListener("change", function(){

    if(this.value=="guru"){

        labelIdentitas.innerHTML="NIP";

        kelasGroup.style.display="none";

        jenjang.required=false;
        kelas.required=false;

    }

    else if(this.value=="kepala_sekolah"){

        labelIdentitas.innerHTML="NIP Kepala Sekolah";

        kelasGroup.style.display="none";

        jenjang.required=false;
        kelas.required=false;

    }

    else if(this.value=="siswa"){

        labelIdentitas.innerHTML="NIS";

        kelasGroup.style.display="block";

        jenjang.required=true;
        kelas.required=true;

    }

    else{

        labelIdentitas.innerHTML="NIP / NIS";

        kelasGroup.style.display="none";

        jenjang.required=false;
        kelas.required=false;

    }

});

jenjang.addEventListener("change",function(){

    kelas.innerHTML='<option value="" selected disabled>-- Pilih Kelas --</option>';

    if(this.value=="TK"){

        kelas.innerHTML+=`
        <option value="TK A">TK A</option>
        <option value="TK B">TK B</option>
        `;

    }

    if(this.value=="SD"){

        kelas.innerHTML+=`
        <option value="Kelas 1">Kelas 1</option>
        <option value="Kelas 2">Kelas 2</option>
        <option value="Kelas 3">Kelas 3</option>
        <option value="Kelas 4">Kelas 4</option>
        <option value="Kelas 5">Kelas 5</option>
        <option value="Kelas 6">Kelas 6</option>
        `;

    }

    if(this.value=="SMP"){

        kelas.innerHTML+=`
        <option value="Kelas VII">Kelas VII</option>
        <option value="Kelas VIII">Kelas VIII</option>
        <option value="Kelas IX">Kelas IX</option>
        `;

    }

});

document.querySelector("form").addEventListener("submit",function(){

    const tombol=document.querySelector(".btn-register");

    tombol.disabled=true;

    tombol.innerHTML=`
    <span class="spinner-border spinner-border-sm"></span>
    Memproses...
    `;

});

</script>

</body>
</html>