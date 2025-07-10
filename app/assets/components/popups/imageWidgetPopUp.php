<div id="imageWidgetPopup"
    class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-2xl p-6 w-[90%] max-w-xl flex flex-col gap-4">
        <h2 class="text-xl font-semibold text-gray-800">Image Widget bearbeiten</h2>

        <input type="hidden" id="widgetImageURL" value="<?= htmlspecialchars($webConfig->WebLogoURL) ?>" />

        <label class="text-sm font-medium text-gray-600">Bild</label>
        <div class="flex flex-col">
            <div class="w-full flex gap-2 items-center justify-center rounded-xl overflow-hidden">
                <!-- Vorschau -->
                <div id="logoPreview" class="w-1/3">
                    <?php if (!empty($webConfig->WebLogoURL)): ?>
                        <img src="<?= htmlspecialchars($webConfig->WebLogoURL) ?>" alt="Aktuelles Logo" class="max-h-[200px] mx-auto" />
                    <?php else: ?>
                        <img src="" alt="Kein Logo ausgewählt" class="max-h-[200px] mx-auto" />
                    <?php endif; ?>
                </div>

                <!-- Drag & Drop Bereich -->
                <div id="imageDropArea" class="flex w-2/3 items-center justify-center border-4 border-dashed border-gray-400 rounded-lg p-10 text-center text-gray-600 cursor-pointer hover:border-sky-500 transition">
                    Ziehen Sie hier Ihr Logo-Bild hinein oder klicken Sie, um auszuwählen.
                    <input type="file" id="imageInput" accept="image/*" class="hidden" />
                </div>
            </div>

            <!-- Button für Popup -->
            <button id="openImageSelectorBtn" type="button" class="mt-5 bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-md">
                Logo aus Bibliothek auswählen
            </button>
        </div>

        <div class="flex flex-col gap-1">
            <label for="widgetImageDesc" class="text-sm font-medium text-gray-600">Beschreibung</label>
            <input id="widgetImageDesc" type="text"
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" />
        </div>


        <div class="flex justify-end gap-2 mt-2">
            <button id="cancelImageWidgetBtn"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                Abbrechen
            </button>
            <button id="saveImageWidgetBtn"
                class="px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition">
                Speichern
            </button>
        </div>
    </div>
</div>

<!-- Popup für Bildauswahl -->
<div id="imageSelectorPopup" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg max-w-4xl w-full max-h-[80vh] overflow-y-auto p-6 relative">
        <h2 class="text-2xl mb-4 font-semibold">Bilder auswählen</h2>
        <button id="closeImageSelectorBtn" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
        <div id="imageList" class="grid grid-cols-4 gap-4"></div>
    </div>
</div>