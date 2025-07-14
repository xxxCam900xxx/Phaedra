<div id="textTypingWidgetPopUp"
    class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-2xl p-6 w-[90%] max-w-md flex flex-col gap-4">
        <h2 class="text-xl font-semibold text-gray-800">TextTyping bearbeiten</h2>

        <div class="flex flex-col gap-1">
            <label for="textTypingWidgetRotationText" class="text-sm font-medium text-gray-600">Typing Text</label>
            <textarea id="textTypingWidgetRotationText" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400"></textarea>
        </div>

        <div class="flex flex-col gap-1">
            <label for="textTypingWidgetContent" class="text-sm font-medium text-gray-600">Inhalt</label>
            <textarea id="textTypingWidgetContent" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400"></textarea>
        </div>

        <div class="flex justify-end gap-2 mt-2">
            <button id="cancelTextTypingWidgetPopUp"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                Abbrechen
            </button>
            <button id="saveTextTypingWidgetPopUp"
                class="px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition">
                Speichern
            </button>
        </div>
    </div>
</div>