@extends('layout')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Daftar Transaksi</h5>
    </div>
    <div class="card-body">
        @auth
            <a href="/transaksi/create" class="btn btn-primary mb-3">Transaksi Baru</a>
        @endauth

        @if($transaksi->isEmpty())
            <div class="alert alert-info">Belum ada data transaksi</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>Rekening</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Saldo Awal</th>
                            <th>Saldo Akhir</th>
                            <th>Pegawai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $item)
                            <tr>
                                <td>{{ $item->tanggal_transaksi->format('d/m/Y H:i') }}</td>
                                <td><strong>{{ $item->rekening->no_rekening }}</strong></td>
                                <td>
                                    <span class="badge 
                                        {{ $item->jenis_transaksi === 'setor' ? 'bg-success' : 
                                           ($item->jenis_transaksi === 'tarik' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ $item->jenis_transaksi }}
                                    </span>
                                </td>
                                <td class="text-end">Rp {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($item->saldo_sebelum, 2, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($item->saldo_sesudah, 2, ',', '.') }}</td>
                                <td>{{ $item->pegawai->nama_pegawai }}</td>
                                <td>
                                    <a href="/transaksi/{{ $item->id_transaksi }}" class="btn btn-sm btn-info">Lihat</a>
                                    @auth
                                        <form action="/transaksi/{{ $item->id_transaksi }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    @endauth
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $transaksi->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Keterangan untuk pembelajaran -->
<div class="alert alert-info mt-3">
    <strong>📚 Pembelajaran:</strong>
    <ul class="mb-0">
        <li><code>$item->rekening->no_rekening</code> - Mengakses data relasi (belongs-to relationship)</li>
        <li><code>$item->pegawai->nama_pegawai</code> - Nested relationship access</li>
        <li>Data ditampilkan dengan informasi saldo sebelum dan sesudah untuk audit trail</li>
    </ul>
</div>
@endsection
