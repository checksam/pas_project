<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\Rekening;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Menampilkan daftar semua transfer
     * GET /transfer
     */
    public function index()
    {
        $transfer = Transfer::with('rekening_pengirim', 'rekening_penerima', 'pegawai')->paginate(10);
        return view('transfer.index', compact('transfer'));
    }

    /**
     * Menampilkan form untuk membuat transfer baru
     * GET /transfer/create
     */
    public function create()
    {
        $rekening = Rekening::where('status', 'aktif')->get();
        $pegawai = Pegawai::where('status', 'aktif')->get();
        return view('transfer.create', compact('rekening', 'pegawai'));
    }

    /**
     * Menyimpan transfer baru ke database
     * POST /transfer
     * Demonstrasi Database Transaction dan Data Manipulation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_rekening_pengirim' => 'required|exists:tbl_rekening,id_rekening|different:id_rekening_penerima',
            'id_rekening_penerima' => 'required|exists:tbl_rekening,id_rekening',
            'id_pegawai' => 'required|exists:tbl_pegawai,id_pegawai',
            'jumlah' => 'required|numeric|min:0.01',
            'biaya_transfer' => 'required|numeric|min:0',
            'tujuan_transfer' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $pengirim = Rekening::lockForUpdate()->find($validated['id_rekening_pengirim']);
            $penerima = Rekening::lockForUpdate()->find($validated['id_rekening_penerima']);
            
            $total_debit = $validated['jumlah'] + $validated['biaya_transfer'];

            // Validasi saldo pengirim
            if ($pengirim->saldo < $total_debit) {
                throw new \Exception('Saldo pengirim tidak cukup');
            }

            // Buat record transfer
            Transfer::create([
                'id_rekening_pengirim' => $validated['id_rekening_pengirim'],
                'id_rekening_penerima' => $validated['id_rekening_penerima'],
                'id_pegawai' => $validated['id_pegawai'],
                'jumlah' => $validated['jumlah'],
                'biaya_transfer' => $validated['biaya_transfer'],
                'tujuan_transfer' => $validated['tujuan_transfer'],
                'status' => 'berhasil',
            ]);

            // Update saldo pengirim (kurang)
            $pengirim->update([
                'saldo' => $pengirim->saldo - $total_debit
            ]);

            // Update saldo penerima (tambah)
            $penerima->update([
                'saldo' => $penerima->saldo + $validated['jumlah']
            ]);

            DB::commit();

            return redirect()->route('transfer.index')->with('success', 'Transfer berhasil dilakukan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail transfer tertentu
     * GET /transfer/{id}
     */
    public function show(Transfer $transfer)
    {
        $transfer->load('rekening_pengirim', 'rekening_penerima', 'pegawai');
        return view('transfer.show', compact('transfer'));
    }

    /**
     * Menampilkan form untuk edit transfer
     * GET /transfer/{id}/edit
     */
    public function edit(Transfer $transfer)
    {
        return view('transfer.edit', compact('transfer'));
    }

    /**
     * Mengupdate status transfer
     * PUT/PATCH /transfer/{id}
     */
    public function update(Request $request, Transfer $transfer)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,berhasil,gagal',
            'catatan' => 'nullable|string',
        ]);

        $transfer->update($validated);

        return redirect()->route('transfer.show', $transfer)->with('success', 'Status transfer berhasil diperbarui');
    }

    /**
     * Menghapus transfer dari database
     * DELETE /transfer/{id}
     */
    public function destroy(Transfer $transfer)
    {
        $transfer->delete();
        return redirect()->route('transfer.index')->with('success', 'Transfer berhasil dihapus');
    }
}
