<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
        }

        if ($request->filled('status') && in_array($request->status, ['hilang', 'ditemukan'])) {
            $query->where('status', $request->status);
        }

        $barangs = $query->latest()->paginate(10)->appends($request->query());

        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'kontak' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar-barang', 'public');
        }

        Barang::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'kontak' => $request->kontak,
            'status' => 'hilang',
            'user_id' => Auth::id(),
            'gambar' => $gambarPath,
        ]);
        

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit(Barang $barang)
    {
        $this->authorizeOwner($barang);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $this->authorizeOwner($barang);

        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'kontak' => 'nullable|string|max:255',
            'status' => 'required|in:hilang,ditemukan',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
            $barang->gambar = $request->file('gambar')->store('gambar-barang', 'public');
        }

        $barang->nama = $request->nama;
        $barang->deskripsi = $request->deskripsi;
        $barang->lokasi = $request->lokasi;
        $barang->kontak = $request->kontak;
        $barang->status = $request->status;
        $barang->save();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate');
    }

    public function destroy(Barang $barang)
    {
        $this->authorizeOwner($barang);

        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }

    public function show(Barang $barang)
    {
        $barang->load('user');
        return view('barang.show', compact('barang'));
    }

    public function ubahStatus(Barang $barang)
    {
        $this->authorizeOwner($barang);

        $barang->status = $barang->status === 'hilang' ? 'ditemukan' : 'hilang';
        $barang->save();

        return redirect()->route('barang.index')->with('success', 'Status barang berhasil diubah.');
    }

    private function authorizeOwner(Barang $barang)
    {
        if ($barang->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak diizinkan mengakses barang ini.');
        }
    }
}
