<!-- Create New Page PopUp -->
<div id="newPageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-96">
        <h2 class="text-xl mb-4">Neue Seite erstellen</h2>
        <form id="newPageForm" class="flex flex-col gap-3">
            <input type="text" name="id" class="hidden" />
            <input type="text" name="nav_title" placeholder="Navigations Titel" required class="border p-2 rounded" />
            <input type="text" name="pathURL" placeholder="URL Pfad" required class="border p-2 rounded" />
            <input type="text" name="page_title" placeholder="Seiten Titel" class="border p-2 rounded" />
            <textarea name="meta_description" placeholder="Meta-Beschreibung" rows="3"
                class="border p-2 rounded"></textarea>
            <input type="number" name="sort" placeholder="Sortierung" class="border p-2 rounded" />

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="cancelBtn"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Abbrechen</button>
                <button type="submit"
                    class="px-4 py-2 bg-sky-500 text-white rounded hover:bg-sky-600">Erstellen</button>
            </div>
        </form>
    </div>
</div>