
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
                <img
                    src="{{ asset($product['image']) }}"
                    alt="{{ $product['name'] }}"
                >
            </div>

            <div class="product-detail-info">

                <div class="product-detail-meta">
                    <span class="product-detail-stock">Tersedia</span>

                    <span class="product-detail-seller-chip">
                        <i class="fa fa-building-o" aria-hidden="true"></i>
                        {{ $product['seller'] ?? 'UMKM Lokal Jember' }}
                    </span>
                </div>

                <h1>{{ $product['name'] }}</h1>

                <strong class="product-detail-price">
                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                </strong>

                <div class="product-detail-divider"></div>

                <h2>Deskripsi Produk</h2>

                <p class="product-detail-description">
                    {{ $product['description'] }}
                </p>

                <!-- JUMLAH PRODUK -->
                <div class="product-detail-quantity-row">
                    <span>Jumlah:</span>

                    <div class="product-detail-quantity-control">

                        <button
                            type="button"
                            id="decreaseQuantity"
                            aria-label="Kurangi jumlah"
                        >−</button>

                        <input
                            type="number"
                            id="productQuantity"
                            value="1"
                            min="1"
                            max="99"
                            aria-label="Jumlah produk"
                        >

                        <button
                            type="button"
                            id="increaseQuantity"
                            aria-label="Tambah jumlah"
                        >+</button>

                    </div>
                </div>

                <!-- TOTAL HARGA -->
                <div class="product-detail-total">
                    <span>Total harga:</span>

                    <strong id="productTotal">
                        Rp {{ number_format($product['price'], 0, ',', '.') }}
                    </strong>
                </div>

                <!-- TOMBOL AKSI -->
                <div class="product-detail-actions">

                    <!-- BELI SEKARANG -->
                    <form
                        action="{{ route('checkout.single', $product['slug']) }}"
                        method="POST"
                        id="buyNowForm"
                    >
                        @csrf

                        <input
                            type="hidden"
                            name="quantity"
                            id="checkoutQuantity"
                            value="1"
                        >

                        <button type="submit" class="btn-buy-now">
                            <i class="fa fa-shopping-bag"></i>
                            Beli Sekarang
                        </button>
                    </form>

                    <button
    type="button"
    class="product-detail-cart"
    id="addToCartButton"
    data-slug="{{ $product['slug'] }}"
    data-name="{{ $product['name'] }}"
    data-price="{{ $product['price'] }}"
    data-image="{{ asset($product['image']) }}"
    data-location="{{ $product['location'] }}"
    title="Tambah ke keranjang"
>
    <i class="fa fa-cart-plus"></i>
</button>

                    

                    <!-- WHATSAPP -->
                    <a
                        href="https://wa.me/6281234567890"
                        class="product-detail-whatsapp"
                        target="_blank"
                        rel="noopener"
                        aria-label="Hubungi penjual melalui WhatsApp"
                    >
                        <i class="fa fa-whatsapp"></i>
                    </a>

                </div>

                <div
                    id="cartMessage"
                    class="cart-message"
                    role="status"
                ></div>

            </div>
        </section>

        <!-- PRODUK TERKAIT -->
        <section class="product-related" aria-label="Produk terkait">

            <div class="product-related-heading">
                <span></span>
                <h2>Produk Terkait</h2>
            </div>

            <div class="product-related-grid">

                @forelse ($relatedProducts as $relatedProduct)

                    <a
                        href="{{ route('products.show', $relatedProduct['slug']) }}"
                        class="related-product-card"
                        aria-label="Lihat {{ $relatedProduct['name'] }}"
                    >

                        <div class="related-product-image">
                            <img
                                src="{{ asset($relatedProduct['image']) }}"
                                alt="{{ $relatedProduct['name'] }}"
                                loading="lazy"
                            >
                        </div>

                        <h3>{{ $relatedProduct['name'] }}</h3>

                        <span class="related-product-category">
                            {{ $categories[$relatedProduct['category']] }}
                        </span>

                        <strong>
                            Rp {{ number_format($relatedProduct['price'], 0, ',', '.') }}
                        </strong>

                        <span class="related-product-location">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            {{ $relatedProduct['location'] }}
                        </span>

                    </a>

                @empty

                    <p class="product-related-empty">
                        Belum ada produk terkait.
                    </p>

                @endforelse

            </div>
        </section>

    </div>
</main>
@endsection
