@extends('layout')

@section('title', 'Daftar Rekening')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Daftar Rekening</h5>
    </div>
    <div class="card-body">
        @auth
            <a href="/rekening/create" class="btn btn-primary mb-3">Buat Rekening Baru</a>
        @endauth

        @if($rekening->isEmpty())
            <div class="alert alert-info">Belum ada data rekening</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No Rekening</th>
                            <th>Nama Pemilik</th>
                            <th>Jenis</th>
                            <th>Saldo</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekening as $item)
                            <tr>
                                <td><strong>{{ $item->no_rekening }}</strong></td>
                                <td>{{ $item->nama_pemilik }}</td>
                                <td>{{ $item->jenis_rekening }}</td>
                                <td class="text-end">Rp {{ number_format($item->saldo, 2, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $item->status === 'aktif' ? 'bg-success' : ($item->status === 'tidak-aktif' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="/rekening/{{ $item->id_rekening }}" class="btn btn-sm btn-info">👁️ Lihat</a>
                                    @auth
                                        <a href="/rekening/{{ $item->id_rekening }}/edit" class="btn btn-sm btn-warning">✏️ Edit</a>
                                        <form action="/rekening/{{ $item->id_rekening }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">🗑️ Hapus</button>
                                        </form>
                                    @endauth
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $rekening->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
