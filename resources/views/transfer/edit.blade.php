@extends('layout')

@section('title', 'Update Transfer')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Update Status Transfer #{{ $transfer->id_transfer }}</h5>
    </div>
    <div class="card-body">
        <form action="/transfer/{{ $transfer->id_transfer }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card bg-light mb-4">
                <div class="card-body">
                    <h6>Info Transfer</h6>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td><strong>Pengirim:</strong></td>
                            <td>{{ $transfer->rekening_pengirim->no_rekening }} - {{ $transfer->rekening_pengirim->nama_pemilik }}</td>
                        </tr>
                        <tr>
                            <td><strong>Penerima:</strong></td>
                            <td>{{ $transfer->rekening_penerima->no_rekening }} - {{ $transfer->rekening_penerima->nama_pemilik }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jumlah:</strong></td>
                            <td>Rp {{ number_format($transfer->jumlah, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal:</strong></td>
                            <td>{{ $transfer->tanggal_transfer->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status Transfer *</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="pending" {{ old('status', $transfer->status) === 'pending' ? 'selected' : '' }}>Pending (Menunggu Proses)</option>
                    <option value="berhasil" {{ old('status', $transfer->status) === 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                    <option value="gagal" {{ old('status', $transfer->status) === 'gagal' ? 'selected' : '' }}>Gagal</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan/Alasan (opsional)</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $transfer->catatan) }}</textarea>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="alert alert-warning">
                <strong>⚠️ Perhatian:</strong> Status transfer tidak bisa diubah kembali jika saldo sudah terbukti berhasil atau gagal di rekening masing-masing.
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">💾 Update Status</button>
                <a href="/transfer/{{ $transfer->id_transfer }}" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
