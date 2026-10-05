@extends('layouts.app')

@section('content')
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-4">
  {{-- SIDEBAR FILTER --}}
  <aside class="col-lg-3">
    <div class="card filter-card bg-white">
      <div class="card-header"><i class="bi bi-funnel-fill me-2"></i>Filter Berita</div>
      <div class="card-body p-4">
        <form method="GET" action="{{ route('berita.index') }}">
          <div class="mb-4">
            <label for="q">Kata Kunci</label>
            <input type="text" id="q" name="q" value="{{ request('q') }}"
                   class="form-control form-control-lg" placeholder="Cari berita...">
          </div>
          <div class="mb-4">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" class="form-select">
              <option value="">Semua Kategori</option>
              @foreach($kategori as $k)
                <option value="{{ $k }}" @selected(request('kategori') == $k)>{{ $k }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100 py-2 mb-2">Cari</button>
          <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </form>
      </div>
    </div>
  </aside>

  {{-- DAFTAR BERITA --}}
  <section class="col-lg-9">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
      @forelse($berita as $b)
        <div class="col">
          <article class="card card-berita h-100 bg-white">
            <a href="{{ route('berita.show', $b->slug) }}">
              <img class="cover" src="{{ $b->gambar }}" alt="{{ $b->judul }}">
            </a>
            <div class="card-body d-flex flex-column p-4">
              <div class="d-flex align-items-center gap-2 mb-3">
                <span class="badge badge-kat">{{ $b->kategori }}</span>
                <span class="tgl"><i class="bi bi-calendar3 me-1"></i>{{ $b->tanggal->translatedFormat('j M Y') }}</span>
              </div>

              <h5 class="judul mb-3">
                <a href="{{ route('berita.show', $b->slug) }}">{{ \Illuminate\Support\Str::limit($b->judul, 70) }}</a>
              </h5>

              <p class="ringkas mb-3">{{ $b->ringkasan }}...</p>

              <div class="mb-3">
                @foreach(array_slice($b->daftar_tag, 0, 3) as $t)
                  <a href="#" class="tag-pill">#{{ $t }}</a>
                @endforeach
              </div>

              <div class="mt-auto d-flex justify-content-between align-items-center">
                <span class="dibaca"><i class="bi bi-eye-fill me-1"></i>{{ number_format($b->dibaca) }}</span>
                <a href="{{ route('berita.show', $b->slug) }}" class="btn-baca">Baca <i class="bi bi-arrow-right ms-1"></i></a>
              </div>
            </div>
          </article>
        </div>
      @empty
        <div class="col-12"><p class="text-center text-muted py-5">Belum ada berita.</p></div>
      @endforelse
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-5">
      <small class="text-muted">
        Showing {{ $berita->firstItem() ?? 0 }} to {{ $berita->lastItem() ?? 0 }} of {{ $berita->total() }} results
      </small>
      {{ $berita->links() }}
    </div>
  </section>
</div>
@endsection