document.addEventListener('DOMContentLoaded', () => {

    const webConfigForm = document.getElementById('webConfigForm');

    webConfigForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(webConfigForm);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('/api/webconfig/updateWebConfig.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            });

            const result = await response.json();
            if (result.success) {
                window.location.reload();
            }
            else {
                alert("Fehler: ", (result.error || 'Unbekannter Fehler'))
            }

        } catch (error) {
            alert("Fehler:", error)
        }
    });

});