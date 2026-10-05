@extends('layouts.app')

@section('title', $berita->judul . ' — Desa Jalatrang')
@section('crumb', 'Detail Berita')

@section('content')
<div class="row g-4">
  <div class="col-lg-8">
    <article class="card card-berita bg-white">
      <img src="{{ $berita->gambar }}" alt="{{ $berita->judul }}" style="width:100%;max-height:480px;object-fit:cover">
      <div class="card-body p-4">
        <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
          <span class="badge badge-kat">{{ $berita->kategori }}</span>
          <span class="tgl"><i class="bi bi-calendar3 me-1"></i>{{ $berita->tanggal->translatedFormat('j M Y') }}</span>
          <span class="tgl"><i class="bi bi-person me-1"></i>{{ $berita->penulis }}</span>
          <span class="tgl"><i class="bi bi-eye-fill me-1"></i>{{ number_format($berita->dibaca) }}</span>
        </div>
        <h2 class="fw-bold mb-3">{{ $berita->judul }}</h2>
        <div class="mb-4">{!! nl2br(e($berita->isi)) !!}</div>
        <div class="mb-4">
          @foreach($berita->daftar_tag as $t)
            <a href="#" class="tag-pill">#{{ $t }}</a>
          @endforeach
        </div>
        <a href="{{ route('berita.index') }}" class="btn-baca"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
      </div>
    </article>
  </div>

  <aside class="col-lg-4">
    <div class="card filter-card bg-white">
      <div class="card-header">Berita Terkait</div>
      <div class="card-body">
        @foreach($terkait as $t)
          <a href="{{ route('berita.show', $t->slug) }}" class="d-flex gap-3 mb-3 text-decoration-none text-dark">
            <img src="{{ $t->gambar }}" width="90" height="68" style="object-fit:cover;border-radius:8px" alt="">
            <div>
              <div class="fw-bold small">{{ \Illuminate\Support\Str::limit($t->judul, 50) }}</div>
              <small class="text-muted">{{ $t->tanggal->translatedFormat('j M Y') }}</small>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </aside>
</div>
@endsection