<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Rekening;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi
     * GET /transaksi
     */
    public function index()
    {
        $transaksi = Transaksi::with('rekening', 'pegawai')->paginate(10);
        return view('transaksi.index', compact('transaksi'));
    }

    /**
     * Menampilkan form untuk membuat transaksi baru
     * GET /transaksi/create
     */
    public function create()
    {
        $rekening = Rekening::where('status', 'aktif')->get();
        $pegawai = Pegawai::where('status', 'aktif')->get();
        return view('transaksi.create', compact('rekening', 'pegawai'));
    }

    /**
     * Menyimpan transaksi baru ke database
     * POST /transaksi
     * Demonstrasi Database Transaction untuk konsistensi data
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_rekening' => 'required|exists:tbl_rekening,id_rekening',
            'id_pegawai' => 'required|exists:tbl_pegawai,id_pegawai',
            'jenis_transaksi' => 'required|in:setor,tarik,biaya_admin',
            'jumlah' => 'required|numeric|min:0.01',
            'keterangan' => 'nullable|string',
        ]);

        // Menggunakan database transaction untuk menjamin konsistensi data
        // Jika salah satu query gagal, semua akan di-rollback
        try {
            DB::beginTransaction();

            $rekening = Rekening::lockForUpdate()->find($validated['id_rekening']);
            
            // Validasi saldo untuk transaksi tarik
            if ($validated['jenis_transaksi'] === 'tarik' && $rekening->saldo < $validated['jumlah']) {
                throw new \Exception('Saldo tidak cukup');
            }

            // Hitung saldo sebelum dan sesudah
            $saldo_sebelum = $rekening->saldo;
            if ($validated['jenis_transaksi'] === 'setor') {
                $saldo_sesudah = $saldo_sebelum + $validated['jumlah'];
            } else {
                $saldo_sesudah = $saldo_sebelum - $validated['jumlah'];
            }

            // Create transaksi
            Transaksi::create([
                'id_rekening' => $validated['id_rekening'],
                'id_pegawai' => $validated['id_pegawai'],
                'jenis_transaksi' => $validated['jenis_transaksi'],
                'jumlah' => $validated['jumlah'],
                'saldo_sebelum' => $saldo_sebelum,
                'saldo_sesudah' => $saldo_sesudah,
                'keterangan' => $validated['keterangan'],
            ]);

            // Update saldo rekening
            $rekening->update(['saldo' => $saldo_sesudah]);

            DB::commit();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail transaksi tertentu
     * GET /transaksi/{id}
     */
    public function show(Transaksi $transaksi)
    {
        $transaksi->load('rekening', 'pegawai');
        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Transaksi tidak bisa diedit, hanya bisa dilihat dan dihapus
     * DELETE /transaksi/{id}
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
