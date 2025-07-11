const scrollBtn = document.getElementById("scrollToTopBtn");

window.addEventListener("scroll", () => {
    if (window.scrollY > 200) {
        scrollBtn.classList.remove("opacity-0", "pointer-events-none");
        scrollBtn.classList.add("opacity-100");
    } else {
        scrollBtn.classList.remove("opacity-100");
        scrollBtn.classList.add("opacity-0", "pointer-events-none");
    }
});

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}