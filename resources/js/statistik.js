
document.addEventListener('DOMContentLoaded', function () {

    // CEK CHART.JS
    if (typeof Chart === 'undefined') {
        console.error('Chart.js belum berhasil dimuat.');
        return;
    }

    // GRAFIK SKALA USAHA
    const skalaCanvas = document.getElementById('skalaChart');

    if (skalaCanvas) {
        new Chart(skalaCanvas, {
            type: 'doughnut',

            data: {
                labels: [
                    'Usaha Mikro',
                    'Usaha Kecil',
                    'Usaha Menengah',
                    'Usaha Besar'
                ],

                datasets: [{
                    data: [75316, 797, 94, 0],

                    backgroundColor: [
                        '#3b82f6',
                        '#f59e0b',
                        '#16a34a',
                        '#9333ea'
                    ],

                    borderWidth: 3,
                    borderColor: '#ffffff'
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',

                plugins: {
                    legend: {
                        position: 'bottom',

                        labels: {
                            usePointStyle: true,
                            padding: 18,
                            font: {
                                size: 11
                            }
                        }
                    },

                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const total = 76207;
                                const value = context.raw;
                                const persen = (value / total * 100)
                                    .toFixed(2);

                                return context.label + ': ' +
                                    value.toLocaleString('id-ID') +
                                    ' (' + persen + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // GRAFIK BIDANG USAHA
    const kategoriCanvas = document.getElementById('kategoriChart');

    if (kategoriCanvas) {
        new Chart(kategoriCanvas, {
            type: 'doughnut',

            data: {
                labels: [
                    'Kuliner & Makanan Minuman',
                    'Fashion & Pakaian',
                    'Kerajinan & Furnitur',
                    'Pertanian & Perkebunan',
                    'Jasa & Lainnya'
                ],

                datasets: [{
                    data: [35, 25, 20, 12, 8],

                    backgroundColor: [
                        '#3b82f6',
                        '#f59e0b',
                        '#16a34a',
                        '#9333ea',
                        '#94a3b8'
                    ],

                    borderWidth: 3,
                    borderColor: '#ffffff'
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',

                plugins: {
                    legend: {
                        position: 'bottom',

                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    }

});
