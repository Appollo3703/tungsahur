<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Kita akan butuh ini untuk berinteraksi dengan tabel users
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan halaman utama yang berisi daftar semua pengguna.
     */
    public function index()
    {
        // 1. Ambil semua data pengguna dari database, kecuali admin yang sedang login.
        // 2. withCount('barangs') akan menghitung berapa banyak laporan yang telah dibuat setiap pengguna.
        // 3. paginate(10) untuk menampilkan 10 pengguna per halaman.
        $users = User::where('id', '!=', Auth::id()) // Jangan tampilkan admin sendiri
            ->withCount('barangs')
            ->orderBy('name')
            ->paginate(10);

        // 4. Kirim data tersebut ke halaman view.
        return view('admin.user.index', compact('users'));
    }

    /**
     * Mengubah status admin seorang pengguna.
     */
    public function toggleAdmin(User $user)
    {
        // Untuk keamanan, pastikan admin tidak bisa mengubah statusnya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak dapat mengubah status admin diri sendiri.');
        }

        // Ubah status admin (jika true jadi false, jika false jadi true)
        $user->is_admin = !$user->is_admin;
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Status admin untuk pengguna ' . $user->name . ' berhasil diubah.');
    }

    /**
     * Menghapus pengguna.
     */
    public function destroy(User $user)
    {
        // Untuk keamanan, pastikan admin tidak bisa menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri dari sini.');
        }

        // Logika tambahan: Apa yang terjadi pada laporan barang milik pengguna yang dihapus?
        // Opsi 1 (Disarankan): Set user_id pada barang-barangnya menjadi NULL.
        // Ini memerlukan perubahan pada foreign key di migration tabel 'barangs'.
        // $user->barangs()->update(['user_id' => null]);

        // Opsi 2: Hapus semua laporan barang milik pengguna tersebut (HATI-HATI!).
        // foreach ($user->barangs as $barang) {
        //     if ($barang->gambar) {
        //         Storage::disk('public')->delete($barang->gambar);
        //     }
        //     $barang->delete();
        // }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'Pengguna "' . $userName . '" berhasil dihapus.');
    }
}
