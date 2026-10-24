<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $beritas = Berita::with(['kategori', 'tags', 'user'])
            ->when($request->kata_kunci, function ($q, $kata) {
                $q->where('judul', 'like', "%{$kata}%");
            })
            ->when($request->kategori, function ($q, $id) {
                $q->where('kategori_id', $id);
            })
            ->when($request->tag, function ($q, $id) {
                $q->whereHas('tags', fn ($t) => $t->where('tags.id', $id));
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $kategoris = Kategori::orderBy('nama')->get();

        return view('berita.index', compact('beritas', 'kategoris'));
    }

    public function show(Berita $berita)
    {
        $berita->increment('dibaca');
        $berita->load(['kategori', 'tags', 'user']);
        $terkait = Berita::where('id', '!=', $berita->id)->latest()->take(5)->get();

        return view('berita.show', compact('berita', 'terkait'));
    }

    public function create()
    {
        return view('berita.create', [
            'kategoris' => Kategori::orderBy('nama')->get(),
            'tags' => Tag::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan());

        $data['slug'] = $this->buatSlug($data['judul']);
        $data['ringkasan'] = $data['ringkasan'] ?? Str::limit(strip_tags($data['isi']), 150);
        $data['tanggal'] = $data['tanggal'] ?? now()->toDateString();

        if ($request->hasFile('gambar')) {
            // tersimpan di storage/app/public/berita/xxxx.jpg
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        // user_id terisi otomatis dari akun yang login
        $berita = $request->user()->beritas()->create(Arr::except($data, 'tags'));
        $berita->tags()->sync($data['tags'] ?? []);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit(Berita $berita)
    {
        return view('berita.edit', [
            'berita' => $berita->load('tags'),
            'kategoris' => Kategori::orderBy('nama')->get(),
            'tags' => Tag::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $request->validate($this->aturan());

        $data['ringkasan'] = $data['ringkasan'] ?? Str::limit(strip_tags($data['isi']), 150);
        $data['tanggal'] = $data['tanggal'] ?? ($berita->tanggal?->toDateString() ?? now()->toDateString());

        if ($request->hasFile('gambar')) {
            $this->hapusGambar($berita);
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        } else {
            // tidak ada upload baru: jangan timpa gambar lama dengan null
            unset($data['gambar']);
        }

        $berita->update(Arr::except($data, 'tags'));
        $berita->tags()->sync($data['tags'] ?? []);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Berita $berita)
    {
        $this->hapusGambar($berita);
        $berita->delete();

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil dihapus!');
    }

    private function aturan(): array
    {
        return [
            'judul' => 'required|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'ringkasan' => 'nullable|max:500',
            'isi' => 'required|min:10',
            'tanggal' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }

    private function buatSlug(string $judul): string
    {
        $slug = Str::slug($judul);

        if (Berita::where('slug', $slug)->exists()) {
            $slug .= '-'.Str::lower(Str::random(5));
        }

        return $slug;
    }

    // Hanya file hasil upload yang dihapus, gambar berupa URL dibiarkan
    private function hapusGambar(Berita $berita): void
    {
        if ($berita->gambar && ! Str::startsWith($berita->gambar, ['http://', 'https://'])) {
            Storage::disk('public')->delete($berita->gambar);
        }
    }
}
