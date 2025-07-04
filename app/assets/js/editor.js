// Prüfen, ob die Seite in einem iframe läuft
if (window !== window.top) {
    document.getElementById('content-container').classList.replace('hidden', 'show');
    document.getElementById('content-container').classList.add('border', 'border-dashed', 'border-gray-500');
}

function handleDragStart(event) {
    // Widget Typ aus dem Attribut lesen
    const type = event.target.dataset.layoutType;
    
    // Im Drag-Datenobjekt ablegen
    event.dataTransfer.setData('text/plain', type);
}

document.addEventListener('DOMContentLoaded', () => {
    const dropzone = document.getElementById('content-container');

    // Dropzone aktivieren
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.style.backgroundColor = '#f0f0f0';
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.style.backgroundColor = '';
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.style.backgroundColor = '';
        const layoutType = e.dataTransfer.getData('text/plain');
        insertLayoutblock(layoutType);
    });
});

/**
 * Erzeugt ein neues Widget-Element im Dropzone-Bereich
 * und sendet optional einen Request ans Backend.
 */
function insertLayoutblock(type) {
    fetch('/api/editor/insertLayout.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            type: type,
            pageContentId: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Server response:', data);
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        // Optional: Fehlermeldung für den Nutzer
    });
}