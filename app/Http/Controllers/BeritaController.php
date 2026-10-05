<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public const KATEGORI = [
        'ekonomi', 'keuangan', 'kunjungan', 'Olahraga', 'pembangunan',
        'pemuda', 'Pendidikan', 'potensi', 'Prestasi dan Apresiasi',
        'tidak memiliki kategori',
    ];

    public function index(Request $request)
    {
        $berita = Berita::query()
            ->when($request->q, fn ($q, $v) => $q->where('judul', 'like', "%{$v}%"))
            ->when($request->kategori, fn ($q, $v) => $q->where('kategori', $v))
            ->orderBy('id')
            ->paginate(12)
            ->withQueryString();

        return view('berita.index', [
            'berita'   => $berita,
            'kategori' => self::KATEGORI,
        ]);
    }

    public function show(string $slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        $berita->increment('dibaca');
        $terkait = Berita::where('id', '!=', $berita->id)->latest('tanggal')->take(5)->get();

        return view('berita.show', compact('berita', 'terkait'));
    }

    public function create()
    {
        return view('berita.create', ['kategori' => self::KATEGORI]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => 'required|max:255',
            'kategori'  => 'required',
            'gambar'    => 'required|url',
            'ringkasan' => 'required',
            'isi'       => 'nullable',
            'tags'      => 'required',
            'tanggal'   => 'required|date',
        ]);
        $data['slug'] = Str::slug($data['judul']);

        Berita::create($data);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }
}