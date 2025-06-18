@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container py-4 py-lg-5 admin-dashboard-page">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h1 class="h2 fw-bold mb-0" style="color: var(--app-navbar-bg, #003366);">Admin Dashboard</h1>
            <span class="badge bg-primary rounded-pill">Panel Kontrol</span>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Statistik --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
            {{-- Total Pengguna --}}
            <div class="col">
                <div class="card h-100 border-0 shadow-sm text-center p-4 rounded-4">
                    <i class="bi bi-people-fill fs-1 text-primary mb-2"></i>
                    <h3 class="fw-bold mb-0">{{ $totalPengguna }}</h3>
                    <p class="text-muted small mb-0">Total Pengguna</p>
                </div>
            </div>

            {{-- Total Laporan --}}
            <div class="col">
                <div class="card h-100 border-0 shadow-sm text-center p-4 rounded-4">
                    <i class="bi bi-journal-text fs-1 text-info mb-2"></i>
                    <h3 class="fw-bold mb-0">{{ $totalLaporan }}</h3>
                    <p class="text-muted small mb-0">Total Laporan</p>
                </div>
            </div>

            {{-- Laporan Hari Ini --}}
            <div class="col">
                <div class="card h-100 border-0 shadow-sm text-center p-4 rounded-4">
                    <i class="bi bi-calendar-plus-fill fs-1 text-success mb-2"></i>
                    <h3 class="fw-bold mb-0">{{ $laporanPerHari }}</h3>
                    <p class="text-muted small mb-0">Laporan Hari Ini</p>
                </div>
            </div>

            {{-- Aksi Cepat --}}
            <div class="col">
                <div class="card h-100 border-0 shadow-sm text-center p-4 rounded-4 bg-opacity-10">
                    <i class="bi bi-gear-fill fs-2 text-primary mb-2"></i>
                    <h6 class="fw-semibold mb-1">Aksi Cepat</h6>
                    <p class="text-muted small mb-3">Kelola data aplikasi</p>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-person-lines-fill me-1"></i> Kelola Pengguna
                    </a>
                </div>
            </div>
        </div>

        {{-- Tabel Laporan Terbaru --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white border-0 pt-3 px-4">
                <h4 class="fw-semibold">5 Laporan Terbaru</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nama Barang</th>
                                <th>Status</th>
                                <th>Kategori</th>
                                <th>Dilaporkan Oleh</th>
                                <th>Tanggal</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporanTerbaru as $barang)
                                <tr>
                                    <td class="ps-4">
                                        <a href="{{ route('barang.show', $barang) }}"
                                            class="fw-medium text-decoration-none text-dark">
                                            {{ Str::limit($barang->nama, 30) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span
                                            class="badge rounded-pill 
                                        @if ($barang->status === 'hilang') bg-danger-soft text-danger-emphasis 
                                        @elseif($barang->status === 'ditemukan') bg-success-soft text-success-emphasis
                                        @else bg-secondary-soft text-secondary-emphasis @endif">
                                            {{ ucfirst($barang->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $barang->kategori->nama_kategori ?? 'N/A' }}</td>
                                    <td>{{ $barang->user->name ?? 'N/A' }}</td>
                                    <td>{{ $barang->created_at->format('d M Y') }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('barang.show', $barang) }}" class="btn btn-sm btn-outline-info"
                                            title="Lihat Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('barang.edit', $barang) }}"
                                            class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteBarangModal-admin-{{ $barang->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada laporan terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-center border-0 py-3">
                <a href="{{ route('barang.index') }}?status=">Lihat Semua Laporan &rarr;</a>
            </div>
        </div>

        {{-- Modal Hapus --}}
        @foreach ($laporanTerbaru as $barang)
            <div class="modal fade" id="deleteBarangModal-admin-{{ $barang->id }}" tabindex="-1"
                aria-labelledby="deleteBarangModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-3">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Yakin ingin menghapus laporan <strong>"{{ $barang->nama }}"</strong> secara permanen?
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary rounded-pill px-4"
                                data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <input type="hidden" name="source" value="admin_dashboard">
                                <button type="submit" class="btn btn-danger rounded-pill px-4">Ya, Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('styles')
    <style>
        .admin-dashboard-page .card {
            transition: transform 0.2s ease-in-out;
        }

        .admin-dashboard-page .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.06) !important;
        }

        .admin-dashboard-page .card .bi {
            transition: transform 0.2s ease;
        }

        .admin-dashboard-page .card:hover .bi {
            transform: scale(1.1);
        }

        .bg-danger-soft {
            background-color: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.15);
        }

        .text-danger-emphasis {
            color: #931f2c !important;
        }

        .bg-success-soft {
            background-color: rgba(25, 135, 84, 0.1);
            border: 1px solid rgba(25, 135, 84, 0.15);
        }

        .text-success-emphasis {
            color: #0f5132 !important;
        }

        .bg-secondary-soft {
            background-color: rgba(108, 117, 125, 0.1);
            border: 1px solid rgba(108, 117, 125, 0.15);
        }

        .text-secondary-emphasis {
            color: #495057 !important;
        }
    </style>
@endpush
