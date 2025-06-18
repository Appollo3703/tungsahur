<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'lokasi',
        'status',
        'user_id',
        'gambar',
        'kontak',
        'kategori_id' // Pastikan ini ada
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kategori (tunggal) - PASTIKAN NAMANYA 'kategori'
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
