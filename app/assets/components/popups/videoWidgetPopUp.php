<div id="videoWidgetPopup"
    class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-2xl p-6 w-[90%] max-w-xl flex flex-col gap-4">
        <h2 class="text-xl font-semibold text-gray-800">Video bearbeiten</h2>

        <input type="hidden" id="widgetVideoURL" value="<?= htmlspecialchars($webConfig->WebLogoURL) ?>" />

        <label class="text-sm font-medium text-gray-600">Bild</label>
        <div class="flex flex-col">
            <div class="w-full flex gap-2 items-center justify-center rounded-xl overflow-hidden">
                <!-- Vorschau -->
                <div id="videoPreview" class="w-1/3">
                    <?php if (!empty($webConfig->WebLogoURL)): ?>
                        <video src="<?= htmlspecialchars($webConfig->WebLogoURL) ?>" alt="Aktuelles Video" class="max-h-[200px] mx-auto">
                        </video>
                    <?php else: ?>
                        <video src="" alt="Kein Video ausgewählt" class="max-h-[200px] mx-auto">
                        </video>
                    <?php endif; ?>
                </div>

                <!-- Drag & Drop Bereich -->
                <div id="videoDropArea" class="flex w-2/3 items-center justify-center border-4 border-dashed border-gray-400 rounded-lg p-10 text-center text-gray-600 cursor-pointer hover:border-sky-500 transition">
                    Ziehen Sie hier Ihr Logo-Bild hinein oder klicken Sie, um auszuwählen.
                    <input type="file" id="videoInput" accept="video/*" class="hidden" />
                </div>
            </div>

            <!-- Button für Popup -->
            <button id="openVideoSelectorBtn" type="button" class="mt-5 bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-md">
                Logo aus Bibliothek auswählen
            </button>
        </div>

        <div class="flex flex-col gap-1">
            <label for="widgetVideoDesc" class="text-sm font-medium text-gray-600">Beschreibung</label>
            <textarea id="widgetVideoDesc" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400"></textarea>
        </div>


        <div class="flex justify-end gap-2 mt-2">
            <button id="cancelVideoWidgetBtn"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                Abbrechen
            </button>
            <button id="saveVideoWidgetBtn"
                class="px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition">
                Speichern
            </button>
        </div>
    </div>
</div>

<!-- Popup für Bildauswahl -->
<div id="videoSelectorPopup" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg max-w-4xl w-full max-h-[80vh] overflow-y-auto p-6 relative">
        <h2 class="text-2xl mb-4 font-semibold">Video auswählen</h2>
        <button id="closeVideoSelectorBtn" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
        <div id="videoList" class="grid grid-cols-4 gap-4"></div>
    </div>
</div>