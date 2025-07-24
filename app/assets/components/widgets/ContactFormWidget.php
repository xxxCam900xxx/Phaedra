<div class="w-full bg-gray-100 rounded-lg p-10 flex flex-row gap-10">
    <div class="w-1/2">
        <h1 class="text-2xl font-semibold mb-6">Wollen Sie Kontakt aufnehemen?</h1>

        <div id="form-result" class="hidden mb-4 p-4 rounded text-white"></div>

        <form id="contact-form" class="space-y-5">
            <!-- Absender-E-Mail -->
            <label for="email" class="block font-medium text-gray-700">E-Mail-Adresse:</label>
            <input type="email" id="email" name="email" required
                class="w-full bg-white border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <!-- Betreff -->
            <label for="subject" class="block font-medium text-gray-700">Betreff:</label>
            <select id="subject" name="subject" required
                class="w-full bg-white border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="" disabled selected>Bitte wählen</option>
                <option>Allgemeine Anfrage</option>
                <option>Technischer Support</option>
                <option>Feedback</option>
                <option>Sonstiges</option>
            </select>

            <!-- Nachricht -->
            <label for="message" class="block font-medium text-gray-700">Nachricht:</label>
            <textarea id="message" name="message" required rows="5"
                class="w-full bg-white border border-gray-300 rounded px-3 py-2 resize-y focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

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
    <div class="w-1/2 flex flex-col gap-2 justify-between">
        <h1 class="text-2xl font-semibold">Wir helfen dir gerne</h1>
        <p>Egal ob Frage, Idee oder Projekt – wir sind für dich da. Schreib uns einfach über das Kontaktformular. Wir melden uns so schnell wie möglich bei dir zurück – persönlich und zuverlässig.</p>
        <img class="h-[200px] object-contain object-left" src="/assets/media/WeAreTheSupport.jpg" alt="WeAreTheSupport-CatTyping">
        <p>Unser Team freut sich darauf, von dir zu hören. Ob technische Unterstützung, eine erste Projektidee oder einfach nur ein Hallo – wir nehmen uns Zeit für dich.</p>
    </div>
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