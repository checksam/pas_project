<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    protected $table = 'tbl_pegawai';
    protected $primaryKey = 'id_pegawai';
    
    /**
     * Kolom yang dapat diisi (mass assignable)
     * PENTING untuk security: whitelist kolom yang boleh diubah
     */
    protected $fillable = [
        'user_id',
        'nip',
        'nama_pegawai',
        'jabatan',
        'email_pegawai',
        'no_telepon',
        'alamat',
        'status',
    ];

    /**
     * Relasi One-to-Many: Satu Pegawai punya banyak Transaksi
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_pegawai');
    }

    /**
     * Relasi One-to-Many: Satu Pegawai punya banyak Transfer
     */
    public function transfer(): HasMany
    {
        return $this->hasMany(Transfer::class, 'id_pegawai');
    }

    /**
     * Relasi Belongs-To: Pegawai punya User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
