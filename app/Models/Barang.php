<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'deskripsi', 'lokasi', 'status', 'user_id', 'gambar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
