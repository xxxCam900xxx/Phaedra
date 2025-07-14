document.addEventListener("DOMContentLoaded", () => {
    const typingEl = document.getElementById("typingText");
    const rawList = typingEl.dataset.typingList || "";
    const texts = rawList.split(",").map(t => t.trim()).filter(t => t !== "");

    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;

    const typingSpeed = 75;
    const deletingSpeed = 40;
    const pauseBeforeDelete = 1200;
    const pauseBeforeType = 500;

    function type() {
        const currentText = texts[textIndex];
        const visibleText = currentText.substring(0, charIndex);

        typingEl.textContent = visibleText;

        if (!isDeleting) {
            if (charIndex < currentText.length) {
                charIndex++;
                setTimeout(type, typingSpeed);
            } else {
                isDeleting = true;
                setTimeout(type, pauseBeforeDelete);
            }
        } else {
            if (charIndex > 0) {
                charIndex--;
                setTimeout(type, deletingSpeed);
            } else {
                isDeleting = false;
                textIndex = (textIndex + 1) % texts.length;
                setTimeout(type, pauseBeforeType);
            }
        }
    }

    if (texts.length > 0) {
        type();
    }
});