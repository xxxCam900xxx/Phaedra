<?php
require_once '../../api/login/IsLoggedIn.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/webconfig/getWebConfig.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/media/getAllMedia.php";

$images = getAllImages();
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

        <!-- Dateimanager Liste -->
        <section class="p-5 w-full">

            <div id="imageManager" class="bg-white p-5 rounded-md flex flex-col gap-5 shadow-lg min-w-[500px]">

                <div id="dragOverlay" class="hidden absolute inset-0 bg-blue-400 bg-opacity-30 border-4 border-dashed border-blue-500 pointer-events-none z-50 rounded flex items-center justify-center text-blue-900 font-semibold text-lg select-none">
                    Datei hierher ziehen zum Hochladen
                </div>

                <div class="flex gap-2 justify-between items-center">
                    <h2 class="text-3xl phaedra-primary-color font-semibold">Bildverwaltung</h2>
                    <button onclick="triggerFileUpload()" class="cursor-pointer phaedra-scondary-backgroundcolor w-[50px] rounded-md aspect-square"><i class="fa-solid fa-cloud-arrow-up"></i></button>
                    <input type="file" id="hiddenFileInput" accept="image/*" class="hidden">
                </div>

                <?php if (empty($images)) : ?>
                    <p class="text-gray-600">Keine Bilder gefunden.</p>
                <?php else : ?>
                    <table class="w-full rounded-md overflow-hidden">
                        <thead class="phaedra-scondary-backgroundcolor">
                            <tr>
                                <th class="p-2 text-left">Bild</th>
                                <th class="p-2 text-left">URL</th>
                                <th class="p-2 text-left">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($images as $image): ?>
                                <tr class="border-t border-blue-800 hover:bg-gray-100">
                                    <td class="p-2">
                                        <?php
                                        $url = htmlspecialchars($image['url']);
                                        $extension = strtolower(pathinfo($url, PATHINFO_EXTENSION));
                                        $videoExtensions = ['mp4', 'webm', 'ogg'];

                                        if (in_array($extension, $videoExtensions)):
                                        ?>
                                            <video controls class="h-[150px] max-w-xs">
                                                <source src="<?= $url ?>" type="video/<?= $extension ?>">
                                                Dein Browser unterstützt das Video-Tag nicht.
                                            </video>
                                        <?php else: ?>
                                            <img draggable="false" src="<?= $url ?>" alt="Image" class="h-[150px]">
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-2"><a class="hover:text-blue-800" draggable="false" href="<?= $url ?>"><?= $url ?></a></td>
                                    <td class="p-2">
                                        <button
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 cursor-pointer"
                                            data-image-id="<?= $image['id'] ?>"
                                            onclick="deleteImage(this)">
                                            Löschen
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

        </section>

        <!-- PopUps -->
        <div></div>

    </main>

    <script src="/assets/js/imageManager.js"></script>

</body>

</html>