if (allowed) {

    function insertWidget(layoutId, widgetSlot, widgetType, layoutType) {
        fetch("/api/editor/widgets/insertWidget.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                layoutId: layoutId,
                layoutType: layoutType,
                widgetType: widgetType,
                widgetSlot: widgetSlot,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log("Widget angelegt:", data);
                if (data.success && data.widgetId) {

                    const widgetData = {
                        layoutId: layoutId,
                        widgetId: data.widgetId,
                        widgetType: widgetType,
                        layoutType: layoutType,
                        widgetSlot: widgetSlot
                    }

                    searchPopUp(widgetType, widgetData, true);
                }
            })
            .catch((error) => {
                console.error("Fehler beim Widget-Insert:", error);
                alert("Fehler beim Einfügen des Widgets.");
            });
    }

    function getWidgetandApplytoPopUp(widgetData, htmlObjects) {
        // Bestehende Daten laden
        console.log(widgetData);
        fetch("/api/editor/widgets/getWidget.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                widgetId: widgetData.widgetId,
                widgetType: widgetData.widgetType
            })
        })
            .then(res => res.json())
            .then(data => {
                if (data && data.success && data.content) {

                    replaceWidgetContent(widgetData.widgetType, data.content, htmlObjects)

                } else {
                    console.warn("Widgetdaten konnten nicht geladen werden:", data.message || data);
                }
            })
            .catch(error => {
                console.error("Fehler beim Laden der Widgetdaten:", error);
            });
    }

    function replaceWidgetContent(widgetType, widgetData, htmlObjects) {

        switch (widgetType) {
            case "TextWidget":
                htmlObjects.titleInput.value = widgetData.Title || "";
                htmlObjects.contentInput.value = widgetData.Content || "";
                break;

            default:
                break;
        }

    }

    function deleteWidget(widgetData) {

        fetch("/api/editor/widgets/deleteWidget.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                layoutId: widgetData.layoutId,
                widgetId: widgetData.widgetId,
                widgetType: widgetData.widgetType,
                layoutType: widgetData.layoutType,
                widgetSlot: widgetData.widgetSlot
            })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) window.location.reload();
                else alert("Fehler beim Löschen: " + (data.message || "Unbekannter Fehler"));
            })
            .catch(err => alert("Netzwerkfehler: " + err));

    }

    function searchPopUp(widgetType, widgetData, isInserted = false) {
        // Je nach widgetType kannst du unterschiedliche Popups starten
        switch (widgetType) {
            case "TextWidget":
                openTextWidgetPopup(widgetData, isInserted);
                break;
            default:
                alert("Kein Popup definiert für Widget-Typ: " + widgetType);
        }
    }

    function openTextWidgetPopup(widgetData, isInserted = false) {
        const popup = document.getElementById("textWidgetPopup");
        popup.style.display = "flex";

        const titleInput = document.getElementById("textWidgetTitle");
        const contentInput = document.getElementById("textWidgetContent");

        const htmlObjects = {
            titleInput: titleInput,
            contentInput: contentInput
        }

        titleInput.value = "";
        contentInput.value = "";

        // Get Widget and Apply Value changes if needed
        getWidgetandApplytoPopUp(widgetData, htmlObjects)

        // Save-Button Handler
        document.getElementById("saveTextWidgetBtn").onclick = function () {
            const widgetContent = {
                Title: titleInput.value,
                Content: contentInput.value
            }

            saveWidgetData(widgetData, widgetContent);
        };

        // Cancel-Button Handler
        document.getElementById("cancelTextWidgetBtn").onclick = function () {
            if (isInserted) {
                titleInput.value = "";
                contentInput.value = "";
                deleteWidget(widgetData);
            } else {
                window.location.reload();
            }
        };
    }

    function saveWidgetData(widgetData, widgetContent) {
        fetch("/api/editor/widgets/saveWidget.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                widgetId: widgetData.widgetId,
                widgetType: widgetData.widgetType,
                widgetContent: widgetContent,
            }),
        })
            .then((res) => res.json())
            .then((resData) => {
                if (resData.success) {
                    console.log("Widget wurde erfolgreich gespeichert!");
                    window.location.reload();
                } else {
                    alert("Fehler beim Speichern: " + (resData.message || "Unbekannter Fehler"));
                }
            })
            .catch((error) => {
                alert("Fehler beim Speichern:", error);
            });
    }

}