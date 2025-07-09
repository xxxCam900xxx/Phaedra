const showPageStructureBtn = document.getElementById('showPageStructureBtn');
const showPageStructure = document.getElementById('showPageStructure');
const showPageStructureCancelBtn = document.getElementById('showPageStructureCancelBtn');
const newPageModal = document.getElementById('newPageModal');

const inputId = document.querySelector('input[name="id"]');
const inputNavTitle = document.querySelector('input[name="nav_title"]');
const inputPathURL = document.querySelector('input[name="pathURL"]');
const inputPageTitle = document.querySelector('input[name="page_title"]');
const inputMetaDesc = document.querySelector('textarea[name="meta_description"]');
const inputSort = document.querySelector('input[name="sort"]');

// Modal öffnen
showPageStructureBtn.addEventListener('click', () => {
    showPageStructure.classList.remove('hidden');
});

// Modal schliessen
showPageStructureCancelBtn.addEventListener('click', () => {
    showPageStructure.classList.add('hidden');
});

// Update Selected Page
function openUpdatePagePopUp(id, nav_title, pathURL, page_title, meta_desc, sort) {
    showPageStructure.classList.add('hidden');
    inputId.setAttribute('value', id);
    inputNavTitle.setAttribute('value', nav_title);
    inputPathURL.setAttribute('value', pathURL);
    inputPageTitle.setAttribute('value', page_title);
    inputMetaDesc.innerText = meta_desc;
    inputSort.setAttribute('value', sort);
    newPageModal.classList.remove('hidden');
}

// Delete Selected Page
async function deletePageById(id) {
    try {
        const response = await fetch('/api/editor/pages/deletePageById.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id }),
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