
<!-- MAIN -->
<main class="main">

    <header class="topbar">
        <div class="d-flex align-items-center gap-3">

            <button class="btn btn-light d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>

            <div>
                <div class="fw-bold" id="judulHalaman">Dashboard Pemilik Usaha</div>
                <small class="text-muted" id="subJudul">Kelola dan pantau perkembangan usaha Anda</small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="text-end d-none d-sm-block">
                <div class="fw-bold small" id="namaPemilikTop"></div>
                <small class="text-muted">Pemilik UMKM</small>
            </div>
            <div class="avatar" id="avatar"></div>
        </div>
    </header>


    <div class="content">

        <div id="notifikasi"></div>

        <!-- DASHBOARD -->
        <section id="halaman-dashboard" class="page-section active">

            <section class="welcome">
                <div class="position-relative" style="z-index:2">
                    <small class="fw-bold" style="color:#ffdc68">
                        SELAMAT DATANG DI UMKM KITA
                    </small>
                    <h2 class="mt-2" id="welcomeNama"></h2>
                    <p id="welcomeUsaha"></p>
                </div>
                <i class="bi bi-shop"></i>
            </section>

            <div class="section-title">Ringkasan Usaha</div>

            <div class="row g-3">

                <div class="col-6 col-xl-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Total Produk</span>
                            <div class="stat-icon blue"><i class="bi bi-box-seam"></i></div>
                        </div>
                        <div class="stat-number" id="totalProduk">0</div>
                        <div class="stat-label">Produk terdaftar</div>
                    </div>
                </div>

                <div class="col-8 col-xl-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Produk Aktif</span>
                            <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
                        </div>
                        <div class="stat-number" id="produkAktif">0</div>
                        <div class="stat-label">Produk ditampilkan</div>
                    </div>
                </div>

                <div class="col-6 col-xl-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Stok Menipis</span>
                            <div class="stat-icon yellow"><i class="bi bi-exclamation-triangle"></i></div>
                        </div>
                        <div class="stat-number" id="stokMenipis">0</div>
                        <div class="stat-label">Stok 5 atau kurang</div>
                    </div>
                </div>

                <div class="col-6 col-xl-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Total Terjual</span>
                            <div class="stat-icon red"><i class="bi bi-graph-up-arrow"></i></div>
                        </div>
                        <div class="stat-number" id="totalTerjual">0</div>
                        <div class="stat-label">Akumulasi penjualan</div>
                    </div>
                </div>

            </div>

            <!-- INFORMASI USAHA -->
            <div class="section-title">Informasi Usaha</div>

            <div class="panel">
                <div class="panel-header">
                    <h5><i class="bi bi-building text-primary me-2"></i>Profil Usaha Saya</h5>
                    <button class="btn btn-outline-primary btn-sm" onclick="pindahHalaman('profil')">
                        Lihat Detail <i class="bi bi-arrow-right"></i>
                    </button>
                </div>

                <div class="p-4">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <small class="text-muted">Nama Usaha</small>
                            <div class="fw-bold mt-1" id="dashNamaUsaha"></div>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Nama Pemilik</small>
                            <div class="fw-bold mt-1" id="dashNamaPemilik"></div>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Status Akun</small>
                            <div class="mt-1"><span class="badge-active">Aktif</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATUS RESTORAN -->
            <div class="section-title">Status Operasional Restoran</div>

            <div class="panel p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h5 class="fw-bold mb-2">Status Restoran</h5>
                        <div id="statusDashboard"></div>
                        <small class="text-muted d-block mt-2">
                            Tentukan apakah restoran sedang menerima pesanan.
                        </small>
                    </div>

                    <button class="btn btn-success btn-status"
                            id="btnStatusDashboard"
                            onclick="ubahStatusRestoran()">
                        BUKA RESTORAN
                    </button>
                </div>

                <div class="mt-3 small text-muted">
                    <i class="bi bi-clock me-1"></i>
                    Jadwal:
                    <strong id="jadwalDashboard">08:00 - 21:00</strong>
                </div>
            </div>

            <!-- PRODUK TERBARU -->
            <div class="section-title">Produk Terbaru</div>

            <div class="panel">
                <div class="panel-header">
                    <h5><i class="bi bi-box-seam text-primary me-2"></i>Produk Saya</h5>
                    <button class="btn btn-primary btn-sm" onclick="pindahHalaman('produk')">
                        Lihat Semua
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>PRODUK</th>
                                <th>KATEGORI</th>
                                <th>HARGA</th>
                                <th>STOK</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="produkTerbaru"></tbody>
                    </table>
                </div>
            </div>

        </section>


        <!-- HALAMAN PRODUK -->
        <section id="halaman-produk" class="page-section">

            <div class="page-heading d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4>Manajemen Produk</h4>
                    <small class="text-muted">Kelola seluruh produk usaha Anda di sini.</small>
                </div>

                <button class="btn btn-primary" onclick="bukaTambah()">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Produk
                </button>
            </div>

            <div class="row g-3 mb-4">

                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="text-muted small">Total Produk</div>
                        <div class="stat-number" id="produkTotalHalaman">0</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="text-muted small">Produk Aktif</div>
                        <div class="stat-number" id="produkAktifHalaman">0</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="text-muted small">Stok Menipis</div>
                        <div class="stat-number" id="stokHalaman">0</div>
                    </div>
                </div>

            </div>

            <div class="panel">

                <div class="panel-header">
                    <div>
                        <h5>Daftar Produk Saya</h5>
                        <small class="text-muted">Daftar produk yang terdaftar pada usaha Anda.</small>
                    </div>
                </div>

                <div class="p-3">
                    <form id="formSearch" class="row g-2">

                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" id="searchNama" class="form-control"
                                       placeholder="Cari nama produk...">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <select id="searchKategori" class="form-select">
                                <option value="">Semua Kategori</option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-primary btn-sm flex-fill">Cari</button>
                            <button type="button" onclick="resetSearch()"
                                    class="btn btn-light border btn-sm">Reset</button>
                        </div>

                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>PRODUK</th>
                                <th>KATEGORI</th>
                                <th>HARGA</th>
                                <th>STOK</th>
                                <th>STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="tabelProduk"></tbody>
                    </table>
                </div>

            </div>

        </section>


        <!-- HALAMAN PROFIL -->
        <section id="halaman-profil" class="page-section">

            <div class="page-heading d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4>Profil Usaha</h4>
                    <small class="text-muted">Informasi identitas dan detail usaha Anda.</small>
                </div>

                <button class="btn btn-primary" onclick="bukaEditProfil()">
                    <i class="bi bi-pencil-square me-1"></i> Edit Profil Usaha
                </button>
            </div>

            <!-- HEADER PROFIL -->
            <div class="welcome">

                <div class="d-flex align-items-center gap-3 position-relative" style="z-index:2">

                    <div id="fotoUsahaContainer">
                        <div class="foto-usaha-placeholder">
                            <i class="bi bi-shop"></i>
                        </div>
                    </div>

                    <div>
                        <small style="color:#dbeafe">PROFIL USAHA</small>
                        <h3 class="fw-bold mb-1" id="profilHeaderNama"></h3>
                        <span class="badge bg-light text-primary">Usaha Terdaftar</span>
                    </div>

                </div>

                <i class="bi bi-building"></i>
            </div>

            <!-- DETAIL USAHA -->
            <div class="panel mb-4">

                <div class="panel-header">
                    <h5><i class="bi bi-info-circle text-primary me-2"></i>Informasi Umum Usaha</h5>
                </div>

                <div class="p-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="profile-item">
                                <small>Nama Usaha</small>
                                <div id="detailNamaUsaha"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-item">
                                <small>Kategori Usaha</small>
                                <div id="detailKategori"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-item">
                                <small>Nama Pemilik</small>
                                <div id="detailPemilik"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-item">
                                <small>Nomor Telepon</small>
                                <div id="detailTelepon"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-item">
                                <small>Email Usaha</small>
                                <div id="detailEmail"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-item">
                                <small>Status Akun</small>
                                <div><span class="badge-active">Aktif</span></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="profile-item">
                                <small>Alamat Usaha</small>
                                <div id="detailAlamat"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="profile-item">
                                <small>Deskripsi Usaha</small>
                                <div id="detailDeskripsi" style="font-weight:normal;line-height:1.7"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- STATUS DAN JADWAL -->
            <div class="section-title">Status dan Jadwal Operasional</div>

            <div class="operasional-card mb-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Status Restoran</h5>
                        <small class="text-muted">
                            Atur apakah restoran sedang menerima pesanan.
                        </small>
                    </div>
                    <span id="badgeStatusRestoran" class="badge-inactive">TUTUP</span>
                </div>

                <div class="status-restoran">

                    <div>
                        <div class="status-indicator" id="indikatorStatus">
                            <span class="status-dot tutup"></span>
                            <span>Restoran sedang tutup</span>
                        </div>

                        <div class="small text-muted mt-2" id="keteranganStatus">
                            Restoran belum menerima pesanan.
                        </div>
                    </div>

                    <button type="button"
                            class="btn btn-success btn-status"
                            id="btnStatusRestoran"
                            onclick="ubahStatusRestoran()">
                        <i class="bi bi-shop me-2"></i>
                        BUKA RESTORAN
                    </button>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold mb-1">Jadwal Operasional</h6>
                        <small class="text-muted">Jam kerja restoran setiap hari.</small>
                    </div>
                    <i class="bi bi-clock-history fs-3 text-primary"></i>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="jadwal-item">
                            <small>Jam Buka</small>
                            <strong id="tampilJamBuka">08:00</strong>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="jadwal-item">
                            <small>Jam Tutup</small>
                            <strong id="tampilJamTutup">21:00</strong>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light border mt-3 mb-0 small">
                    <i class="bi bi-info-circle text-primary me-1"></i>
                    Jadwal operasional merupakan informasi jam kerja. Status buka atau tutup tetap dikendalikan melalui tombol.
                </div>

            </div>

            <!-- STATISTIK PROFIL -->
            <div class="section-title">Ringkasan Aktivitas Usaha</div>

            <div class="row g-3">

                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between">
                            <span class="small text-muted">Jumlah Produk</span>
                            <div class="stat-icon blue"><i class="bi bi-box-seam"></i></div>
                        </div>
                        <div class="stat-number" id="profilJumlahProduk">0</div>
                        <div class="stat-label">Produk terdaftar</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between">
                            <span class="small text-muted">Produk Aktif</span>
                            <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
                        </div>
                        <div class="stat-number" id="profilProdukAktif">0</div>
                        <div class="stat-label">Produk tersedia</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between">
                            <span class="small text-muted">Total Terjual</span>
                            <div class="stat-icon red"><i class="bi bi-graph-up-arrow"></i></div>
                        </div>
                        <div class="stat-number">128</div>
                        <div class="stat-label">Akumulasi penjualan dummy</div>
                    </div>
                </div>

            </div>

        </section>

    </div>
</main>


<!-- MODAL TAMBAH PRODUK -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="formTambah" class="modal-content">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold">Tambah Produk Baru</h5>
                    <small class="text-muted">Masukkan informasi produk usaha Anda</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Nama Produk *</label>
                        <input type="text" name="nama_produk" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Kategori *</label>
                        <select name="kategori_id" class="form-select" required id="tambahKategori">
                            <option value="">Pilih kategori</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Harga Produk *</label>
                        <input type="number" name="harga" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Stok Produk *</label>
                        <input type="number" name="stok" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Foto Produk</label>
                        <input type="file" id="gambarTambah" class="form-control" accept="image/*">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small">Deskripsi Produk</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>


<!-- MODAL EDIT PRODUK -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="formEdit" class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="editId">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Nama Produk *</label>
                        <input type="text" id="editNama" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Kategori *</label>
                        <select id="editKategori" class="form-select" required></select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Harga *</label>
                        <input type="number" id="editHarga" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Stok *</label>
                        <input type="number" id="editStok" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Status</label>
                        <select id="editStatus" class="form-select">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Foto Produk</label>
                        <input type="file" id="editGambar" class="form-control" accept="image/*">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small">Deskripsi</label>
                        <textarea id="editDeskripsi" class="form-control" rows="3"></textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Perbarui Produk
                </button>
            </div>
        </form>
    </div>
</div>


<!-- MODAL EDIT PROFIL USAHA -->
<div class="modal fade" id="modalProfil" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form id="formProfil" class="modal-content">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold">Edit Profil Usaha</h5>
                    <small class="text-muted">Perbarui informasi identitas usaha Anda.</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Nama Usaha *</label>
                        <input type="text" id="editNamaUsaha" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Nama Pemilik *</label>
                        <input type="text" id="editPemilik" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Kategori Usaha *</label>
                        <select id="editKategoriUsaha" class="form-select" required>
                            <option value="">Pilih kategori usaha</option>
                            <option value="Makanan dan Minuman">Makanan dan Minuman</option>
                            <option value="Kuliner">Kuliner</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Kerajinan">Kerajinan</option>
                            <option value="Jasa">Jasa</option>
                            <option value="Pertanian">Pertanian</option>
                            <option value="Perdagangan">Perdagangan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Nomor Telepon *</label>
                        <input type="tel" id="editTelepon" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Email Usaha</label>
                        <input type="email" id="editEmail" class="form-control">
                    </div>

                    <!-- FOTO USAHA -->
                    <div class="col-12">
                        <label class="form-label fw-bold small">Foto atau Logo Usaha</label>

                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <div id="previewFotoUsaha">
                                <div class="foto-usaha-placeholder">
                                    <i class="bi bi-shop"></i>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <input type="file" id="inputFotoUsaha"
                                       class="form-control"
                                       accept="image/png,image/jpeg,image/webp">
                                <small class="text-muted">
                                    Format JPG, PNG, atau WEBP. Maksimal 2 MB.
                                </small>
                                <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                                        onclick="hapusFotoUsaha()">
                                    <i class="bi bi-trash me-1"></i> Hapus Foto
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- JADWAL OPERASIONAL -->
                    <div class="col-12">
                        <hr>
                        <h6 class="fw-bold">
                            <i class="bi bi-clock text-primary me-2"></i>
                            Jadwal Operasional
                        </h6>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Jam Buka *</label>
                        <input type="time" id="editJamBuka" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Jam Tutup *</label>
                        <input type="time" id="editJamTutup" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small">Alamat Usaha *</label>
                        <textarea id="editAlamat" class="form-control" rows="2" required></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold small">Deskripsi Usaha</label>
                        <textarea id="editDeskripsiUsaha" class="form-control" rows="4"></textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<!-- FLOATING BUTTON STATUS RESTORAN -->
<button
    type="button"
    id="btnStatusFloating"
    class="btn btn-danger floating-status"
    onclick="ubahStatusRestoran()"
>
    <i class="bi bi-shop-window me-2"></i>
    <span id="teksStatusFloating">TUTUP RESTORAN</span>
</button>