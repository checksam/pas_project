<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * TABEL REKENING - Menyimpan data rekening nasabah
     */
    public function up(): void
    {
        Schema::create('tbl_rekening', function (Blueprint $table) {
            $table->id('id_rekening');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_rekening', 20)->unique(); // Nomor rekening
            $table->string('nama_pemilik', 100);
            $table->string('jenis_rekening', 50); // Tabungan, Giro, Deposit, dll
            $table->decimal('saldo', 15, 2)->default(0); // Saldo dengan 2 desimal
            $table->string('no_identitas', 20); // KTP, SIM, Paspor, dll
            $table->enum('status', ['aktif', 'tidak-aktif', 'tersuspend'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_rekening');
    }
};
