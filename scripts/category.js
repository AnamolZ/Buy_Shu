document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelector('.slides');
    const slideArray = document.querySelectorAll('.slide');
    let index = 0;

    function nextSlide() {
        index = (index + 1) % slideArray.length;
        slides.style.transform = `translateX(${-index * 100}%)`;
    }

    setInterval(nextSlide, 5000);
});
