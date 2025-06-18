<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Atau Auth::check(); jika hanya user login yang boleh
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'status' => ['required', Rule::in(['hilang', 'ditemukan'])],
            'kategori_id' => 'required|exists:kategoris,id', // Validasi untuk kategori tunggal
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // Batas 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_id.required' => 'Kategori barang harus dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            // Tambahkan pesan custom lain jika perlu
        ];
    }
}
