<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    /**
     * Menampilkan daftar semua pegawai
     * GET /pegawai
     */
    public function index()
    {
        $pegawai = Pegawai::with('user')->paginate(10);
        return view('pegawai.index', compact('pegawai'));
    }

    /**
     * Menampilkan form untuk membuat pegawai baru
     * GET /pegawai/create
     */
    public function create()
    {
        return view('pegawai.create');
    }

    /**
     * Menyimpan pegawai baru ke database
     * POST /pegawai
     * Demonstrasi VALIDASI INPUT & SECURITY
     */
    public function store(Request $request)
    {
        // Validasi input - mencegah data yang tidak valid masuk ke database
        $validated = $request->validate([
            'nip' => 'required|string|max:20|unique:tbl_pegawai,nip',
            'nama_pegawai' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'email_pegawai' => 'required|email|unique:tbl_pegawai,email_pegawai',
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        // Assign user_id untuk pegawai yang baru
        $validated['user_id'] = auth()->id();

        // Create menggunakan Eloquent ORM
        Pegawai::create($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    /**
     * Menampilkan detail pegawai tertentu
     * GET /pegawai/{id}
     */
    public function show(Pegawai $pegawai)
    {
        $pegawai->load('transaksi', 'transfer', 'user');
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Menampilkan form untuk edit pegawai
     * GET /pegawai/{id}/edit
     */
    public function edit(Pegawai $pegawai)
    {
        return view('pegawai.edit', compact('pegawai'));
    }

    /**
     * Mengupdate data pegawai di database
     * PUT/PATCH /pegawai/{id}
     * Demonstrasi UPDATE operation pada Eloquent ORM
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:20|unique:tbl_pegawai,nip,' . $pegawai->id_pegawai . ',id_pegawai',
            'nama_pegawai' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'email_pegawai' => 'required|email|unique:tbl_pegawai,email_pegawai,' . $pegawai->id_pegawai . ',id_pegawai',
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        // Update menggunakan Eloquent ORM
        $pegawai->update($validated);

        return redirect()->route('pegawai.show', $pegawai)->with('success', 'Data pegawai berhasil diperbarui');
    }

    /**
     * Menghapus pegawai dari database
     * DELETE /pegawai/{id}
     * Demonstrasi DELETE operation pada Eloquent ORM
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }
}
