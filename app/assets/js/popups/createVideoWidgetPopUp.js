// 📌 Element-Referenzen
const videoDropArea = document.getElementById('videoDropArea');
const videoInput = document.getElementById('videoInput');
const videoPreview = document.getElementById('videoPreview');
const openVideoPopupBtn = document.getElementById('openVideoSelectorBtn');
const popupVideo = document.getElementById('videoSelectorPopup');
const closeVideoPopupBtn = document.getElementById('closeVideoSelectorBtn');
const videoList = document.getElementById('videoList');
const videoURLInput = document.getElementById('widgetVideoURL');
const videoDescInput = document.getElementById('widgetVideoDesc');

// 📌 Initialisiere Popup
function openVideoWidgetPopUp(widgetData, isInserted = false) {
    document.getElementById("videoWidgetPopup").style.display = "flex";

    videoURLInput.value = "";
    videoDescInput.value = "";
    updateVideoPreview("");

    getWidgetandApplytoPopUp(widgetData, {
        videoURLInput,
        videoDescInput,
        videoPreview: videoPreview.querySelector("video")
    });

    document.getElementById("saveVideoWidgetBtn").onclick = () => {
        saveWidgetData(widgetData, {
            VideoURL: videoURLInput.value,
            VideoDesc: videoDescInput.value
        });
    };

    document.getElementById("cancelVideoWidgetBtn").onclick = () => {
        if (isInserted) {
            deleteWidget(widgetData);
        } else {
            window.location.reload();
        }
    };
}

// 📌 Vorschau aktualisieren
function updateVideoPreview(url) {
    const videoElement = videoPreview.querySelector("video");
    videoElement.setAttribute("src", url);
}

// 📌 Chunks hochladen
async function uploadVideoInChunks(file) {
    if (!file.type.startsWith("video/")) {
        alert("Bitte wählen Sie eine Videodatei aus.");
        return;
    }

    const chunkSize = 5 * 1024 * 1024; // 5MB
    const totalChunks = Math.ceil(file.size / chunkSize);
    const uploadId = `${Date.now()}_${Math.random().toString(36).substring(2)}`;

    for (let i = 0; i < totalChunks; i++) {
        const chunk = file.slice(i * chunkSize, Math.min((i + 1) * chunkSize, file.size));
        const formData = new FormData();
        formData.append("chunk", chunk);
        formData.append("uploadId", uploadId);
        formData.append("chunkIndex", i);
        formData.append("totalChunks", totalChunks);
        formData.append("fileName", file.name);

        try {
            const response = await fetch("/api/media/uploadChunk.php", {
                method: "POST",
                body: formData
            });
            const json = await response.json();
            if (!json.success) {
                alert(`Fehler beim Hochladen von Chunk ${i + 1}: ${json.message}`);
                return;
            }
        } catch (err) {
            alert("Netzwerkfehler: " + err.message);
            return;
        }
    }

    const filePath = `/upload/${uploadId}_${file.name}`;
    videoURLInput.value = filePath;
    updateVideoPreview(filePath);
}

// 📌 Datei-Ereignisse
videoDropArea.addEventListener("click", () => videoInput.click());

videoDropArea.addEventListener("dragover", e => {
    e.preventDefault();
    videoDropArea.classList.add("border-sky-500", "bg-sky-50");
});

videoDropArea.addEventListener("dragleave", e => {
    e.preventDefault();
    videoDropArea.classList.remove("border-sky-500", "bg-sky-50");
});

videoDropArea.addEventListener("drop", async e => {
    e.preventDefault();
    videoDropArea.classList.remove("border-sky-500", "bg-sky-50");

    if (e.dataTransfer.files.length > 0) {
        const file = e.dataTransfer.files[0];
        videoURLInput.value = ""; // Textfeld zurücksetzen
        await uploadVideoInChunks(file);
    }
});

videoInput.addEventListener("change", async () => {
    if (videoInput.files.length > 0) {
        videoURLInput.value = ""; // Textfeld zurücksetzen
        await uploadVideoInChunks(videoInput.files[0]);
    }
});

// 📌 Textfeld-Änderung -> Datei-Input zurücksetzen
videoURLInput.addEventListener("input", () => {
    videoInput.value = "";
    updateVideoPreview(videoURLInput.value);
});

// 📌 Popup öffnen
openVideoPopupBtn.addEventListener("click", () => {
    popupVideo.classList.remove("hidden");
    loadImages();
});

closeVideoPopupBtn.addEventListener("click", () => {
    popupVideo.classList.add("hidden");
});

// 📌 Bibliotheksbilder laden
async function loadImages() {
    videoList.innerHTML = "Lade Videos...";

    try {
        const res = await fetch("/api/media/fetchMedia.php");
        const videos = await res.json();

        if (!Array.isArray(videos)) throw new Error();

        videoList.innerHTML = "";
        videos.forEach(video => {
            const div = document.createElement("div");
            div.className = "relative group";
            div.innerHTML = `
                <video src="${video.url}" class="rounded shadow cursor-pointer w-full h-[200px] object-cover" muted></video>
                <button class="absolute bottom-1 right-1 bg-sky-600 text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">Auswählen</button>
            `;
            div.addEventListener("click", () => {
                videoInput.value = ""; // Datei-Input zurücksetzen
                videoURLInput.value = video.url;
                updateVideoPreview(video.url);
                popupVideo.classList.add("hidden");
            });
            videoList.appendChild(div);
        });
    } catch {
        videoList.innerHTML = "Fehler beim Laden der Videos.";
    }
}