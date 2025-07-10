document.addEventListener('DOMContentLoaded', () => {
    const userProfileChangesForm = document.getElementById('userProfileChangesForm');

    userProfileChangesForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(userProfileChangesForm);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch("/api/userprofile/updateUserProfile.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data),
            });

            let result;
            try {
                result = await response.json();
            } catch (parseError) {
                const raw = await response.text();
                console.error("Antwort war kein JSON:", raw);
                alert("Fehler: Antwort vom Server war ungültig.");
                return;
            }

            if (!response.ok) {
                alert("Fehler: " + (result.message || "Unbekannter Fehler vom Server"));
                return;
            }

            if (result.success) {
                alert("Passwort geändert – Sie werden abgemeldet.");
                window.location.href = "/api/login/logout.php";
            } else {
                alert("Fehler: " + (result.message || "Unbekannter Fehler"));
            }

        } catch (error) {
            console.error("Fetch-Fehler:", error);
            alert("Verbindungsfehler: " + (error.message || "Unbekannter Fehler"));
        }
    });
});