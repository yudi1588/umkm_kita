
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
                        <img
                            src="{{ asset('assets/user/img/umkm.png') }}"
                            alt="Logo UMKM"
                            class="img-responsive">
                    </a>
                </div>

                <!-- SEARCH -->
                <div class="col-md-5 col-sm-5 col-xs-8">
                    <form action="{{ route('products') }}" method="GET" class="header-search">
                        <input
                            type="text"
                            name="q"
                            placeholder="Cari Produk..."
                            value="{{ request('q') }}"
                            autocomplete="off">

                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- KERANJANG DAN KONTAK -->
                <div class="col-md-5 col-sm-4 col-xs-12 header-action">

                    <a href="#" class="header-cart">
                        <span class="cart-icon">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="cart-count">0</span>
                        </span>
                        <span>Keranjang</span>
                    </a>

                    <a href="#"
                    target="_blank"
                    class="btn-login">
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

                <li>
                    <a href="#">Statistik usaha</a>
                </li>

            </ul>
        </div>
    </nav>
    </div>
    </div>