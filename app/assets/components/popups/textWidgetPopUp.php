<div id="textWidgetPopup"
    class="fixed inset-0 flex items-center justify-center z-50 hidden"
>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-2xl p-6 w-[90%] max-w-md flex flex-col gap-4">
        <h2 class="text-xl font-semibold text-gray-800">Text Widget bearbeiten</h2>

        <div class="flex flex-col gap-1">
            <label for="widgetTitle" class="text-sm font-medium text-gray-600">Titel</label>
            <input id="widgetTitle" type="text"
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" />
        </div>

        <div class="flex flex-col gap-1">
            <label for="widgetContent" class="text-sm font-medium text-gray-600">Content</label>
            <textarea id="widgetContent" rows="5"
                class="border border-gray-300 rounded-lg px-3 py-2 resize-y focus:outline-none focus:ring-2 focus:ring-sky-400"></textarea>
        </div>

        <div class="flex justify-end gap-2 mt-2">
            <button onclick="document.getElementById('textWidgetPopup').classList.add('hidden')"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                Abbrechen
            </button>
            <button id="saveWidgetBtn"
                class="px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition">
                Speichern
            </button>
        </div>
    </div>
</div>