{{-- resources/views/admin/user/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 fw-bolder mb-0">Kelola Pengguna</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        {{-- Tempat untuk menampilkan pesan sukses atau error --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status Admin</th>
                                <th>Jumlah Laporan</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->is_admin)
                                            <span class="badge bg-success">Admin</span>
                                        @else
                                            <span class="badge bg-secondary">Pengguna</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-info">{{ $user->barangs_count }}</span></td>
                                    <td class="text-end">
                                        {{-- Form untuk toggle status admin --}}
                                        <form action="{{ route('admin.user.toggleAdmin', $user) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-info"
                                                title="{{ $user->is_admin ? 'Jadikan Pengguna Biasa' : 'Jadikan Admin' }}">
                                                <i
                                                    class="bi {{ $user->is_admin ? 'bi-person-dash-fill' : 'bi-person-check-fill' }}"></i>
                                            </button>
                                        </form>

                                        {{-- Tombol Hapus Pengguna --}}
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteUserModal-{{ $user->id }}" title="Hapus Pengguna">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>

                                        {{-- Modal Konfirmasi Hapus Pengguna --}}
                                        <div class="modal fade" id="deleteUserModal-{{ $user->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Konfirmasi Hapus Pengguna</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <p>Apakah Anda yakin ingin menghapus pengguna
                                                            <strong>"{{ $user->name }}"</strong>?</p>
                                                        <div class="alert alert-danger small">
                                                            <strong>PERHATIAN:</strong> Tindakan ini tidak dapat diurungkan
                                                            dan akan menghapus akun pengguna secara permanen.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.user.destroy', $user) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Ya, Hapus
                                                                Pengguna</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada data pengguna lain.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Tampilkan link paginasi jika ada banyak pengguna --}}
                @if ($users->hasPages())
                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
