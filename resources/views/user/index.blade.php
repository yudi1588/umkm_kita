@extends('layouts.app')

@section('title', 'Beranda - UMKM Kita')

@section('content')

<section class="home-banner">
    <div class="home-container">
        <div class="home-text">
            <span>SELAMAT DATANG DI UMKM KITA</span>
            <h1>Temukan Kebutuhan Anda dengan Mudah</h1>
            <p>
                UMKM Kita hadir sebagai platform yang menghubungkan pelaku Usaha Mikro, 
                Kecil, dan Menengah (UMKM) dengan masyarakat untuk memperkenalkan produk lokal, 
                memperluas jangkauan pemasaran, serta mendukung pertumbuhan ekonomi masyarakat.
            </p>
            <a href="{{ route('products') }}" class="btn-shop">Belanja Sekarang</a>
        </div>

        <div class="home-image">
            <img src="{{ asset('assets/user/img/bannerUMKM.png') }}"
                 alt="Banner UMKM Kita">
        </div>
    </div>
</section>


<!-- BAR KATEGORI DAN PENCARIAN -->
<section class="category-search">
    <div class="category-search-container">

<!-- NAVIGASI KATEGORI -->
<div class="category-navigation">

    <h3><span>Produk</span> Kategori</h3>

    <div class="kategori-slider-wrapper">

        <button type="button"
                class="category-arrow"
                id="prevCategory">
            &#10094;
        </button>

        <div class="kategori-slider" id="categoryScroll">
            <a href="#">Makanan & Kuliner</a>
            <a href="#">Fashion & Pakaian</a>
            <a href="#">Oleh-Oleh Khas Jember</a>
            <a href="#">Kerajinan & Craft</a>
            <a href="#">Kecantikan & Perawatan</a>
            <a href="#">Perlengkapan Rumah Tangga</a>
            <a href="#">Elektronik & Peralatan Komputer</a>
            <a href="#">Pertanian</a>
            <a href="#">Furnitur</a>
            <a href="#">Jasa</a>
        </div>

        <button type="button"
                class="category-arrow"
                id="nextCategory">
            &#10095;
        </button>

    </div>

</div>


        <!-- PENCARIAN PRODUK -->
        <div class="product-search">
            <h3><span>Cari</span> Produk</h3>

            <form action="{{ route('products') }}" method="GET">
                <input type="text"
                       name="q"
                       placeholder="Cari produk..."
                       value="{{ request('q') }}">

                <button type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>

    </div>
</section>


<!-- KATEGORI PRODUK -->
<section class="home-category">
    <div class="home-container">

        <div class="category-heading">
            <span>KATEGORI UMKM</span>
            <h2>Jelajahi Produk Lokal</h2>
            <p>
                Temukan beragam produk unggulan dari pelaku UMKM lokal.
            </p>
        </div>

        <div class="category-list">

            <a href="{{ route('products', ['category' => 'kuliner']) }}" class="category-card">
                <div class="category-icon">
                    <i class="fa fa-cutlery"></i>
                </div>
                <h3>Makanan & Minuman</h3>
                <p>Produk kuliner khas dan olahan lokal.</p>
            </a>

            <a href="{{ route('products', ['category' => 'fashion']) }}" class="category-card">
                <div class="category-icon">
                    <i class="fa fa-shopping-bag"></i>
                </div>
                <h3>Fashion</h3>
                <p>Pakaian, aksesoris, dan produk fashion.</p>
            </a>

            <a href="{{ route('products', ['category' => 'kerajinan']) }}" class="category-card">
                <div class="category-icon">
                    <i class="fa fa-gift"></i>
                </div>
                <h3>Kerajinan</h3>
                <p>Kerajinan tangan dan produk kreatif.</p>
            </a>

            <a href="{{ route('products', ['category' => 'pertanian']) }}" class="category-card">
                <div class="category-icon">
                    <i class="fa fa-leaf"></i>
                </div>
                <h3>Pertanian</h3>
                <p>Hasil pertanian dan produk olahan.</p>
            </a>

        </div>
    </div>
</section>


<!-- DAFTAR MITRA UMKM -->
<section class="partner-section">
    <div class="home-container">

        <div class="partner-heading">
            <div class="partner-label">
                <span></span>
                DAFTAR MITRA
            </div>

            <h2>Katalog UMKM Binaan</h2>

            <p>
                Potensi unggulan daerah yang telah terverifikasi.
            </p>
        </div>

        <div class="partner-list">

            <!-- MITRA 1 -->
            <div class="partner-card">

    <div class="partner-image">

        <!-- FOTO SAMPUL -->
        <img
            src="{{ asset('assets/user/img/sampulusaha/1.jpeg') }}"
            alt="Sampul Dapur Kreatif"
            class="partner-cover"
        >

        <!-- FOTO PROFIL -->
        <div class="partner-profile">
            <img
                src="{{ asset('assets/user/img/profilusaha/1.jpeg') }}"
                alt="Profil Dapur Kreatif"
                class="partner-avatar"
            >
        </div>

        <!-- STATUS VERIFIKASI -->
        <span class="verified-badge">
            <i class="fa fa-check-circle"></i> Terverifikasi
        </span>

    </div>

    <div class="partner-info">

        <span class="partner-category">Makanan & Minuman</span>

        <h3>Dapur Kreatif</h3>

        <p>
            <i class="fa fa-map-marker"></i>
            Kaliwates, Jember
        </p>

        <a href="#" class="partner-link">
            Lihat Profil <i class="fa fa-arrow-right"></i>
        </a>

    </div>

</div>

          
<!-- MITRA 2 -->
<div class="partner-card">
    <div class="partner-image">

        <!-- FOTO SAMPUL -->
        <img
            src="{{ asset('assets/user/img/sampulusaha/2.jpeg') }}"
            alt="Sampul Karya Rakyat"
            class="partner-cover"
        >

        <!-- FOTO PROFIL -->
        <div class="partner-profile">
            <img
                src="{{ asset('assets/user/img/profilusaha/2.jpeg') }}"
                alt="Profil Karya Rakyat"
                class="partner-avatar"
            >
        </div>

        <!-- STATUS VERIFIKASI -->
        <span class="verified-badge">
            <i class="fa fa-check-circle"></i> Terverifikasi
        </span>

    </div>

    <div class="partner-info">
        <span class="partner-category">Kerajinan</span>

        <h3>Karya Rakyat</h3>

        <p>
            <i class="fa fa-map-marker"></i>
            Ambulu, Jember
        </p>

        <a href="#" class="partner-link">
            Lihat Profil <i class="fa fa-arrow-right"></i>
        </a>
    </div>
</div>


<!-- MITRA 3 -->
<div class="partner-card">
    <div class="partner-image">

        <!-- FOTO SAMPUL -->
        <img
            src="{{ asset('assets/user/img/sampulusaha/5.jpeg') }}"
            alt="Sampul Batik Sejahtera"
            class="partner-cover"
        >

        <!-- FOTO PROFIL -->
        <div class="partner-profile">
            <img
                src="{{ asset('assets/user/img/profilusaha/3.jpg') }}"
                alt="Profil Batik Sejahtera"
                class="partner-avatar"
            >
        </div>

        <!-- STATUS VERIFIKASI -->
        <span class="verified-badge">
            <i class="fa fa-check-circle"></i> Terverifikasi
        </span>

    </div>

    <div class="partner-info">
        <span class="partner-category">Makanan</span>

        <h3>Jawara Telur</h3>

        <p>
            <i class="fa fa-map-marker"></i>
            Patrang, Jember
        </p>

        <a href="#" class="partner-link">
            Lihat Profil <i class="fa fa-arrow-right"></i>
        </a>
    </div>
</div>


<!-- MITRA 4 -->
<div class="partner-card">
    <div class="partner-image">

        <!-- FOTO SAMPUL -->
        <img
            src="{{ asset('assets/user/img/sampulusaha/4.jpeg') }}"
            alt="Sampul Dapur Kreatif"
            class="partner-cover"
        >

        <!-- FOTO PROFIL -->
        <div class="partner-profile">
            <img
                src="{{ asset('assets/user/img/profilusaha/4.jpeg') }}"
                alt="Profil Dapur Kreatif"
                class="partner-avatar"
            >
        </div>

        <!-- STATUS VERIFIKASI -->
        <span class="verified-badge">
            <i class="fa fa-check-circle"></i> Terverifikasi
        </span>

    </div>

    <div class="partner-info">
        <span class="partner-category">Makanan & Minuman</span>

        <h3>Dapur Kreatif</h3>

        <p>
            <i class="fa fa-map-marker"></i>
            Panti, Jember
        </p>

        <a href="#" class="partner-link">
            Lihat Profil <i class="fa fa-arrow-right"></i>
        </a>
    </div>
</div>


<!-- MITRA 5 -->
<div class="partner-card">
    <div class="partner-image">

        <!-- FOTO SAMPUL -->
        <img
            src="{{ asset('assets/user/img/sampulusaha/3.jpeg') }}"
            alt="Sampul Karya Rakyat"
            class="partner-cover"
        >

        <!-- FOTO PROFIL -->
        <div class="partner-profile">
            <img
                src="{{ asset('assets/user/img/profilusaha/5.jpeg') }}"
                alt="Profil Karya Rakyat"
                class="partner-avatar"
            >
        </div>

        <!-- STATUS VERIFIKASI -->
        <span class="verified-badge">
            <i class="fa fa-check-circle"></i> Terverifikasi
        </span>

    </div>

    <div class="partner-info">
        <span class="partner-category">Pertanian</span>

        <h3>Farm Rakyat</h3>

        <p>
            <i class="fa fa-map-marker"></i>
            Ajung, Jember
        </p>

        <a href="#" class="partner-link">
            Lihat Profil <i class="fa fa-arrow-right"></i>
        </a>
    </div>
</div>


<!-- MITRA 6 -->
<div class="partner-card">
    <div class="partner-image">

        <!-- FOTO SAMPUL -->
        <img
            src="{{ asset('assets/user/img/sampulusaha/6.jpeg') }}"
            alt="Sampul Batik Sejahtera"
            class="partner-cover"
        >

        <!-- FOTO PROFIL -->
        <div class="partner-profile">
            <img
                src="{{ asset('assets/user/img/profilusaha/6.jpeg') }}"
                alt="Profil Batik Sejahtera"
                class="partner-avatar"
            >
        </div>

        <!-- STATUS VERIFIKASI -->
        <span class="verified-badge">
            <i class="fa fa-check-circle"></i> Terverifikasi
        </span>

    </div>

    <div class="partner-info">
        <span class="partner-category">Fashion</span>

        <h3>Batik Sejahtera</h3>

        <p>
            <i class="fa fa-map-marker"></i>
            Panti, Jember
        </p>

        <a href="#" class="partner-link">
            Lihat Profil <i class="fa fa-arrow-right"></i>
        </a>
    </div>
</div>

        </div>

       <div class="partner-more">
    <a href="#" class="arrow">
        <i class="fa fa-angle-left"></i>
    </a>

    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">4</a>
    <a href="#">5</a>
    <a href="#">6</a>
    <span>...</span>
    
    <a href="#">9</a>
    <a href="#">10</a>
    <a href="#">11</a>

    <a href="#" class="arrow">
        <i class="fa fa-angle-right"></i>
    </a>
</div>
</div>


<script>
    function scrollCategory(amount) {
        document.getElementById('categoryScroll').scrollBy({
            left: amount,
            behavior: 'smooth'
        });
    }
</script>
</section>
@endsection