<div id="timeLineWidgetPopUp"
    class="fixed inset-0 flex items-center justify-center z-50 hidden"
>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-2xl p-6 w-[90%] max-w-md flex flex-col gap-4">
        <h2 class="text-xl font-semibold text-gray-800">Timeline Widget bearbeiten</h2>

        <div class="flex flex-col gap-1">
            <label for="timeLineWidgetFrom" class="text-sm font-medium text-gray-600">From</label>
            <input id="timeLineWidgetFrom" type="date"
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" />
        </div>

        <div class="flex flex-col gap-1">
            <label for="timeLineWidgetTo" class="text-sm font-medium text-gray-600">To</label>
            <input id="timeLineWidgetTo" type="date"
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" />
        </div>

        <div class="flex justify-end gap-2 mt-2">
            <button id="cancelTimeLineWidgetbtn"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                Abbrechen
            </button>
            <button id="saveTimeLineWidgetbtn"
                class="px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition">
                Speichern
            </button>
        </div>
    </div>
</div>