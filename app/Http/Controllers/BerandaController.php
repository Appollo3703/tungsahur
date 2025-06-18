<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    /**
     * Menampilkan halaman beranda.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $barangs = Barang::where('status', '!=', 'selesai') // Hanya tampilkan barang yang belum selesai
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('barangs'/*, 'kategorisForForm'*/));
    }
}
