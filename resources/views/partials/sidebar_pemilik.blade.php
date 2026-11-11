<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">

    <div class="brand">
        <div class="brand-icon">
            <i class="bi bi-shop-window"></i>
        </div>
        <div>
            <h4>UMKM <span>KITA</span></h4>
            <small class="text-muted">PANEL PEMILIK</small>
        </div>
    </div>

    <div class="menu-title">MENU UTAMA</div>

    <a class="nav-link-custom active" onclick="pindahHalaman('dashboard',this)">
        <i class="bi bi-grid-1x2-fill"></i> Dashboard
    </a>

    <a class="nav-link-custom" onclick="pindahHalaman('produk',this)">
        <i class="bi bi-box-seam"></i> Produk Saya
    </a>

    <a class="nav-link-custom" onclick="bukaTambah()">
        <i class="bi bi-plus-circle"></i> Tambah Produk
    </a>

    <a class="nav-link-custom" onclick="pindahHalaman('produk',this);setTimeout(()=>document.getElementById('searchNama').focus(),100)">
        <i class="bi bi-search"></i> Pencarian Produk
    </a>

    <div class="menu-title mt-3">AKUN USAHA</div>

    <a class="nav-link-custom" onclick="pindahHalaman('profil',this)">
        <i class="bi bi-building"></i> Profil Usaha
    </a>

    <div class="mt-auto pt-4">
        <hr>
        <a href="#" class="nav-link-custom" onclick="logoutDummy(event)">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
        <small class="text-muted px-3">UMKM Kita © 2026</small>
    </div>
</aside>