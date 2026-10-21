<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_absensis', function (Blueprint $table) {
            $table->id();

            // Jadwal pelajaran yang sedang diabsen.
            $table->foreignId('jadwal_pelajaran_id')
                ->constrained('jadwal_pelajaran')
                ->cascadeOnDelete();

            // Token unik untuk QR Code.
            $table->string('token_qr', 64)->unique();

            // Masa berlaku sesi absensi.
            $table->dateTime('mulai_at');
            $table->dateTime('berakhir_at');

            // Status sesi.
            $table->enum('status', [
                'aktif',
                'ditutup',
            ])->default('aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_absensis');
    }
};