const showPageStructureBtn = document.getElementById('showPageStructureBtn');
const showPageStructure = document.getElementById('showPageStructure');
const showPageStructureCancelBtn = document.getElementById('showPageStructureCancelBtn');

// Modal öffnen
showPageStructureBtn.addEventListener('click', () => {
    showPageStructure.classList.remove('hidden');
});

// Modal schliessen
showPageStructureCancelBtn.addEventListener('click', () => {
    showPageStructure.classList.add('hidden');
});

// Update Selected Page
function openUpdatePagePopUp(id, title, meta_title, meta_desc, sort) {

}

// Delete Selected Page
async function deletePageById(id) {
    try {
        const response = await fetch('/api/editor/pages/deletePageById.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id }), // Fix: JSON.stringify
        });

        const result = await response.json();

        if (result.success) {
            document.getElementById('showPageStructure')?.classList.add('hidden'); // optional Absicherung
            window.location.reload();
        } else {
            alert('Fehler: ' + (result.error || 'Unbekannter Fehler'));
        }
    } catch (error) {
        console.error(error);
        alert('Netzwerkfehler');
    }
}