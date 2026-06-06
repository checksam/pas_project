<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * TABEL TRANSFER - Menyimpan data transfer antar rekening
     */
    public function up(): void
    {
        Schema::create('tbl_transfer', function (Blueprint $table) {
            $table->id('id_transfer');
            $table->foreignId('id_rekening_pengirim')->constrained('tbl_rekening', 'id_rekening')->onDelete('cascade');
            $table->foreignId('id_rekening_penerima')->constrained('tbl_rekening', 'id_rekening')->onDelete('cascade');
            $table->foreignId('id_pegawai')->constrained('tbl_pegawai', 'id_pegawai')->onDelete('restrict');
            $table->decimal('jumlah', 15, 2); // Nominal transfer
            $table->decimal('biaya_transfer', 15, 2)->default(0); // Biaya admin transfer
            $table->text('tujuan_transfer'); // Deskripsi tujuan transfer
            $table->enum('status', ['pending', 'berhasil', 'gagal'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_transfer')->useCurrent();
            $table->timestamps();
            
            // Index untuk performa query
            $table->index('id_rekening_pengirim');
            $table->index('id_rekening_penerima');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_transfer');
    }
};
