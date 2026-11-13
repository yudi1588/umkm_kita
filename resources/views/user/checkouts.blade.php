@extends('layouts.app')

@section('title', 'Statistik Usaha - UMKM Kita')

@section('content')


<div class="checkout-wrapper">
    <form id="checkoutForm" class="checkout-container">

        <!-- BAGIAN FORM PENGIRIMAN -->
        <div class="checkout-left">

            <h2>PENGIRIMAN</h2>

            <div class="checkout-fields">
                <input type="text" id="nama"
                    placeholder="Nama Lengkap" required>

                <textarea id="alamat"
                    placeholder="Alamat Rumah Pengiriman"
                    rows="2" required></textarea>

                <input type="text" id="kota"
                    placeholder="Kota" required>

                <input type="text" id="kodepos"
                    placeholder="Kode Pos" required>
            </div>

            <h2 class="catatan-title">CATATAN</h2>

            <textarea id="catatan"
                class="checkout-note"
                placeholder="Catatan Pesanan"></textarea>

        </div>

        <!-- BAGIAN RINGKASAN PESANAN -->
        <div class="checkout-right">

            <h2>PESANAN ANDA</h2>

            <div class="order-table">

                <div class="order-header">
                    <span>PRODUK</span>
                    <span>TOTAL</span>
                </div>

                <div class="order-product">
                    <span>
                        <strong>1x</strong> BUSINESS FILE A4
                    </span>

                    <span>Rp. 30.000</span>
                </div>

            </div>

            <!-- PEMBAYARAN -->
            <div class="checkout-option">
                <label for="pembayaran">
                    Pilih Metode Pembayaran (Opsional)
                </label>

                <select id="pembayaran">
                    <option value="">Pilih Pembayaran</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="COD">COD</option>
                    <option value="QRIS">QRIS</option>
                </select>
            </div>

            <!-- PENGIRIMAN -->
            <div class="checkout-option">
                <label for="pengiriman">
                    Pilih Jasa Kirim (Opsional)
                </label>

                <select id="pengiriman">
                    <option value="">Pilih Pengiriman</option>
                    <option value="JNE">JNE</option>
                    <option value="J&T">J&T</option>
                    <option value="SiCepat">SiCepat</option>
                    <option value="Ambil di Tempat">Ambil di Tempat</option>
                </select>
            </div>

            <!-- ONGKIR -->
            <div class="shipping-total">
                <span>Ongkos Pengiriman</span>
                <strong id="ongkir">GRATIS</strong>
            </div>

            <!-- TOTAL -->
            <div class="checkout-total">
                <strong>TOTAL</strong>
                <h3 id="totalHarga">Rp. 30.000</h3>
            </div>

            <button type="submit" class="checkout-button">
                BUAT PESANAN VIA WHATSAPP
            </button>

        </div>
    </form>
</div>

@endsection