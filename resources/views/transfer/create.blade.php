@extends('layout')

@section('title', 'Buat Transfer Baru')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Buat Transfer Baru</h5>
    </div>
    <div class="card-body">
        <form action="/transfer" method="POST">
            @csrf
            
            <div class="alert alert-info">
                💡 Transfer adalah perpindahan dana dari rekening pengirim ke rekening penerima. 
                Biaya transfer akan dipotong dari saldo pengirim.
            </div>

            <h6 class="mb-3 border-bottom pb-2">📤 Data Pengirim</h6>
            
            <div class="mb-3">
                <label for="id_rekening_pengirim" class="form-label">Pilih Rekening Pengirim *</label>
                <select class="form-select text-dark @error('id_rekening_pengirim') is-invalid @enderror" 
                        id="id_rekening_pengirim" name="id_rekening_pengirim" required onchange="updatePengirim()"
                        style="text-dark: true;">
                    <option value="">-- Pilih Rekening --</option>
                    @foreach($rekening as $item)
                        <option value="{{ $item->id_rekening }}" 
                                data-saldo="{{ $item->saldo }}"
                                data-nama="{{ $item->nama_pemilik }}"
                                data-no="{{ $item->no_rekening }}"
                                {{ old('id_rekening_pengirim') == $item->id_rekening ? 'selected' : '' }}>
                            {{ $item->no_rekening }} - {{ $item->nama_pemilik }}
                        </option>
                    @endforeach
                </select>
                @error('id_rekening_pengirim')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="pengirim-info" class="mt-2"></div>
            </div>

            <h6 class="mb-3 border-bottom pb-2">Data Penerima</h6>

            <div class="mb-3">
                <label for="id_rekening_penerima" class="form-label">Pilih Rekening Penerima *</label>
                <select class="form-select @error('id_rekening_penerima') is-invalid @enderror" 
                        id="id_rekening_penerima" name="id_rekening_penerima" required onchange="updatePenerima()"
                        style="text-dark: true;">
                    <option value="">-- Pilih Rekening --</option>
                    @foreach($rekening as $item)
                        <option value="{{ $item->id_rekening }}" 
                                data-nama="{{ $item->nama_pemilik }}"
                                data-no="{{ $item->no_rekening }}"
                                {{ old('id_rekening_penerima') == $item->id_rekening ? 'selected' : '' }}>
                            {{ $item->no_rekening }} - {{ $item->nama_pemilik }}
                        </option>
                    @endforeach
                </select>
                @error('id_rekening_penerima')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="penerima-info" class="mt-2"></div>
            </div>

            <h6 class="mb-3 border-bottom pb-2">💰 Detail Transfer</h6>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Transfer (Nominal yang diterima penerima) *</label>
                <input type="number" step="0.01" class="form-control @error('jumlah') is-invalid @enderror" 
                       id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required oninput="calculateTotal()">
                @error('jumlah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="biaya_transfer" class="form-label">Biaya Transfer *</label>
                <input type="number" step="0.01" class="form-control @error('biaya_transfer') is-invalid @enderror" 
                       id="biaya_transfer" name="biaya_transfer" value="{{ old('biaya_transfer', 0) }}" required oninput="calculateTotal()">
                @error('biaya_transfer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div id="total-info" class="mt-2"></div>
            </div>

            <div class="mb-3">
                <label for="tujuan_transfer" class="form-label">Tujuan/Keperluan Transfer *</label>
                <textarea class="form-control @error('tujuan_transfer') is-invalid @enderror" 
                          id="tujuan_transfer" name="tujuan_transfer" rows="2" required>{{ old('tujuan_transfer') }}</textarea>
                @error('tujuan_transfer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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

            <div class="alert alert-warning">
                <strong>⚠️ Perhatian:</strong> Pastikan saldo pengirim mencukupi untuk jumlah transfer + biaya transfer!
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">💾 Lakukan Transfer</button>
                <a href="/transfer" class="btn btn-secondary">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function updatePengirim() {
    const select = document.getElementById('id_rekening_pengirim');
    const option = select.options[select.selectedIndex];
    const saldo = option.getAttribute('data-saldo');
    const nama = option.getAttribute('data-nama');
    const no = option.getAttribute('data-no');
    
    if (saldo) {
        document.getElementById('pengirim-info').innerHTML = 
            `<div class="alert alert-info mb-0">
                <strong>${no}</strong> - ${nama}<br>
                Saldo: <strong>Rp ${parseFloat(saldo).toLocaleString('id-ID', {minimumFractionDigits: 2})}</strong>
            </div>`;
    }
}

function updatePenerima() {
    const select = document.getElementById('id_rekening_penerima');
    const option = select.options[select.selectedIndex];
    const nama = option.getAttribute('data-nama');
    const no = option.getAttribute('data-no');
    
    if (nama) {
        document.getElementById('penerima-info').innerHTML = 
            `<div class="alert alert-info mb-0">
                <strong>${no}</strong> - ${nama}
            </div>`;
    }
}

function calculateTotal() {
    const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
    const biaya = parseFloat(document.getElementById('biaya_transfer').value) || 0;
    const total = jumlah + biaya;
    
    document.getElementById('total-info').innerHTML = 
        `<div class="alert alert-warning mb-0">
            <strong>Total Debit dari Pengirim:</strong> Rp ${total.toLocaleString('id-ID', {minimumFractionDigits: 2})}
        </div>`;
}

// Initialize on page load
window.addEventListener('load', function() {
    updatePengirim();
    updatePenerima();
    calculateTotal();
});
</script>

<!-- Keterangan untuk pembelajaran -->
<div class="alert alert-info mt-3">
    <strong>📚 Pembelajaran:</strong>
    <ul class="mb-0">
        <li>Form ini menunjukkan relationship multiple belongs-to dalam praktik</li>
        <li>Validasi penting: pengirim ≠ penerima (atribut <code>different</code> di controller)</li>
        <li>Interaktivitas form: total debit dihitung otomatis (jumlah + biaya)</li>
        <li>Database transaction di controller memastikan konsistensi data kedua rekening</li>
    </ul>
</div>
@endsection
