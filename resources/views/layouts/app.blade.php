<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Berita Desa — Jalatrang')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root{ --navy:#0d2a5c; --navy-dark:#0a1228; --indigo:#1a1f6b; --gold:#f5b301; }
        html{font-size:16px}
        body{font-family:'Roboto',sans-serif;font-size:1rem;background:#fff;color:#212529;-webkit-font-smoothing:antialiased}
        .font-cond{font-family:'Barlow Condensed',sans-serif}

        /* ===== NAVBAR ===== */
        .site-nav{background:var(--navy-dark);border-bottom:1px solid rgba(255,255,255,.08);
            padding:.5rem 1.25rem;position:sticky;top:0;z-index:1030}
        .brand-pill{display:flex;align-items:center;gap:.6rem;padding:.3rem .85rem .3rem .45rem;
            border:1px solid rgba(255,255,255,.18);border-radius:12px;background:rgba(255,255,255,.05);text-decoration:none}
        .brand-pill img{height:36px}
        .brand-pill .t1{font-family:'Barlow Condensed',sans-serif;font-weight:800;font-size:1.3rem;line-height:1;color:#fff}
        .brand-pill .t2{font-size:.72rem;color:#9aa4b8;letter-spacing:.5px;margin-top:2px}
        .site-nav .nav-link{font-family:'Barlow Condensed',sans-serif;font-weight:600;font-size:1.1rem;color:#fff;
            padding:.3rem .7rem;border-radius:999px;border:1px solid transparent}
        .site-nav .nav-link:hover{color:var(--gold)}
        .site-nav .nav-link.active{color:var(--gold);border-color:rgba(245,179,1,.6);
            background:rgba(245,179,1,.12);box-shadow:0 0 12px rgba(245,179,1,.25)}
        .dropdown-toggle::after{display:none}
        .home-btn{width:40px;height:40px;border-radius:50%;background:#4d1f2e;color:#fff;display:flex;
            align-items:center;justify-content:center;font-size:1.15rem;text-decoration:none}
        .grid-btn{width:42px;height:42px;border-radius:50%;border:1px solid rgba(245,179,1,.7);
            background:rgba(245,179,1,.12);color:var(--gold);display:flex;align-items:center;
            justify-content:center;font-size:1.3rem;text-decoration:none}
        .dropdown-menu{border-radius:12px;font-size:.95rem}

        /* ===== HERO ===== */
        .hero{background:linear-gradient(135deg,var(--navy) 0%,var(--indigo) 100%);color:#fff;padding:.9rem 0 3.5rem}
        .hero .breadcrumb{--bs-breadcrumb-divider-color:#8fa0c4;margin-bottom:.9rem;font-size:1.1rem}
        .hero .breadcrumb a{color:var(--gold);text-decoration:none}
        .hero .breadcrumb-item.active{color:#fff}
        .hero h1{font-family:'Barlow Condensed',sans-serif;font-weight:800;font-size:2.8rem;margin:0;line-height:1.1}
        .hero p{font-size:1.1rem;color:#cdd6ec;margin:.5rem 0 0}

        main.page{padding-top:3rem}
        @media (min-width:1400px){ .container{max-width:1320px} }

        /* ===== FILTER ===== */
        .filter-card{border:0;border-radius:14px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,.08)}
        aside > .filter-card{position:sticky;top:5.5rem}
        .filter-card .card-header{background:var(--navy);color:#fff;font-weight:700;font-size:1.2rem;padding:.85rem 1.25rem;border:0}
        .filter-card .card-body{padding:1.25rem !important}
        .filter-card label{font-weight:700;font-size:1rem;margin-bottom:.5rem}
        .filter-card .form-control,.filter-card .form-control-lg,.filter-card .form-select{
            font-size:1rem;padding:.6rem .85rem;border-radius:8px}
        .filter-card .btn{font-size:1rem}

        /* ===== KARTU BERITA ===== */
        .card-berita{border:0;border-radius:14px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,.08);
            transition:transform .25s ease,box-shadow .25s ease}
        .card-berita:hover{transform:translateY(-5px);box-shadow:0 10px 26px rgba(0,0,0,.14)}
        .card-berita img.cover{height:210px;object-fit:cover;width:100%;display:block}
        .card-berita .card-body{padding:1.25rem !important}
        .badge-kat{background:var(--navy);color:#fff;font-weight:700;font-size:.8rem;border-radius:7px;padding:.35rem .6rem}
        .tgl{color:#6c757d;font-size:.95rem}
        .card-berita .judul{font-weight:700;font-size:1.1rem;line-height:1.4}
        .card-berita .judul a{color:#212529;text-decoration:none}
        .card-berita .judul a:hover{color:var(--navy)}
        .ringkas{color:#6c757d;font-size:.95rem;line-height:1.55;
            display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
        .tag-pill{display:inline-block;background:#f1f3f5;color:#6c757d;border:1px solid #dee2e6;
            border-radius:7px;padding:.15rem .5rem;font-size:.8rem;text-decoration:none;margin:0 .35rem .25rem 0}
        .dibaca{color:#6c757d;font-size:.95rem}
        .dibaca i{color:#495057}
        .btn-baca{border:1px solid #0d6efd;color:#0d6efd;border-radius:8px;padding:.3rem .8rem;
            background:#fff;text-decoration:none;font-size:.9rem}
        .btn-baca:hover{background:#0d6efd;color:#fff}

        /* ===== FOOTER ===== */
        .site-footer{background:var(--navy-dark);color:#cdd6ec;padding:2.5rem 0 1.25rem;margin-top:3.5rem;font-size:.9rem}
        .site-footer h6{color:#fff;font-weight:700}
        .site-footer a{color:#cdd6ec;text-decoration:none}
        .site-footer a:hover{color:var(--gold)}

        @media (max-width:991px){
            .hero h1{font-size:2.2rem}
            aside > .filter-card{position:static}
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark site-nav">
  <div class="container-fluid">
    <a href="{{ route('berita.index') }}" class="brand-pill">
      <img src="https://jalatrang.id/assets/images/info_desa/logo.png" alt="Logo">
      <div>
        <div class="t1">PEMERINTAH DESA JALATRANG</div>
        <div class="t2">KECAMATAN CIPAKU KABUPATEN CIAMIS</div>
      </div>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuUtama">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="menuUtama">
      <ul class="navbar-nav align-items-lg-center gap-lg-1">
        <li class="nav-item me-lg-1"><a class="home-btn" href="{{ route('berita.index') }}"><i class="bi bi-house-fill"></i></a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Profil</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">VISI</a></li>
            <li><a class="dropdown-item" href="#">MISI</a></li>
            <li><a class="dropdown-item" href="#">Sejarah</a></li>
            <li><a class="dropdown-item" href="#">Struktural</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="#">Kependudukan</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('berita.index') }}">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Potensi Wisata</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">IDM & SDGs</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">IDM</a></li>
            <li><a class="dropdown-item" href="#">SDGs</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Ketahanan Pangan</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Statistik</a></li>
            <li><a class="dropdown-item" href="#">Galeri</a></li>
            <li><a class="dropdown-item" href="#">Top 10</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Keuangan</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">APBdes</a></li>
            <li><a class="dropdown-item" href="#">PBB</a></li>
            <li><a class="dropdown-item" href="#">Kegiatan</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Download</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Regulasi</a></li>
            <li><a class="dropdown-item" href="#">Materi</a></li>
          </ul>
        </li>
        <li class="nav-item ms-lg-2"><a class="grid-btn" href="#"><i class="bi bi-grid-3x3-gap-fill"></i></a></li>
      </ul>
    </div>
  </div>
</nav>

<header class="hero">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Beranda</a></li>
        <li class="breadcrumb-item active">@yield('crumb', 'Berita')</li>
      </ol>
    </nav>
    <h1>@yield('hero_judul', 'Berita & Informasi')</h1>
    <p>@yield('hero_sub', 'Informasi terkini dari Desa Jalatrang')</p>
  </div>
</header>

<main class="container page">
  @yield('content')
</main>

<footer class="site-footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="d-flex align-items-center gap-2 mb-2">
          <img src="https://jalatrang.id/assets/images/info_desa/logo.png" height="48" alt="Logo">
          <div class="font-cond fs-5 fw-bold text-white lh-1">PEMERINTAH DESA<br>JALATRANG</div>
        </div>
        <small>Jalan Raya Cipaku Nomor 181<br>Desa Jalatrang, Kecamatan Cipaku<br>Kabupaten Ciamis</small><br>
        <a href="#" class="btn btn-sm btn-outline-light mt-2">Lihat Peta</a>
      </div>
      <div class="col-6 col-lg-2">
        <h6>Menu</h6>
        <ul class="list-unstyled small">
          <li><a href="#">Beranda</a></li>
          <li><a href="{{ route('berita.index') }}">Berita</a></li>
          <li><a href="#">Struktural</a></li>
          <li><a href="#">APBDes</a></li>
          <li><a href="#">Prestasi</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-3">
        <h6>Link Terkait</h6>
        <ul class="list-unstyled small">
          <li><a href="https://kemendesa.go.id">Kemendesa</a></li>
          <li><a href="https://ciamis.go.id">Kab. Ciamis</a></li>
          <li><a href="https://jabar.go.id">Pemprov Jabar</a></li>
          <li><a href="#">Panel Admin</a></li>
        </ul>
      </div>
      <div class="col-lg-3">
        <h6>Media Sosial</h6>
        <div class="d-flex gap-3 fs-5">
          <a href="https://x.com"><i class="bi bi-twitter-x"></i></a>
          <a href="https://facebook.com"><i class="bi bi-facebook"></i></a>
          <a href="https://www.youtube.com/@jalatrangTV"><i class="bi bi-youtube"></i></a>
          <a href="https://instagram.com/pemerintahdesajalatrang"><i class="bi bi-instagram"></i></a>
        </div>
      </div>
    </div>
    <hr class="border-secondary mt-4">
    <small>© 2026 Pemerintah Desa Jalatrang — Semua hak dilindungi.</small>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>