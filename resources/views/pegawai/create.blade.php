@extends('layout')

@section('title', 'Tambah Pegawai')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah Pegawai Baru</h5>
    </div>
    <div class="card-body">
        <!-- Form dengan CSRF Token untuk security -->
        <form action="/pegawai" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="nip" class="form-label">NIP (Nomor Induk Pegawai) *</label>
                <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                       id="nip" name="nip" value="{{ old('nip') }}" required>
                @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_pegawai" class="form-label">Nama Pegawai *</label>
                <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" 
                       id="nama_pegawai" name="nama_pegawai" value="{{ old('nama_pegawai') }}" required>
                @error('nama_pegawai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan *</label>
                <select class="form-select @error('jabatan') is-invalid @enderror" 
                        id="jabatan" name="jabatan" required>
                    <option value="">Pilih Jabatan</option>
                    <option value="Teller" {{ old('jabatan') === 'Teller' ? 'selected' : '' }}>Teller</option>
                    <option value="Manager" {{ old('jabatan') === 'Manager' ? 'selected' : '' }}>Manager</option>
                    <option value="Security" {{ old('jabatan') === 'Security' ? 'selected' : '' }}>Security</option>
                    <option value="Admin" {{ old('jabatan') === 'Admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email_pegawai" class="form-label">Email *</label>
                <input type="email" class="form-control @error('email_pegawai') is-invalid @enderror" 
                       id="email_pegawai" name="email_pegawai" value="{{ old('email_pegawai') }}" required>
                @error('email_pegawai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_telepon" class="form-label">Nomor Telepon *</label>
                <input type="tel" class="form-control @error('no_telepon') is-invalid @enderror" 
                       id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required>
                @error('no_telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat *</label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                          id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status *</label>
                <select class="form-select @error('status') is-invalid @enderror" 
                        id="status" name="status" required>
                    <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="non-aktif" {{ old('status') === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
                <a href="/pegawai" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<!-- Keterangan untuk pembelajaran -->
<div class="alert alert-info mt-3">
    <strong>📚 Pembelajaran:</strong>
    <ul class="mb-0">
        <li><code>@@csrf</code> - Token CSRF untuk mencegah serangan Cross-Site Request Forgery</li>
        <li><code>old()</code> - Menampilkan kembali data yang diinput jika ada validasi error</li>
        <li><code>@@error()</code> - Menampilkan pesan error untuk field tertentu</li>
        <li><code>required</code> - Validasi form HTML5</li>
    </ul>
</div>
@endsection
