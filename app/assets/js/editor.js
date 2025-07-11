async function getCookieAndVerify() {
  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    return parts.length === 2 ? parts.pop().split(';').shift() : null;
  }

  const token = getCookie("session_key");
  if (!token) return false;

  try {
    const response = await fetch("/api/login/verifyToken.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ token })
    });

    const result = await response.json();
    return result.success === true;
  } catch (err) {
    console.error("Fehler beim Token-Check:", err);
    return false;
  }
}

if (window !== window.top) {
  document
    .getElementById("content-container")
    .classList.replace("hidden", "show");
  document
    .getElementById("content-container")
    .classList.add("border", "border-dashed", "border-gray-500");
  document
    .querySelectorAll(".Layout").forEach((layout) => {
      layout.classList.add("EditorLayout");
    });

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

const allowed = getCookieAndVerify();
if (allowed) {

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
    let pageContentId = document.querySelector('html').getAttribute('data-pageContentId');

    fetch("/api/editor/insertLayout.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        type: type,
        pageContentId: pageContentId,
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

        console.log(widgetType, layoutId, layoutType, slot)

        const allowedWidgets = ["TextWidget", "ImageWidget", "RepoCrawlerWidget", "FaqWidget"];

        if (allowedWidgets.includes(widgetType)) {
          insertWidget(layoutId, slot, widgetType, layoutType);
        } else {
          console.warn("Nicht erlaubtes Widget!");
        }

      });
    });
  });

  

}