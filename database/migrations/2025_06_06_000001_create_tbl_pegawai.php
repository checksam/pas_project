<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * TABEL PEGAWAI - Menyimpan data karyawan bank
     */
    public function up(): void
    {
        Schema::create('tbl_pegawai', function (Blueprint $table) {
            $table->id('id_pegawai');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nip', 20)->unique(); // Nomor Induk Pegawai
            $table->string('nama_pegawai', 100);
            $table->string('jabatan', 100); // Teller, Manager, Security, dll
            $table->string('email_pegawai', 100)->unique();
            $table->string('no_telepon', 15);
            $table->text('alamat');
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pegawai');
    }
};
