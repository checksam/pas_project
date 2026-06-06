@extends('layout')

@section('title', 'Daftar Pegawai')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Daftar Pegawai</h5>
    </div>
    <div class="card-body">
        @auth
            <a href="/pegawai/create" class="btn btn-primary mb-3">➕ Tambah Pegawai Baru</a>
        @endauth

        @if($pegawai->isEmpty())
            <div class="alert alert-info">Belum ada data pegawai</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawai as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->nama_pegawai }}</td>
                                <td>{{ $item->jabatan }}</td>
                                <td>{{ $item->email_pegawai }}</td>
                                <td>
                                    <span class="badge {{ $item->status === 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="/pegawai/{{ $item->id_pegawai }}" class="btn btn-sm btn-info">👁️ Lihat</a>
                                    @auth
                                        <a href="/pegawai/{{ $item->id_pegawai }}/edit" class="btn btn-sm btn-warning">✏️ Edit</a>
                                        <form action="/pegawai/{{ $item->id_pegawai }}" method="POST" style="display:inline;" 
                                              onsubmit="return confirm('Yakin hapus?')">
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

            <!-- Pagination -->
            <div class="mt-3">
                {{ $pegawai->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
