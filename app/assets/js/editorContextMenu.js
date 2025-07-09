if (window !== window.top) {
    document.addEventListener("DOMContentLoaded", function () {
        const contextMenu = document.getElementById("layoutContextMenu");
        const deleteLayoutBtn = document.getElementById("deleteLayoutBtn");
        const deleteWidgetBtn = document.getElementById("deleteWidgetBtn");
        const updateWidgetBtn = document.getElementById("updateWidgetBtn");

        let currentLayoutId = null;
        let currentWidgetId = null;
        let currentWidgetType = null;
        let currentLayoutType = null;
        let curretnWidgetSlot = null;

        document.querySelectorAll(".Layout .Widget").forEach(widgetEl => {
            widgetEl.addEventListener("contextmenu", function (e) {
                e.preventDefault();

                // Aktuelles Widget-Element (this)
                const widgetId = this.dataset.widgetId;
                const widgetType = this.dataset.widgetType;
                const widgetSlot = this.dataset.widgetSlot;

                if (widgetId && widgetId.trim() !== '' && widgetType && widgetType.trim() !== '') {
                    console.log("Widget Rechtsklick auf Widget mit ID:", widgetId, "Type:", widgetType);
                    deleteWidgetBtn.style.display = "block";
                    updateWidgetBtn.style.display = "block";
                } else {
                    console.log("Kein Widget in diesem Slot");
                    deleteWidgetBtn.style.display = "none";
                    updateWidgetBtn.style.display = "none";
                }

                const layoutEl = this.closest(".Layout");
                const layoutId = layoutEl ? layoutEl.dataset.layoutId : null;
                const layoutType = layoutEl ? layoutEl.dataset.layoutType : null;

                currentWidgetId = widgetId || null;
                currentWidgetType = widgetType || null;
                currentLayoutId = layoutId;
                currentLayoutType = layoutType;
                curretnWidgetSlot = widgetSlot || null;

                contextMenu.style.top = `${e.pageY}px`;
                contextMenu.style.left = `${e.pageX}px`;
                contextMenu.style.display = "block";
            });
        });

        // Klick ausserhalb schliesst Menü
        document.addEventListener("click", function (e) {
            if (!contextMenu.contains(e.target)) {
                contextMenu.style.display = "none";
            }
        });

        // Layout löschen
        deleteLayoutBtn.addEventListener("click", function () {
            if (!currentLayoutId) return;
            if (!confirm("Möchten Sie dieses Layout wirklich löschen?")) return;

            fetch("/api/editor/deleteLayout.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ layoutId: currentLayoutId })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) window.location.reload();
                    else alert("Fehler beim Löschen: " + (data.message || "Unbekannter Fehler"));
                })
                .catch(err => alert("Netzwerkfehler: " + err));

            contextMenu.style.display = "none";
        });

        // Widget bearbeiten
        updateWidgetBtn.addEventListener("click", function () {
            if (!currentWidgetId || !currentWidgetType) return;
            contextMenu.style.display = "none";
            searchPopUp(currentWidgetType, currentWidgetId);
        });

        // Widget löschen
        deleteWidgetBtn.addEventListener("click", function () {
            if (!currentLayoutId || !currentWidgetId || !currentWidgetType) return;
            if (!confirm("Möchten Sie dieses Widget wirklich löschen?")) return;

            fetch("/api/editor/widgets/deleteWidget.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    layoutId: currentLayoutId,
                    widgetId: currentWidgetId,
                    widgetType: currentWidgetType,
                    layoutType: currentLayoutType,
                    widgetSlot: curretnWidgetSlot
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) window.location.reload();
                    else alert("Fehler beim Löschen: " + (data.message || "Unbekannter Fehler"));
                })
                .catch(err => alert("Netzwerkfehler: " + err));

            contextMenu.style.display = "none";
        });
    });
}