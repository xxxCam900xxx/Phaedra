const webConfigForm = document.getElementById('webConfigForm');
const dropArea = document.getElementById('imageDropArea');
const imageInput = document.getElementById('imageInput');
const logoPreview = document.getElementById('logoPreview');
const openPopupBtn = document.getElementById('openImageSelectorBtn');
const popup = document.getElementById('imageSelectorPopup');
const closePopupBtn = document.getElementById('closeImageSelectorBtn');
const imageList = document.getElementById('imageList');
const webLogoURLInput = document.getElementById('widgetImageURL');

function openImageWidgetPopUp(widgetData, isInserted = false) {
    const popup = document.getElementById("imageWidgetPopup");
    popup.style.display = "flex";

    const imageURLInput = document.getElementById("widgetImageURL");
    const imageDescInput = document.getElementById("widgetImageDesc");
    const imagePreview = logoPreview.querySelector('img');

    const htmlObjects = {
        imageURLInput: imageURLInput,
        imageDescInput: imageDescInput,
        imagePreview: imagePreview
    }

    imageURLInput.value = "";
    imageDescInput.value = "";

    // Get Widget and Apply Value changes if needed
    getWidgetandApplytoPopUp(widgetData, htmlObjects);

    // Save-Button Handler
    document.getElementById("saveImageWidgetBtn").onclick = function () {
        const widgetContent = {
            ImageURL: imageURLInput.value,
            ImageDesc: imageDescInput.value
        }

        saveWidgetData(widgetData, widgetContent);
    };

    // Cancel-Button Handler
    document.getElementById("cancelImageWidgetBtn").onclick = function () {
        if (isInserted) {
            imageURLInput.value = "";
            imageDescInput.value = "";
            deleteWidget(widgetData);
        } else {
            window.location.reload();
        }
    };
}

// Datei-Auswahl per Klick
dropArea.addEventListener('click', () => imageInput.click());

// Drag & Drop Visual Feedback
dropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropArea.classList.add('border-sky-500', 'bg-sky-50');
});

dropArea.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropArea.classList.remove('border-sky-500', 'bg-sky-50');
});

// Drop-Event behandeln
dropArea.addEventListener('drop', async (e) => {
    e.preventDefault();
    dropArea.classList.remove('border-sky-500', 'bg-sky-50');

    if (e.dataTransfer.files.length > 0) {
        await uploadImage(e.dataTransfer.files[0]);
    }
});

// Datei-Auswahl per Dateiauswahl-Dialog
imageInput.addEventListener('change', async () => {
    if (imageInput.files.length > 0) {
        await uploadImage(imageInput.files[0]);
    }
});

// Bild hochladen und in Datenbank einfügen
async function uploadImage(file) {
    if (!file.type.startsWith('image/')) {
        alert('Bitte wählen Sie eine Bilddatei aus.');
        return;
    }

    const formData = new FormData();
    formData.append('image', file);

    try {
        const res = await fetch('/api/media/uploadMedia.php', {
            method: 'POST',
            body: formData
        });

        const json = await res.json();

        if (json.success) {
            updateLogoPreview(json['path']);
            webLogoURLInput.value = json['path'];
            alert('Bild erfolgreich hochgeladen.');
        } else {
            alert('Fehler: ' + json.message);
        }

    } catch (err) {
        alert('Netzwerkfehler: ' + err.message);
    }
}

// Vorschau aktualisieren
function updateLogoPreview(url) {
    logoPreview.querySelector('img').setAttribute('src', url);
}

// Popup öffnen
openPopupBtn.addEventListener('click', () => {
    popup.classList.remove('hidden');
    loadImages();
});

// Popup schliessen
closePopupBtn.addEventListener('click', () => {
    popup.classList.add('hidden');
});

// Bilder aus DB laden und anzeigen
async function loadImages() {
    imageList.innerHTML = 'Lade Bilder...';

    try {
        const res = await fetch('/api/media/fetchMedia.php');
        const images = await res.json();

        if (!Array.isArray(images)) {
            imageList.innerHTML = 'Fehler beim Laden der Bilder.';
            return;
        }

        imageList.innerHTML = '';
        images.forEach(img => {
            const div = document.createElement('div');
            div.className = 'relative group';

            div.innerHTML = `
                    <img src="${img['url']}" alt="Image" class="rounded shadow hover:opacity-80 cursor-pointer w-full h-[200px] object-cover" />
                    <button class="absolute bottom-1 right-1 bg-sky-600 text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition" title="Als Logo auswählen">Auswählen</button>
                `;

            div.addEventListener('click', () => {
                updateLogoPreview(img['url']);
                webLogoURLInput.value = img['url'];
                popup.classList.add('hidden');
            });

            imageList.appendChild(div);
        });

    } catch {
        imageList.innerHTML = 'Fehler beim Laden der Bilder.';
    }
}