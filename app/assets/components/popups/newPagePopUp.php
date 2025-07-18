<!-- Create New Page PopUp -->
<div id="newPageModal" class="fixed inset-0 phaedra-popup-background flex items-center justify-center hidden">
    <div class="bg-white rounded-lg w-96 relative shadow-xl">

        <!-- Close Button -->
        <button onclick="javascript:newPageModal.classList.add('hidden');" class="absolute shadow-xl cursor-pointer text-xl top-[-15px] right-[-15px] w-[40px] h-[40px] phaedra-scondary-backgroundcolor z-index-10 rounded-md">
            <i class="fa-solid fa-x"></i>
        </button>

        <!-- HeadTitle -->
        <div class="phaedra-scondary-backgroundcolor p-5 rounded-t-md">
            <h2 class="text-2xl font-semibold">Seite bearbeiten / erstellen</h2>
        </div>

        <form id="newPageForm" class="flex flex-col gap-3 p-5">

            <input type="text" name="id" class="hidden" />

            <div class="flex flex-col">
                <label for="nav_title">Navigation Titel</label>
                <input type="text" name="nav_title" placeholder="Navigations Titel" required class="border p-2 rounded" />
            </div>

            <div class="flex flex-col">
                <label for="nav_title">Url</label>
                <input type="text" name="pathURL" placeholder="URL Pfad" required class="border p-2 rounded" />
            </div>
            <div class="flex flex-col">
                <label for="nav_title">Seitentitel</label>
                <input type="text" name="page_title" placeholder="Seiten Titel" class="border p-2 rounded" />
            </div>
            <div class="flex flex-col">
                <label for="nav_title">Meta-Beschreibung</label>
                <textarea name="meta_description" placeholder="Meta-Beschreibung" rows="3"
                    class="border p-2 rounded">
                </textarea>
            </div>
            <div class="flex flex-col">
                <label for="sort">Sortierung</label>
                <input type="number" name="sort" placeholder="Sortierung" class="border p-2 rounded" />
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="cancelBtn" class="px-4 py-2 phaedra-scondary-backgroundcolor rounded-md">Abbrechen</button>
                <button type="submit" class="px-4 py-2 text-white rounded bg-emerald-500 hover:bg-emerald-600">Erstellen</button>
            </div>
        </form>
    </div>
</div>