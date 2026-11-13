<!-- STICKY HEADER WRAPPER -->
<div class="sticky-header">

    <!-- TOP BAR -->
    <div class="top-header">
        <div class="container">
            <div class="top-header-left">
                <i class="fa fa-calendar"></i>
                {{ now()->locale('id')->translatedFormat('l, d F Y') }},
                pukul {{ now()->format('H.i') }} WIB
            </div>

            <div class="top-header-right">
                <i class="fa fa-map-marker"></i>
                Platform Digital UMKM Kota Jember
            </div>
        </div>
    </div>

    <!-- HEADER UTAMA -->
    <header class="main-header">
        <div class="container">
            <div class="row header-content">

                <!-- LOGO -->
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('assets/user/img/umkm.png') }}" alt="Logo UMKM" class="img-responsive">
                    </a>
                </div>

                <!-- SEARCH -->
                <div class="col-md-5 col-sm-5 col-xs-8">
                    <form action="{{ route('products') }}" method="GET" class="header-search">
                        <input type="text" name="q" placeholder="Cari Produk..." value="{{ request('q') }}"
                            autocomplete="off">

                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- KERANJANG DAN KONTAK -->
                <div class="col-md-5 col-sm-4 col-xs-12 header-action">

                    


<!-- MINI SHOPPING CART -->
<details class="cart-menu" id="headerCart">

    <!-- ICON KERANJANG -->
    <summary class="header-cart">
        <span class="cart-icon">
            <i class="fa fa-shopping-cart"></i>
            <span class="cart-count" id="cartCount">0</span>
        </span>

        <span>Keranjang</span>
        <i class="fa fa-angle-down cart-arrow"></i>
    </summary>

    <!-- DROPDOWN KERANJANG -->
    <div class="cart-dropdown">

        <!-- HEADER DROPDOWN -->
        <div class="cart-dropdown-header">

            <div>
                <h3>Keranjang Belanja</h3>
                <span id="cartItemSummary">0 produk dipilih</span>
            </div>

            <button
                type="button"
                id="clearCartButton"
                class="cart-clear-button"
            >
                <i class="fa fa-trash-o"></i>
                Kosongkan
            </button>

        </div>

        <!-- DAFTAR PRODUK -->
        <div class="cart-body">

            <!-- KERANJANG KOSONG -->
            <div class="cart-empty" id="cartEmpty">

                <div class="cart-empty-icon">
                    <i class="fa fa-shopping-basket"></i>
                </div>

                <h4>Keranjang masih kosong</h4>

                <p>
                    Yuk, temukan produk UMKM favoritmu!
                </p>

            </div>

            <!-- ITEM PRODUK DIISI JAVASCRIPT -->
            <div class="cart-items" id="cartItems"></div>

        </div>

        <!-- FOOTER -->
        <div class="cart-dropdown-footer">

            <div class="cart-subtotal">

                <div>
                    <span>Subtotal</span>
                    <small id="cartTotalItems">0 barang</small>
                </div>

                <strong id="cartSubtotal">Rp 0</strong>

            </div>

            <div class="cart-footer">

                <button
                    type="button"
                    class="cart-view"
                    id="continueShopping"
                >
                    Lanjut Belanja
                </button>

                <form
                    action="{{ route('checkout.cart') }}"
                    method="POST"
                    id="cartCheckoutForm"
                >
                    @csrf

                    <input
                        type="hidden"
                        name="items"
                        id="checkoutCartItems"
                    >

                    <button
                        type="submit"
                        class="cart-checkout"
                        id="cartCheckoutButton"
                    >
                        Checkout
                        <i class="fa fa-arrow-right"></i>
                    </button>

                </form>

            </div>

<<<<<<< HEAD
=======
            <a href="{{ route('checkouts') }}" class="cart-checkout">
                Checkout <i class="fa fa-arrow-circle-right"></i>
            </a>
>>>>>>> a0ba721 (Menambahkan tampilan halaman checkout)
        </div>

    </div>

</details>



                    <a href="{{ route('login') }}" class="btn-login">
                        Masuk
                    </a>

                </div>
            </div>
        </div>
    </header>

    <!-- NAVIGATION -->
    <nav class="main-navigation">
        <div class="container">
            <ul class="nav-menu">

                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ url('/') }}">Beranda</a>
                </li>

                <li class="{{ request()->routeIs('products') ? 'active' : '' }}">
                    <a href="{{ route('products') }}">Produk</a>
                </li>

                <li class="dropdown">
                    <a href="#">
                        Kategori Produk
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('products', ['category' => 'kuliner']) }}">Makanan & Minuman</a></li>
                        <li><a href="{{ route('products', ['category' => 'fashion']) }}">Fashion</a></li>
                        <li><a href="{{ route('products', ['category' => 'kerajinan']) }}">Kerajinan</a></li>
                        <li><a href="{{ route('products', ['category' => 'pertanian']) }}">Pertanian</a></li>
                    </ul>
                </li>

                <li class="{{ request()->routeIs('statistiks') ? 'active' : '' }}">
                    <a href="{{ route('statistiks') }}">Statistik usaha</a>
                </li>

            </ul>
        </div>
    </nav>
</div>
</div>

<script>
    function checkoutCart() {

    /*
     * Contoh format data keranjang:
     * [
     *   { slug: "keripik-singkong-umkm", quantity: 2 },
     *   { slug: "kue-kering-homemade", quantity: 1 }
     * ]
     *
     * Sesuaikan nama localStorage dan struktur datanya
     * dengan JavaScript keranjang yang sudah kamu miliki.
     */

    const cart = JSON.parse(localStorage.getItem('cart') || '[]');

    if (!cart.length) {
        alert('Keranjang belanja masih kosong!');
        return;
    }

    const checkoutItems = cart.map(item => ({
        slug: item.slug,
        quantity: Number(item.quantity || 1)
    }));

    document.getElementById('checkoutCartItems').value =
        JSON.stringify(checkoutItems);

    document.getElementById('cartCheckoutForm').submit();
}
</script>
