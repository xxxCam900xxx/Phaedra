let currentlyOpen = null;

function toggleFaq(index) {
    const content = document.getElementById(`answer-${index}`);
    const icon = document.getElementById(`icon-${index}`);

    // Schließe bisher geöffnete
    if (currentlyOpen !== null && currentlyOpen !== index) {
        const oldContent = document.getElementById(`answer-${currentlyOpen}`);
        const oldIcon = document.getElementById(`icon-${currentlyOpen}`);
        oldContent.style.maxHeight = "0px";
        oldIcon.classList.remove("rotate-180");
    }

    if (currentlyOpen === index) {
        // Gleiche erneut geklickt → schließen
        content.style.maxHeight = "0px";
        icon.classList.remove("rotate-180");
        currentlyOpen = null;
    } else {
        // Neue öffnen
        content.style.maxHeight = content.scrollHeight + "px";
        icon.classList.add("rotate-180");
        currentlyOpen = index;
    }
}

// Create a Post Request to Create new FAQs
const newFaqQuestionForm = document.getElementById(`newFaqQuestionForm`);

newFaqQuestionForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(newFaqQuestionForm);
    const data = Object.fromEntries(formData.entries());

    try {
      const response = await fetch('/api/faqs/saveFaq.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
      });
      const result = await response.json();

      if (result.success) {
        window.location.reload();
      } else {
        alert('Fehler: ' + (result.error || 'Unbekannter Fehler'));
      }
    } catch (error) {
      alert('Netzwerkfehler');
    }
})