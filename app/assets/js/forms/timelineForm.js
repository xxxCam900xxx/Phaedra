function editTimeLine(button) {
    document.getElementById('ID').value = button.dataset.id;
    document.getElementById('Date').value = button.dataset.date;
    document.getElementById('Title').value = button.dataset.title;
    document.getElementById('Description').value = button.dataset.description;
    document.getElementById('Link').value = button.dataset.link;
}

function deleteTimeLine(button) {
    fetch("/api/TimeLines/deleteTimeLine.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            timeLineId: button.dataset.id
        })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) window.location.reload();
            else alert("Fehler beim Löschen: " + (data.message || "Unbekannter Fehler"));
        })
        .catch(err => alert("Netzwerkfehler: " + err));
}

const newTimelineForm = document.getElementById(`newTimeLineForm`);

newTimelineForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(newTimelineForm);
    const data = Object.fromEntries(formData.entries());

    try {
        const response = await fetch('/api/timelines/saveTimeLine.php', {
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