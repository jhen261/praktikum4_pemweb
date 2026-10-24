<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $fillable = [
        'judul', 'slug', 'kategori_id', 'gambar',
        'ringkasan', 'isi', 'tanggal', 'dibaca',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Alamat berita memakai slug, contoh: /berita/judul-berita
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Gambar bisa berupa URL penuh atau path hasil upload di storage/public
    public function getGambarUrlAttribute(): ?string
    {
        if (! $this->gambar) {
            return null;
        }

        return Str::startsWith($this->gambar, ['http://', 'https://'])
            ? $this->gambar
            : asset('storage/'.$this->gambar);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
