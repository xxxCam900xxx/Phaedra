function editsocial(button) {
    document.getElementById('ID').value = button.dataset.id;
    document.getElementById('Icon').value = button.dataset.icon;
    document.getElementById('Social').value = button.dataset.social;
    document.getElementById('IsShown').checked = button.dataset.active === "1";
}

function deletesocial(button) {
    fetch("/api/socials/deleteSocial.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            socialId: button.dataset.id
        })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) window.location.reload();
            else alert("Fehler beim Löschen: " + (data.message || "Unbekannter Fehler"));
        })
        .catch(err => alert("Netzwerkfehler: " + err));
}

const newSocialForm = document.getElementById(`newSocialForm`);

newSocialForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(newSocialForm);
    const data = Object.fromEntries(formData.entries());

    try {
        const response = await fetch('/api/socials/saveSocial.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        });
        const result = await response.json();

        if (result.success) {
            window.location.reload();
        } else {
            alert('Fehler: ' + (result.error || 'Unbekannter Fehler'));
        }
    } catch (error) {
        alert('Netzwerkfehler');
    }
})