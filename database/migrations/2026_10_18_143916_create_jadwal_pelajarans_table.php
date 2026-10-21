<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_pelajaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mata_pelajaran_id')
                ->constrained('mata_pelajarans')
                ->cascadeOnDelete();

            $table->foreignId('guru_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->enum('jenjang', ['TK', 'SD', 'SMP']);
            $table->string('kelas');

            $table->enum('hari', [
                'Senin', 'Selasa', 'Rabu',
                'Kamis', 'Jumat', 'Sabtu',
            ]);

            $table->time('jam_mulai');
            $table->time('jam_selesai');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pelajaran');
    }
};