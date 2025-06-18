<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Tambahkan otorisasi jika perlu, misal memastikan user adalah pemilik barang
        // $barang = $this->route('barang');
        // return $barang && $this->user()->can('update', $barang);
        return true;
    }
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'status' => ['required', Rule::in(['hilang', 'ditemukan'])],
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // Maks 5MB
        ];
    }
    public function messages(): array
    {
        return [
            'kategori_ids.required' => 'Setidaknya satu kategori harus dipilih.',
            'kategori_ids.*.exists' => 'Kategori yang dipilih tidak valid.',
        ];
    }
}
