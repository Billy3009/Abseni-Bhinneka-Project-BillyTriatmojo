<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

<style>

*{

font-family:'Segoe UI',sans-serif;

}

body{

background:#f4f6fb;

overflow-x:hidden;

}

.sidebar{

position:fixed;

width:260px;

height:100vh;

background:linear-gradient(180deg,#0D6EFD,#084298);

color:white;

padding-top:20px;

box-shadow:5px 0 20px rgba(0,0,0,.15);

}

.sidebar h4{

text-align:center;

font-weight:bold;

margin-bottom:35px;

}

.sidebar a{

display:block;

padding:15px 25px;

color:white;

text-decoration:none;

transition:.3s;

}

.sidebar a:hover{

background:rgba(255,255,255,.15);

padding-left:35px;

}

.main{

margin-left:260px;

padding:30px;

}

.navbar-custom{

background:white;

padding:15px 25px;

border-radius:15px;

box-shadow:0 5px 20px rgba(0,0,0,.08);

margin-bottom:30px;

}

.card-stat{

border:none;

border-radius:20px;

box-shadow:0 10px 30px rgba(0,0,0,.08);

transition:.3s;

}

.card-stat:hover{

transform:translateY(-6px);

}

.stat-icon{

font-size:35px;

margin-bottom:10px;

}

.table{

background:white;

border-radius:15px;

overflow:hidden;

}

.badge{

font-size:14px;

padding:8px 12px;

}

</style>

</head>

<body>

@include('partials.sidebar')

<div class="main">

@include('partials.navbar')

@yield('content')

</div>

</body>

</html>