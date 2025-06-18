<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang; // Pastikan model Barang di-import

class UserDashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user(); // Mengambil data pengguna yang sedang login

        // Mengambil laporan barang milik pengguna dengan paginasi
        $laporanBarangs = Barang::where('user_id', $user->id)
            ->with('kategori') // Eager load kategori untuk efisiensi
            ->latest()         // Urutkan berdasarkan terbaru
            ->paginate(5);     // Misalnya 5 item per halaman, sesuaikan jika perlu

        // Mengambil statistik
        $totalLaporan = Barang::where('user_id', $user->id)->count();
        $totalAktif = Barang::where('user_id', $user->id)
            ->whereIn('status', ['hilang', 'ditemukan'])
            ->count();
        $totalSelesai = Barang::where('user_id', $user->id)
            ->where('status', 'selesai') // Asumsi Anda akan menambahkan status 'selesai'
            ->count();

        return view('dashboard', compact('user', 'laporanBarangs', 'totalLaporan', 'totalAktif', 'totalSelesai'));
    }
}
