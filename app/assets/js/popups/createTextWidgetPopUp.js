function openTextWidgetPopup(widgetData, isInserted = false) {
    const popup = document.getElementById("textWidgetPopup");
    popup.style.display = "flex";

    const titleInput = document.getElementById("textWidgetTitle");
    const contentInput = document.getElementById("textWidgetContent");

    const htmlObjects = {
        titleInput: titleInput,
        contentInput: contentInput
    }

    titleInput.value = "";
    contentInput.value = "";

    // Get Widget and Apply Value changes if needed
    getWidgetandApplytoPopUp(widgetData, htmlObjects)

    // Save-Button Handler
    document.getElementById("saveTextWidgetBtn").onclick = function () {
        const widgetContent = {
            Title: titleInput.value,
            Content: contentInput.value
        }

        saveWidgetData(widgetData, widgetContent);
    };

    // Cancel-Button Handler
    document.getElementById("cancelTextWidgetBtn").onclick = function () {
        if (isInserted) {
            titleInput.value = "";
            contentInput.value = "";
            deleteWidget(widgetData);
        } else {
            window.location.reload();
        }
    };
}