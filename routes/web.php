<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SesiAbsensiController;
use App\Http\Controllers\AbsensiMuridController;
use App\Http\Controllers\LaporanController;

Route::redirect('/', '/login');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

// Route yang harus login
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AdminController::class,'dashboard'])
        ->name('dashboard');
        

    Route::get('/users', [AdminController::class,'users'])
        ->name('users');

        // Data Guru — Admin dan Kepala Sekolah
Route::get('/data-guru', [AdminController::class, 'dataGuru'])
->name('data-guru');

        // Edit akun
Route::get('/users/{user}/edit', [AdminController::class, 'edit'])
->name('users.edit');

// Simpan perubahan akun
Route::put('/users/{user}', [AdminController::class, 'update'])
->name('users.update');

    Route::post('/users/{id}/approve', [AdminController::class,'approve'])
        ->name('users.approve');

    Route::post('/users/{id}/reject', [AdminController::class,'reject'])
        ->name('users.reject');

        Route::delete('/users/{user}', [AdminController::class, 'destroy'])
    ->name('users.destroy');

// Route Logout
Route::post('/logout', function () {
    Auth::guard('web')->logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login')
        ->with('success', 'Kamu berhasil logout.');
})->name('logout');

// Route Absensi
Route::post(
    '/jadwal/{jadwal}/absensi/mulai',
    [SesiAbsensiController::class, 'mulai']
)->name('absensi-guru.mulai');

Route::post(
    '/sesi-absensi/{sesi}/tutup',
    [SesiAbsensiController::class, 'tutup']
)->name('absensi-guru.tutup');

// Route QR
Route::get(
    '/sesi-absensi/{sesi}/qr',
    [SesiAbsensiController::class, 'qr']
)->name('absensi-guru.qr');

Route::get('/scan-absensi/{token}', [AbsensiMuridController::class, 'scan'])
    ->name('absensi.scan');

//Route Rekapan Absensi
Route::get('/rekap-absensi', [
    AdminController::class,
    'rekapAbsensi'
])->name('rekap-absensi');

//Route Data Siswa
Route::get('/data-siswa', [AdminController::class, 'dataSiswa'])
    ->name('data-siswa');

//Route Laporan
Route::get('/laporan-absensi', [LaporanController::class, 'index'])
    ->name('laporan-absensi');

Route::get('/laporan-absensi/pdf', [LaporanController::class, 'downloadPdf'])
    ->name('laporan-absensi.pdf');

//ROute Jadwal Guru
Route::get('/guru/jadwal', [AdminController::class, 'jadwalGuru'])
    ->name('guru.jadwal');

Route::get('/guru/sesi-absensi', [AdminController::class, 'sesiGuru'])
    ->name('guru.sesi');


});