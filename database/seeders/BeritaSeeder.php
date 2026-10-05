<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $img = 'https://jalatrang.id/assets/images/web_berita/';

        Berita::create([
            'judul'     => 'Malam Penuh Gengsi Dimulai! 16 Tim Berebut Mahkota Juara di Ajang CVC Cup 2026 Desa Jalatrang',
            'slug'      => 'malam-penuh-gengsi-dimulai-16-tim-berebut-mahkota-juara-di-ajang-cvc-cup-2026-desa-jalatrang',
            'kategori'  => 'Olahraga',
            'gambar'    => $img . '1790662317-whatsapp-image-2026-09-27-at-081321.jpeg',
            'ringkasan' => 'JalatrangNews; Himpunan Pemuda-Pemudi Dusun Cikandung yang tergabung dalam Cikandung Voli',
            'isi'       => 'TEMPEL ISI LENGKAP dari halaman detail berita di jalatrang.id',
            'tags'      => 'cikandung,dusun,2026,voli,desa,jalatrang,cipaku,hingga,kecamatan,malam',
            'penulis'   => 'Dadi Haryadi',
            'dibaca'    => 369,
            'tanggal'   => '2026-09-26',
        ]);

        Berita::create([
            'judul'     => 'Pemerintah Desa Jalatrang Kukuhkan Desa Siaga TB, Perkuat Kolaborasi Lintas Sektor Basmi Tuberkulosis',
            'slug'      => 'pemerintah-desa-jalatrang-kukuhkan-desa-siaga-tb-perkuat-kolaborasi-lintas-sektor-basmi-tuberkulosis',
            'kategori'  => 'Pendidikan',
            'gambar'    => $img . '1790660451-whatsapp-image-2026-09-28-at-102755.jpeg',
            'ringkasan' => 'JalatrangNews; Pemerintah Desa Jalatrang, Kecamatan Cipaku, Kabupaten Ciamis, menunjukkan',
            'isi'       => 'TEMPEL ISI LENGKAP dari halaman detail berita di jalatrang.id',
            'tags'      => 'desa,jalatrang,siaga',
            'penulis'   => 'Pemerintah Desa Jalatrang',
            'dibaca'    => 143,
            'tanggal'   => '2026-09-28',
        ]);
    }
}