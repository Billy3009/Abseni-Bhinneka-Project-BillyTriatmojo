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
    Schema::table('users', function (Blueprint $table) {

        $table->string('username')->unique()->after('email');

        $table->enum('role', [
            'admin',
            'guru',
            'kepala_sekolah',
            'siswa'
        ])->default('siswa')->after('username');
        
        $table->string('nik_nip_nis')->nullable()->after('role');
        
        $table->enum('jenjang', [
            'TK',
            'SD',
            'SMP'
        ])->nullable()->after('nik_nip_nis');
        
        $table->string('kelas')->nullable()->after('jenjang');
        
        $table->enum('status', [
            'pending',
            'aktif',
            'ditolak'
        ])->default('pending')->after('kelas');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
    
            $table->dropColumn([
                'username',
                'role',
                'nik_nip_nis',
                'jenjang',
                'kelas',
                'status'
            ]);
    
        });
    }
};
