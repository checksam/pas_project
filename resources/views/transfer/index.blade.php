@extends('layout')

@section('title', 'Daftar Transfer')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Daftar Transfer</h5>
    </div>
    <div class="card-body">
        @auth
            <a href="/transfer/create" class="btn btn-primary mb-3">Transfer Baru</a>
        @endauth

        @if($transfer->isEmpty())
            <div class="alert alert-info">Belum ada data transfer</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>Pengirim</th>
                            <th>Penerima</th>
                            <th>Jumlah</th>
                            <th>Biaya</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transfer as $item)
                            <tr>
                                <td>{{ $item->tanggal_transfer->format('d/m/Y H:i') }}</td>
                                <td>
                                    <small>{{ $item->rekening_pengirim->no_rekening }}</small><br>
                                    <strong>{{ $item->rekening_pengirim->nama_pemilik }}</strong>
                                </td>
                                <td>
                                    <small>{{ $item->rekening_penerima->no_rekening }}</small><br>
                                    <strong>{{ $item->rekening_penerima->nama_pemilik }}</strong>
                                </td>
                                <td class="text-end">Rp {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($item->biaya_transfer, 2, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $item->status === 'berhasil' ? 'bg-success' : ($item->status === 'gagal' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="/transfer/{{ $item->id_transfer }}" class="btn btn-sm btn-info">Lihat</a>
                                    @auth
                                        <a href="/transfer/{{ $item->id_transfer }}/edit" class="btn btn-sm btn-warning">Edit</a>
                                    @endauth
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $transfer->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Keterangan untuk pembelajaran -->
<div class="alert alert-info mt-3">
    <strong>📚 Pembelajaran:</strong>
    <ul class="mb-0">
        <li>Tabel transfer menunjukkan relasi multiple belongs-to: pengirim dan penerima adalah kedua-duanya rekening</li>
        <li><code>$item->rekening_pengirim</code> dan <code>$item->rekening_penerima</code> - Dua relasi berbeda ke tabel yang sama</li>
        <li>Total transaksi = Jumlah + Biaya Transfer</li>
    </ul>
</div>
@endsection
