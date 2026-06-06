<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Rekening;
use App\Models\Transaksi;
use App\Models\Transfer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * DEMONSTRASI: Database Seeder untuk mengisi data dummy otomatis
     */
    public function run(): void
    {
        // ===== 1. BUAT USER =====
        $user1 = User::create([
            'name' => 'Admin Bank',
            'email' => 'admin@bank.com',
            'password' => bcrypt('password123'),
        ]);

        $user2 = User::create([
            'name' => 'Nasabah 1',
            'email' => 'nasabah1@email.com',
            'password' => bcrypt('password123'),
        ]);

        $user3 = User::create([
            'name' => 'Nasabah 2',
            'email' => 'nasabah2@email.com',
            'password' => bcrypt('password123'),
        ]);

        // ===== 2. BUAT PEGAWAI =====
        $pegawai1 = Pegawai::create([
            'user_id' => $user1->id,
            'nip' => '001001',
            'nama_pegawai' => 'Budi Santoso',
            'jabatan' => 'Teller',
            'email_pegawai' => 'budi@bank.com',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Bank No. 1 Jakarta',
            'status' => 'aktif',
        ]);

        $pegawai2 = Pegawai::create([
            'user_id' => $user1->id,
            'nip' => '001002',
            'nama_pegawai' => 'Siti Nurhaliza',
            'jabatan' => 'Manager',
            'email_pegawai' => 'siti@bank.com',
            'no_telepon' => '081234567891',
            'alamat' => 'Jl. Bank No. 2 Jakarta',
            'status' => 'aktif',
        ]);

        // ===== 3. BUAT REKENING =====
        $rekening1 = Rekening::create([
            'user_id' => $user2->id,
            'no_rekening' => '1001000001',
            'nama_pemilik' => 'Andi Wijaya',
            'jenis_rekening' => 'Tabungan',
            'saldo' => 5000000,
            'no_identitas' => '3201234567890001',
            'status' => 'aktif',
            'catatan' => 'Rekening nasabah aktif',
        ]);

        $rekening2 = Rekening::create([
            'user_id' => $user3->id,
            'no_rekening' => '1001000002',
            'nama_pemilik' => 'Citra Dewi',
            'jenis_rekening' => 'Giro',
            'saldo' => 10000000,
            'no_identitas' => '3201234567890002',
            'status' => 'aktif',
            'catatan' => 'Rekening giro untuk bisnis',
        ]);

        // ===== 4. BUAT TRANSAKSI =====
        // Transaksi Setor untuk Rekening 1
        Transaksi::create([
            'id_rekening' => $rekening1->id_rekening,
            'id_pegawai' => $pegawai1->id_pegawai,
            'jenis_transaksi' => 'setor',
            'jumlah' => 1000000,
            'saldo_sebelum' => 4000000,
            'saldo_sesudah' => 5000000,
            'keterangan' => 'Setoran dari ATM',
            'tanggal_transaksi' => now()->subDays(2),
        ]);

        // Transaksi Tarik untuk Rekening 1
        Transaksi::create([
            'id_rekening' => $rekening1->id_rekening,
            'id_pegawai' => $pegawai1->id_pegawai,
            'jenis_transaksi' => 'tarik',
            'jumlah' => 500000,
            'saldo_sebelum' => 5000000,
            'saldo_sesudah' => 4500000,
            'keterangan' => 'Penarikan tunai',
            'tanggal_transaksi' => now()->subDays(1),
        ]);

        // Transaksi Tarik untuk Rekening 1 (dikembalikan ke 5jt)
        Transaksi::create([
            'id_rekening' => $rekening1->id_rekening,
            'id_pegawai' => $pegawai1->id_pegawai,
            'jenis_transaksi' => 'setor',
            'jumlah' => 500000,
            'saldo_sebelum' => 4500000,
            'saldo_sesudah' => 5000000,
            'keterangan' => 'Setoran koreksi',
            'tanggal_transaksi' => now(),
        ]);

        // ===== 5. BUAT TRANSFER =====
        Transfer::create([
            'id_rekening_pengirim' => $rekening1->id_rekening,
            'id_rekening_penerima' => $rekening2->id_rekening,
            'id_pegawai' => $pegawai2->id_pegawai,
            'jumlah' => 2000000,
            'biaya_transfer' => 15000,
            'tujuan_transfer' => 'Transfer untuk pembayaran hutang',
            'status' => 'berhasil',
            'tanggal_transfer' => now()->subHours(5),
        ]);

        // Update saldo setelah transfer (transfer sudah langsung update di controller)
        $rekening1->update(['saldo' => 5000000 - 2000000 - 15000]);
        $rekening2->update(['saldo' => 10000000 + 2000000]);
    }
}
