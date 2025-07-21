<?php
require_once '../../api/login/IsLoggedIn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/webconfig/getWebConfig.php';

$webConfig = getWebConfig();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("../../configs/head.php"); ?>
    <title>Phaedra - Settings</title>
</head>

<body class="admin-background">

    <main class="flex flex-row h-screen">

        <!-- Navigation -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/navigation/adminNavigation.php" ?>
        <div class="platzhalter w-[100px] h-screen"></div>

        <section class="p-5 flex w-full items-center justify-center gap-5">

            <!-- Konfigurationsformular -->
            <form id="webConfigForm" class="flex p-5 flex-col bg-white shadow-lg rounded-xl min-w-[500px] gap-5" method="POST" action="/api/webconfig/saveWebConfig.php" enctype="multipart/form-data">

                <div class="">
                    <label class="text-2xl phaedra-primary-color font-semibold" for="webName">Domain Name</label>
                    <input class="p-2 w-full rounded-md border border-blue-800" type="text" name="webName" placeholder="example.com" value="<?= htmlspecialchars($webConfig->WebsiteName) ?>">
                </div>

                <div class="">
                    <label class="text-2xl phaedra-primary-color font-semibold" for="webHostName">Hostname</label>
                    <input class="p-2 w-full rounded-md border border-blue-800" type="text" name="webHostName" placeholder="support@email.com" value="<?= htmlspecialchars($webConfig->WebHostName) ?>">
                </div>

                <div class="">
                    <label class="text-2xl phaedra-primary-color font-semibold" for="webContact">Email Adresse</label>
                    <input class="p-2 w-full rounded-md border border-blue-800" type="email" name="webContact" placeholder="example@sample.com" value="<?= htmlspecialchars($webConfig->WebContact) ?>">
                </div>

                <!-- Hidden Input für Logo-Pfad -->
                <input type="hidden" id="webLogoURL" name="webLogoURL" value="<?= htmlspecialchars($webConfig->WebLogoURL) ?>" />
                <div>
                    <label class="text-2xl phaedra-primary-color font-semibold">Webseiten Logo</label>
                    <div class="flex gap-5 p-5 rounded-md border border-blue-800">
                        <!-- Vorschau -->
                        <div id="logoPreview" class="w-1/2">
                            <?php if (!empty($webConfig->WebLogoURL)): ?>
                                <img src="<?= htmlspecialchars($webConfig->WebLogoURL) ?>" alt="Aktuelles Logo" class="max-h-[200px] mx-auto" />
                            <?php else: ?>
                                <img src="" alt="Kein Logo ausgewählt" class="max-h-[200px] mx-auto" />
                            <?php endif; ?>
                        </div>

                        <!-- Drag & Drop Bereich -->
                        <div id="imageDropArea" class="w-1/2 flex items-center justify-center border-4 border-dashed border-gray-400 rounded-lg p-10 text-center text-gray-600 cursor-pointer hover:border-blue-800 transition">
                            Ziehen Sie hier Ihr Logo-Bild hinein oder klicken Sie, um auszuwählen.
                            <input type="file" id="imageInput" accept="image/*" class="hidden" />
                        </div>
                    </div>


                    <!-- Button für Popup -->
                    <button id="openImageSelectorBtn" type="button" class="w-fit mt-2 font-semibold phaedra-scondary-backgroundcolor hover:bg-sky-700 text-white px-4 py-2 rounded-md">
                        Logo aus Bibliothek auswählen
                    </button>
                </div>

                <div class="flex justify-end mt-6">
                    <button id="webConfigFormSaveBtn" type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white py-2 px-4 rounded w-fit">
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