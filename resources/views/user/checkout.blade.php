
@extends('layouts.app')

@section('title', 'Checkout - UMKM Kita')

@section('content')

<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">


<main class="checkout-page">

    <div class="checkout-container">

        <!-- BAGIAN KIRI: PENGIRIMAN -->
        <section class="checkout-left">

            <h2 class="checkout-section-title">
                Pengiriman
            </h2>

            <form id="whatsappCheckoutForm">

                <!-- NAMA -->
                <input
                    type="text"
                    name="customer_name"
                    id="customerName"
                    class="checkout-input"
                    placeholder="Nama Lengkap"
                    autocomplete="name"
                    required
                >

                <!-- ALAMAT + AUTOCOMPLETE -->
                <div class="checkout-address-field">

                    <div class="checkout-address-row">

                        <input
                            type="text"
                            name="address"
                            id="customerAddress"
                            class="checkout-input"
                            placeholder="Alamat Rumah Pengiriman"
                            autocomplete="off"
                            required
                        >

                        <button
                            type="button"
                            id="useCurrentLocation"
                            class="btn-current-location"
                            title="Gunakan lokasi saat ini"
                            aria-label="Gunakan lokasi saat ini"
                        >
                            <i class="fa fa-crosshairs"></i>
                        </button>

                    </div>

                    <!-- SARAN ALAMAT -->
                    <div
                        class="address-suggestions"
                        id="addressSuggestions"
                        role="listbox"
                        hidden
                    ></div>

                    <!-- STATUS LOKASI -->
                    <div
                        class="location-status"
                        id="locationStatus"
                        aria-live="polite"
                    ></div>

                    <!-- KOORDINAT -->
                    <input type="hidden" id="locationLatitude">
                    <input type="hidden" id="locationLongitude">

                </div>

                <!-- KOTA -->
                <input
                    type="text"
                    name="city"
                    id="customerCity"
                    class="checkout-input"
                    placeholder="Kota"
                    autocomplete="address-level2"
                    required
                >

                <!-- KODE POS -->
                <input
                    type="text"
                    name="postal_code"
                    id="postalCode"
                    class="checkout-input"
                    placeholder="Kode Pos"
                    autocomplete="postal-code"
                    maxlength="10"
                    required
                >

                <!-- CATATAN -->
                <h3 class="checkout-subtitle">
                    Catatan
                </h3>

                <textarea
                    name="notes"
                    id="orderNotes"
                    class="checkout-textarea"
                    placeholder="Catatan Pesanan"
                ></textarea>

            </form>

        </section>


        <!-- BAGIAN KANAN: PESANAN -->
        <aside class="checkout-right">

            <h2 class="checkout-order-title">
                Pesanan Anda
            </h2>

            <div class="checkout-table-heading">
                <span>Produk</span>
                <span>Total</span>
            </div>

            <!-- PRODUK -->
            <div class="checkout-product-list">

                @foreach($items as $item)

                    <div class="checkout-product-item">

                        <div class="checkout-product-name">
                            <span>{{ $item['quantity'] }}x</span>
                            {{ strtoupper($item['name']) }}
                        </div>

                        <div class="checkout-product-price">
                            Rp {{ number_format(
                                $item['price'] * $item['quantity'],
                                0,
                                ',',
                                '.'
                            ) }}
                        </div>

                    </div>

                @endforeach

            </div>

            <!-- PEMBAYARAN -->
            <div class="checkout-option-group">

                <label class="checkout-option-label">
                    Pilih Metode Pembayaran (Opsional)
                </label>

                <select
                    name="payment_method"
                    id="paymentMethod"
                    class="checkout-select"
                    form="whatsappCheckoutForm"
                >
                    <option value="">Pilih Pembayaran</option>
                    <option value="COD">Bayar di Tempat (COD)</option>
                    <option value="Transfer Manual">Transfer Manual</option>
                </select>

            </div>

            <!-- JASA KIRIM -->
            <div class="checkout-option-group">

                <label class="checkout-option-label">
                    Pilih Jasa Kirim (Opsional)
                </label>

                <select
                    name="shipping_service"
                    id="shippingService"
                    class="checkout-select"
                    form="whatsappCheckoutForm"
                >
                    <option value="">Pilih Pengiriman</option>
                    <option value="Pengiriman oleh Merchant">
                        Pengiriman oleh Merchant
                    </option>
                    <option value="Ambil di Tempat">
                        Ambil di Tempat
                    </option>
                </select>

            </div>

            <!-- ONGKOS -->
            <div class="checkout-shipping-row">

                <span>Ongkos Pengiriman</span>

                <strong id="shippingCost">
                    GRATIS
                </strong>

            </div>

            <p class="checkout-shipping-note">
                Ongkos kirim akhir akan dikonfirmasi oleh merchant sesuai alamat pengiriman.
            </p>

            <!-- TOTAL -->
            <div class="checkout-total-row">

                <span class="checkout-total-label">
                    TOTAL
                </span>

                <strong class="checkout-total-price" id="checkoutTotal">
                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                </strong>

            </div>

            <!-- WHATSAPP -->
            <button
                type="button"
                class="checkout-whatsapp-button"
                id="submitWhatsappOrder"
            >
                <i class="fa fa-whatsapp"></i>
                BUAT PESANAN VIA WHATSAPP
            </button>

            <p style="font-size:10px;color:#999;text-align:center;margin-top:12px;">
                Pencarian alamat menggunakan data OpenStreetMap.
            </p>

        </aside>

    </div>

</main>


<script>
document.addEventListener('DOMContentLoaded', function () {

    // ============================================
    // KONFIGURASI
    // ============================================

    const PHOTON_API = 'https://photon.komoot.io/api/';
    const PHOTON_REVERSE = 'https://photon.komoot.io/reverse';

    // Titik awal pencarian diprioritaskan di Kota Probolinggo.
    // Jika pengguna menggunakan lokasi saat ini, titik ini
    // otomatis diganti dengan koordinat perangkatnya.
    const DEFAULT_BIAS = {
        lat: -7.7543,
        lon: 113.2159
    };

    let searchBias = { ...DEFAULT_BIAS };

    // GANTI NOMOR INI DENGAN WHATSAPP MERCHANT
    const merchantWhatsapp = '6289621276211';

    // DATA CHECKOUT DARI LARAVEL
    const checkoutItems = @json($items);
    const serverSubtotal = Number(@json($subtotal));


    // ============================================
    // ELEMEN HTML
    // ============================================

    const addressInput = document.getElementById('customerAddress');
    const cityInput = document.getElementById('customerCity');
    const postalInput = document.getElementById('postalCode');

    const suggestionsBox = document.getElementById('addressSuggestions');

    const locationButton = document.getElementById('useCurrentLocation');
    const locationStatus = document.getElementById('locationStatus');

    const latitudeInput = document.getElementById('locationLatitude');
    const longitudeInput = document.getElementById('locationLongitude');

    const submitButton = document.getElementById('submitWhatsappOrder');


    // ============================================
    // FORMAT RUPIAH
    // ============================================

    function formatRupiah(value) {
        return 'Rp ' + Number(value).toLocaleString('id-ID');
    }


    // ============================================
    // HITUNG TOTAL PESANAN
    // ============================================

    const calculatedSubtotal = checkoutItems.reduce(function (total, item) {
        return total + (
            Number(item.price) * Number(item.quantity)
        );
    }, 0);

    const finalSubtotal = calculatedSubtotal || serverSubtotal;

    document.getElementById('checkoutTotal').textContent =
        formatRupiah(finalSubtotal);


    // ============================================
    // FORMAT ALAMAT DARI PHOTON
    // ============================================

    function uniqueParts(parts) {

        const result = [];
        const used = new Set();

        parts.forEach(function (part) {

            if (!part) return;

            const value = String(part).trim();

            if (!value) return;

            const key = value.toLowerCase();

            if (!used.has(key)) {
                used.add(key);
                result.push(value);
            }

        });

        return result;
    }


    function getAddressParts(properties) {

        const houseStreet = [
            properties.housenumber,
            properties.street
        ].filter(Boolean).join(' ');

        return uniqueParts([
            properties.name,
            houseStreet,
            properties.district,
            properties.city,
            properties.county,
            properties.state,
            properties.postcode,
            properties.country
        ]);
    }


    function getFullAddress(properties) {

        return getAddressParts(properties).join(', ');

    }


    function getCity(properties) {

        return properties.city ||
            properties.county ||
            properties.district ||
            properties.state ||
            '';

    }


    function getPostalCode(properties) {

        return properties.postcode || '';

    }


    function getSuggestionTitle(properties) {

        return properties.name ||
            properties.street ||
            properties.city ||
            properties.district ||
            'Lokasi ditemukan';

    }


    function getSuggestionDescription(properties) {

        const parts = uniqueParts([
            properties.street,
            properties.district,
            properties.city,
            properties.county,
            properties.state,
            properties.country
        ]);

        return parts.join(', ');

    }


    // ============================================
    // STATUS LOKASI
    // ============================================

    function showLocationStatus(message, type) {

        locationStatus.textContent = message;
        locationStatus.className = 'location-status ' + type;

    }


    function hideLocationStatus() {

        locationStatus.textContent = '';
        locationStatus.className = 'location-status';

    }


    // ============================================
    // AUTOCOMPLETE ALAMAT
    // ============================================

    let searchTimer = null;
    let searchController = null;

    function showSuggestionMessage(message, className) {

        suggestionsBox.innerHTML = '';

        const element = document.createElement('div');
        element.className = className;
        element.textContent = message;

        suggestionsBox.appendChild(element);
        suggestionsBox.hidden = false;

    }


    function closeSuggestions() {

        suggestionsBox.hidden = true;
        suggestionsBox.innerHTML = '';

    }


    function selectAddress(feature) {

        const properties = feature.properties || {};
        const coordinates = feature.geometry?.coordinates || [];

        const longitude = coordinates[0];
        const latitude = coordinates[1];

        const fullAddress = getFullAddress(properties);

        if (!fullAddress) return;

        // Isi alamat otomatis
        addressInput.value = fullAddress;

        // Isi kota jika tersedia
        const city = getCity(properties);

        if (city) {
            cityInput.value = city;
        }

        // Isi kode pos jika tersedia
        const postcode = getPostalCode(properties);

        if (postcode) {
            postalInput.value = postcode;
        }

        // Simpan koordinat lokasi terpilih
        if (
            Number.isFinite(latitude) &&
            Number.isFinite(longitude)
        ) {
            latitudeInput.value = latitude;
            longitudeInput.value = longitude;

            searchBias = {
                lat: latitude,
                lon: longitude
            };
        }

        closeSuggestions();

        showLocationStatus(
            'Alamat berhasil dipilih. Silakan periksa kembali alamat pengiriman.',
            'success'
        );

    }


    async function searchAddress(query) {

        if (searchController) {
            searchController.abort();
        }

        searchController = new AbortController();

        const params = new URLSearchParams({
            q: query,
            limit: '8',
            lang: 'id',
            lat: String(searchBias.lat),
            lon: String(searchBias.lon),
            zoom: '13'
        });

        const response = await fetch(
            PHOTON_API + '?' + params.toString(),
            {
                signal: searchController.signal,
                headers: {
                    'Accept': 'application/json'
                }
            }
        );

        if (!response.ok) {
            throw new Error('Pencarian alamat gagal.');
        }

        return await response.json();

    }


    function renderSuggestions(features) {

        suggestionsBox.innerHTML = '';

        if (!features || features.length === 0) {

            showSuggestionMessage(
                'Alamat tidak ditemukan. Coba kata kunci lain.',
                'address-suggestion-empty'
            );

            return;
        }

        features.forEach(function (feature) {

            const properties = feature.properties || {};

            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'address-suggestion-item';
            button.setAttribute('role', 'option');

            const icon = document.createElement('span');
            icon.className = 'address-suggestion-icon';

            const iconElement = document.createElement('i');
            iconElement.className = 'fa fa-map-marker';

            icon.appendChild(iconElement);

            const content = document.createElement('span');
            content.className = 'address-suggestion-content';

            const title = document.createElement('span');
            title.className = 'address-suggestion-title';
            title.textContent = getSuggestionTitle(properties);

            const detail = document.createElement('span');
            detail.className = 'address-suggestion-detail';
            detail.textContent = getSuggestionDescription(properties);

            content.appendChild(title);
            content.appendChild(detail);

            button.appendChild(icon);
            button.appendChild(content);

            button.addEventListener('click', function () {
                selectAddress(feature);
            });

            suggestionsBox.appendChild(button);

        });

        suggestionsBox.hidden = false;

    }


    // KETIKA USER MENGETIK ALAMAT
    addressInput.addEventListener('input', function () {

        const query = this.value.trim();

        // Alamat diedit manual, koordinat pilihan sebelumnya tidak lagi valid
        latitudeInput.value = '';
        longitudeInput.value = '';

        hideLocationStatus();

        clearTimeout(searchTimer);

        if (searchController) {
            searchController.abort();
        }

        if (query.length < 3) {
            closeSuggestions();
            return;
        }

        showSuggestionMessage(
            'Mencari alamat...',
            'address-suggestion-loading'
        );

        // Debounce: tunggu pengguna selesai mengetik
        searchTimer = setTimeout(async function () {

            try {

                const result = await searchAddress(query);

                renderSuggestions(result.features);

            } catch (error) {

                if (error.name === 'AbortError') {
                    return;
                }

                showSuggestionMessage(
                    'Pencarian gagal. Periksa koneksi internet dan coba lagi.',
                    'address-suggestion-empty'
                );

            }

        }, 450);

    });


    // Tutup dropdown saat klik di luar kolom alamat
    document.addEventListener('click', function (event) {

        const addressField = document.querySelector('.checkout-address-field');

        if (!addressField.contains(event.target)) {
            closeSuggestions();
        }

    });


    // ============================================
    // REVERSE GEOCODING
    // KOORDINAT MENJADI ALAMAT
    // ============================================

    async function reverseGeocode(latitude, longitude) {

        const params = new URLSearchParams({
            lat: String(latitude),
            lon: String(longitude),
            lang: 'id',
            limit: '1'
        });

        const response = await fetch(
            PHOTON_REVERSE + '?' + params.toString(),
            {
                headers: {
                    'Accept': 'application/json'
                }
            }
        );

        if (!response.ok) {
            throw new Error('Gagal mengubah koordinat menjadi alamat.');
        }

        const result = await response.json();

        if (!result.features || !result.features.length) {
            throw new Error('Alamat tidak ditemukan pada koordinat tersebut.');
        }

        return result.features[0];

    }


    // ============================================
    // TOMBOL GUNAKAN LOKASI SAAT INI
    // ============================================

    locationButton.addEventListener('click', function () {

        if (!navigator.geolocation) {

            showLocationStatus(
                'Browser kamu tidak mendukung fitur lokasi.',
                'error'
            );

            return;
        }

        if (!window.isSecureContext) {

            showLocationStatus(
                'Fitur lokasi memerlukan HTTPS atau localhost. Buka website melalui koneksi yang aman.',
                'error'
            );

            return;
        }

        const originalButton = locationButton.innerHTML;

        locationButton.disabled = true;

        locationButton.innerHTML =
            '<i class="fa fa-spinner fa-spin"></i>';

        showLocationStatus(
            'Sedang mengambil lokasi perangkat kamu...',
            'info'
        );

        navigator.geolocation.getCurrentPosition(

            async function (position) {

                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Simpan titik GPS
                latitudeInput.value = latitude;
                longitudeInput.value = longitude;

                // Gunakan lokasi saat ini sebagai pusat pencarian berikutnya
                searchBias = {
                    lat: latitude,
                    lon: longitude
                };

                try {

                    showLocationStatus(
                        'Lokasi ditemukan. Sedang mencari alamat lengkap...',
                        'info'
                    );

                    const feature = await reverseGeocode(
                        latitude,
                        longitude
                    );

                    const properties = feature.properties || {};

                    const fullAddress = getFullAddress(properties);

                    if (!fullAddress) {
                        throw new Error('Alamat lengkap tidak ditemukan.');
                    }

                    // ISI FORM OTOMATIS
                    addressInput.value = fullAddress;

                    const city = getCity(properties);

                    if (city) {
                        cityInput.value = city;
                    }

                    const postcode = getPostalCode(properties);

                    if (postcode) {
                        postalInput.value = postcode;
                    }

                    closeSuggestions();

                    showLocationStatus(
                        'Lokasi berhasil ditemukan dan alamat telah diisi otomatis.',
                        'success'
                    );

                } catch (error) {

                    showLocationStatus(
                        'Koordinat ditemukan, tetapi alamat lengkap gagal diperoleh. Silakan isi alamat secara manual.',
                        'error'
                    );

                } finally {

                    locationButton.disabled = false;
                    locationButton.innerHTML = originalButton;

                }

            },

            function (error) {

                let message = 'Tidak dapat mengambil lokasi perangkat.';

                if (error.code === 1) {
                    message = 'Akses lokasi ditolak. Izinkan akses lokasi pada browser kamu.';
                } else if (error.code === 2) {
                    message = 'Lokasi perangkat tidak tersedia. Periksa GPS atau koneksi internet.';
                } else if (error.code === 3) {
                    message = 'Waktu pengambilan lokasi habis. Silakan coba kembali.';
                }

                showLocationStatus(message, 'error');

                locationButton.disabled = false;
                locationButton.innerHTML = originalButton;

            },

            {
                enableHighAccuracy: true,
                timeout: 20000,
                maximumAge: 60000
            }

        );

    });


    // ============================================
    // CHECKOUT VIA WHATSAPP
    // ============================================

    submitButton.addEventListener('click', function () {

        const name = document.getElementById('customerName').value.trim();
        const address = addressInput.value.trim();
        const city = cityInput.value.trim();
        const postalCode = postalInput.value.trim();
        const notes = document.getElementById('orderNotes').value.trim();

        const payment = document.getElementById('paymentMethod').value;
        const shipping = document.getElementById('shippingService').value;

        const latitude = latitudeInput.value;
        const longitude = longitudeInput.value;

        // Validasi data pembeli
        if (!name || !address || !city || !postalCode) {

            alert(
                'Mohon lengkapi nama, alamat, kota, dan kode pos terlebih dahulu.'
            );

            return;
        }

        if (!checkoutItems.length) {

            alert('Tidak ada produk dalam pesanan.');

            return;
        }

        // ========================================
        // DAFTAR PRODUK
        // ========================================

        let productMessage = '';

        checkoutItems.forEach(function (item, index) {

            const itemPrice = Number(item.price);
            const quantity = Number(item.quantity);

            const itemTotal = itemPrice * quantity;

            productMessage +=
                (index + 1) + '. ' + item.name + '\n' +
                '   Jumlah: ' + quantity + 'x\n' +
                '   Harga satuan: ' + formatRupiah(itemPrice) + '\n' +
                '   Subtotal: ' + formatRupiah(itemTotal) + '\n\n';

        });


        // ========================================
        // TAUTAN MAPS DARI LOKASI GPS
        // ========================================

        let mapMessage = '';

        if (latitude && longitude) {

            const mapURL =
                'https://www.google.com/maps?q=' +
                encodeURIComponent(latitude + ',' + longitude);

            mapMessage =
                'Koordinat Lokasi: ' + latitude + ', ' + longitude + '\n' +
                'Google Maps: ' + mapURL + '\n';

        }


        // ========================================
        // SUSUN PESAN WHATSAPP
        // ========================================

        let message =
            '*PESANAN BARU - UMKM KITA*\n' +
            '================================\n\n' +

            '*INFORMASI PEMBELI*\n' +
            'Nama: ' + name + '\n' +
            'Alamat: ' + address + '\n' +
            'Kota: ' + city + '\n' +
            'Kode Pos: ' + postalCode + '\n' +
            mapMessage + '\n' +

            '*DAFTAR PESANAN*\n' +
            productMessage +

            '================================\n' +
            '*Subtotal Produk: ' + formatRupiah(finalSubtotal) + '*\n' +
            'Ongkos Pengiriman: Konfirmasi Merchant\n' +
            '*Total Sementara: ' + formatRupiah(finalSubtotal) + '*\n\n' +

            '*METODE PEMBAYARAN*\n' +
            (payment || 'Belum dipilih') + '\n\n' +

            '*JASA PENGIRIMAN*\n' +
            (shipping || 'Belum dipilih') + '\n\n' +

            '*CATATAN PESANAN*\n' +
            (notes || '-') + '\n\n' +

            'Mohon konfirmasi ketersediaan produk, ongkos kirim, dan total pembayaran. Terima kasih.';


        // BUKA WHATSAPP
        const whatsappURL =
            'https://wa.me/' +
            merchantWhatsapp +
            '?text=' +
            encodeURIComponent(message);

        window.open(whatsappURL, '_blank');

    });

});
</script>

@endsection
