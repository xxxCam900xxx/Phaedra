document.addEventListener('DOMContentLoaded', () => {
  const newPageBtn = document.getElementById('newPageBtn');
  const newPageModal = document.getElementById('newPageModal');
  const cancelBtn = document.getElementById('cancelBtn');
  const newPageForm = document.getElementById('newPageForm');

  function clearForm() {
    newPageForm.querySelector('[name="nav_title"]').value = '';
    newPageForm.querySelector('[name="pathURL"]').value = '';
    newPageForm.querySelector('[name="page_title"]').value = '';
    newPageForm.querySelector('[name="meta_description"]').textContent = '';
    newPageForm.querySelector('[name="sort"]').value = '';
  }

  // Modal öffnen
  newPageBtn.addEventListener('click', () => {
    newPageForm.reset();
    clearForm();
    newPageModal.classList.remove('hidden');
  });

  // Modal schliessen
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
  const navTitleInput = document.querySelector('input[name="nav_title"]');
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

  navTitleInput.addEventListener("input", () => {
    const slug = generatePathURL(navTitleInput.value);
    pathURLInput.value = slug;
  });
});
