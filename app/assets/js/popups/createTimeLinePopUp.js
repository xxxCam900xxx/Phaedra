function openTimelineWidgetPopUp(widgetData, isInserted = false) {

    const popup = document.getElementById("timeLineWidgetPopUp");
    popup.style.display = "flex";

    const fromInput = document.getElementById("timeLineWidgetFrom");
    const toInput = document.getElementById("timeLineWidgetTo");

    const htmlObjects = {
        fromInput: fromInput,
        toInput: toInput
    }

    fromInput.value = "";
    toInput.value = "";

    // Get Widget and Apply Value changes if needed
    getWidgetandApplytoPopUp(widgetData, htmlObjects)

    // Save-Button Handler
    document.getElementById("saveTimeLineWidgetbtn").onclick = function () {
        const widgetContent = {
            FromDate: fromInput.value,
            ToDate: toInput.value
        }

        saveWidgetData(widgetData, widgetContent);
    };

    // Cancel-Button Handler
    document.getElementById("cancelTimeLineWidgetbtn").onclick = function () {
        if (isInserted) {
            fromInput.value = "";
            toInput.value = "";
            deleteWidget(widgetData);
        } else {
            window.location.reload();
        }
    };
}