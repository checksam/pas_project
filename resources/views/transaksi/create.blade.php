@extends('layout')

@section('title', 'Buat Transaksi Baru')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Buat Transaksi Baru</h5>
    </div>
    <div class="card-body">
        <form action="/transaksi" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="id_rekening" class="form-label">Pilih Rekening *</label>
                <select class="form-select @error('id_rekening') is-invalid @enderror" 
                        id="id_rekening" name="id_rekening" required onchange="showSaldo()">
                    <option value="">-- Pilih Rekening --</option>
                    @foreach($rekening as $item)
                        <option value="{{ $item->id_rekening }}" 
                                data-saldo="{{ $item->saldo }}"
                                data-nama="{{ $item->nama_pemilik }}"
                                data-no="{{ $item->no_rekening }}"
                                {{ old('id_rekening') == $item->id_rekening ? 'selected' : '' }}>
                            {{ $item->no_rekening }} - {{ $item->nama_pemilik }} (Rp {{ number_format($item->saldo, 2, ',', '.') }})
                        </option>
                    @endforeach
                </select>
                @error('id_rekening')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="saldo-info" class="mt-2"></div>
            </div>

            <div class="mb-3">
                <label for="id_pegawai" class="form-label">Pegawai yang Memproses *</label>
                <select class="form-select @error('id_pegawai') is-invalid @enderror" 
                        id="id_pegawai" name="id_pegawai" required>
                    <option value="">-- Pilih Pegawai --</option>
                    @foreach($pegawai as $item)
                        <option value="{{ $item->id_pegawai }}" {{ old('id_pegawai') == $item->id_pegawai ? 'selected' : '' }}>
                            {{ $item->nama_pegawai }} ({{ $item->jabatan }})
                        </option>
                    @endforeach
                </select>
                @error('id_pegawai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis_transaksi" class="form-label">Jenis Transaksi *</label>
                <select class="form-select @error('jenis_transaksi') is-invalid @enderror" 
                        id="jenis_transaksi" name="jenis_transaksi" required onchange="updateLabel()">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="setor" {{ old('jenis_transaksi') === 'setor' ? 'selected' : '' }}>Setor</option>
                    <option value="tarik" {{ old('jenis_transaksi') === 'tarik' ? 'selected' : '' }}>Tarik</option>
                    <option value="biaya_admin" {{ old('jenis_transaksi') === 'biaya_admin' ? 'selected' : '' }}>Biaya Admin</option>
                </select>
                @error('jenis_transaksi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label" id="jumlah-label">Jumlah *</label>
                <input type="number" step="0.01" class="form-control @error('jumlah') is-invalid @enderror" 
                       id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required>
                @error('jumlah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                          id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="alert alert-warning">
                <strong>⚠️ Perhatian:</strong> Transaksi akan langsung memperbarui saldo rekening dan tidak bisa diedit, hanya bisa dihapus.
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">💾 Simpan Transaksi</button>
                <a href="/transaksi" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function showSaldo() {
    const select = document.getElementById('id_rekening');
    const option = select.options[select.selectedIndex];
    const saldo = option.getAttribute('data-saldo');
    const nama = option.getAttribute('data-nama');
    const no = option.getAttribute('data-no');
    
    if (saldo) {
        document.getElementById('saldo-info').innerHTML = 
            `<div class="alert alert-info mb-0">
                <strong>${no}</strong> - ${nama}<br>
                Saldo Saat Ini: <strong>Rp ${parseFloat(saldo).toLocaleString('id-ID', {minimumFractionDigits: 2})}</strong>
            </div>`;
    }
}

function updateLabel() {
    const jenis = document.getElementById('jenis_transaksi').value;
    const label = document.getElementById('jumlah-label');
    
    if (jenis === 'setor') {
        label.textContent = 'Jumlah Setoran *';
    } else if (jenis === 'tarik') {
        label.textContent = 'Jumlah Penarikan *';
    } else {
        label.textContent = 'Biaya Admin *';
    }
}

// Initialize on page load
window.addEventListener('load', function() {
    showSaldo();
    updateLabel();
});
</script>

<!-- Keterangan untuk pembelajaran -->
<div class="alert alert-info mt-3">
    <strong>📚 Pembelajaran:</strong>
    <ul class="mb-0">
        <li>Form ini menunjukkan penggunaan relasi One-to-Many dalam form (select option)</li>
        <li><code>data-saldo="{{ $item->saldo }}"</code> - Custom attribute untuk menyimpan data</li>
        <li>JavaScript digunakan untuk update label berdasarkan jenis transaksi (interaktivitas frontend)</li>
        <li>Validasi di level form: memastikan jumlah lebih dari 0</li>
    </ul>
</div>
@endsection
