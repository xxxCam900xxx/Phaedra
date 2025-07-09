const dragOverlay = document.getElementById('dragOverlay');
const imageManager = document.getElementById('imageManager');

imageManager.addEventListener('dragover', (e) => {
    e.preventDefault();
    dragOverlay.classList.remove('hidden');
});

imageManager.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dragOverlay.classList.add('hidden');
});

imageManager.addEventListener('drop', async (e) => {
    e.preventDefault();
    dragOverlay.classList.add('hidden');

    const files = e.dataTransfer.files;
    if (files.length === 0) {
        alert("Keine Datei zum Hochladen gefunden.");
        return;
    }

    const file = files[0];

    // Optional: Nur Bilder erlauben
    if (!file.type.startsWith('image/')) {
        alert('Bitte eine Bilddatei hochladen.');
        return;
    }

    const formData = new FormData();
    formData.append('image', file);

    try {
        const response = await fetch('/api/media/uploadMedia.php', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

        if (result.success) {
            window.location.reload();
        } else {
            alert('Fehler: ' + (result.message || 'Unbekannter Fehler'));
        }
    } catch (err) {
        alert('Netzwerkfehler: ' + err.message);
    }
});

async function deleteImage(button) {
    const imageId = button.dataset.imageId;

    if (!imageId || !confirm("Möchten Sie dieses Bild wirklich löschen?")) return;

    try {
        const response = await fetch('/api/media/deleteMedia.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: imageId })
        });

        const result = await response.json();

        if (result.success) {
            window.location.reload();
        } else {
            alert('Fehler: ' + (result.message || 'Unbekannter Fehler'));
        }
    } catch (err) {
        alert('Netzwerkfehler');
        console.error(err);
    }
}