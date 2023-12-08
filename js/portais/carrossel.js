let slideIndex = 0;
showSlide(slideIndex);

function showSlide(n) {
    const slides = document.querySelectorAll('.slide');

    if (n >= slides.length) {
        slideIndex = 0;
    }
    if (n < 0) {
        slideIndex = slides.length - 1;
    }

    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }

    slides[slideIndex].style.display = 'block';
}

function nextSlide() {
    showSlide(++slideIndex);
}

setInterval(nextSlide, 3000); // Mude a cada 3 segundos