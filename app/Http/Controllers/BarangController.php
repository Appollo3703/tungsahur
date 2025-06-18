<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query()->with(['user', 'kategori']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $statusFilter = $request->input('status', 'aktif');

        if ($statusFilter === 'aktif') {
            $query->whereIn('status', ['hilang', 'ditemukan']);
        } elseif (in_array($statusFilter, ['hilang', 'ditemukan', 'selesai'])) {
            $query->where('status', $statusFilter);
        }
        // Jika statusFilter adalah string kosong (dari opsi "Semua"), tidak ada filter status tambahan.

        if ($request->filled('kategori')) {
            $kategoriSlug = $request->kategori;
            $query->whereHas('kategori', function ($q) use ($kategoriSlug) {
                $q->where('slug', $kategoriSlug);
            });
        }

        $barangs = $query->latest()->paginate(9)->appends($request->query());
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('barang.index', compact('barangs', 'kategoris'));
    }

    public function create(Request $request)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        // Simpan URL asal (dari mana tombol "Laporkan Barang" diklik)
        $redirectAfterStore = $request->query('from', route('barang.index'));
        return view('barang.create', compact('kategoris', 'redirectAfterStore'));
    }

    public function store(StoreBarangRequest $request)
    {
        $validatedData = $request->validated();
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar-barang', 'public');
        }

        $barangData = array_merge($validatedData, [
            'user_id' => Auth::id(),
            'gambar' => $gambarPath,
        ]);

        Barang::create($barangData);

        $message = 'Laporan barang berhasil ditambahkan!';
        // Ambil URL redirect dari input tersembunyi
        $redirectUrl = $request->input('_redirect_to_after_action', route('barang.index'));

        // Validasi sederhana untuk URL redirect
        if (!Str::startsWith($redirectUrl, url('/')) && !Route::has(parse_url($redirectUrl, PHP_URL_PATH))) {
            $redirectUrl = route('barang.index');
        }

        return redirect($redirectUrl)->with('success', $message);
    }

    public function show(Barang $barang)
    {
        $barang->load(['user', 'kategori']);
        return view('barang.show', compact('barang'));
    }

    public function edit(Request $request, Barang $barang)
    {
        $this->authorizeOwner($barang);
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        // Tentukan URL redirect setelah update, prioritaskan 'from_page' dari query
        $redirectAfterUpdate = $request->query('from_page', URL::previous());
        // Fallback jika URL::previous() adalah halaman edit itu sendiri
        if (str_contains($redirectAfterUpdate, route('barang.edit', $barang->id, false))) {
            // Jika query 'from_page' ada dan valid (dashboard atau barang.index), gunakan itu
            if ($request->query('from_page') && (str_contains($request->query('from_page'), route('dashboard', [], false)) || str_contains($request->query('from_page'), route('barang.index', [], false)))) {
                $redirectAfterUpdate = $request->query('from_page');
            } else {
                $redirectAfterUpdate = route('barang.show', $barang->id); // Default ke show jika loop
            }
        }

        return view('barang.edit', compact('barang', 'kategoris', 'redirectAfterUpdate'));
    }

    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $this->authorizeOwner($barang);
        $validatedData = $request->validated();

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
            $validatedData['gambar'] = $request->file('gambar')->store('gambar-barang', 'public');
        }

        if (isset($validatedData['status']) && $validatedData['status'] === 'selesai') {
            unset($validatedData['status']);
        }

        $barang->update($validatedData);
        $message = 'Laporan barang berhasil diupdate.';

        $redirectUrl = $request->input('_redirect_to_after_action', route('barang.show', $barang->id));

        if (!Str::startsWith($redirectUrl, url('/')) || str_contains($redirectUrl, route('barang.edit', $barang->id, false))) {
            $redirectUrl = route('barang.show', $barang->id);
        }

        return redirect($redirectUrl)->with('success', $message);
    }

    public function ubahStatus(Request $request, Barang $barang)
    {
        $this->authorizeOwner($barang);

        if ($barang->status === 'selesai') {
            return redirect()->back()->with('error', 'Laporan yang sudah selesai tidak dapat diubah statusnya lagi.');
        }

        $barang->status = $barang->status === 'hilang' ? 'ditemukan' : 'hilang';
        $barang->save();
        $message = 'Status barang berhasil diubah menjadi ' . ucfirst($barang->status) . '.';

        $redirectUrl = $request->input('_redirect_to_after_action', URL::previous());
        if (!Str::startsWith($redirectUrl, url('/')) || str_contains($redirectUrl, '/edit')) {
            $redirectUrl = (str_contains(URL::previous(), route('dashboard', [], false))) ? route('dashboard') : route('barang.index');
        }

        return redirect($redirectUrl)->with('success', $message);
    }

    public function tandaiSelesai(Request $request, Barang $barang)
    {
        $this->authorizeOwner($barang);

        if ($barang->status === 'selesai') {
            return redirect()->back()->with('info', 'Laporan ini sudah ditandai selesai.');
        }

        $barang->status = 'selesai';
        $barang->save();
        $message = 'Laporan barang "' . Str::limit($barang->nama, 30) . '" telah ditandai sebagai selesai.';

        $redirectUrl = $request->input('_redirect_to_after_action', URL::previous());
        if (!Str::startsWith($redirectUrl, url('/')) || str_contains($redirectUrl, '/edit')) {
            $redirectUrl = (str_contains(URL::previous(), route('dashboard', [], false))) ? route('dashboard') : route('barang.index');
        }

        return redirect($redirectUrl)->with('success', $message);
    }

    public function destroy(Request $request, Barang $barang) // <-- TAMBAHKAN Request $request
    {
        // Otorisasi untuk admin atau pemilik
        if (Auth::check() && Auth::user()->is_admin) {
            // Admin boleh hapus
        } else {
            // Jika bukan admin, cek kepemilikan
            $this->authorizeOwner($barang);
        }

        // Hapus gambar
        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        $message = 'Laporan barang berhasil dihapus.';

        // --- LOGIKA REDIRECT BARU ---
        // Cek apakah permintaan datang dari halaman dashboard admin
        if ($request->input('source') === 'admin_dashboard') {
            return redirect()->route('admin.dashboard')->with('success', $message);
        }

        // Cek apakah permintaan datang dari halaman dashboard pengguna biasa
        if ($request->input('source') === 'dashboard') {
            return redirect()->route('dashboard')->with('success', $message);
        }

        // Default redirect ke halaman daftar barang jika tidak ada source
        return redirect()->route('barang.index')->with('success', $message);
    }

    private function authorizeOwner(Barang $barang): void
    {
        if ($barang->user_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan untuk melakukan tindakan ini pada laporan barang milik orang lain.');
        }
    }
}
