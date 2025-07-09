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

  function searchPopUp(widgetType, widgetId) {
    // Je nach widgetType kannst du unterschiedliche Popups starten
    switch (widgetType) {
      case "TextWidget":
        openTextWidgetPopup(widgetId);
        break;
      default:
        alert("Kein Popup definiert für Widget-Typ: " + widgetType);
    }
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
        if (data.success && data.widgetId) {
          // Popup mit widgetType und widgetId öffnen
          searchPopUp(widgetType, data.widgetId);
        }
        /* INBETWEEN OPEN EDITOR OF WIDGET AFTERWARDS RELOAD WITH SAVE */
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

        const allowedWidgets = ["TextWidget"];

        if (allowedWidgets.includes(widgetType)) {
          insertWidget(layoutId, slot, widgetType, layoutType);
        }

      });
    });
  });


  function openTextWidgetPopup(widgetId) {
    const popup = document.getElementById("textWidgetPopup");
    popup.style.display = "flex";

    const titleInput = document.getElementById("widgetTitle");
    const contentInput = document.getElementById("widgetContent");

    // Felder leeren
    titleInput.value = "";
    contentInput.value = "";

    // Bestehende Daten laden
    fetch("/api/editor/widgets/getWidget.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        widgetId: widgetId,
        widgetType: "TextWidget"
      })
    })
      .then(res => res.json())
      .then(data => {
        if (data && data.success && data.widget) {
          titleInput.value = data.widget.Title || "";
          contentInput.value = data.widget.Content || "";
        } else {
          console.warn("Widgetdaten konnten nicht geladen werden:", data.message || data);
        }
      })
      .catch(error => {
        console.error("Fehler beim Laden der Widgetdaten:", error);
      });

    // Save-Button Handler
    document.getElementById("saveWidgetBtn").onclick = function () {
      const title = titleInput.value;
      const content = contentInput.value;

      saveWidgetData(widgetId, "TextWidget", { Titel: title, Content: content });
    };
  }

  function saveWidgetData(widgetId, widgetType, data) {
    fetch("/api/editor/widgets/saveWidget.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        widgetId: widgetId,
        widgetType: widgetType,
        data: data,
      }),
    })
      .then((res) => res.json())
      .then((resData) => {
        if (resData.success) {
          alert("Widget gespeichert!");
          // Popup schließen
          document.getElementById("textWidgetPopup").style.display = "none";
          // Danach Seite neu laden
          window.location.reload();
        } else {
          alert("Fehler beim Speichern: " + (resData.message || "Unbekannter Fehler"));
        }
      })
      .catch((error) => {
        console.error("Fehler beim Speichern:", error);
        alert("Netzwerkfehler beim Speichern.");
      });
  }

}