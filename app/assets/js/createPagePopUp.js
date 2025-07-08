document.addEventListener('DOMContentLoaded', () => {
  const newPageBtn = document.getElementById('newPageBtn');
  const newPageModal = document.getElementById('newPageModal');
  const cancelBtn = document.getElementById('cancelBtn');
  const newPageForm = document.getElementById('newPageForm');

  // Modal öffnen
  newPageBtn.addEventListener('click', () => {
    newPageModal.classList.remove('hidden');
  });

  // Modal schließen
  cancelBtn.addEventListener('click', () => {
    newPageModal.classList.add('hidden');
  });

  // Formular absenden
  newPageForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(newPageForm);
    const data = Object.fromEntries(formData.entries());

    try {
      const response = await fetch('/api/editor/pages/createNewPage.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
      });
      const result = await response.json();

      if (result.success) {
        /* MAKE A ALERT = alert('Seite erfolgreich erstellt!'); */
        newPageModal.classList.add('hidden');
        newPageForm.reset();
        window.location.reload();
      } else {
        alert('Fehler: ' + (result.error || 'Unbekannter Fehler'));
      }
    } catch (error) {
      alert('Netzwerkfehler');
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
    const titleInput = document.querySelector('input[name="title"]');
    const pathURLInput = document.querySelector('input[name="pathURL"]');

    function generatePathURL(title) {
        return title
            .toLowerCase()
            .trim()
            .replace(/ä/g, 'ae')
            .replace(/ö/g, 'oe')
            .replace(/ü/g, 'ue')
            .replace(/ß/g, 'ss')
            .replace(/[^a-z0-9]+/g, '-')  // alles Nicht-Alphanumerische zu "-"
            .replace(/^-+|-+$/g, '');     // führende/trailing "-" entfernen
    }

    titleInput.addEventListener("input", () => {
        const slug = generatePathURL(titleInput.value);
        pathURLInput.value = slug;
    });
});
