<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * TABEL TRANSAKSI - Menyimpan data transaksi (setor, tarik, biaya admin)
     */
    public function up(): void
    {
        Schema::create('tbl_transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_rekening')->constrained('tbl_rekening', 'id_rekening')->onDelete('cascade');
            $table->foreignId('id_pegawai')->constrained('tbl_pegawai', 'id_pegawai')->onDelete('restrict');
            $table->enum('jenis_transaksi', ['setor', 'tarik', 'biaya_admin']); // Tipe transaksi
            $table->decimal('jumlah', 15, 2); // Nominal transaksi
            $table->decimal('saldo_sebelum', 15, 2); // Saldo sebelum transaksi
            $table->decimal('saldo_sesudah', 15, 2); // Saldo sesudah transaksi
            $table->text('keterangan')->nullable(); // Deskripsi transaksi
            $table->timestamp('tanggal_transaksi')->useCurrent(); // Waktu transaksi
            $table->timestamps();
            
            // Index untuk performa query
            $table->index('id_rekening');
            $table->index('id_pegawai');
            $table->index('tanggal_transaksi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_transaksi');
    }
};
