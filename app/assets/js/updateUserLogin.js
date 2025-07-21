document.addEventListener('DOMContentLoaded', () => {
    const userProfileChangesForm = document.getElementById('userProfileChangesForm');

    userProfileChangesForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(userProfileChangesForm);
        const data = Object.fromEntries(formData.entries());

        const oldPassword = data.oldPassword;
        if (!oldPassword) {
            alert("Bitte altes Passwort eingeben.");
            return;
        }

        // Schritt 1: altes Passwort prüfen
        try {
            const checkResponse = await fetch("/api/userprofile/getCurrentUserProfile.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ oldPassword })
            });

            const checkResult = await checkResponse.json();

            if (!checkResult.success) {
                alert("Fehler beim Prüfen des Passworts: " + (checkResult.message || ""));
                return;
            }

            if (!checkResult.valid) {
                alert("Altes Passwort ist falsch.");
                return;
            }
        } catch (err) {
            console.error("Fehler beim Passwort-Check:", err);
            alert("Verbindungsfehler beim Passwort-Check.");
            return;
        }

        // Schritt 2: neues Passwort speichern
        try {
            const response = await fetch("/api/userprofile/updateUserProfile.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                alert("Fehler beim Speichern: " + (result.message || "Unbekannter Fehler"));
                return;
            }

            alert("Passwort geändert – Sie werden abgemeldet.");
            window.location.href = "/api/login/logout.php";

        } catch (error) {
            console.error("Fetch-Fehler:", error);
            alert("Verbindungsfehler beim Speichern.");
        }
    });
});