@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Barang Hilang</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Search dan Status --}}
    <form method="GET" action="{{ route('barang.index') }}" class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari barang..."
                value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">-- Semua Status --</option>
                <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                <option value="ditemukan" {{ request('status') == 'ditemukan' ? 'selected' : '' }}>Ditemukan</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-secondary w-100">Filter</button>
        </div>
    </form>

    @auth
        <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">Laporkan Barang Hilang</a>
    @endauth

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barangs as $barang)
            <tr>
                <td>{{ $barang->nama }}</td>
                <td>{{ $barang->deskripsi }}</td>
                <td>{{ $barang->lokasi }}</td>
                <td>{{ ucfirst($barang->status) }}</td>
                <td>
                    @if($barang->gambar)
                        <img src="{{ asset('storage/' . $barang->gambar) }}" alt="gambar" width="80">
                    @else
                        <small>Tidak ada gambar</small>
                    @endif
                </td>
                <td>
                    <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-sm btn-info">Lihat</a>
                    @if ($barang->kontak)
                        @php
                            $kontak = preg_replace('/\D/', '', $barang->kontak);
                            $isWhatsapp = preg_match('/^(08|62)/', $kontak);
                            if (str_starts_with($kontak, '08')) {
                                $kontak = '62' . substr($kontak, 1);
                            }
                        @endphp
                        @if ($isWhatsapp)
                            <a href="https://wa.me/{{ $kontak }}" target="_blank" class="btn btn-sm btn-success mt-1">
                                Kontak WA
                            </a>
                        @else
                            <small class="d-block">{{ $barang->kontak }}</small>
                        @endif
                    @endif
                    @auth
                        @if (auth()->id() === $barang->user_id)
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus barang ini?')">Hapus</button>
                            </form>
                            <form action="{{ route('barang.ubahStatus', $barang->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-secondary"
                                    onclick="return confirm('Yakin ingin ubah status barang ini?')">
                                    Ubah Status
                                </button>
                            </form>
                        @endif
                    @endauth
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Belum ada barang hilang dilaporkan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    {{ $barangs->links() }}
</div>
@endsection
