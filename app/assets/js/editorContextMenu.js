document.addEventListener("DOMContentLoaded", function () {
    const contextMenu = document.getElementById("layoutContextMenu");
    let currentLayoutId = null;

    // Rechtsklick-Handler
    document.querySelectorAll(".Layout").forEach(layout => {
        layout.addEventListener("contextmenu", function (e) {
            e.preventDefault();

            currentLayoutId = this.dataset.layoutId;

            // Position neben Cursor
            contextMenu.style.top = `${e.pageY}px`;
            contextMenu.style.left = `${e.pageX}px`;
            contextMenu.style.display = "block";
        });
    });

    // Klick außerhalb des Menüs schließt es
    document.addEventListener("click", function (e) {
        if (!contextMenu.contains(e.target)) {
            contextMenu.style.display = "none";
        }
    });

    // Löschen-Button
    document.getElementById("deleteLayoutBtn").addEventListener("click", function () {
        if (!currentLayoutId) return;

        if (!confirm("Möchten Sie dieses Layout wirklich löschen?")) {
            contextMenu.style.display = "none";
            return;
        }

        fetch("/api/editor/deleteLayout.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ 
                layoutId: currentLayoutId,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();                
            } else {
                alert("Fehler beim Löschen: " + (data.message || "Unbekannter Fehler"));
            }
        })
        .catch(err => {
            console.error("Löschfehler:", err);
            alert("Netzwerkfehler beim Löschen.");
        });

        contextMenu.style.display = "none";
    });
});
