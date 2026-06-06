<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    protected $table = 'tbl_transfer';
    protected $primaryKey = 'id_transfer';

    /**
     * Kolom yang dapat diisi (mass assignable)
     */
    protected $fillable = [
        'id_rekening_pengirim',
        'id_rekening_penerima',
        'id_pegawai',
        'jumlah',
        'biaya_transfer',
        'tujuan_transfer',
        'status',
        'catatan',
        'tanggal_transfer',
    ];

    /**
     * Cast kolom ke tipe data tertentu
     */
    protected $casts = [
        'jumlah' => 'decimal:2',
        'biaya_transfer' => 'decimal:2',
        'tanggal_transfer' => 'datetime',
    ];

    /**
     * Relasi Belongs-To: Transfer dari satu Rekening (pengirim)
     */
    public function rekening_pengirim(): BelongsTo
    {
        return $this->belongsTo(Rekening::class, 'id_rekening_pengirim');
    }

    /**
     * Relasi Belongs-To: Transfer ke satu Rekening (penerima)
     */
    public function rekening_penerima(): BelongsTo
    {
        return $this->belongsTo(Rekening::class, 'id_rekening_penerima');
    }

    /**
     * Relasi Belongs-To: Transfer diproses oleh satu Pegawai
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
