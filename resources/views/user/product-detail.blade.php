@extends('layouts.app')

@section('title', $product['name'].' - UMKM Kita')

@section('content')
<main class="product-detail-page">
    <div class="product-detail-container">
        <a href="{{ route('products') }}" class="product-detail-back">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
            Kembali
        </a>

        <section class="product-detail-card" aria-label="Detail produk {{ $product['name'] }}">
            <div class="product-detail-media">
                <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}">
            </div>

            <div class="product-detail-info">
                <div class="product-detail-meta">
                    <span class="product-detail-stock">Tersedia</span>
                    <span class="product-detail-seller-chip"><i class="fa fa-building-o" aria-hidden="true"></i> {{ $product['seller'] ?? 'UMKM Lokal Jember' }}</span>
                </div>
                <h1>{{ $product['name'] }}</h1>
                <strong class="product-detail-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</strong>

                <div class="product-detail-divider"></div>

                <h2>Deskripsi Produk</h2>
                <p class="product-detail-description">{{ $product['description'] }}</p>

                <div class="product-detail-quantity-row">
                    <span>Jumlah:</span>
                    <div class="product-detail-quantity-control" data-quantity-control>
                        <button type="button" data-quantity-decrease aria-label="Kurangi jumlah">−</button>
                        <input type="number" value="1" min="1" max="99" aria-label="Jumlah produk">
                        <button type="button" data-quantity-increase aria-label="Tambah jumlah">+</button>
                    </div>
                </div>

                <div class="product-detail-actions">
                    <button type="button" class="product-detail-buy"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Beli Sekarang</button>
                    <button type="button" class="product-detail-cart" aria-label="Tambah ke keranjang"><i class="fa fa-cart-plus" aria-hidden="true"></i></button>
                    <a href="https://wa.me/6281234567890" class="product-detail-whatsapp" target="_blank" rel="noopener" aria-label="Hubungi penjual melalui WhatsApp"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                </div>
            </div>
        </section>

        <section class="product-related" aria-label="Produk terkait">
            <div class="product-related-heading">
                <span></span>
                <h2>Produk Terkait</h2>
            </div>

            <div class="product-related-grid">
                @forelse ($relatedProducts as $relatedProduct)
                    <a href="{{ route('products.show', $relatedProduct['slug']) }}" class="related-product-card" aria-label="Lihat {{ $relatedProduct['name'] }}">
                        <div class="related-product-image">
                            <img src="{{ asset($relatedProduct['image']) }}" alt="{{ $relatedProduct['name'] }}" loading="lazy">
                        </div>
                        <h3>{{ $relatedProduct['name'] }}</h3>
                        <span class="related-product-category">{{ $categories[$relatedProduct['category']] }}</span>
                        <strong>Rp {{ number_format($relatedProduct['price'], 0, ',', '.') }}</strong>
                        <span class="related-product-location"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $relatedProduct['location'] }}</span>
                    </a>
                @empty
                    <p class="product-related-empty">Belum ada produk terkait.</p>
                @endforelse
            </div>
        </section>
    </div>
</main>

<script>
    document.querySelectorAll('[data-quantity-control]').forEach((control) => {
        const input = control.querySelector('input');
        control.querySelector('[data-quantity-decrease]').addEventListener('click', () => {
            input.value = Math.max(1, Number(input.value || 1) - 1);
        });
        control.querySelector('[data-quantity-increase]').addEventListener('click', () => {
            input.value = Math.min(99, Number(input.value || 1) + 1);
        });
    });
</script>
@endsection
