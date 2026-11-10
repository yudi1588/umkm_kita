<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pemilik')</title>

    <!-- CSS Assets (Bootstrap, Icons, FontAwesome) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Laravel Vite Asset Compiler -->
    @vite(['resources/css/dashboard_pemilik.css'])
</head>
<body>

    <!-- Template Partials -->
    @include('partials.sidebar_pemilik')
    @include('partials.content_pemilik')

    <!-- Bootstrap 5 JavaScript Bundle (Sudah Diperbaiki Tag Penutupnya) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        
// =====================================
// DATA DAN LOCAL STORAGE
// =====================================

const defaultProfil = {
    namaPemilik:"Rifky Aditya",
    namaUsaha:"Iyowes Eskrim",
    kategori:"Makanan dan Minuman",
    telepon:"081234567890",
    email:"iyowes@example.com",
    alamat:"Kota Probolinggo, Jawa Timur",
    deskripsi:"Iyowes Eskrim merupakan usaha yang menyediakan berbagai pilihan es krim dengan harga terjangkau.",
    gambarUsaha:"",
    jamBuka:"08:00",
    jamTutup:"21:00",
    statusBuka:true
};

const defaultKategori = [
    {id:1,nama:"Makanan"},
    {id:2,nama:"Minuman"},
    {id:3,nama:"Dessert"},
    {id:4,nama:"Camilan"}
];

const defaultProduk = [
    {
        id:1,nama:"Es Krim Cokelat",kategori_id:3,
        harga:5000,stok:45,status:"aktif",
        deskripsi:"Es krim rasa cokelat dengan tekstur lembut.",
        gambar:"https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=200"
    },
    {
        id:2,nama:"Es Krim Stroberi",kategori_id:3,
        harga:5000,stok:3,status:"aktif",
        deskripsi:"Es krim stroberi segar.",
        gambar:"https://images.unsplash.com/photo-1497034825429-c343d7c6a68f?w=200"
    },
    {
        id:3,nama:"Es Krim Vanilla",kategori_id:3,
        harga:3000,stok:25,status:"aktif",
        deskripsi:"Es krim vanilla premium.",
        gambar:"https://images.unsplash.com/photo-1501446529957-6226bd447c46?w=200"
    },
    {
        id:4,nama:"Es Krim Matcha",kategori_id:3,
        harga:7000,stok:0,status:"nonaktif",
        deskripsi:"Es krim matcha Jepang.",
        gambar:"https://images.unsplash.com/photo-1488900128323-21503983a07e?w=200"
    },
    {
        id:5,nama:"Es Krim Mangga",kategori_id:3,
        harga:5000,stok:12,status:"aktif",
        deskripsi:"Es krim rasa mangga.",
        gambar:"https://images.unsplash.com/photo-1516559828984-fb3b99548b21?w=200"
    }
];

function ambilData(key,defaultData){
    try{
        const data=localStorage.getItem(key);
        return data ? JSON.parse(data) : defaultData;
    }catch(error){
        return defaultData;
    }
}

let profil={
    ...defaultProfil,
    ...ambilData("umkm_profil",defaultProfil)
};


let kategori=defaultKategori;
let produk=ambilData("umkm_produk",defaultProduk);

const totalTerjual=128;

function simpanProduk(){
    try{
        localStorage.setItem("umkm_produk",JSON.stringify(produk));
    }catch(error){
        notifikasi("Penyimpanan penuh. Periksa ukuran gambar produk.","danger");
    }
}

function simpanProfil(){
    try{
        localStorage.setItem("umkm_profil",JSON.stringify(profil));
    }catch(error){
        notifikasi("Penyimpanan penuh. Coba gunakan gambar yang lebih kecil.","danger");
    }
}








// =====================================
// NAVIGASI HALAMAN
// =====================================

function pindahHalaman(nama,element=null){

    document.querySelectorAll('.page-section').forEach(page=>{
        page.classList.remove('active');
    });

    document.getElementById('halaman-'+nama).classList.add('active');

    document.querySelectorAll('.nav-link-custom').forEach(link=>{
        link.classList.remove('active');
    });

    if(element){
        element.classList.add('active');
    }else{
        const menu=[...document.querySelectorAll('.nav-link-custom')].find(el=>{
            return el.getAttribute('onclick')?.includes("'"+nama+"'");
        });
        if(menu)menu.classList.add('active');
    }

    const judul={
        dashboard:"Dashboard Pemilik Usaha",
        produk:"Manajemen Produk",
        profil:"Profil Usaha"
    };

    const subjudul={
        dashboard:"Kelola dan pantau perkembangan usaha Anda",
        produk:"Kelola seluruh produk usaha Anda",
        profil:"Kelola informasi identitas usaha Anda"
    };

    document.getElementById('judulHalaman').textContent=judul[nama];
    document.getElementById('subJudul').textContent=subjudul[nama];

    document.getElementById('sidebar').classList.remove('show');

    window.scrollTo({top:0,behavior:'smooth'});
}

function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('show');
}


// =====================================
// NOTIFIKASI
// =====================================

function notifikasi(pesan,jenis='success'){

    const container=document.getElementById('notifikasi');

    container.innerHTML=`
        <div class="alert alert-${jenis} alert-dismissible fade show">
            ${escapeHTML(pesan)}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    window.scrollTo({top:0,behavior:'smooth'});
}


// =====================================
// FORMAT RUPIAH DAN ESCAPE HTML
// =====================================

function rupiah(angka){
    return 'Rp'+Number(angka).toLocaleString('id-ID');
}

function escapeHTML(value){
    return String(value ?? '').replace(/[&<>"']/g,char=>({
        '&':'&amp;',
        '<':'&lt;',
        '>':'&gt;',
        '"':'&quot;',
        "'":'&#039;'
    }[char]));
}


// =====================================
// IDENTITAS PEMILIK
// =====================================

function updateIdentitas(){

    document.getElementById('namaPemilikTop').textContent=profil.namaPemilik;

    document.getElementById('avatar').textContent=
        profil.namaPemilik.charAt(0).toUpperCase();

    document.getElementById('welcomeNama').textContent=
        'Halo, '+profil.namaPemilik+'! 👋';

    document.getElementById('welcomeUsaha').innerHTML=
        `Selamat datang di panel pengelolaan <strong>${escapeHTML(profil.namaUsaha)}</strong>. Mari kembangkan usaha lokal Anda.`;

    document.getElementById('dashNamaUsaha').textContent=profil.namaUsaha;
    document.getElementById('dashNamaPemilik').textContent=profil.namaPemilik;
}


// =====================================
// FOTO USAHA
// =====================================

function tampilkanFotoUsaha(){

    const gambar=profil.gambarUsaha
        ? `<img src="${profil.gambarUsaha}" class="foto-usaha" alt="Foto Usaha">`
        : `<div class="foto-usaha-placeholder"><i class="bi bi-shop"></i></div>`;

    document.getElementById('fotoUsahaContainer').innerHTML=gambar;
    document.getElementById('previewFotoUsaha').innerHTML=gambar;

}

function hapusFotoUsaha(){

    profil.gambarUsaha='';

    document.getElementById('inputFotoUsaha').value='';

    document.getElementById('previewFotoUsaha').innerHTML=
        `<div class="foto-usaha-placeholder"><i class="bi bi-shop"></i></div>`;

}

document.getElementById('inputFotoUsaha').addEventListener('change',function(){

    const file=this.files[0];
    if(!file)return;

    if(!['image/jpeg','image/png','image/webp'].includes(file.type)){
        notifikasi('Format gambar harus JPG, PNG, atau WEBP!','danger');
        this.value='';
        return;
    }

    if(file.size>2*1024*1024){
        notifikasi('Ukuran gambar maksimal 2 MB!','warning');
        this.value='';
        return;
    }

    const reader=new FileReader();

    reader.onload=()=>{
        document.getElementById('previewFotoUsaha').innerHTML=
            `<img src="${reader.result}" class="foto-usaha" alt="Preview Foto">`;
    };

    reader.readAsDataURL(file);

});

// =====================================
// STATUS RESTORAN
// =====================================

function tampilkanStatusRestoran() {

    const buka = profil.statusBuka === true;

    const badge = document.getElementById('badgeStatusRestoran');
    const indikator = document.getElementById('indikatorStatus');
    const tombol = document.getElementById('btnStatusRestoran');
    const keterangan = document.getElementById('keteranganStatus');

    // STATUS PADA HALAMAN PROFIL
    if (badge) {
        badge.className = buka ? 'badge-active' : 'badge-inactive';
        badge.textContent = buka ? 'BUKA' : 'TUTUP';
    }

    if (indikator) {
        indikator.innerHTML = buka
            ? `
                <span class="status-dot buka"></span>
                <span>Restoran sedang buka</span>
              `
            : `
                <span class="status-dot tutup"></span>
                <span>Restoran sedang tutup</span>
              `;
    }

    if (tombol) {
        tombol.className = buka
            ? 'btn btn-danger btn-status'
            : 'btn btn-success btn-status';

        tombol.innerHTML = buka
            ? `<i class="bi bi-shop-window me-2"></i> TUTUP RESTORAN`
            : `<i class="bi bi-shop me-2"></i> BUKA RESTORAN`;
    }

    if (keterangan) {
        keterangan.textContent = buka
            ? 'Restoran sedang menerima pesanan.'
            : 'Restoran sedang tidak menerima pesanan.';
    }


    // =====================================
    // SINKRONISASI DASHBOARD
    // =====================================

    const statusDashboard = document.getElementById('statusDashboard');
    const tombolDashboard = document.getElementById('btnStatusDashboard');
    const jadwalDashboard = document.getElementById('jadwalDashboard');

    if (statusDashboard) {
        statusDashboard.innerHTML = buka
            ? '<span class="badge-active">BUKA</span>'
            : '<span class="badge-inactive">TUTUP</span>';
    }

    if (tombolDashboard) {
        tombolDashboard.className = buka
            ? 'btn btn-danger btn-status'
            : 'btn btn-success btn-status';

        tombolDashboard.innerHTML = buka
            ? '<i class="bi bi-shop-window me-2"></i> TUTUP RESTORAN'
            : '<i class="bi bi-shop me-2"></i> BUKA RESTORAN';
    }

    if (jadwalDashboard) {
        jadwalDashboard.textContent =
            (profil.jamBuka || '08:00') + ' - ' +
            (profil.jamTutup || '21:00');
    }


    // =====================================
    // SINKRONISASI FLOATING BUTTON
    // =====================================

    const tombolFloating = document.getElementById('btnStatusFloating');
    const teksFloating = document.getElementById('teksStatusFloating');

    if (tombolFloating && teksFloating) {

        if (buka) {
            tombolFloating.className = 'btn btn-danger floating-status';

            teksFloating.innerHTML = `
                <i class="bi bi-shop-window me-2"></i>
                TUTUP RESTORAN
            `;
        } else {
            tombolFloating.className = 'btn btn-success floating-status';

            teksFloating.innerHTML = `
                <i class="bi bi-shop me-2"></i>
                BUKA RESTORAN
            `;
        }
    }
}


// =====================================
// UBAH STATUS RESTORAN
// =====================================

function ubahStatusRestoran() {

    profil.statusBuka = !profil.statusBuka;

    simpanProfil();

    // Perbarui semua indikator dan tombol
    tampilkanStatusRestoran();

    notifikasi(
        profil.statusBuka
            ? 'Restoran berhasil dibuka dan siap menerima pesanan!'
            : 'Restoran berhasil ditutup dan tidak menerima pesanan.',
        profil.statusBuka ? 'success' : 'warning'
    );
}

// =====================================
// TAMPILKAN PROFIL
// =====================================

function tampilkanProfil(){

    document.getElementById('profilHeaderNama').textContent=profil.namaUsaha;

    document.getElementById('detailNamaUsaha').textContent=profil.namaUsaha;
    document.getElementById('detailKategori').textContent=profil.kategori;
    document.getElementById('detailPemilik').textContent=profil.namaPemilik;
    document.getElementById('detailTelepon').textContent=profil.telepon;
    document.getElementById('detailEmail').textContent=profil.email||'-';
    document.getElementById('detailAlamat').textContent=profil.alamat;
    document.getElementById('detailDeskripsi').textContent=profil.deskripsi||'-';

    document.getElementById('tampilJamBuka').textContent=profil.jamBuka||'08:00';
    document.getElementById('tampilJamTutup').textContent=profil.jamTutup||'21:00';

    tampilkanFotoUsaha();
    tampilkanStatusRestoran();

    document.getElementById('profilJumlahProduk').textContent=produk.length;
    document.getElementById('profilProdukAktif').textContent=
        produk.filter(p=>p.status==='aktif').length;
}


// =====================================
// EDIT PROFIL USAHA
// =====================================

function bukaEditProfil(){

    document.getElementById('editNamaUsaha').value=profil.namaUsaha;
    document.getElementById('editPemilik').value=profil.namaPemilik;
    document.getElementById('editKategoriUsaha').value=profil.kategori;
    document.getElementById('editTelepon').value=profil.telepon;
    document.getElementById('editEmail').value=profil.email;
    document.getElementById('editAlamat').value=profil.alamat;
    document.getElementById('editDeskripsiUsaha').value=profil.deskripsi;

    document.getElementById('editJamBuka').value=profil.jamBuka||'08:00';
    document.getElementById('editJamTutup').value=profil.jamTutup||'21:00';

    document.getElementById('inputFotoUsaha').value='';

    const gambar=profil.gambarUsaha
        ? `<img src="${profil.gambarUsaha}" class="foto-usaha" alt="Preview Foto">`
        : `<div class="foto-usaha-placeholder"><i class="bi bi-shop"></i></div>`;

    document.getElementById('previewFotoUsaha').innerHTML=gambar;

    bootstrap.Modal.getOrCreateInstance(
        document.getElementById('modalProfil')
    ).show();
}

document.getElementById('formProfil').addEventListener('submit',function(e){

    e.preventDefault();

    const jamBuka=document.getElementById('editJamBuka').value;
    const jamTutup=document.getElementById('editJamTutup').value;

    if(jamBuka===jamTutup){
        notifikasi('Jam buka dan jam tutup tidak boleh sama!','warning');
        return;
    }

    const simpanPerubahan=function(gambar){

        profil={
            ...profil,
            namaUsaha:document.getElementById('editNamaUsaha').value.trim(),
            namaPemilik:document.getElementById('editPemilik').value.trim(),
            kategori:document.getElementById('editKategoriUsaha').value,
            telepon:document.getElementById('editTelepon').value.trim(),
            email:document.getElementById('editEmail').value.trim(),
            alamat:document.getElementById('editAlamat').value.trim(),
            deskripsi:document.getElementById('editDeskripsiUsaha').value.trim(),
            jamBuka:jamBuka,
            jamTutup:jamTutup,
            gambarUsaha:gambar
        };

        simpanProfil();
        updateIdentitas();
        tampilkanProfil();

        bootstrap.Modal.getInstance(
            document.getElementById('modalProfil')
        ).hide();

        notifikasi('Profil usaha berhasil diperbarui!');
    };

    const file=document.getElementById('inputFotoUsaha').files[0];

    if(file){

        if(!['image/jpeg','image/png','image/webp'].includes(file.type)){
            notifikasi('Format gambar harus JPG, PNG, atau WEBP!','danger');
            return;
        }

        if(file.size>2*1024*1024){
            notifikasi('Ukuran gambar maksimal 2 MB!','warning');
            return;
        }

        const reader=new FileReader();

        reader.onload=function(){
            simpanPerubahan(reader.result);
        };

        reader.readAsDataURL(file);

    }else{
        simpanPerubahan(profil.gambarUsaha||'');
    }

});


// =====================================
// KATEGORI
// =====================================

function isiKategori(){

    const pilihan=kategori.map(k=>
        `<option value="${k.id}">${escapeHTML(k.nama)}</option>`
    ).join('');

    document.getElementById('searchKategori').innerHTML=
        '<option value="">Semua Kategori</option>'+pilihan;

    document.getElementById('tambahKategori').innerHTML=
        '<option value="">Pilih kategori</option>'+pilihan;

    document.getElementById('editKategori').innerHTML=
        '<option value="">Pilih kategori</option>'+pilihan;
}


// =====================================
// STATISTIK
// =====================================

function updateStatistik(){

    const aktif=produk.filter(p=>p.status==='aktif').length;
    const menipis=produk.filter(p=>p.stok<=5).length;

    document.getElementById('totalProduk').textContent=produk.length;
    document.getElementById('produkAktif').textContent=aktif;
    document.getElementById('stokMenipis').textContent=menipis;
    document.getElementById('totalTerjual').textContent=totalTerjual;

    document.getElementById('produkTotalHalaman').textContent=produk.length;
    document.getElementById('produkAktifHalaman').textContent=aktif;
    document.getElementById('stokHalaman').textContent=menipis;

    document.getElementById('profilJumlahProduk').textContent=produk.length;
    document.getElementById('profilProdukAktif').textContent=aktif;
}



// =====================================
// TAMPILKAN PRODUK
// =====================================

function buatBarisProduk(item,aksi=false){

    const kat=kategori.find(k=>k.id==item.kategori_id);

    return `
    <tr>
        <td>
            <div class="d-flex align-items-center gap-2">
                ${item.gambar
                    ? `<img src="${item.gambar}" class="product-image" alt="Produk">`
                    : `<div class="product-image d-grid place-items-center"><i class="bi bi-image text-muted fs-4"></i></div>`
                }
                <div>
                    <div class="fw-bold">${escapeHTML(item.nama)}</div>
                    <small class="text-muted">ID #${item.id}</small>
                </div>
            </div>
        </td>

        <td>${kat?escapeHTML(kat.nama):'-'}</td>
        <td class="fw-bold">${rupiah(item.harga)}</td>
        <td>${item.stok}</td>

        <td>
            ${item.status==='aktif'
                ? '<span class="badge-active">Aktif</span>'
                : '<span class="badge-inactive">Tidak Aktif</span>'
            }
        </td>

        ${aksi?`
        <td class="text-center text-nowrap">
            <button class="btn btn-sm btn-light border text-primary"
                    onclick="editProduk(${item.id})">
                <i class="bi bi-pencil-square"></i>
            </button>

            <button class="btn btn-sm btn-light border text-danger"
                    onclick="hapusProduk(${item.id})">
                <i class="bi bi-trash"></i>
            </button>
        </td>`:''}
    </tr>`;
}

function tampilkanProduk(data=produk){

    const tbody=document.getElementById('tabelProduk');

    if(data.length===0){
        tbody.innerHTML=`
        <tr>
            <td colspan="6" class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-secondary"></i>
                <h6 class="mt-3 fw-bold">Belum Ada Produk</h6>
                <p class="text-muted small">Silakan tambahkan produk pertama Anda.</p>
            </td>
        </tr>`;
        return;
    }

    tbody.innerHTML=data.map(item=>buatBarisProduk(item,true)).join('');
}

function tampilkanProdukTerbaru(){

    const terbaru=[...produk].sort((a,b)=>b.id-a.id).slice(0,5);
    const tbody=document.getElementById('produkTerbaru');

    if(!terbaru.length){
        tbody.innerHTML=`
            <tr><td colspan="5" class="text-center py-4 text-muted">
                Belum ada produk.
            </td></tr>`;
        return;
    }

    tbody.innerHTML=terbaru.map(item=>buatBarisProduk(item,false)).join('');
}


// =====================================
// TAMBAH PRODUK
// =====================================

function bukaTambah(){

    document.getElementById('formTambah').reset();

    bootstrap.Modal.getOrCreateInstance(
        document.getElementById('modalTambah')
    ).show();
}

document.getElementById('formTambah').addEventListener('submit',function(e){

    e.preventDefault();

    const form=new FormData(this);
    const file=document.getElementById('gambarTambah').files[0];

    const data={
        id:produk.length?Math.max(...produk.map(p=>p.id))+1:1,
        nama:form.get('nama_produk').trim(),
        kategori_id:Number(form.get('kategori_id')),
        harga:Number(form.get('harga')),
        stok:Number(form.get('stok')),
        status:form.get('status'),
        deskripsi:form.get('deskripsi').trim(),
        gambar:''
    };

    if(file){

        if(!file.type.startsWith('image/')){
            notifikasi('File foto produk harus berupa gambar!','danger');
            return;
        }

        if(file.size>2*1024*1024){
            notifikasi('Ukuran foto produk maksimal 2 MB!','warning');
            return;
        }

        const reader=new FileReader();

        reader.onload=function(){
            data.gambar=reader.result;
            produk.push(data);
            selesaiTambah();
        };

        reader.readAsDataURL(file);

    }else{
        produk.push(data);
        selesaiTambah();
    }

});

function selesaiTambah(){

    simpanProduk();
    refreshSemua();

    bootstrap.Modal.getInstance(
        document.getElementById('modalTambah')
    ).hide();

    notifikasi('Produk berhasil ditambahkan!');
}


// =====================================
// EDIT PRODUK
// =====================================

function editProduk(id){

    const item=produk.find(p=>p.id===id);
    if(!item)return;

    document.getElementById('editId').value=item.id;
    document.getElementById('editNama').value=item.nama;
    document.getElementById('editKategori').value=item.kategori_id;
    document.getElementById('editHarga').value=item.harga;
    document.getElementById('editStok').value=item.stok;
    document.getElementById('editStatus').value=item.status;
    document.getElementById('editDeskripsi').value=item.deskripsi;

    document.getElementById('editGambar').value='';

    bootstrap.Modal.getOrCreateInstance(
        document.getElementById('modalEdit')
    ).show();
}

document.getElementById('formEdit').addEventListener('submit',function(e){

    e.preventDefault();

    const id=Number(document.getElementById('editId').value);
    const item=produk.find(p=>p.id===id);
    if(!item)return;

    const file=document.getElementById('editGambar').files[0];

    item.nama=document.getElementById('editNama').value.trim();
    item.kategori_id=Number(document.getElementById('editKategori').value);
    item.harga=Number(document.getElementById('editHarga').value);
    item.stok=Number(document.getElementById('editStok').value);
    item.status=document.getElementById('editStatus').value;
    item.deskripsi=document.getElementById('editDeskripsi').value.trim();

    if(file){

        if(!file.type.startsWith('image/')){
            notifikasi('File foto produk harus berupa gambar!','danger');
            return;
        }

        if(file.size>2*1024*1024){
            notifikasi('Ukuran foto produk maksimal 2 MB!','warning');
            return;
        }

        const reader=new FileReader();

        reader.onload=function(){
            item.gambar=reader.result;
            selesaiEdit();
        };

        reader.readAsDataURL(file);

    }else{
        selesaiEdit();
    }

});

function selesaiEdit(){

    simpanProduk();
    refreshSemua();

    bootstrap.Modal.getInstance(
        document.getElementById('modalEdit')
    ).hide();

    notifikasi('Produk berhasil diperbarui!');
}


// =====================================
// HAPUS PRODUK
// =====================================

function hapusProduk(id){

    if(!confirm('Yakin ingin menghapus produk ini?'))return;

    produk=produk.filter(p=>p.id!==id);

    simpanProduk();
    refreshSemua();

    notifikasi('Produk berhasil dihapus!');
}


// =====================================
// PENCARIAN PRODUK
// =====================================

document.getElementById('formSearch').addEventListener('submit',function(e){

    e.preventDefault();

    const q=document.getElementById('searchNama').value.toLowerCase().trim();
    const kat=document.getElementById('searchKategori').value;

    const hasil=produk.filter(p=>{
        return p.nama.toLowerCase().includes(q) &&
            (!kat || p.kategori_id==kat);
    });

    tampilkanProduk(hasil);
});

function resetSearch(){

    document.getElementById('searchNama').value='';
    document.getElementById('searchKategori').value='';

    tampilkanProduk();
}


// =====================================
// REFRESH SEMUA
// =====================================

function refreshSemua(){

    updateIdentitas();
    tampilkanProfil();
    updateStatistik();
    tampilkanProduk();
    tampilkanProdukTerbaru();
}


// =====================================
// SINKRONISASI ANTAR TAB
// =====================================

window.addEventListener('storage',function(e){

    if(e.key==='umkm_profil' && e.newValue){

        try{
            profil={
                ...defaultProfil,
                ...JSON.parse(e.newValue)
            };

            refreshSemua();
        }catch(error){
            console.error('Gagal membaca profil:',error);
        }
    }

    if(e.key==='umkm_produk' && e.newValue){

        try{
            produk=JSON.parse(e.newValue);
            refreshSemua();
        }catch(error){
            console.error('Gagal membaca produk:',error);
        }
    }

});


// =====================================
// LOGOUT SIMULASI
// =====================================

function logoutDummy(e){

    e.preventDefault();

    if(confirm('Apakah Anda yakin ingin keluar dari dashboard?')){
        alert('Ini masih mode dummy. Fitur logout memerlukan sistem autentikasi.');
    }
}


// =====================================
// INISIALISASI
// =====================================

isiKategori();
refreshSemua();


    </script>

</body>
</html>
