@extends('layout')

@section('title', 'Buat Rekening Baru')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Buat Rekening Baru</h5>
    </div>
    <div class="card-body">
        <form action="/rekening" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="no_rekening" class="form-label">Nomor Rekening *</label>
                <input type="text" class="form-control @error('no_rekening') is-invalid @enderror" 
                       id="no_rekening" name="no_rekening" value="{{ old('no_rekening') }}" required>
                @error('no_rekening')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_pemilik" class="form-label">Nama Pemilik Rekening *</label>
                <input type="text" class="form-control @error('nama_pemilik') is-invalid @enderror" 
                       id="nama_pemilik" name="nama_pemilik" value="{{ old('nama_pemilik') }}" required>
                @error('nama_pemilik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis_rekening" class="form-label">Jenis Rekening *</label>
                <select class="form-select @error('jenis_rekening') is-invalid @enderror" 
                        id="jenis_rekening" name="jenis_rekening" required>
                    <option value="">Pilih Jenis Rekening</option>
                    <option value="Tabungan" {{ old('jenis_rekening') === 'Tabungan' ? 'selected' : '' }}>Tabungan</option>
                    <option value="Giro" {{ old('jenis_rekening') === 'Giro' ? 'selected' : '' }}>Giro</option>
                    <option value="Deposit" {{ old('jenis_rekening') === 'Deposit' ? 'selected' : '' }}>Deposit</option>
                </select>
                @error('jenis_rekening')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="saldo" class="form-label">Saldo Awal *</label>
                <input type="number" step="0.01" class="form-control @error('saldo') is-invalid @enderror" 
                       id="saldo" name="saldo" value="{{ old('saldo', 0) }}" required>
                @error('saldo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_identitas" class="form-label">Nomor Identitas (KTP/SIM/Paspor) *</label>
                <input type="text" class="form-control @error('no_identitas') is-invalid @enderror" 
                       id="no_identitas" name="no_identitas" value="{{ old('no_identitas') }}" required>
                @error('no_identitas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status Rekening *</label>
                 <select class="form-select @error('status') is-invalid @enderror" 
                        id="status" name="status" required 
                        style="text-dark: true;">
                    <option value="">Pilih Status Rekening</option>
                    <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="non-aktif" {{ old('status') === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                </select>
            </div>

            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" 
                          id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">💾 Buat Rekening</button>
                <a href="/rekening" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
