@extends('layouts.app')

@section('title', 'Statistik Usaha - UMKM Kita')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/user/css/statistik.css') }}">

<div class="statistik-wrapper">

    <!-- JUDUL -->
    <div class="statistik-header">
        <div>
            <span class="statistik-subtitle">DATA DAN INFORMASI UMKM</span>
            <h1>Statistik Usaha</h1>
            <p>Data perkembangan dan persebaran UMKM Kabupaten Probolinggo.</p>
        </div>
    </div>

    <!-- TOTAL UMKM -->
   <div class="total-umkm">
    <div class="total-info">
        <span>Total UMKM Terdaftar</span>
        <h2>76.207</h2>
        <p>Jumlah keseluruhan berdasarkan data contoh</p>
    </div>

    <div class="total-icon">
        <div class="total-icon-circle">
            <i class="fa fa-bar-chart"></i>
        </div>

        <h4>STATISTIK UMKM</h4>
        <span>Kota Jember</span>
        <small>Mikro • Kecil • Menengah</small>
    </div>
</div>

    <!-- SKALA USAHA -->
    <div class="section-title">
        <h2>Statistik Berdasarkan Skala Usaha</h2>
        <p>Jumlah UMKM berdasarkan ukuran usaha</p>
    </div>

    <div class="statistik-cards">

        <div class="stat-card">
            <div class="stat-icon blue">
    <i class="fa fa-shopping-bag"></i>
</div>
            <div class="stat-info">
                <span>Usaha Mikro</span>
                <h3>75.316</h3>
                <small>98,83% dari total UMKM</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fa fa-home"></i>
            </div>
            <div class="stat-info">
                <span>Usaha Kecil</span>
                <h3>797</h3>
                <small>1,05% dari total UMKM</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fa fa-industry"></i>
            </div>
            <div class="stat-info">
                <span>Usaha Menengah</span>
                <h3>94</h3>
                <small>0,12% dari total UMKM</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fa fa-building-o"></i>
            </div>
            <div class="stat-info">
                <span>Usaha Besar</span>
                <h3>0</h3>
                <small>0% dari total UMKM</small>
            </div>
        </div>

    </div>

    <!-- GRAFIK -->
    <div class="section-title">
        <h2>Visualisasi Data UMKM</h2>
        <p>Persentase dan bidang usaha UMKM</p>
    </div>

    <div class="chart-grid">

        <!-- PERSENTASE SKALA -->
        <div class="chart-card">
            <div class="chart-title">
                <h3>Persentase UMKM</h3>
                <p>Berdasarkan skala usaha</p>
            </div>

            <div class="chart-area">
                <canvas id="skalaChart"></canvas>
            </div>

            <div class="chart-note">
                Mayoritas UMKM termasuk dalam kategori usaha mikro.
            </div>
        </div>

        <!-- BIDANG USAHA -->
        <div class="chart-card">
            <div class="chart-title">
                <h3>Bidang Usaha UMKM</h3>
                <p>Berdasarkan kategori UMKM Kita</p>
            </div>

            <div class="chart-area">
                <canvas id="kategoriChart"></canvas>
            </div>

            <div class="chart-note">
                Kategori usaha meliputi kuliner, fashion, kerajinan,
                pertanian, dan bidang lainnya.
            </div>
        </div>

    </div>

    <!-- SEBARAN KECAMATAN -->
    <div class="section-title">
        <h2>Sebaran UMKM Menurut Kecamatan</h2>
        <p>Jumlah UMKM berdasarkan wilayah kecamatan</p>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Kecamatan</th>
                        <th>Jumlah UMKM</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>01</td>
                        <td>Sumbersari</td>
                        <td>1.923</td>
                    </tr>
                    <tr>
                        <td>02</td>
                        <td>Kaliwates</td>
                        <td>1.250</td>
                    </tr>
                    <tr>
                        <td>03</td>
                        <td>Patrang</td>
                        <td>1.105</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span>Data kecamatan merupakan contoh tampilan.</span>
        </div>
    </div>

</div>
@endsection