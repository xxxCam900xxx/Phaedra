if (window !== window.top) {
    document.addEventListener("DOMContentLoaded", function () {
        const contextMenu = document.getElementById("layoutContextMenu");
        const deleteLayoutBtn = document.getElementById("deleteLayoutBtn");
        const deleteWidgetBtn = document.getElementById("deleteWidgetBtn");
        const updateWidgetBtn = document.getElementById("updateWidgetBtn");
        const copydeleteWidgetBtn = document.getElementById("copydeleteWidgetBtn");
        const pasteWidgetBtn = document.getElementById("pasteWidgetBtn");

        let currentLayoutId = null;
        let currentWidgetId = null;
        let currentWidgetType = null;
        let currentLayoutType = null;
        let currentWidgetSlot = null;

        function saveClipboardToSession(data) {
            sessionStorage.setItem("clipboardData", JSON.stringify(data));
        }

        function loadClipboardFromSession() {
            const data = sessionStorage.getItem("clipboardData");
            return data ? JSON.parse(data) : null;
        }

        function clearClipboardSession() {
            sessionStorage.removeItem("clipboardData");
        }

        document.querySelectorAll(".Layout .Widget").forEach(widgetEl => {
            widgetEl.addEventListener("contextmenu", function (e) {
                e.preventDefault();

                const widgetId = this.dataset.widgetId;
                const widgetType = this.dataset.widgetType;
                const widgetSlot = this.dataset.widgetSlot;

                const layoutEl = this.closest(".Layout");
                const layoutId = layoutEl ? layoutEl.dataset.layoutId : null;
                const layoutType = layoutEl ? layoutEl.dataset.layoutType : null;

                currentWidgetId = widgetId || null;
                currentWidgetType = widgetType || null;
                currentWidgetSlot = widgetSlot || null;
                currentLayoutId = layoutId;
                currentLayoutType = layoutType;

                const clipboard = loadClipboardFromSession();

                if (widgetId && widgetType) {
                    deleteWidgetBtn.style.display = "block";
                    updateWidgetBtn.style.display = "block";
                    copydeleteWidgetBtn.style.display = "block";
                    pasteWidgetBtn.style.display = "none";
                } else {
                    deleteWidgetBtn.style.display = "none";
                    updateWidgetBtn.style.display = "none";
                    copydeleteWidgetBtn.style.display = "none";
                    pasteWidgetBtn.style.display = clipboard?.active ? "block" : "none";
                }

                contextMenu.style.top = `${e.pageY}px`;
                contextMenu.style.left = `${e.pageX}px`;
                contextMenu.style.display = "block";
            });
        });

        document.addEventListener("click", function (e) {
            if (!contextMenu.contains(e.target)) {
                contextMenu.style.display = "none";
            }
        });

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

        updateWidgetBtn.addEventListener("click", function () {
            if (!currentWidgetId || !currentWidgetType) return;
            contextMenu.style.display = "none";

            const widgetData = {
                layoutId: currentLayoutId,
                widgetId: currentWidgetId,
                widgetType: currentWidgetType,
                layoutType: currentLayoutType,
                widgetSlot: currentWidgetSlot
            }

            console.log(widgetData);

            searchPopUp(currentWidgetType, widgetData);
        });

        copydeleteWidgetBtn.addEventListener("click", function () {
            if (!currentLayoutId || !currentWidgetId || !currentWidgetType) return;

            saveClipboardToSession({
                widgetID: currentWidgetId,
                widgetType: currentWidgetType,
                widgetSlot: currentWidgetSlot,
                layoutType: currentLayoutType,
                layoutId: currentLayoutId,
                active: true
            });

            contextMenu.style.display = "none";
        });

        pasteWidgetBtn.addEventListener("click", function () {
            const clipboard = loadClipboardFromSession();
            if (!clipboard || !clipboard.active) return;

            clipboard.active = false;
            saveClipboardToSession(clipboard);

            fetch("/api/editor/widgets/moveWidget.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    clipboardWidgetID: clipboard.widgetID,
                    clipboardWidgetType: clipboard.widgetType,
                    clipboardWidgetSlot: clipboard.widgetSlot,
                    clipboardLayoutType: clipboard.layoutType,
                    clipboardLayoutId: clipboard.layoutId,
                    curretnWidgetSlot: currentWidgetSlot,
                    currentLayoutType: currentLayoutType,
                    currentLayoutId: currentLayoutId
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) window.location.reload();
                    else alert("Fehler beim Einfügen: " + (data.message || "Unbekannter Fehler"));
                })
                .catch(err => alert("Netzwerkfehler: " + err));

            contextMenu.style.display = "none";
        });

        deleteWidgetBtn.addEventListener("click", function () {
            if (!currentLayoutId || !currentWidgetId || !currentWidgetType) return;
            if (!confirm("Möchten Sie dieses Widget wirklich löschen?")) return;

            const widgetData = {
                layoutId: currentLayoutId,
                widgetId: currentWidgetId,
                widgetType: currentWidgetType,
                layoutType: currentLayoutType,
                widgetSlot: currentWidgetSlot
            }

            deleteWidget(widgetData);

            contextMenu.style.display = "none";
        });
    });
}