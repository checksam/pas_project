<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rekening extends Model
{
    protected $table = 'tbl_rekening';
    protected $primaryKey = 'id_rekening';

    /**
     * Kolom yang dapat diisi (mass assignable)
     */
    protected $fillable = [
        'user_id',
        'no_rekening',
        'nama_pemilik',
        'jenis_rekening',
        'saldo',
        'no_identitas',
        'status',
        'catatan',
    ];

    /**
     * Cast kolom ke tipe data tertentu
     * Berguna untuk otomatis konversi tipe data
     */
    protected $casts = [
        'saldo' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi One-to-Many: Satu Rekening punya banyak Transaksi
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_rekening');
    }

    /**
     * Relasi One-to-Many: Satu Rekening sebagai pengirim banyak Transfer
     */
    public function transfer_pengirim(): HasMany
    {
        return $this->hasMany(Transfer::class, 'id_rekening_pengirim');
    }

    /**
     * Relasi One-to-Many: Satu Rekening sebagai penerima banyak Transfer
     */
    public function transfer_penerima(): HasMany
    {
        return $this->hasMany(Transfer::class, 'id_rekening_penerima');
    }

    /**
     * Relasi Belongs-To: Rekening punya User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
