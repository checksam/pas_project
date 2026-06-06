@extends('layout')

@section('title', 'Edit Pegawai')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Edit Data Pegawai</h5>
    </div>
    <div class="card-body">
        <form action="/pegawai/{{ $pegawai->id_pegawai }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="nip" class="form-label">NIP (Nomor Induk Pegawai) *</label>
                <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                       id="nip" name="nip" value="{{ old('nip', $pegawai->nip) }}" required>
                @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_pegawai" class="form-label">Nama Pegawai *</label>
                <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" 
                       id="nama_pegawai" name="nama_pegawai" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}" required>
                @error('nama_pegawai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan *</label>
                <select class="form-select @error('jabatan') is-invalid @enderror" 
                        id="jabatan" name="jabatan" required>
                    <option value="Teller" {{ old('jabatan', $pegawai->jabatan) === 'Teller' ? 'selected' : '' }}>Teller</option>
                    <option value="Manager" {{ old('jabatan', $pegawai->jabatan) === 'Manager' ? 'selected' : '' }}>Manager</option>
                    <option value="Security" {{ old('jabatan', $pegawai->jabatan) === 'Security' ? 'selected' : '' }}>Security</option>
                    <option value="Admin" {{ old('jabatan', $pegawai->jabatan) === 'Admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email_pegawai" class="form-label">Email *</label>
                <input type="email" class="form-control @error('email_pegawai') is-invalid @enderror" 
                       id="email_pegawai" name="email_pegawai" value="{{ old('email_pegawai', $pegawai->email_pegawai) }}" required>
                @error('email_pegawai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_telepon" class="form-label">Nomor Telepon *</label>
                <input type="tel" class="form-control @error('no_telepon') is-invalid @enderror" 
                       id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $pegawai->no_telepon) }}" required>
                @error('no_telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat *</label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                          id="alamat" name="alamat" rows="3" required>{{ old('alamat', $pegawai->alamat) }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status *</label>
                <select class="form-select @error('status') is-invalid @enderror" 
                        id="status" name="status" required>
                    <option value="aktif" {{ old('status', $pegawai->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="non-aktif" {{ old('status', $pegawai->status) === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                <a href="/pegawai/{{ $pegawai->id_pegawai }}" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<!-- Keterangan untuk pembelajaran -->
<div class="alert alert-info mt-3">
    <strong>📚 Pembelajaran:</strong>
    <ul class="mb-0">
        <li><code>@@method('PUT')</code> - Mengirim HTTP method PUT untuk update data (REsouce Controller)</li>
        <li><code>old('nama', $value)</code> - Menampilkan data lama jika ada error validasi, atau value yang tersimpan</li>
        <li>Ini adalah UPDATE operation pada Eloquent ORM</li>
    </ul>
</div>
@endsection
