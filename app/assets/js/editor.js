// Prüfen, ob die Seite in einem iframe läuft
if (window !== window.top) {
  document
    .getElementById("content-container")
    .classList.replace("hidden", "show");
  document
    .getElementById("content-container")
    .classList.add("border", "border-dashed", "border-gray-500");

  const allWidgets = document.querySelectorAll(".Widget");

  allWidgets.forEach((widget) => {
    const content = widget.textContent.trim();
    const hasChildren = widget.children.length > 0;

    if (content !== "" || hasChildren) {
      // Wenn das Widget Inhalt hat
      widget.classList.remove("border", "border-dashed", "border-gray-500");
    } else {
      // Wenn das Widget leer ist
      widget.classList.add("border", "border-dashed", "border-gray-500");
    }
  });
}

function handleDragStart(event) {
  // Widget Typ aus dem Attribut lesen
  const type = event.target.dataset.dropboxType;

  // Im Drag-Datenobjekt ablegen
  event.dataTransfer.setData("text/plain", type);
}

document.addEventListener("DOMContentLoaded", () => {
  const dropzone = document.getElementById("content-container");

  // Dropzone aktivieren
  dropzone.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropzone.style.backgroundColor = "#f0f0f0";
  });

  dropzone.addEventListener("dragleave", () => {
    dropzone.style.backgroundColor = "";
  });

  dropzone.addEventListener("drop", (e) => {
    e.preventDefault();
    dropzone.style.backgroundColor = "";
    const layoutType = e.dataTransfer.getData("text/plain");
    insertLayoutblock(layoutType);
  });
});

/**
 * Erzeugt ein neues Widget-Element im Dropzone-Bereich
 * und sendet optional einen Request ans Backend.
 */
function insertLayoutblock(type) {
  fetch("/api/editor/insertLayout.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      type: type,
      pageContentId: 1,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Server response:", data);
      window.location.reload();
    })
    .catch((error) => {
      console.error("Error:", error);
      // Optional: Fehlermeldung für den Nutzer
    });
}

function insertWidget(layoutId, slot, widgetType, layoutType) {
  fetch("/api/editor/widgets/insertWidget.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      layoutId: layoutId,
      slot: slot,
      widgetType: widgetType,
      layoutType: layoutType,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Widget angelegt:", data);
      /* INBETWEEN OPEN EDITOR OF WIDGET AFTERWARDS RELOAD WITH SAVE */
      window.location.reload();
    })
    .catch((error) => {
      console.error("Fehler beim Widget-Insert:", error);
      alert("Fehler beim Einfügen des Widgets.");
    });
}

document.addEventListener("DOMContentLoaded", () => {
  const widgetDropzones = document.querySelectorAll(".Widget");

  widgetDropzones.forEach((dropzone) => {
    dropzone.addEventListener("dragover", (e) => {
      e.preventDefault();
      dropzone.classList.add("bg-gray-100");
    });

    dropzone.addEventListener("dragleave", () => {
      dropzone.classList.remove("bg-gray-100");
    });

    dropzone.addEventListener("drop", (e) => {
      e.preventDefault();
      dropzone.classList.remove("bg-gray-100");

      const widgetType = e.dataTransfer.getData("text/plain");
      const layoutId = dropzone.closest(".Layout").dataset.layoutId;
      const layoutType = dropzone.closest(".Layout").dataset.layoutType;
      const slot = dropzone.dataset.widgetSlot;

      insertWidget(layoutId, slot, widgetType, layoutType);
    });
  });
});
