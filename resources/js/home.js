// Js untuk produk kategori sidebar
document.addEventListener('DOMContentLoaded', function () {

    const slider = document.getElementById('categoryScroll');
    const prev = document.getElementById('prevCategory');
    const next = document.getElementById('nextCategory');

    if (!slider) return;

    let direction = 1;
    let isPaused = false;

    // ANIMASI OTOMATIS KANAN DAN KIRI
    setInterval(function () {

        if (isPaused) return;

        const maxScroll = slider.scrollWidth - slider.clientWidth;

        if (maxScroll <= 0) return;

        slider.scrollLeft += direction;

        if (slider.scrollLeft >= maxScroll - 1) {
            direction = -1;
        }

        if (slider.scrollLeft <= 0) {
            direction = 1;
        }

    }, 20);

    // BERHENTI SAAT MOUSE DIARAHKAN
    slider.addEventListener('mouseenter', function () {
        isPaused = true;
    });

    slider.addEventListener('mouseleave', function () {
        isPaused = false;
    });

    // TOMBOL KIRI
    if (prev) {
        prev.addEventListener('click', function () {
            slider.scrollBy({
                left: -250,
                behavior: 'smooth'
            });
            direction = -1;
        });
    }

    // TOMBOL KANAN
    if (next) {
        next.addEventListener('click', function () {
            slider.scrollBy({
                left: 250,
                behavior: 'smooth'
            });
            direction = 1;
        });
    }

});
