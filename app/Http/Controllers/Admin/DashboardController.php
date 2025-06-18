<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;
use App\Models\Kategori; // Import Kategori
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data untuk statistik
        $totalPengguna = User::count();
        $totalLaporan = Barang::count();
        $laporanTerbaru = Barang::latest()->take(5)->with(['user', 'kategori'])->get(); // 5 laporan terbaru
        $laporanPerHari = Barang::whereDate('created_at', Carbon::today())->count();
        $totalKategori = Kategori::count();

        return view('admin.dashboard', compact(
            'totalPengguna',
            'totalLaporan',
            'laporanTerbaru',
            'laporanPerHari',
            'totalKategori'
        ));
    }
}
