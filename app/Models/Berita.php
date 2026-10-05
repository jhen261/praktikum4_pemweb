<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'judul', 'slug', 'kategori', 'gambar', 'ringkasan',
        'isi', 'tags', 'penulis', 'dibaca', 'tanggal',
    ];

    protected $casts = ['tanggal' => 'date'];

    public function getDaftarTagAttribute(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $this->tags))));
    }
}