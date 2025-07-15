<div class="w-full max-w-md bg-white rounded shadow-md p-6">
    <h1 class="text-2xl font-semibold mb-6">Kontaktformular</h1>

    <div id="form-result" class="hidden mb-4 p-4 rounded text-white"></div>

    <form id="contact-form" class="space-y-5">
        <!-- Absender-E-Mail -->
        <label for="email" class="block font-medium text-gray-700">Deine E-Mail-Adresse:</label>
        <input type="email" id="email" name="email" required
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

        <!-- Betreff -->
        <label for="subject" class="block font-medium text-gray-700">Betreff:</label>
        <select id="subject" name="subject" required
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="" disabled selected>Bitte wählen</option>
            <option>Allgemeine Anfrage</option>
            <option>Technischer Support</option>
            <option>Feedback</option>
            <option>Sonstiges</option>
        </select>

        <!-- Nachricht -->
        <label for="message" class="block font-medium text-gray-700">Nachricht:</label>
        <textarea id="message" name="message" required rows="5"
            class="w-full border border-gray-300 rounded px-3 py-2 resize-y focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

        <!-- Honeypot -->
        <div class="absolute left-[-9999px] top-[-9999px]" aria-hidden="true">
            <label for="phone">Telefonnummer</label>
            <input type="text" name="phone" id="phone" autocomplete="off" tabindex="-1">
        </div>

        <button type="submit"
            class="w-full button cursor-pointer text-white font-semibold py-2 rounded focus:outline-none focus:ring-2">
            Absenden
        </button>
    </form>

</div>

<script>
    document.getElementById('contact-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        const responseElement = document.getElementById('form-result');
        responseElement.classList.add('hidden');

        const res = await fetch('/api/email/sendMail.php', {
            method: 'POST',
            body: formData,
        });

        const data = await res.json();

        responseElement.textContent = data.message;
        responseElement.classList.remove('hidden');
        responseElement.classList.toggle('bg-green-500', data.success);
        responseElement.classList.toggle('bg-red-500', !data.success);
    });
</script>