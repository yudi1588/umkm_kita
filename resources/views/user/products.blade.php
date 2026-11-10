@extends('layouts.app')

@section('title', 'Produk UMKM Lokal - UMKM Kita')

@section('content')
<main class="catalog-page">
    <div class="catalog-container">
        <aside class="catalog-sidebar">
            <div class="catalog-sidebar-heading">
                <span class="catalog-filter-icon"><i class="fa fa-filter" aria-hidden="true"></i></span>
                <div>
                    <h1>FILTER PRODUK</h1>
                    <p>Sesuaikan pencarian Anda</p>
                </div>
            </div>

            <form action="{{ route('products') }}" method="GET" class="catalog-location-filter">
                @if ($activeCategory)
                    <input type="hidden" name="category" value="{{ $activeCategory }}">
                @endif
                @if ($query)
                    <input type="hidden" name="q" value="{{ $query }}">
                @endif
                <label for="catalog-location"><i class="fa fa-map-marker" aria-hidden="true"></i> LOKASI PENJUAL</label>
                <select id="catalog-location" name="location" onchange="this.form.submit()">
                    <option value="">Semua Kecamatan</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location }}" @selected($activeLocation === $location)>{{ $location }}</option>
                    @endforeach
                </select>
                <noscript><button type="submit">Terapkan lokasi</button></noscript>
            </form>

            <div class="catalog-category-heading">
                <i class="fa fa-th-large" aria-hidden="true"></i>
                <span>KATEGORI</span>
            </div>
            <nav class="catalog-sidebar-categories" aria-label="Kategori produk">
                <a
                    href="{{ route('products', array_filter(['q' => $query, 'location' => $activeLocation])) }}"
                    class="{{ $activeCategory === '' ? 'is-active' : '' }}">
                    <span class="catalog-category-icon"><i class="fa fa-th-large" aria-hidden="true"></i></span>
                    <span>Semua Kategori</span>
                    @if ($activeCategory === '')
                        <i class="fa fa-circle catalog-selected-indicator" aria-hidden="true"></i>
                    @endif
                </a>
                @foreach ($categories as $slug => $label)
                    <a
                        href="{{ route('products', array_filter(['category' => $slug, 'q' => $query, 'location' => $activeLocation])) }}"
                        class="{{ $activeCategory === $slug ? 'is-active' : '' }}">
                        <span class="catalog-category-icon"><i class="fa {{ $categoryIcons[$slug] }}" aria-hidden="true"></i></span>
                        <span>{{ $label }}</span>
                        @if ($activeCategory === $slug)
                            <i class="fa fa-circle catalog-selected-indicator" aria-hidden="true"></i>
                        @endif
                    </a>
                @endforeach
            </nav>
        </aside>

        <section class="catalog-content" aria-label="Daftar produk UMKM">
            @if ($query || $activeCategory || $activeLocation)
                <div class="catalog-results">
                    <a href="{{ route('products') }}" class="catalog-reset-filter">Reset filter</a>
                </div>
            @endif

            @if ($productCount > 0)
                <div class="catalog-grid">
                    @foreach ($products as $product)
                        <article class="catalog-card">
                            <div class="catalog-product-image">
                                <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" loading="lazy">
                            </div>
                            <div class="catalog-card-info">
                                <h2>{{ $product['name'] }}</h2>
                                <span class="catalog-product-category">{{ $categories[$product['category']] }}</span>
                                <strong class="catalog-product-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</strong>
                                <div class="catalog-product-location">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    {{ $product['location'] }}
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="catalog-empty">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <h2>Produk belum ditemukan</h2>
                    <p>Coba kata kunci lain atau ubah filter yang dipilih.</p>
                    <a href="{{ route('products') }}">Reset filter</a>
                </div>
            @endif
        </section>
    </div>
</main>
@endsection
