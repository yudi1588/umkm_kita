
document.addEventListener('DOMContentLoaded', function () {

    const categoryScroll = document.getElementById('categoryScroll');
    const prevCategory = document.getElementById('prevCategory');
    const nextCategory = document.getElementById('nextCategory');

    if (!categoryScroll || !prevCategory || !nextCategory) {
        return;
    }

    // Geser ke kiri
    prevCategory.addEventListener('click', function () {
        categoryScroll.scrollBy({
            left: -250,
            behavior: 'smooth'
        });
    });

    // Geser ke kanan
    nextCategory.addEventListener('click', function () {
        categoryScroll.scrollBy({
            left: 250,
            behavior: 'smooth'
        });
    });

    // Geser menggunakan mouse
    let isDragging = false;
    let startX = 0;
    let scrollLeft = 0;

    categoryScroll.addEventListener('mousedown', function (e) {
        isDragging = true;
        categoryScroll.classList.add('active');

        startX = e.pageX;
        scrollLeft = categoryScroll.scrollLeft;
    });

    categoryScroll.addEventListener('mouseup', function () {
        isDragging = false;
        categoryScroll.classList.remove('active');
    });

    categoryScroll.addEventListener('mouseleave', function () {
        isDragging = false;
        categoryScroll.classList.remove('active');
    });

    categoryScroll.addEventListener('mousemove', function (e) {
        if (!isDragging) return;

        e.preventDefault();

        const distance = e.pageX - startX;
        categoryScroll.scrollLeft = scrollLeft - distance;
    });

});
