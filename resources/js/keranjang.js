document.addEventListener('DOMContentLoaded', function () {

    const CART_KEY = 'cart';

    // =========================================
    // 1. UTILITAS
    // =========================================

    function formatRupiah(value) {
        return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
    }

    function getCart() {
        try {
            const data = JSON.parse(localStorage.getItem(CART_KEY) || '[]');

            if (!Array.isArray(data)) return [];

            return data.filter(function (item) {
                return item &&
                    typeof item.slug === 'string' && item.slug.trim() !== '' &&
                    Number.isFinite(Number(item.price)) &&
                    Number(item.price) >= 0 &&
                    Number.isFinite(Number(item.quantity)) &&
                    Number(item.quantity) >= 1;
            }).map(function (item) {
                return {
                    slug: item.slug,
                    name: item.name || 'Produk UMKM',
                    price: Number(item.price),
                    image: item.image || '',
                    location: item.location || '',
                    quantity: Math.min(99, Math.floor(Number(item.quantity)))
                };
            });
        } catch (error) {
            console.error('Gagal membaca keranjang:', error);
            return [];
        }
    }

    function saveCart(cart) {
        try {
            localStorage.setItem(CART_KEY, JSON.stringify(cart));
            window.dispatchEvent(new CustomEvent('cartUpdated', { detail: cart }));
            return true;
        } catch (error) {
            console.error('Gagal menyimpan keranjang:', error);
            alert('Keranjang tidak dapat disimpan. Periksa pengaturan penyimpanan browser.');
            return false;
        }
    }

    // =========================================
    // 2. QUANTITY DI HALAMAN DETAIL PRODUK
    // Mendukung selector data-* dan ID lama.
    // =========================================

    const quantityControl = document.querySelector('[data-quantity-control]');
    const quantityInput = document.getElementById('productQuantity') ||
        (quantityControl ? quantityControl.querySelector('input[type="number"]') : null);

    const decreaseButton = document.getElementById('decreaseQuantity') ||
        document.querySelector('[data-quantity-decrease]');
    const increaseButton = document.getElementById('increaseQuantity') ||
        document.querySelector('[data-quantity-increase]');

    const totalElement = document.getElementById('productTotal');
    const checkoutQuantity = document.getElementById('checkoutQuantity') ||
        document.querySelector('#buyNowForm input[name="quantity"]');
    const buyNowForm = document.getElementById('buyNowForm');

    const addToCartButton = document.getElementById('addToCartButton');
    const cartMessage = document.getElementById('cartMessage');

    function readDisplayedPrice() {
        const priceText = document.querySelector('.product-detail-price')?.textContent || '';
        const digits = priceText.replace(/[^0-9]/g, '');
        return digits ? Number(digits) : 0;
    }

    const productPrice = addToCartButton && addToCartButton.dataset.price !== undefined
        ? Number(addToCartButton.dataset.price)
        : readDisplayedPrice();

    function getQuantity() {
        if (!quantityInput) return 1;

        let quantity = parseInt(quantityInput.value, 10);
        if (!Number.isFinite(quantity)) quantity = 1;

        quantity = Math.max(1, Math.min(99, quantity));
        quantityInput.value = quantity;
        return quantity;
    }

    function updateProductQuantity() {
        if (!quantityInput) return;

        const quantity = getQuantity();

        if (totalElement) {
            totalElement.textContent = formatRupiah(productPrice * quantity);
        }

        if (checkoutQuantity) {
            checkoutQuantity.value = quantity;
        }
    }

    if (decreaseButton && quantityInput) {
        decreaseButton.addEventListener('click', function () {
            quantityInput.value = Math.max(1, getQuantity() - 1);
            updateProductQuantity();
        });
    }

    if (increaseButton && quantityInput) {
        increaseButton.addEventListener('click', function () {
            quantityInput.value = Math.min(99, getQuantity() + 1);
            updateProductQuantity();
        });
    }

    if (quantityInput) {
        quantityInput.addEventListener('input', updateProductQuantity);
        quantityInput.addEventListener('change', updateProductQuantity);
        quantityInput.addEventListener('blur', updateProductQuantity);
        updateProductQuantity();
    }

    if (buyNowForm) {
        buyNowForm.addEventListener('submit', function () {
            if (checkoutQuantity) checkoutQuantity.value = getQuantity();
        });
    }

    // =========================================
    // 3. TAMBAH PRODUK DARI DETAIL KE KERANJANG
    // =========================================

    function showCartMessage(message, success) {
        if (!cartMessage) {
            alert(message);
            return;
        }

        cartMessage.textContent = message;
        cartMessage.className = success ? 'cart-message success' : 'cart-message error';

        window.clearTimeout(showCartMessage.timer);
        showCartMessage.timer = window.setTimeout(function () {
            cartMessage.textContent = '';
            cartMessage.className = 'cart-message';
        }, 3000);
    }

    const cartMenu = document.getElementById('headerCart') || document.querySelector('.cart-menu');

    if (addToCartButton) {
        addToCartButton.addEventListener('click', function () {
            // Ambil slug dari data-slug. Jika atribut belum dipasang,
            // ambil dari URL form Beli Sekarang (/checkout/single/{slug}).
            let slug = (addToCartButton.dataset.slug || '').trim();

            if (!slug && buyNowForm && buyNowForm.action) {
                try {
                    const actionUrl = new URL(buyNowForm.action, window.location.origin);
                    const path = actionUrl.pathname;
                    const marker = '/checkout/single/';
                    const markerIndex = path.indexOf(marker);

                    if (markerIndex !== -1) {
                        slug = decodeURIComponent(
                            path.substring(markerIndex + marker.length).split('/')[0]
                        );
                    }
                } catch (error) {
                    console.warn('Slug produk tidak dapat dibaca dari form checkout:', error);
                }
            }

            const name = (addToCartButton.dataset.name ||
                document.querySelector('.product-detail-info h1')?.textContent.trim() || '').trim();

            const rawPrice = addToCartButton.dataset.price;
            const price = rawPrice !== undefined && rawPrice !== ''
                ? Number(rawPrice)
                : productPrice;

            const detailImage = document.querySelector('.product-detail-media img');
            const image = addToCartButton.dataset.image ||
                detailImage?.currentSrc ||
                detailImage?.getAttribute('src') || '';

            const location = addToCartButton.dataset.location ||
                document.querySelector('[data-product-location]')?.textContent.trim() ||
                document.querySelector('.product-detail-location')?.textContent.trim() ||
                'Lokasi tidak tersedia';

            if (!slug || !name || !Number.isFinite(price) || price < 0) {
                console.error('Data produk untuk keranjang belum lengkap.', {
                    slug, name, price, image, location,
                    buyNowAction: buyNowForm?.action || null
                });
                showCartMessage('Data produk belum lengkap. Pastikan tombol Beli Sekarang memiliki route checkout.single dan nama serta harga produk tampil di halaman detail.', false);
                return;
            }

            const quantity = getQuantity();
            const cart = getCart();
            const existingProduct = cart.find(function (item) {
                return item.slug === slug;
            });

            if (existingProduct) {
                const nextQuantity = Number(existingProduct.quantity) + quantity;
                if (nextQuantity > 99) {
                    showCartMessage('Maksimal jumlah satu produk di keranjang adalah 99.', false);
                    return;
                }
                existingProduct.quantity = nextQuantity;
            } else {
                cart.push({
                    slug: slug,
                    name: name,
                    price: price,
                    image: image,
                    location: location,
                    quantity: quantity
                });
            }

            if (saveCart(cart)) {
                showCartMessage(name + ' berhasil ditambahkan ke keranjang.', true);
                if (cartMenu) cartMenu.open = true;
            }
        });
    }

    // =========================================
    // 4. RENDER MINI CART
    // Mendukung HTML keranjang versi baru.
    // =========================================

    const cartItemsContainer = document.getElementById('cartItems');
    const cartEmpty = document.getElementById('cartEmpty');
    const cartCount = document.getElementById('cartCount');
    const cartSubtotal = document.getElementById('cartSubtotal');
    const cartItemSummary = document.getElementById('cartItemSummary');
    const cartTotalItems = document.getElementById('cartTotalItems');
    const clearCartButton = document.getElementById('clearCartButton');
    const checkoutButton = document.getElementById('cartCheckoutButton');

    function makeElement(tag, className, text) {
        const element = document.createElement(tag);
        if (className) element.className = className;
        if (text !== undefined) element.textContent = text;
        return element;
    }

    function renderCart() {
        if (!cartItemsContainer) return;

        const cart = getCart();
        const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        cartItemsContainer.innerHTML = '';

        if (cartEmpty) cartEmpty.style.display = cart.length ? 'none' : 'block';
        if (cartCount) cartCount.textContent = totalQuantity;
        if (cartSubtotal) cartSubtotal.textContent = formatRupiah(subtotal);
        if (cartItemSummary) cartItemSummary.textContent = cart.length + ' produk dipilih';
        if (cartTotalItems) cartTotalItems.textContent = totalQuantity + ' barang';
        if (clearCartButton) clearCartButton.style.display = cart.length ? 'inline-block' : 'none';
        if (checkoutButton) checkoutButton.disabled = cart.length === 0;

        cart.forEach(function (item) {
            const wrapper = makeElement('div', 'cart-item');

            const imageWrapper = makeElement('div', 'cart-item-image-wrapper');
            const image = makeElement('img', 'cart-item-image');
            image.src = item.image;
            image.alt = item.name;
            image.loading = 'lazy';
            image.onerror = function () {
                this.style.display = 'none';
                imageWrapper.classList.add('cart-image-missing');
                imageWrapper.textContent = 'UMKM';
            };
            if (!item.image) {
                image.style.display = 'none';
                imageWrapper.classList.add('cart-image-missing');
                imageWrapper.textContent = 'UMKM';
            }
            imageWrapper.appendChild(image);

            const info = makeElement('div', 'cart-item-info');
            const name = makeElement('div', 'cart-item-name', item.name);

            const location = makeElement('span', 'cart-item-location');
            const locationIcon = makeElement('i', 'fa fa-map-marker');
            location.appendChild(locationIcon);
            location.appendChild(document.createTextNode(' ' + (item.location || 'Lokasi tidak tersedia')));

            const unitPrice = makeElement('div', 'cart-item-price', formatRupiah(item.price));
            const lineTotal = makeElement('div', 'cart-item-line-total', 'Subtotal: ' + formatRupiah(item.price * item.quantity));

            const bottom = makeElement('div', 'cart-item-bottom');
            const quantityControl = makeElement('div', 'cart-quantity');

            const decrease = makeElement('button', '', '−');
            decrease.type = 'button';
            decrease.setAttribute('aria-label', 'Kurangi jumlah ' + item.name);
            decrease.disabled = item.quantity <= 1;
            decrease.addEventListener('click', function () {
                changeQuantity(item.slug, -1);
            });

            const quantity = makeElement('span', '', String(item.quantity));

            const increase = makeElement('button', '', '+');
            increase.type = 'button';
            increase.setAttribute('aria-label', 'Tambah jumlah ' + item.name);
            increase.disabled = item.quantity >= 99;
            increase.addEventListener('click', function () {
                changeQuantity(item.slug, 1);
            });

            quantityControl.append(decrease, quantity, increase);

            const remove = makeElement('button', 'cart-delete-button');
            remove.type = 'button';
            remove.innerHTML = '<i class="fa fa-trash-o" aria-hidden="true"></i> Hapus';
            remove.addEventListener('click', function () {
                removeProduct(item.slug);
            });

            bottom.append(quantityControl, remove);
            info.append(name, location, unitPrice, lineTotal, bottom);
            wrapper.append(imageWrapper, info);
            cartItemsContainer.appendChild(wrapper);
        });
    }

    // =========================================
    // 5. UBAH QUANTITY DAN HAPUS PRODUK
    // =========================================

    function changeQuantity(slug, difference) {
        const cart = getCart();
        const product = cart.find(item => item.slug === slug);
        if (!product) return;

        const newQuantity = product.quantity + difference;
        if (newQuantity < 1 || newQuantity > 99) return;

        product.quantity = newQuantity;
        saveCart(cart);
    }

    function removeProduct(slug) {
        const cart = getCart().filter(item => item.slug !== slug);
        saveCart(cart);
    }

    if (clearCartButton) {
        clearCartButton.addEventListener('click', function () {
            if (!getCart().length) return;
            if (confirm('Apakah kamu yakin ingin mengosongkan keranjang?')) {
                saveCart([]);
            }
        });
    }

    // =========================================
    // 6. CHECKOUT DARI KERANJANG
    // =========================================

    const cartCheckoutForm = document.getElementById('cartCheckoutForm');
    const checkoutCartItems = document.getElementById('checkoutCartItems');

    if (cartCheckoutForm) {
        cartCheckoutForm.addEventListener('submit', function (event) {
            const cart = getCart();

            if (!cart.length) {
                event.preventDefault();
                alert('Keranjang belanja masih kosong!');
                return;
            }

            if (!checkoutCartItems) {
                event.preventDefault();
                console.error('Input #checkoutCartItems tidak ditemukan di form checkout keranjang.');
                alert('Form checkout keranjang belum lengkap. Periksa partials.header.');
                return;
            }

            checkoutCartItems.value = JSON.stringify(cart.map(function (item) {
                return {
                    slug: item.slug,
                    quantity: item.quantity
                };
            }));
        });
    }

    // =========================================
    // 7. TOMBOL LANJUT BELANJA
    // =========================================

    const continueShopping = document.getElementById('continueShopping');
    if (continueShopping) {
        continueShopping.addEventListener('click', function () {
            if (cartMenu) cartMenu.open = false;
        });
    }

    // Klik di luar dropdown menutup keranjang.
    document.addEventListener('click', function (event) {
        if (cartMenu && cartMenu.open && !cartMenu.contains(event.target)) {
            cartMenu.open = false;
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && cartMenu) cartMenu.open = false;
    });

    // Sinkronisasi antar-tab.
    window.addEventListener('storage', function (event) {
        if (event.key === CART_KEY) renderCart();
    });

    window.addEventListener('cartUpdated', renderCart);

    // Tampilkan isi keranjang saat halaman dibuka.
    renderCart();

});