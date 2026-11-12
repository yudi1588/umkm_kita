
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background: #f5f7fb;
        }

        .success-card {
            max-width: 600px;
            margin: 80px auto;
            padding: 40px 30px;
            background: white;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 5px 25px rgba(0,0,0,.05);
        }

        .success-icon {
            width: 85px;
            height: 85px;
            background: #e4f8ed;
            color: #20a464;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 25px;
        }

        .order-number {
            background: #f1f6fb;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .btn-home {
            background: #1769aa;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-home:hover {
            background: #12558c;
            color: white;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="success-card">

        <div class="success-icon">
            <i class="fa fa-check"></i>
        </div>

        <h3 class="fw-bold">Pesanan Berhasil Dibuat!</h3>

        <p class="text-secondary mt-3">
            Terima kasih telah berbelanja produk UMKM lokal.
            Pesanan kamu sudah berhasil dibuat dan menunggu konfirmasi merchant.
        </p>

        <div class="order-number">
            <small class="text-secondary">Nomor Pesanan</small>
            <h5 class="fw-bold mt-1">
                {{ $order['order_number'] }}
            </h5>
        </div>

        <div class="text-start mb-4">

            <div class="d-flex justify-content-between mb-2">
                <span>Nama Pembeli</span>
                <strong>{{ $order['customer']['customer_name'] }}</strong>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span>Jumlah Produk</span>
                <strong>{{ count($order['items']) }} produk</strong>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span>Total Produk</span>
                <strong>
                    Rp {{ number_format($order['subtotal'], 0, ',', '.') }}
                </strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Metode Pembayaran</span>
                <strong>
                    {{ $order['customer']['payment_method'] === 'cod'
                        ? 'COD'
                        : 'Transfer Manual' }}
                </strong>
            </div>

        </div>

        <div class="alert alert-info text-start small">
            Merchant akan menghubungi kamu untuk mengonfirmasi ketersediaan produk,
            ongkos kirim, dan proses pembayaran.
        </div>

        <a href="{{ route('products.index') }}" class="btn-home">
            <i class="fa fa-home"></i>
            Kembali Belanja
        </a>

    </div>

</div>

</body>
</html>
