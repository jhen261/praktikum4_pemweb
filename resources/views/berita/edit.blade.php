@extends('layouts.app')

@section('title', 'Edit Berita')
@section('crumb', 'Edit Berita')
@section('hero_judul', 'Edit Berita')
@section('hero_sub', 'Perbarui data berita')

@section('content')
<div class="card filter-card bg-white" style="max-width:760px">
  <div class="card-header">Form Edit Berita</div>
  <div class="card-body p-4">
    @if ($errors->any())
      <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('berita.update', $berita) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <input name="judul" class="form-control mb-3" placeholder="Judul" value="{{ old('judul', $berita->judul) }}">

      <select name="kategori_id" class="form-select mb-3">
        <option value="">-- Pilih Kategori --</option>
        @foreach ($kategoris as $k)
          <option value="{{ $k->id }}"
              @selected(old('kategori_id', $berita->kategori_id) == $k->id)>{{ $k->nama }}</option>
        @endforeach
      </select>

      <div class="mb-3">
        <label for="gambar" class="form-label fw-semibold">Gambar</label>
        @if ($berita->gambar_url)
          <div>
            <img src="{{ $berita->gambar_url }}" class="img-thumbnail mb-2" style="max-height:140px;" alt="">
          </div>
        @endif
        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
        <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
      </div>

      <textarea name="ringkasan" class="form-control mb-3" placeholder="Ringkasan">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
      <textarea name="isi" rows="5" class="form-control mb-3" placeholder="Isi">{{ old('isi', $berita->isi) }}</textarea>

      <div class="mb-3">
        <label class="form-label fw-semibold d-block">Tag</label>
        @foreach ($tags as $tag)
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="tags[]"
                   id="tag{{ $tag->id }}" value="{{ $tag->id }}"
                   @checked(in_array($tag->id, old('tags', $berita->tags->pluck('id')->toArray())))>
            <label class="form-check-label" for="tag{{ $tag->id }}">#{{ $tag->nama }}</label>
          </div>
        @endforeach
      </div>

      <input type="date" name="tanggal" class="form-control mb-4"
             value="{{ old('tanggal', $berita->tanggal?->format('Y-m-d')) }}">
      <button class="btn btn-primary">Perbarui</button>
      <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
