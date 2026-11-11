
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | UMKM Kita</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>

@php
    $dataUsaha = [
        [
            'id' => 1,
            'nama' => 'Iyowes Eskrim',
            'pemilik' => 'Rifky Aditya',
            'kategori' => 'Makanan dan Minuman',
            'telepon' => '081234567890',
            'email' => 'iyowes@example.com',
            'alamat' => 'Kota Probolinggo, Jawa Timur',
            'deskripsi' => 'Usaha es krim dengan berbagai pilihan rasa dan harga terjangkau.',
            'status' => 'Aktif',
            'statusBuka' => true,
            'jamBuka' => '09:00',
            'jamTutup' => '20:00',
            'tanggal' => '2026-10-01',
            'produk' => [
                [
                    'id' => 101,
                    'nama' => 'Es Krim Cokelat',
                    'kategori' => 'Dessert',
                    'harga' => 5000,
                    'stok' => 50,
                    'status' => 'Tersedia'
                ],
                [
                    'id' => 102,
                    'nama' => 'Es Krim Vanilla',
                    'kategori' => 'Dessert',
                    'harga' => 5000,
                    'stok' => 35,
                    'status' => 'Tersedia'
                ],
                [
                    'id' => 103,
                    'nama' => 'Es Krim Stroberi',
                    'kategori' => 'Dessert',
                    'harga' => 3000,
                    'stok' => 20,
                    'status' => 'Tersedia'
                ]
            ]
        ],
        [
            'id' => 2,
            'nama' => 'Kedai Kopi Senja',
            'pemilik' => 'Andi Saputra',
            'kategori' => 'Minuman',
            'telepon' => '082345678901',
            'email' => 'senja@example.com',
            'alamat' => 'Jember, Jawa Timur',
            'deskripsi' => 'Kedai kopi dengan berbagai pilihan minuman.',
            'status' => 'Aktif',
            'statusBuka' => true,
            'jamBuka' => '08:00',
            'jamTutup' => '22:00',
            'tanggal' => '2026-10-03',
            'produk' => [
                [
                    'id' => 201,
                    'nama' => 'Kopi Susu',
                    'kategori' => 'Minuman',
                    'harga' => 12000,
                    'stok' => 40,
                    'status' => 'Tersedia'
                ],
                [
                    'id' => 202,
                    'nama' => 'Americano',
                    'kategori' => 'Minuman',
                    'harga' => 10000,
                    'stok' => 25,
                    'status' => 'Tersedia'
                ]
            ]
        ],
        [
            'id' => 3,
            'nama' => 'Dapur Bu Sari',
            'pemilik' => 'Sari Wulandari',
            'kategori' => 'Makanan',
            'telepon' => '083456789012',
            'email' => 'dapur@example.com',
            'alamat' => 'Lumajang, Jawa Timur',
            'deskripsi' => 'Menyediakan makanan rumahan dan lauk siap saji.',
            'status' => 'Aktif',
            'statusBuka' => false,
            'jamBuka' => '07:00',
            'jamTutup' => '16:00',
            'tanggal' => '2026-10-05',
            'produk' => [
                [
                    'id' => 301,
                    'nama' => 'Nasi Ayam',
                    'kategori' => 'Makanan',
                    'harga' => 15000,
                    'stok' => 15,
                    'status' => 'Tersedia'
                ],
                [
                    'id' => 302,
                    'nama' => 'Nasi Pecel',
                    'kategori' => 'Makanan',
                    'harga' => 12000,
                    'stok' => 0,
                    'status' => 'Habis'
                ]
            ]
        ],
        [
            'id' => 4,
            'nama' => 'Keripik Makmur',
            'pemilik' => 'Budi Santoso',
            'kategori' => 'Camilan',
            'telepon' => '084567890123',
            'email' => 'makmur@example.com',
            'alamat' => 'Probolinggo, Jawa Timur',
            'deskripsi' => 'Usaha camilan keripik lokal.',
            'status' => 'Nonaktif',
            'statusBuka' => false,
            'jamBuka' => '09:00',
            'jamTutup' => '17:00',
            'tanggal' => '2026-10-08',
            'produk' => [
                [
                    'id' => 401,
                    'nama' => 'Keripik Singkong',
                    'kategori' => 'Camilan',
                    'harga' => 10000,
                    'stok' => 30,
                    'status' => 'Tersedia'
                ]
            ]
        ]
    ];
@endphp

<script>
    window.dataUsahaAwal = @json($dataUsaha);
</script>


<!-- MAIN CONTENT -->
<main class="main-content">

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn-sidebar" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>

            <div>
                <h5 id="pageTitle">Dashboard</h5>
                <small id="pageSubtitle">Ringkasan aktivitas UMKM Kita</small>
            </div>
        </div>

        <div class="topbar-right">
            <div class="date-info">
                <i class="bi bi-calendar3"></i>
                <span id="tanggalHariIni"></span>
            </div>

            <div class="top-avatar">A</div>
        </div>
    </header>

    <div class="content-wrapper">

        <!-- ================================= -->
        <!-- HALAMAN DASHBOARD -->
        <!-- ================================= -->
        <section class="page-section active" id="page-dashboard">

            <div class="welcome-section">
                <div>
                    <h3>Selamat Datang, Admin! 👋</h3>
                    <p>Pantau dan kelola seluruh aktivitas usaha UMKM melalui dashboard ini.</p>
                </div>

                <button class="btn btn-primary-custom" onclick="bukaModalUsaha()">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Pemilik Usaha
                </button>
            </div>

            <!-- STATISTIK -->
            <div class="row g-3 mb-4">

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-shop"></i>
                        </div>
                        <div>
                            <p>Total Usaha</p>
                            <h3 id="statTotalUsaha">0</h3>
                            <small>Terdaftar di sistem</small>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <p>Total Produk</p>
                            <h3 id="statTotalProduk">0</h3>
                            <small>Produk seluruh usaha</small>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <p>Usaha Aktif</p>
                            <h3 id="statUsahaAktif">0</h3>
                            <small>Terdaftar dan aktif</small>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="bi bi-shop-window"></i>
                        </div>
                        <div>
                            <p>Sedang Buka</p>
                            <h3 id="statUsahaBuka">0</h3>
                            <small>Usaha yang menerima pesanan</small>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RINGKASAN DAN KATEGORI -->
            <div class="row g-3 mb-4">

                <div class="col-12 col-xl-7">
                    <div class="content-card h-100">
                        <div class="card-heading">
                            <div>
                                <h5>Usaha Terbaru</h5>
                                <p>Daftar usaha yang baru terdaftar</p>
                            </div>
                            <button class="btn btn-light-custom" onclick="pindahHalaman('usaha')">
                                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table custom-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Nama Usaha</th>
                                        <th>Pemilik</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelUsahaTerbaru"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-5">
                    <div class="content-card h-100">
                        <div class="card-heading">
                            <div>
                                <h5>Ringkasan Kategori</h5>
                                <p>Jumlah usaha berdasarkan kategori</p>
                            </div>
                        </div>

                        <div id="ringkasanKategori" class="category-summary"></div>
                    </div>
                </div>

            </div>

            <!-- INFORMASI -->
            <div class="content-card">
                <div class="card-heading">
                    <div>
                        <h5>Informasi Pengelolaan</h5>
                        <p>Ringkasan aktivitas sistem</p>
                    </div>
                </div>

                <div class="info-box">
                    <i class="bi bi-info-circle"></i>
                    <div>
                        <strong>Panel Administrasi UMKM Kita</strong>
                        <p>Gunakan menu Data Usaha untuk mengelola pemilik usaha, melihat detail usaha, serta mengelola produk yang dijual.</p>
                    </div>
                </div>
            </div>

        </section>


        <!-- ================================= -->
        <!-- HALAMAN DATA USAHA -->
        <!-- ================================= -->
        <section class="page-section" id="page-usaha">

            <div class="section-header">
                <div>
                    <h3>Data Pemilik Usaha</h3>
                    <p>Kelola informasi seluruh pemilik usaha yang terdaftar.</p>
                </div>

                <button class="btn btn-primary-custom" onclick="bukaModalUsaha()">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Usaha
                </button>
            </div>

            <div class="content-card">

                <div class="filter-area">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="cariUsaha" placeholder="Cari nama usaha atau pemilik...">
                    </div>

                    <select id="filterStatus" class="form-select filter-select">
                        <option value="">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>

                    <select id="filterKategori" class="form-select filter-select">
                        <option value="">Semua Kategori</option>
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Usaha</th>
                                <th>Pemilik</th>
                                <th>Kategori</th>
                                <th>Jumlah Produk</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabelSemuaUsaha"></tbody>
                    </table>
                </div>

                <div id="jumlahDataUsaha" class="table-footer"></div>

            </div>

        </section>


        <!-- ================================= -->
        <!-- HALAMAN DETAIL USAHA -->
        <!-- ================================= -->
        <section class="page-section" id="page-detail">

            <div class="detail-top">
                <button class="btn btn-light-custom" onclick="pindahHalaman('usaha')">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Data Usaha
                </button>
            </div>

            <div id="kontenDetailUsaha"></div>

        </section>


        <!-- ================================= -->
        <!-- HALAMAN LAPORAN -->
        <!-- ================================= -->
        <section class="page-section" id="page-laporan">

            <div class="section-header">
                <div>
                    <h3>Laporan UMKM</h3>
                    <p>Rekapitulasi data usaha dan produk yang terdaftar.</p>
                </div>

                <button class="btn btn-primary-custom" onclick="cetakLaporan()">
                    <i class="bi bi-printer me-2"></i>Cetak Laporan
                </button>
            </div>

            <div class="row g-3 mb-4">

                <div class="col-12 col-md-4">
                    <div class="report-card">
                        <span>Total Pemilik Usaha</span>
                        <h2 id="laporanTotalUsaha">0</h2>
                        <i class="bi bi-shop"></i>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="report-card">
                        <span>Total Produk</span>
                        <h2 id="laporanTotalProduk">0</h2>
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="report-card">
                        <span>Usaha Aktif</span>
                        <h2 id="laporanUsahaAktif">0</h2>
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>

            </div>

            <div class="content-card" id="areaCetakLaporan">
                <div class="card-heading">
                    <div>
                        <h5>Rekapitulasi Data Usaha</h5>
                        <p id="tanggalLaporan"></p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Usaha</th>
                                <th>Pemilik</th>
                                <th>Kategori</th>
                                <th>Jumlah Produk</th>
                                <th>Status Usaha</th>
                                <th>Status Operasional</th>
                            </tr>
                        </thead>
                        <tbody id="tabelLaporan"></tbody>
                    </table>
                </div>
            </div>

        </section>

    </div>
</main>


<!-- ================================= -->
<!-- MODAL TAMBAH / EDIT USAHA -->
<!-- ================================= -->
<div class="modal fade" id="modalUsaha" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="judulModalUsaha">Tambah Pemilik Usaha</h5>
                    <small class="text-muted">Lengkapi informasi usaha di bawah ini.</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formUsaha">
                <div class="modal-body">

                    <input type="hidden" id="usahaId">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Nama Usaha</label>
                            <input type="text" class="form-control" id="namaUsaha" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Pemilik</label>
                            <input type="text" class="form-control" id="namaPemilik" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kategori Usaha</label>
                            <select class="form-select" id="kategoriUsaha" required>
                                <option value="">Pilih kategori</option>
                                <option>Makanan</option>
                                <option>Minuman</option>
                                <option>Makanan dan Minuman</option>
                                <option>Dessert</option>
                                <option>Camilan</option>
                                <option>Kerajinan</option>
                                <option>Fashion</option>
                                <option>Lainnya</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="teleponUsaha" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailUsaha">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status Usaha</label>
                            <select class="form-select" id="statusUsaha">
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jam Buka</label>
                            <input type="time" class="form-control" id="jamBukaUsaha" value="08:00">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jam Tutup</label>
                            <input type="time" class="form-control" id="jamTutupUsaha" value="21:00">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat Usaha</label>
                            <textarea class="form-control" id="alamatUsaha" rows="2" required></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi Usaha</label>
                            <textarea class="form-control" id="deskripsiUsaha" rows="3"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-save me-2"></i>Simpan Data
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- ================================= -->
<!-- MODAL TAMBAH / EDIT PRODUK -->
<!-- ================================= -->
<div class="modal fade" id="modalProduk" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="judulModalProduk">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formProduk">
                <div class="modal-body">

                    <input type="hidden" id="produkUsahaId">
                    <input type="hidden" id="produkId">

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" id="namaProduk" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori Produk</label>
                        <input type="text" id="kategoriProduk" class="form-control" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" id="hargaProduk" class="form-control" min="0" required>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Stok</label>
                            <input type="number" id="stokProduk" class="form-control" min="0" required>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Status Produk</label>
                        <select id="statusProduk" class="form-select">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Habis">Habis</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-save me-2"></i>Simpan Produk
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- TOAST NOTIFIKASI -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="adminToast" class="toast border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">Berhasil.</div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
