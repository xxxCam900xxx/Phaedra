document.addEventListener("DOMContentLoaded", async () => {
    const settingsContainer = document.getElementById("editorSettings");
    const saveBtn = document.getElementById("saveEditorStyles");
    const editorFrame = document.getElementById("editor");
    const hoverStyle = document.createElement("style");

    // Editor-Dokument referenzieren (erst nach iframe load)
    let iframeDoc = null;
    if (editorFrame) {
        editorFrame.addEventListener("load", () => {
            iframeDoc = editorFrame.contentDocument || editorFrame.contentWindow.document;
            iframeDoc.head.appendChild(hoverStyle);
        });
    }

    try {
        const response = await fetch("/api/editor/design/fetchWebDesign.php");
        const result = await response.json();
        if (result.success && result.data) {
            const data = result.data;

            // Setze nur die Werte im Formular, NICHT im Iframe
            const inputs = settingsContainer.querySelectorAll("input");
            inputs.forEach(input => {
                const name = input.name;
                if (data.hasOwnProperty(name)) {
                    input.value = data[name];

                    const label = document.getElementById(name + "Label");
                    if (label) {
                        label.textContent = name.includes("Size")
                            ? `${input.value}px`
                            : input.value;
                    }
                }
            });
        }
    } catch (error) {
        console.error("Fehler beim Laden der Styles:", error);
    }

    // ⬇️ 2. Live-Vorschau nur bei Benutzereingaben
    settingsContainer.querySelectorAll("input").forEach(input => {
        input.addEventListener("input", () => {
            const target = input.dataset.styleTarget;
            const prop = input.dataset.styleProp;
            const name = input.name;

            // Iframe-Stil setzen
            if (iframeDoc && target && prop) {
                iframeDoc.querySelectorAll(target).forEach(el => {
                    el.style[prop] = prop.includes("Size") ? `${input.value}px` : input.value;
                });
            }

            // Label live aktualisieren
            const label = document.getElementById(name + "Label");
            if (label) {
                label.textContent = name.includes("Size")
                    ? `${input.value}px`
                    : input.value;
            }

            // Hover-Farbe live anwenden
            if (input.hasAttribute("data-hover-color") && iframeDoc) {
                hoverStyle.textContent = `a:hover { color: ${input.value}; }`;
            }
            // Hover-Button-Farbe live anwenden
            if (input.hasAttribute("data-btn-hover-color") && iframeDoc) {
                hoverStyle.textContent = `a.button:hover { background-color: ${input.value}; }`;
            }
            if (input.hasAttribute("data-section-gab") && iframeDoc) {
                hoverStyle.textContent = `#dynamicContent { gap: ${input.value}px !important; }`;
            }
        });
    });

    // ⬇️ 3. Speichern-Klick
    saveBtn.addEventListener("click", async () => {
        const inputs = settingsContainer.querySelectorAll("input");
        const data = {};
        inputs.forEach(input => {
            data[input.name] = input.value;
        });

        try {
            const res = await fetch("/api/editor/design/saveEditorStyles.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });

            const result = await res.json();
            if (result.success) {
                alert("Design erfolgreich gespeichert.");
            } else {
                alert("Fehler beim Speichern: " + (result.message || "Unbekannter Fehler"));
            }
        } catch (error) {
            alert("Netzwerkfehler: " + error.message);
        }
    });
});