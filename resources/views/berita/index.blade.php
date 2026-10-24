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
        <form action="{{ route('berita.index') }}" method="GET">
          <input type="text" name="kata_kunci" class="form-control mb-3"
                 placeholder="Cari judul..." value="{{ request('kata_kunci') }}">

          <select name="kategori" class="form-select mb-3">
            <option value="">Semua Kategori</option>
            @foreach ($kategoris as $k)
              <option value="{{ $k->id }}" @selected(request('kategori') == $k->id)>{{ $k->nama }}</option>
            @endforeach
          </select>

          <button type="submit" class="btn btn-primary w-100 py-2 mb-2">Cari</button>
          <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </form>

        @auth
          <a href="{{ route('berita.create') }}" class="btn btn-success w-100 mt-3">+ Tambah Berita</a>
        @endauth
      </div>
    </div>
  </aside>

  {{-- DAFTAR BERITA --}}
  <section class="col-lg-9">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
      @forelse ($beritas as $berita)
        <div class="col">
          <article class="card card-berita h-100 bg-white">
            @if ($berita->gambar_url)
              <a href="{{ route('berita.show', $berita) }}">
                <img class="cover" src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}">
              </a>
            @endif
            <div class="card-body d-flex flex-column p-4">
              <div class="mb-2">
                <span class="badge badge-kategori text-white bg-primary">{{ $berita->kategori->nama }}</span>
              </div>

              <h5 class="judul mb-3">
                <a href="{{ route('berita.show', $berita) }}">{{ \Illuminate\Support\Str::limit($berita->judul, 70) }}</a>
              </h5>

              <p class="ringkas mb-3">{{ \Illuminate\Support\Str::limit($berita->ringkasan ?: strip_tags($berita->isi), 100) }}</p>

              <div class="mb-2">
                @foreach ($berita->tags as $tag)
                  <a href="{{ route('berita.index', ['tag' => $tag->id]) }}"
                     class="tag-pill text-decoration-none">#{{ $tag->nama }}</a>
                @endforeach
              </div>

              <div class="mt-auto d-flex justify-content-between align-items-center">
                <span class="dibaca"><i class="bi bi-eye-fill me-1"></i>{{ number_format($berita->dibaca) }}</span>
                <a href="{{ route('berita.show', $berita) }}" class="btn-baca">Baca <i class="bi bi-arrow-right ms-1"></i></a>
              </div>

              @auth
                <div class="mt-2 pt-2 border-top d-flex gap-2">
                  <a href="{{ route('berita.edit', $berita) }}"
                     class="btn btn-sm btn-outline-warning">Edit</a>

                  @if (auth()->user()->isAdmin())
                    <form action="{{ route('berita.destroy', $berita) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus berita ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                  @endif
                </div>
              @endauth
            </div>
          </article>
        </div>
      @empty
        <div class="col-12"><p class="text-center text-muted py-5">Belum ada berita.</p></div>
      @endforelse
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-5">
      <small class="text-muted">
        Showing {{ $beritas->firstItem() ?? 0 }} to {{ $beritas->lastItem() ?? 0 }} of {{ $beritas->total() }} results
      </small>
      {{ $beritas->links() }}
    </div>
  </section>
</div>
@endsection
