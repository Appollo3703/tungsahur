@extends('layouts.app')

@section('content')
<h2>Tambah Barang Hilang</h2>

<form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Nama Barang</label>
        <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label>Lokasi Kehilangan</label>
        <input type="text" name="lokasi" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="kontak" class="form-label">Kontak Pelapor (WA / IG / Facebook)</label>
        <input type="text" name="kontak" class="form-control" value="{{ old('kontak') }}" placeholder="Contoh: 08123456789 / @username">
    </div>
    <div class="mb-3">
        <label>Gambar Barang</label>
        <input type="file" name="gambar" class="form-control">
    </div>
    <button class="btn btn-primary">Simpan</button>
</form>
@endsection
