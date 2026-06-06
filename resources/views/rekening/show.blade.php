@extends('layout')

@section('title', 'Detail Rekening')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Detail Rekening: {{ $rekening->no_rekening }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>No Rekening:</strong></td>
                        <td><h6>{{ $rekening->no_rekening }}</h6></td>
                    </tr>
                    <tr>
                        <td><strong>Nama Pemilik:</strong></td>
                        <td>{{ $rekening->nama_pemilik }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Rekening:</strong></td>
                        <td>{{ $rekening->jenis_rekening }}</td>
                    </tr>
                    <tr>
                        <td><strong>No Identitas:</strong></td>
                        <td>{{ $rekening->no_identitas }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Saldo:</strong></td>
                        <td><h5 class="text-success">Rp {{ number_format($rekening->saldo, 2, ',', '.') }}</h5></td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <span class="badge {{ $rekening->status === 'aktif' ? 'bg-success' : ($rekening->status === 'tidak-aktif' ? 'bg-danger' : 'bg-warning') }}">
                                {{ $rekening->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Catatan:</strong></td>
                        <td>{{ $rekening->catatan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <h6 class="mb-3">📝 Transaksi Terkait</h6>
        @if($rekening->transaksi->isEmpty())
            <div class="alert alert-info">Belum ada transaksi</div>
        @else
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekening->transaksi as $item)
                            <tr>
                                <td>{{ $item->tanggal_transaksi->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge {{ $item->jenis_transaksi === 'setor' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->jenis_transaksi }}
                                    </span>
                                </td>
                                <td class="text-end">Rp {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($item->saldo_sesudah, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <hr>

        <div class="d-flex gap-2">
            @auth
                <a href="/rekening/{{ $rekening->id_rekening }}/edit" class="btn btn-warning">✏️ Edit</a>
            @endauth
            <a href="/rekening" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>
</div>
@endsection
