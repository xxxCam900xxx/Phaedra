function openRepoCrawlerWidgetPopup(widgetData, isInserted = false) {
    const popup = document.getElementById("repoWidgetPopup");
    popup.style.display = "flex";

    const forgejoURLInput = document.getElementById("widgetForgejoURL");
    const forgejoUsernameInput = document.getElementById("widgetForgejoUsername");
    const githubUsernameInput = document.getElementById("widgetGithubUsername");

    const htmlObjects = {
        forgejoURLInput: forgejoURLInput,
        forgejoUsernameInput: forgejoUsernameInput,
        githubUsernameInput: githubUsernameInput
    }

    forgejoURLInput.value = "";
    forgejoUsernameInput.value = "";
    githubUsernameInput.value = "";

    // Get Widget and Apply Value changes if needed
    getWidgetandApplytoPopUp(widgetData, htmlObjects)

    // Save-Button Handler
    document.getElementById("saveRepoWidgetBtn").onclick = function () {
        const widgetContent = {
            ForgejoURL: forgejoURLInput.value,
            ForgejoUsername: forgejoUsernameInput.value,
            GithubUsername: githubUsernameInput.value
        }

        saveWidgetData(widgetData, widgetContent);
    };

    // Cancel-Button Handler
    document.getElementById("cancelRepoWidgetBtn").onclick = function () {
        if (isInserted) {
            titleInput.value = "";
            contentInput.value = "";
            deleteWidget(widgetData);
        } else {
            window.location.reload();
        }
    };
}