
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('checkoutForm');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const nama = document.getElementById('nama').value.trim();
        const alamat = document.getElementById('alamat').value.trim();
        const kota = document.getElementById('kota').value.trim();
        const kodepos = document.getElementById('kodepos').value.trim();
        const catatan = document.getElementById('catatan').value.trim();

        const pembayaran = document.getElementById('pembayaran').value;
        const pengiriman = document.getElementById('pengiriman').value;

        const ongkir = 0;
        const subtotal = 30000;
        const total = subtotal + ongkir;

        const pesan = `
*PESANAN BARU - UMKM KITA*

*DATA PENGIRIMAN*
Nama: ${nama}
Alamat: ${alamat}
Kota: ${kota}
Kode Pos: ${kodepos}

*DETAIL PESANAN*
1x BUSINESS FILE A4 = Rp30.000

Metode Pembayaran: ${pembayaran || 'Belum dipilih'}
Jasa Pengiriman: ${pengiriman || 'Belum dipilih'}

Ongkos Kirim: Rp${ongkir.toLocaleString('id-ID')}
*TOTAL: Rp${total.toLocaleString('id-ID')}*

Catatan: ${catatan || '-'}

Terima kasih.
        `;

        // GANTI DENGAN NOMOR WHATSAPP ADMIN
        const nomorAdmin = '628xxxxxxxxxx';

        const url = `https://wa.me/${nomorAdmin}?text=${encodeURIComponent(pesan)}`;

        window.open(url, '_blank');
    });

});
