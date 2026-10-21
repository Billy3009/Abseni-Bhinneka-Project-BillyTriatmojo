<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('absensi_murids', function (Blueprint $table) {
        $table->id();

        $table->foreignId('sesi_absensi_id')
            ->constrained('sesi_absensis')
            ->cascadeOnDelete();

        $table->foreignId('siswa_id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa'])
            ->default('hadir');

        $table->dateTime('waktu_absen')->nullable();

        $table->timestamps();

        // Satu siswa hanya boleh absen sekali per sesi.
        $table->unique(['sesi_absensi_id', 'siswa_id']);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_murids');
    }
};
