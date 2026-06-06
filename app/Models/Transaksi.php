<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $table = 'tbl_transaksi';
    protected $primaryKey = 'id_transaksi';

    /**
     * Kolom yang dapat diisi (mass assignable)
     */
    protected $fillable = [
        'id_rekening',
        'id_pegawai',
        'jenis_transaksi',
        'jumlah',
        'saldo_sebelum',
        'saldo_sesudah',
        'keterangan',
        'tanggal_transaksi',
    ];

    /**
     * Cast kolom ke tipe data tertentu
     */
    protected $casts = [
        'jumlah' => 'decimal:2',
        'saldo_sebelum' => 'decimal:2',
        'saldo_sesudah' => 'decimal:2',
        'tanggal_transaksi' => 'datetime',
    ];

    /**
     * Relasi Belongs-To: Transaksi punya satu Rekening
     * Ini adalah contoh belongsTo relationship
     */
    public function rekening(): BelongsTo
    {
        return $this->belongsTo(Rekening::class, 'id_rekening');
    }

    /**
     * Relasi Belongs-To: Transaksi dibuat oleh satu Pegawai
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
