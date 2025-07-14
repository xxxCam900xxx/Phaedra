function openTextTypingWidgetPopUp(widgetData, isInserted = false) {
    const popup = document.getElementById("textTypingWidgetPopUp");
    popup.style.display = "flex";

    const rotationTextInput = document.getElementById("textTypingWidgetRotationText");
    const contentInput = document.getElementById("textTypingWidgetContent");

    const htmlObjects = {
        rotationTextInput: rotationTextInput,
        contentInput: contentInput,
    }

    rotationTextInput.textContent = "";
    contentInput.textContent = "";

    // Get Widget and Apply Value changes if needed
    getWidgetandApplytoPopUp(widgetData, htmlObjects)

    // Save-Button Handler
    document.getElementById("saveTextTypingWidgetPopUp").onclick = function () {
        const widgetContent = {
            RotationText: rotationTextInput.value,
            Content: contentInput.value,
        }

        saveWidgetData(widgetData, widgetContent);
    };

    // Cancel-Button Handler
    document.getElementById("cancelTextTypingWidgetPopUp").onclick = function () {
        if (isInserted) {
            rotationTextInput.textContent = "";
            contentInput.textContent = "";
            deleteWidget(widgetData);
        } else {
            window.location.reload();
        }
    };    
}