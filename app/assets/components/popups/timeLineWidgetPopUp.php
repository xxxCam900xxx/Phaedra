<div id="timeLineWidgetPopUp"
    class="fixed inset-0 flex items-center justify-center z-50 hidden"
>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-2xl w-[90%] max-w-md flex flex-col gap-4 overflow-hidden">
        <h2 class="text-2xl font-semibold p-5 phaedra-scondary-backgroundcolor">Timeline Widget bearbeiten</h2>
<div class="px-5 pb-5 flex flex-col gap-2">
        <div class="flex flex-col">
            <label for="timeLineWidgetFrom" class="text-2xl phaedra-primary-color font-semibold">From</label>
            <input id="timeLineWidgetFrom" type="date"
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" />
        </div>

        <div class="flex flex-col">
            <label for="timeLineWidgetTo" class="text-2xl phaedra-primary-color font-semibold">To</label>
            <input id="timeLineWidgetTo" type="date"
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" />
        </div>

        <div class="flex justify-end gap-2 mt-2">
            <button id="cancelTimeLineWidgetbtn"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                Abbrechen
            </button>
            <button id="saveTimeLineWidgetbtn"
                class="px-4 py-2 phaedra-scondary-backgroundcolor text-white rounded-lg transition">
                Speichern
            </button>
        </div>
        </div>
    </div>
</div>