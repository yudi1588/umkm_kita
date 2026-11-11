<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard Admin')</title>

       <!-- CSS Assets (Bootstrap, Icons, FontAwesome) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/dashboard_admin.css'])
</head>
<body>

    @include('partials.sidebar_admin')

   @include('partials.content_admin')

    <!-- Bootstrap 5 JavaScript Bundle (Sudah Diperbaiki Tag Penutupnya) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        
// ==========================================
// KONFIGURASI DAN DATA
// ==========================================

const STORAGE_KEY = 'umkm_admin_data_v1';

function cloneData(data) {
    return JSON.parse(JSON.stringify(data));
}

function ambilDataAwal() {
    return cloneData(window.dataUsahaAwal || []);
}

function muatData() {
    try {
        const tersimpan = localStorage.getItem(STORAGE_KEY);
        return tersimpan ? JSON.parse(tersimpan) : ambilDataAwal();
    } catch (error) {
        console.error('Gagal membaca data:', error);
        return ambilDataAwal();
    }
}

let dataUsaha = muatData();
let usahaTerpilih = null;

function simpanData() {
    try {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(dataUsaha));
        return true;
    } catch (error) {
        tampilkanNotifikasi('Gagal menyimpan data di browser.', 'danger');
        return false;
    }
}


// ==========================================
// HELPER
// ==========================================

function escapeHTML(value) {
    return String(value ?? '').replace(/[&<>"']/g, function (char) {
        return {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[char];
    });
}

function formatRupiah(angka) {
    return 'Rp ' + Number(angka || 0).toLocaleString('id-ID');
}

function totalProduk(usaha) {
    return (usaha.produk || []).length;
}

function cariUsaha(id) {
    return dataUsaha.find(item => Number(item.id) === Number(id));
}

function tampilkanNotifikasi(pesan, jenis = 'success') {
    const toastElement = document.getElementById('adminToast');
    const toastMessage = document.getElementById('toastMessage');

    if (!toastElement || !toastMessage) return;

    toastElement.className = `toast border-0 text-bg-${jenis}`;
    toastMessage.textContent = pesan;

    bootstrap.Toast.getOrCreateInstance(toastElement, {
        delay: 3000
    }).show();
}

function statusBadge(status) {
    return status === 'Aktif'
        ? '<span class="status-badge status-active">Aktif</span>'
        : '<span class="status-badge status-inactive">Nonaktif</span>';
}

function statusOperasionalBadge(buka) {
    return buka
        ? '<span class="status-badge status-open">Sedang Buka</span>'
        : '<span class="status-badge status-closed">Sedang Tutup</span>';
}


// ==========================================
// NAVIGASI HALAMAN
// ==========================================

function pindahHalaman(namaHalaman) {
    document.querySelectorAll('.page-section').forEach(page => {
        page.classList.remove('active');
    });

    document.querySelectorAll('.menu-link').forEach(link => {
        link.classList.remove('active');
    });

    const halaman = document.getElementById('page-' + namaHalaman);

    if (halaman) {
        halaman.classList.add('active');
    }

    const menu = document.querySelector(
        `.menu-link[data-page="${namaHalaman}"]`
    );

    if (menu) menu.classList.add('active');

    const judul = {
        dashboard: 'Dashboard',
        usaha: 'Data Usaha',
        detail: 'Detail Usaha',
        laporan: 'Laporan'
    };

    const subjudul = {
        dashboard: 'Ringkasan aktivitas UMKM Kita',
        usaha: 'Kelola data pemilik usaha',
        detail: 'Informasi lengkap usaha dan produk',
        laporan: 'Rekapitulasi data UMKM'
    };

    document.getElementById('pageTitle').textContent =
        judul[namaHalaman] || 'Dashboard';

    document.getElementById('pageSubtitle').textContent =
        subjudul[namaHalaman] || '';

    document.getElementById('sidebar').classList.remove('show');

    if (namaHalaman === 'usaha') tampilkanSemuaUsaha();
    if (namaHalaman === 'laporan') tampilkanLaporan();
}

document.querySelectorAll('.menu-link').forEach(link => {
    link.addEventListener('click', function (event) {
        event.preventDefault();
        pindahHalaman(this.dataset.page);
    });
});

document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('show');
});


// ==========================================
// DASHBOARD STATISTIK
// ==========================================

function tampilkanDashboard() {
    const jumlahUsaha = dataUsaha.length;

    const jumlahProduk = dataUsaha.reduce(
        (total, usaha) => total + totalProduk(usaha), 0
    );

    const usahaAktif = dataUsaha.filter(
        usaha => usaha.status === 'Aktif'
    ).length;

    const usahaBuka = dataUsaha.filter(
        usaha => usaha.statusBuka === true
    ).length;

    document.getElementById('statTotalUsaha').textContent = jumlahUsaha;
    document.getElementById('statTotalProduk').textContent = jumlahProduk;
    document.getElementById('statUsahaAktif').textContent = usahaAktif;
    document.getElementById('statUsahaBuka').textContent = usahaBuka;

    tampilkanUsahaTerbaru();
    tampilkanKategori();
}

function tampilkanUsahaTerbaru() {
    const tbody = document.getElementById('tabelUsahaTerbaru');

    const data = [...dataUsaha].slice(-5).reverse();

    if (!data.length) {
        tbody.innerHTML = `
            <tr><td colspan="4" class="empty-state">
                <i class="bi bi-shop"></i>Belum ada data usaha.
            </td></tr>
        `;
        return;
    }

    tbody.innerHTML = data.map(usaha => `
        <tr>
            <td>
                <div class="business-name">${escapeHTML(usaha.nama)}</div>
                <div class="business-subtitle">${escapeHTML(usaha.alamat)}</div>
            </td>
            <td>${escapeHTML(usaha.pemilik)}</td>
            <td>${escapeHTML(usaha.kategori)}</td>
            <td>${statusBadge(usaha.status)}</td>
        </tr>
    `).join('');
}

function tampilkanKategori() {
    const container = document.getElementById('ringkasanKategori');

    const kategori = {};

    dataUsaha.forEach(usaha => {
        const nama = usaha.kategori || 'Lainnya';
        kategori[nama] = (kategori[nama] || 0) + 1;
    });

    const daftar = Object.entries(kategori);
    const maksimum = Math.max(...daftar.map(item => item[1]), 1);

    if (!daftar.length) {
        container.innerHTML = '<p class="text-muted small">Belum ada data kategori.</p>';
        return;
    }

    container.innerHTML = daftar.map(([nama, jumlah]) => {
        const persen = Math.round((jumlah / maksimum) * 100);

        return `
            <div class="category-item">
                <div class="category-info">
                    <strong>${escapeHTML(nama)}</strong>
                    <span>${jumlah} usaha</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width:${persen}%"></div>
                </div>
            </div>
        `;
    }).join('');
}


// ==========================================
// DATA USAHA - READ
// ==========================================

function tampilkanSemuaUsaha() {
    const tbody = document.getElementById('tabelSemuaUsaha');

    const keyword = document.getElementById('cariUsaha').value.toLowerCase();
    const filterStatus = document.getElementById('filterStatus').value;
    const filterKategori = document.getElementById('filterKategori').value;

    const hasil = dataUsaha.filter(usaha => {
        const cocokKata =
            usaha.nama.toLowerCase().includes(keyword) ||
            usaha.pemilik.toLowerCase().includes(keyword) ||
            usaha.alamat.toLowerCase().includes(keyword);

        const cocokStatus = !filterStatus || usaha.status === filterStatus;
        const cocokKategori = !filterKategori || usaha.kategori === filterKategori;

        return cocokKata && cocokStatus && cocokKategori;
    });

    if (!hasil.length) {
        tbody.innerHTML = `
            <tr><td colspan="7" class="empty-state">
                <i class="bi bi-search"></i>Data usaha tidak ditemukan.
            </td></tr>
        `;
    } else {
        tbody.innerHTML = hasil.map((usaha, index) => `
            <tr>
                <td>${index + 1}</td>

                <td>
                    <div class="business-name">${escapeHTML(usaha.nama)}</div>
                    <div class="business-subtitle">${escapeHTML(usaha.email || '-')}</div>
                </td>

                <td>${escapeHTML(usaha.pemilik)}</td>
                <td>${escapeHTML(usaha.kategori)}</td>
                <td>${totalProduk(usaha)} Produk</td>
                <td>${statusBadge(usaha.status)}</td>

                <td>
                    <div class="action-buttons">
                        <button class="action-btn action-view"
                            title="Detail"
                            onclick="lihatDetailUsaha(${usaha.id})">
                            <i class="bi bi-eye"></i>
                        </button>

                        <button class="action-btn action-edit"
                            title="Edit"
                            onclick="editUsaha(${usaha.id})">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <button class="action-btn action-delete"
                            title="Hapus"
                            onclick="hapusUsaha(${usaha.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    document.getElementById('jumlahDataUsaha').textContent =
        `Menampilkan ${hasil.length} dari ${dataUsaha.length} usaha`;

    perbaruiFilterKategori();
}

function perbaruiFilterKategori() {
    const select = document.getElementById('filterKategori');
    const nilaiLama = select.value;

    const kategori = [...new Set(dataUsaha.map(usaha => usaha.kategori))];

    select.innerHTML = '<option value="">Semua Kategori</option>' +
        kategori.map(item =>
            `<option value="${escapeHTML(item)}">${escapeHTML(item)}</option>`
        ).join('');

    select.value = kategori.includes(nilaiLama) ? nilaiLama : '';
}

document.getElementById('cariUsaha').addEventListener('input', tampilkanSemuaUsaha);
document.getElementById('filterStatus').addEventListener('change', tampilkanSemuaUsaha);
document.getElementById('filterKategori').addEventListener('change', tampilkanSemuaUsaha);


// ==========================================
// DATA USAHA - CREATE
// ==========================================

const modalUsaha = new bootstrap.Modal(document.getElementById('modalUsaha'));

function bukaModalUsaha() {
    document.getElementById('formUsaha').reset();
    document.getElementById('usahaId').value = '';
    document.getElementById('judulModalUsaha').textContent = 'Tambah Pemilik Usaha';

    document.getElementById('jamBukaUsaha').value = '08:00';
    document.getElementById('jamTutupUsaha').value = '21:00';

    modalUsaha.show();
}


// ==========================================
// DATA USAHA - CREATE / UPDATE
// ==========================================

document.getElementById('formUsaha').addEventListener('submit', function (event) {
    event.preventDefault();

    const id = document.getElementById('usahaId').value;

    const data = {
        nama: document.getElementById('namaUsaha').value.trim(),
        pemilik: document.getElementById('namaPemilik').value.trim(),
        kategori: document.getElementById('kategoriUsaha').value,
        telepon: document.getElementById('teleponUsaha').value.trim(),
        email: document.getElementById('emailUsaha').value.trim(),
        status: document.getElementById('statusUsaha').value,
        jamBuka: document.getElementById('jamBukaUsaha').value,
        jamTutup: document.getElementById('jamTutupUsaha').value,
        alamat: document.getElementById('alamatUsaha').value.trim(),
        deskripsi: document.getElementById('deskripsiUsaha').value.trim()
    };

    if (id) {
        const index = dataUsaha.findIndex(item => Number(item.id) === Number(id));

        if (index !== -1) {
            dataUsaha[index] = {
                ...dataUsaha[index],
                ...data,
                statusBuka: dataUsaha[index].statusBuka ?? false
            };
        }

        tampilkanNotifikasi('Data usaha berhasil diperbarui.');
    } else {
        dataUsaha.push({
            id: Date.now(),
            ...data,
            statusBuka: false,
            tanggal: new Date().toISOString().slice(0, 10),
            produk: []
        });

        tampilkanNotifikasi('Pemilik usaha berhasil ditambahkan.');
    }

    if (!simpanData()) return;

    modalUsaha.hide();
    refreshSemua();
});


// ==========================================
// DATA USAHA - UPDATE
// ==========================================

function editUsaha(id) {
    const usaha = cariUsaha(id);

    if (!usaha) return;

    document.getElementById('usahaId').value = usaha.id;
    document.getElementById('namaUsaha').value = usaha.nama;
    document.getElementById('namaPemilik').value = usaha.pemilik;
    document.getElementById('kategoriUsaha').value = usaha.kategori;
    document.getElementById('teleponUsaha').value = usaha.telepon;
    document.getElementById('emailUsaha').value = usaha.email || '';
    document.getElementById('statusUsaha').value = usaha.status;
    document.getElementById('jamBukaUsaha').value = usaha.jamBuka || '08:00';
    document.getElementById('jamTutupUsaha').value = usaha.jamTutup || '21:00';
    document.getElementById('alamatUsaha').value = usaha.alamat;
    document.getElementById('deskripsiUsaha').value = usaha.deskripsi || '';

    document.getElementById('judulModalUsaha').textContent = 'Edit Data Usaha';

    modalUsaha.show();
}


// ==========================================
// DATA USAHA - DELETE
// ==========================================

function hapusUsaha(id) {
    const usaha = cariUsaha(id);

    if (!usaha) return;

    if (!confirm(`Apakah Anda yakin ingin menghapus usaha "${usaha.nama}" beserta seluruh produknya?`)) {
        return;
    }

    dataUsaha = dataUsaha.filter(item => Number(item.id) !== Number(id));

    if (!simpanData()) return;

    tampilkanNotifikasi('Data usaha berhasil dihapus.', 'warning');
    refreshSemua();
}


// ==========================================
// DETAIL USAHA
// ==========================================

function lihatDetailUsaha(id) {
    const usaha = cariUsaha(id);

    if (!usaha) return;

    usahaTerpilih = id;

    const container = document.getElementById('kontenDetailUsaha');

    container.innerHTML = `
        <div class="detail-business-header">
            <span class="badge bg-light text-success">INFORMASI USAHA</span>
            <h3>${escapeHTML(usaha.nama)}</h3>
            <p>${escapeHTML(usaha.kategori)} · Pemilik: ${escapeHTML(usaha.pemilik)}</p>

            <div class="mt-3 d-flex flex-wrap gap-2">
                ${statusBadge(usaha.status)}
                ${statusOperasionalBadge(usaha.statusBuka)}
            </div>
        </div>

        <div class="content-card mb-4">
            <div class="card-heading">
                <div>
                    <h5>Informasi Pemilik dan Usaha</h5>
                    <p>Informasi lengkap profil usaha</p>
                </div>

                <button class="btn btn-light-custom" onclick="editUsaha(${usaha.id})">
                    <i class="bi bi-pencil me-1"></i>Edit Usaha
                </button>
            </div>

            <div class="detail-info-grid">
                <div class="detail-info-item">
                    <small>Nama Pemilik</small>
                    <strong>${escapeHTML(usaha.pemilik)}</strong>
                </div>

                <div class="detail-info-item">
                    <small>Kategori Usaha</small>
                    <strong>${escapeHTML(usaha.kategori)}</strong>
                </div>

                <div class="detail-info-item">
                    <small>Nomor Telepon</small>
                    <strong>${escapeHTML(usaha.telepon)}</strong>
                </div>

                <div class="detail-info-item">
                    <small>Email</small>
                    <strong>${escapeHTML(usaha.email || '-')}</strong>
                </div>

                <div class="detail-info-item">
                    <small>Jam Operasional</small>
                    <strong>${escapeHTML(usaha.jamBuka || '-')} - ${escapeHTML(usaha.jamTutup || '-')}</strong>
                </div>

                <div class="detail-info-item">
                    <small>Tanggal Terdaftar</small>
                    <strong>${escapeHTML(usaha.tanggal || '-')}</strong>
                </div>

                <div class="detail-info-item" style="grid-column:1/-1">
                    <small>Alamat Usaha</small>
                    <strong>${escapeHTML(usaha.alamat)}</strong>
                </div>
            </div>

            <hr class="my-4">

            <small class="text-muted fw-bold">DESKRIPSI USAHA</small>
            <p class="detail-description mt-2 mb-0">
                ${escapeHTML(usaha.deskripsi || 'Belum ada deskripsi usaha.')}
            </p>
        </div>

        <div class="content-card">
            <div class="card-heading">
                <div>
                    <h5>Produk yang Dijual</h5>
                    <p>${totalProduk(usaha)} produk terdaftar pada usaha ini</p>
                </div>

                <button class="btn btn-primary-custom" onclick="bukaModalProduk(${usaha.id})">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Produk
                </button>
            </div>

            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        ${buatBarisProduk(usaha)}
                    </tbody>
                </table>
            </div>
        </div>
    `;

    pindahHalaman('detail');
}

function buatBarisProduk(usaha) {
    if (!usaha.produk || usaha.produk.length === 0) {
        return `
            <tr>
                <td colspan="7" class="empty-state">
                    <i class="bi bi-box-seam"></i>Belum ada produk pada usaha ini.
                </td>
            </tr>
        `;
    }

    return usaha.produk.map((produk, index) => `
        <tr>
            <td>${index + 1}</td>
            <td><strong>${escapeHTML(produk.nama)}</strong></td>
            <td>${escapeHTML(produk.kategori)}</td>
            <td>${formatRupiah(produk.harga)}</td>
            <td>${Number(produk.stok)}</td>
            <td>
                <span class="status-badge ${produk.status === 'Tersedia' ? 'status-active' : 'status-inactive'}">
                    ${escapeHTML(produk.status)}
                </span>
            </td>
            <td>
                <div class="action-buttons">
                    <button class="action-btn action-edit"
                        title="Edit Produk"
                        onclick="editProduk(${usaha.id}, ${produk.id})">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <button class="action-btn action-delete"
                        title="Hapus Produk"
                        onclick="hapusProduk(${usaha.id}, ${produk.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}


// ==========================================
// PRODUK - CREATE
// ==========================================

const modalProduk = new bootstrap.Modal(document.getElementById('modalProduk'));

function bukaModalProduk(usahaId) {
    document.getElementById('formProduk').reset();
    document.getElementById('produkUsahaId').value = usahaId;
    document.getElementById('produkId').value = '';
    document.getElementById('judulModalProduk').textContent = 'Tambah Produk';

    modalProduk.show();
}


// ==========================================
// PRODUK - CREATE / UPDATE
// ==========================================

document.getElementById('formProduk').addEventListener('submit', function (event) {
    event.preventDefault();

    const usahaId = Number(document.getElementById('produkUsahaId').value);
    const produkId = document.getElementById('produkId').value;

    const usaha = cariUsaha(usahaId);

    if (!usaha) return;

    const produkBaru = {
        nama: document.getElementById('namaProduk').value.trim(),
        kategori: document.getElementById('kategoriProduk').value.trim(),
        harga: Number(document.getElementById('hargaProduk').value),
        stok: Number(document.getElementById('stokProduk').value),
        status: document.getElementById('statusProduk').value
    };

    usaha.produk = usaha.produk || [];

    if (produkId) {
        const index = usaha.produk.findIndex(
            item => Number(item.id) === Number(produkId)
        );

        if (index !== -1) {
            usaha.produk[index] = {
                ...usaha.produk[index],
                ...produkBaru
            };
        }

        tampilkanNotifikasi('Produk berhasil diperbarui.');
    } else {
        usaha.produk.push({
            id: Date.now(),
            ...produkBaru
        });

        tampilkanNotifikasi('Produk berhasil ditambahkan.');
    }

    if (!simpanData()) return;

    modalProduk.hide();

    tampilkanDashboard();
    lihatDetailUsaha(usahaId);
});


// ==========================================
// PRODUK - UPDATE
// ==========================================

function editProduk(usahaId, produkId) {
    const usaha = cariUsaha(usahaId);
    if (!usaha) return;

    const produk = usaha.produk.find(
        item => Number(item.id) === Number(produkId)
    );

    if (!produk) return;

    document.getElementById('produkUsahaId').value = usahaId;
    document.getElementById('produkId').value = produk.id;
    document.getElementById('namaProduk').value = produk.nama;
    document.getElementById('kategoriProduk').value = produk.kategori;
    document.getElementById('hargaProduk').value = produk.harga;
    document.getElementById('stokProduk').value = produk.stok;
    document.getElementById('statusProduk').value = produk.status;

    document.getElementById('judulModalProduk').textContent = 'Edit Produk';

    modalProduk.show();
}


// ==========================================
// PRODUK - DELETE
// ==========================================

function hapusProduk(usahaId, produkId) {
    const usaha = cariUsaha(usahaId);
    if (!usaha) return;

    const produk = usaha.produk.find(
        item => Number(item.id) === Number(produkId)
    );

    if (!produk) return;

    if (!confirm(`Hapus produk "${produk.nama}"?`)) return;

    usaha.produk = usaha.produk.filter(
        item => Number(item.id) !== Number(produkId)
    );

    if (!simpanData()) return;

    tampilkanNotifikasi('Produk berhasil dihapus.', 'warning');

    tampilkanDashboard();
    lihatDetailUsaha(usahaId);
}


// ==========================================
// LAPORAN
// ==========================================

function tampilkanLaporan() {
    const totalUsaha = dataUsaha.length;

    const totalProdukSemua = dataUsaha.reduce(
        (total, usaha) => total + totalProduk(usaha), 0
    );

    const usahaAktif = dataUsaha.filter(
        usaha => usaha.status === 'Aktif'
    ).length;

    document.getElementById('laporanTotalUsaha').textContent = totalUsaha;
    document.getElementById('laporanTotalProduk').textContent = totalProdukSemua;
    document.getElementById('laporanUsahaAktif').textContent = usahaAktif;

    document.getElementById('tanggalLaporan').textContent =
        'Diperbarui pada ' + new Date().toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

    const tbody = document.getElementById('tabelLaporan');

    if (!dataUsaha.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="empty-state">Belum ada data laporan.</td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = dataUsaha.map((usaha, index) => `
        <tr>
            <td>${index + 1}</td>
            <td>${escapeHTML(usaha.nama)}</td>
            <td>${escapeHTML(usaha.pemilik)}</td>
            <td>${escapeHTML(usaha.kategori)}</td>
            <td>${totalProduk(usaha)}</td>
            <td>${statusBadge(usaha.status)}</td>
            <td>${statusOperasionalBadge(usaha.statusBuka)}</td>
        </tr>
    `).join('');
}

function cetakLaporan() {
    pindahHalaman('laporan');
    window.print();
}


// ==========================================
// REFRESH SELURUH DATA
// ==========================================

function refreshSemua() {
    tampilkanDashboard();
    tampilkanSemuaUsaha();
    tampilkanLaporan();
}


// ==========================================
// INISIALISASI
// ==========================================

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('tanggalHariIni').textContent =
        new Date().toLocaleDateString('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

    refreshSemua();
});

    </script>

</body>
</html>