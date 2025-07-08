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
        alert('Seite erfolgreich erstellt!');
        newPageModal.classList.add('hidden');
        newPageForm.reset();
        // Optional: Seite im Editor aktualisieren
      } else {
        alert('Fehler: ' + (result.error || 'Unbekannter Fehler'));
      }
    } catch (error) {
      alert('Netzwerkfehler');
    }
  });
});
