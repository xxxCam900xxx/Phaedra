<?php
require_once '../../api/login/IsLoggedIn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/webconfig/getWebConfig.php';

$webConfig = getWebConfig();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("../../configs/head.php"); ?>
    <title>MythosMorph - Settings</title>
</head>

<body>

    <main class="flex flex-col h-screen">

        <!-- Navigation -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/navigation/adminNavigation.php" ?>

        <section class="p-5 flex w-full gap-5">

            <!-- Konfigurationsformular -->
            <form id="webConfigForm" class="flex flex-col w-full gap-5" method="POST" action="/api/webconfig/saveWebConfig.php" enctype="multipart/form-data">

                <div class="flex gap-5 w-full">
                    <div class="w-1/2 flex flex-col gap-5">
                        <div class="w-full bg-sky-100 flex flex-col rounded-xl overflow-hidden">
                            <label class="w-full bg-sky-700 text-white p-3 text-2xl" for="webName">Webseiten Name</label>
                            <div class="p-5">
                                <input class="p-2 w-full bg-white" type="text" name="webName" placeholder="example.com" value="<?= htmlspecialchars($webConfig->WebsiteName) ?>">
                            </div>
                        </div>

                        <div class="w-full bg-sky-100 flex flex-col rounded-xl overflow-hidden">
                            <label class="w-full bg-sky-700 text-white p-3 text-2xl" for="webHostName">Webseiten Hostname</label>
                            <div class="p-5">
                                <input class="p-2 w-full bg-white" type="email" name="webHostName" placeholder="example@sample.com" value="<?= htmlspecialchars($webConfig->WebHostName) ?>">
                            </div>
                        </div>

                        <div class="w-full bg-sky-100 flex flex-col rounded-xl overflow-hidden">
                            <label class="w-full bg-sky-700 text-white p-3 text-2xl" for="webContact">Webseiten Email</label>
                            <div class="p-5">
                                <input class="p-2 w-full bg-white" type="text" name="webContact" placeholder="support@email.com" value="<?= htmlspecialchars($webConfig->WebContact) ?>">
                            </div>
                        </div>
                    </div>


                    <!-- Hidden Input für Logo-Pfad -->
                    <input type="hidden" id="webLogoURL" name="webLogoURL" value="<?= htmlspecialchars($webConfig->WebLogoURL) ?>" />

                    <div class="w-1/2 bg-sky-100 flex flex-col items-center rounded-xl overflow-hidden">
                        <label class="w-full bg-sky-700 text-white p-3 text-2xl mb-3">Website Logo Upload / Auswahl</label>

                        <div class="flex gap-5 p-5">
                            <!-- Vorschau -->
                            <div id="logoPreview" class="mt-4 w-1/2">
                                <?php if (!empty($webConfig->WebLogoURL)): ?>
                                    <img src="<?= htmlspecialchars($webConfig->WebLogoURL) ?>" alt="Aktuelles Logo" class="max-h-[200px] mx-auto" />
                                <?php else: ?>
                                    <img src="" alt="Kein Logo ausgewählt" class="max-h-[200px] mx-auto" />
                                <?php endif; ?>
                            </div>

                            <!-- Drag & Drop Bereich -->
                            <div id="imageDropArea" class="w-1/2 flex items-center justify-center border-4 border-dashed border-gray-400 rounded-lg p-10 text-center text-gray-600 cursor-pointer hover:border-sky-500 transition">
                                Ziehen Sie hier Ihr Logo-Bild hinein oder klicken Sie, um auszuwählen.
                                <input type="file" id="imageInput" accept="image/*" class="hidden" />
                            </div>
                        </div>

                        <!-- Button für Popup -->
                        <button id="openImageSelectorBtn" type="button" class="w-fit mt-5 bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-md">
                            Logo aus Bibliothek auswählen
                        </button>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button id="webConfigFormSaveBtn" type="submit" class="bg-green-400 cursor-pointer text-white rounded-md p-2 text-xl">
                        Speichern
                    </button>
                </div>
            </form>

        </section>

    </main>

    <!-- Popup für Bildauswahl -->
    <div id="imageSelectorPopup" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-[80vh] overflow-y-auto p-6 relative">
            <h2 class="text-2xl mb-4 font-semibold">Bilder auswählen</h2>
            <button id="closeImageSelectorBtn" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
            <div id="imageList" class="grid grid-cols-4 gap-4"></div>
        </div>
    </div>

    <script src="/assets/js/updateWebConfigs.js"></script>

</body>

</html>