<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@desa.test')->first();
        $editor = User::where('email', 'editor@desa.test')->first();

        $olahraga = Kategori::where('nama', 'Olahraga')->first();
        $pendidikan = Kategori::where('nama', 'Pendidikan')->first();
        $potensi = Kategori::where('nama', 'Potensi')->first();

        // Dibuat lewat relasi user: user_id terisi otomatis
        $b1 = $admin->beritas()->create([
            'judul' => 'Turnamen Voli Antar Dusun Resmi Dibuka',
            'slug' => 'turnamen-voli-antar-dusun-resmi-dibuka',
            'kategori_id' => $olahraga->id,
            'ringkasan' => 'Turnamen voli tahunan antar dusun resmi dibuka oleh kepala desa',
            'isi' => 'Turnamen voli tahunan antar dusun resmi dibuka oleh kepala desa...',
            'tanggal' => '2026-10-01',
        ]);
        $b2 = $editor->beritas()->create([
            'judul' => 'Sosialisasi Bank Sampah untuk Warga',
            'slug' => 'sosialisasi-bank-sampah-untuk-warga',
            'kategori_id' => $pendidikan->id,
            'ringkasan' => 'Pemerintah desa mengadakan sosialisasi pengelolaan sampah',
            'isi' => 'Pemerintah desa mengadakan sosialisasi pengelolaan sampah...',
            'tanggal' => '2026-10-02',
        ]);
        $b3 = $editor->beritas()->create([
            'judul' => 'Panen Raya Kelompok Wanita Tani',
            'slug' => 'panen-raya-kelompok-wanita-tani',
            'kategori_id' => $potensi->id,
            'ringkasan' => 'Kelompok wanita tani desa berhasil panen sayuran organik',
            'isi' => 'Kelompok wanita tani desa berhasil panen sayuran organik...',
            'tanggal' => '2026-10-03',
        ]);

        $b1->tags()->attach(Tag::whereIn('nama', ['desa', 'kegiatan'])->pluck('id'));
        $b2->tags()->attach(Tag::whereIn('nama', ['warga', 'lingkungan'])->pluck('id'));
        $b3->tags()->attach(Tag::whereIn('nama', ['desa', 'ekonomi'])->pluck('id'));
    }
}
