@extends('layouts.app')

@section('title', 'Tambah Berita')
@section('crumb', 'Tambah Berita')
@section('hero_judul', 'Tambah Berita')
@section('hero_sub', 'Isi formulir untuk menambahkan berita baru')

@section('content')
<div class="card filter-card bg-white" style="max-width:760px">
  <div class="card-header">Form Berita</div>
  <div class="card-body p-4">
    @if($errors->any())
      <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('berita.store') }}">
      @csrf
      <input name="judul" class="form-control mb-3" placeholder="Judul" value="{{ old('judul') }}">
      <select name="kategori" class="form-select mb-3">
        @foreach($kategori as $k)<option>{{ $k }}</option>@endforeach
      </select>
      <input name="gambar" class="form-control mb-3" placeholder="URL gambar" value="{{ old('gambar') }}">
      <textarea name="ringkasan" class="form-control mb-3" placeholder="Ringkasan">{{ old('ringkasan') }}</textarea>
      <textarea name="isi" rows="5" class="form-control mb-3" placeholder="Isi">{{ old('isi') }}</textarea>
      <input name="tags" class="form-control mb-3" placeholder="tag1,tag2,tag3" value="{{ old('tags') }}">
      <input type="date" name="tanggal" class="form-control mb-4" value="{{ old('tanggal') }}">
      <button class="btn btn-primary">Simpan</button>
      <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection