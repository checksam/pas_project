@extends('layout')

@section('title', 'Edit Rekening')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Edit Data Rekening</h5>
    </div>
    <div class="card-body">
        <form action="/rekening/{{ $rekening->id_rekening }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="no_rekening" class="form-label">Nomor Rekening *</label>
                <input type="text" class="form-control @error('no_rekening') is-invalid @enderror" 
                       id="no_rekening" name="no_rekening" value="{{ old('no_rekening', $rekening->no_rekening) }}" required>
                @error('no_rekening')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_pemilik" class="form-label">Nama Pemilik *</label>
                <input type="text" class="form-control @error('nama_pemilik') is-invalid @enderror" 
                       id="nama_pemilik" name="nama_pemilik" value="{{ old('nama_pemilik', $rekening->nama_pemilik) }}" required>
                @error('nama_pemilik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis_rekening" class="form-label">Jenis Rekening *</label>
                <select class="form-select @error('jenis_rekening') is-invalid @enderror" id="jenis_rekening" name="jenis_rekening" required>
                    <option value="Tabungan" {{ old('jenis_rekening', $rekening->jenis_rekening) === 'Tabungan' ? 'selected' : '' }}>Tabungan</option>
                    <option value="Giro" {{ old('jenis_rekening', $rekening->jenis_rekening) === 'Giro' ? 'selected' : '' }}>Giro</option>
                    <option value="Deposit" {{ old('jenis_rekening', $rekening->jenis_rekening) === 'Deposit' ? 'selected' : '' }}>Deposit</option>
                </select>
                @error('jenis_rekening')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_identitas" class="form-label">Nomor Identitas *</label>
                <input type="text" class="form-control @error('no_identitas') is-invalid @enderror" 
                       id="no_identitas" name="no_identitas" value="{{ old('no_identitas', $rekening->no_identitas) }}" required>
                @error('no_identitas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status *</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="aktif" {{ old('status', $rekening->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak-aktif" {{ old('status', $rekening->status) === 'tidak-aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="tersuspend" {{ old('status', $rekening->status) === 'tersuspend' ? 'selected' : '' }}>Tersuspend</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $rekening->catatan) }}</textarea>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                <a href="/rekening/{{ $rekening->id_rekening }}" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
