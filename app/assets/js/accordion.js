function toggleAccordion(button) {
    const content = button.nextElementSibling;
    const svg = button.querySelector('svg');

    // Collapse all others
    document.querySelectorAll('.accordion-content').forEach((el) => {
        if (el !== content) {
            el.style.maxHeight = null;
            el.previousElementSibling.querySelector('svg').classList.remove('rotate-180');
        }
    });

    // Toggle this one
    if (content.style.maxHeight) {
        content.style.maxHeight = null;
        svg.classList.remove('rotate-180');
    } else {
        content.style.maxHeight = content.scrollHeight + "px";
        svg.classList.add('rotate-180');
    }
}