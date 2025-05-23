<!-- resources/views/barang/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Barang</h2>

    <form method="POST" action="{{ route('barang.update', $barang->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama" class="form-control" value="{{ $barang->nama }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required>{{ $barang->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label>Lokasi Kehilangan</label>
            <input type="text" name="lokasi" class="form-control" value="{{ $barang->lokasi }}" required>
        </div>

        <div class="mb-3">
            <label for="kontak" class="form-label">Kontak Pelapor</label>
            <input type="text" name="kontak" class="form-control" value="{{ old('kontak', $barang->kontak) }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="hilang" {{ $barang->status == 'hilang' ? 'selected' : '' }}>Hilang</option>
                <option value="ditemukan" {{ $barang->status == 'ditemukan' ? 'selected' : '' }}>Ditemukan</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Gambar (biarkan kosong jika tidak ingin diganti)</label>
            <input type="file" name="gambar" class="form-control">
            @if ($barang->gambar)
                <p>Gambar saat ini:</p>
                <img src="{{ asset('storage/' . $barang->gambar) }}" width="150">
            @endif
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
