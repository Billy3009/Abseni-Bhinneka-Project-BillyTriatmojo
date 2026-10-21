
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi_guru', function (Blueprint $table) {
            $table->id();

            // Relasi ke akun guru.
            // Riwayat absensi tetap tersimpan jika akun dihapus.
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Menyimpan identitas guru saat absensi dicatat.
            $table->string('nama_guru');

            // Tanggal dan waktu absensi.
            $table->date('tanggal');
            $table->time('waktu')->nullable();

            // Status kehadiran.
            $table->enum('status', [
                'hadir',
                'izin',
                'sakit',
                'alpa',
            ]);

            // Keterangan tambahan jika diperlukan.
            $table->text('keterangan')->nullable();

            $table->timestamps();

            // Satu catatan per akun guru per tanggal.
            $table->unique(
                ['user_id', 'tanggal'],
                'absensi_guru_user_tanggal_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi_guru');
    }
};
