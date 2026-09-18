<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Absensi</title>

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

}

.login-card{

    width:100%;
    max-width:430px;
    border:none;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0px 20px 45px rgba(0,0,0,.25);
    transition:.4s;

}

.login-card:hover{

    transform:translateY(-8px);

}

.header{

    background:#0D6EFD;
    color:white;
    text-align:center;
    padding:35px;

}

.logo{

    display:flex;
    justify-content:center;
    align-items:center;
    margin-bottom:20px;

}

.logo-img{

    width:95px;
    height:95px;
    object-fit:contain;
    transition:.3s;

}

.logo-img:hover{

    transform:scale(1.08);

}

.card-body{

    padding:35px;

}

.form-control{

    height:50px;
    border-radius:12px;
    border:2px solid #ddd;
    transition:.3s;

}

.form-control:focus{

    border-color:#0D6EFD;
    box-shadow:0 0 15px rgba(13,110,253,.25);
    transform:scale(1.02);

}

.password-box{

    position:relative;

}

.password-box i{

    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#777;
    transition:.3s;

}

.password-box i:hover{

    color:#0D6EFD;

}

.btn-login{

    height:50px;
    border-radius:12px;
    font-weight:bold;
    transition:.3s;

}

.btn-login:hover{

    transform:translateY(-3px);
    box-shadow:0 10px 20px rgba(13,110,253,.3);

}

.form-check-input{

    cursor:pointer;

}

.form-check-label{

    cursor:pointer;

}

a{

    text-decoration:none;
    transition:.3s;

}

a:hover{

    color:#FFC107;

}

    </style>

</head>

<body>

<div class="card login-card">

    <div class="header">

    <div class="logo">
    <img src="{{ asset('images/ChatGPT Image 27 Jul 2026, 15.19.19.png') }}"
         alt="Logo Sekolah"
         class="logo-img">
</div>

        <h3>Aplikasi Absensi Bhinneka</h3>

        <small>Silakan login terlebih dahulu</small>

    </div>

    <div class="card-body">

    @if(session('error'))
<div class="alert alert-warning">
    {{ session('error') }}
</div>
@endif

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

    <form method="POST" action="{{ route('login.process') }}">
    @csrf

            <div class="mb-3">

                <label class="form-label">

                    Username

                </label>

                <input
    type="text"
    name="username"
    class="form-control"
    placeholder="Masukkan Username"
    required
    autocomplete="username">

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Password

                </label>

                <div class="password-box">

                <input
    type="password"
    id="password"
    name="password"
    class="form-control"
    placeholder="Masukkan Password"
    required
    autocomplete="current-password">

                    <i class="bi bi-eye" id="eye"></i>

                </div>

            </div>

            <div class="form-check mb-4">

                <input class="form-check-input" type="checkbox">

                <label class="form-check-label">

                    Ingat Saya

                </label>

            </div>

            <button type="submit" class="btn btn-primary w-100 btn-login">
    <i class="bi bi-box-arrow-in-right"></i>
    Login
</button>

        </form>

        <div class="text-center mt-4">

        Belum punya akun?

<a href="{{ route('register') }}">

    Register

</a>

        </div>

    </div>

</div>

<script>

const eye=document.getElementById("eye");

const pass=document.getElementById("password");

eye.onclick=function(){

if(pass.type==="password"){

pass.type="text";

eye.classList.replace("bi-eye","bi-eye-slash");

}else{

pass.type="password";

eye.classList.replace("bi-eye-slash","bi-eye");

}

}

</script>

</body>
</html>\