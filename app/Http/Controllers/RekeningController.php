<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    /**
     * Menampilkan daftar semua rekening
     * GET /rekening
     */
    public function index()
    {
        $rekening = Rekening::with('user')->paginate(10);
        return view('rekening.index', compact('rekening'));
    }

    /**
     * Menampilkan form untuk membuat rekening baru
     * GET /rekening/create
     */
    public function create()
    {
        return view('rekening.create');
    }

    /**
     * Menyimpan rekening baru ke database
     * POST /rekening
     * Demonstrasi CREATE operation dan validasi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_rekening' => 'required|string|max:20|unique:tbl_rekening,no_rekening',
            'nama_pemilik' => 'required|string|max:100',
            'jenis_rekening' => 'required|string|max:50',
            'saldo' => 'required|numeric|min:0',
            'no_identitas' => 'required|string|max:20',
            'status' => 'required|in:aktif,tidak-aktif,tersuspend',
            'catatan' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        // Create menggunakan Eloquent ORM
        Rekening::create($validated);

        return redirect()->route('rekening.index')->with('success', 'Rekening berhasil dibuat');
    }

    /**
     * Menampilkan detail rekening tertentu
     * GET /rekening/{id}
     * Menampilkan transaksi dan transfer terkait
     */
    public function show(Rekening $rekening)
    {
        $rekening->load('transaksi', 'transfer_pengirim', 'transfer_penerima', 'user');
        return view('rekening.show', compact('rekening'));
    }

    /**
     * Menampilkan form untuk edit rekening
     * GET /rekening/{id}/edit
     */
    public function edit(Rekening $rekening)
    {
        return view('rekening.edit', compact('rekening'));
    }

    /**
     * Mengupdate data rekening di database
     * PUT/PATCH /rekening/{id}
     */
    public function update(Request $request, Rekening $rekening)
    {
        $validated = $request->validate([
            'no_rekening' => 'required|string|max:20|unique:tbl_rekening,no_rekening,' . $rekening->id_rekening . ',id_rekening',
            'nama_pemilik' => 'required|string|max:100',
            'jenis_rekening' => 'required|string|max:50',
            'no_identitas' => 'required|string|max:20',
            'status' => 'required|in:aktif,tidak-aktif,tersuspend',
            'catatan' => 'nullable|string',
        ]);

        // Update menggunakan Eloquent ORM
        $rekening->update($validated);

        return redirect()->route('rekening.show', $rekening)->with('success', 'Data rekening berhasil diperbarui');
    }

    /**
     * Menghapus rekening dari database
     * DELETE /rekening/{id}
     */
    public function destroy(Rekening $rekening)
    {
        $rekening->delete();
        return redirect()->route('rekening.index')->with('success', 'Rekening berhasil dihapus');
    }
}
