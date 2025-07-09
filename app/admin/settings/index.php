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

        <!-- Dashboard Informationen -->
        <section class="p-5 flex gap-5">

            <!-- Text Section -->
            <form id="webConfigForm" class="w-1/2 flex flex-col gap-5">

                <div class="w-full bg-sky-100 flex flex-col rounded-xl overflow-hidden">
                    <label class="w-full bg-sky-700 text-white p-3 text-2xl" for="webName">Webseiten Name</label>
                    <div class="p-5">
                        <input class="p-2 w-full bg-white" type="text" name="webName" placeholder="example.com" value="<?= htmlspecialchars($webConfig->WebsiteName) ?>">
                    </div>
                </div>

                <div class="w-full bg-sky-100 flex flex-col rounded-xl overflow-hidden">
                    <label class="w-full bg-sky-700 text-white p-3 text-2xl" for="webHostName">Webseiten Hostname</label>
                    <div class="p-5">
                        <input class="p-2 w-full bg-white" type="text" name="webHostName" placeholder="Max Mustermann" value="<?= htmlspecialchars($webConfig->WebHostName) ?>">
                    </div>
                </div>

                <div class="w-full bg-sky-100 flex flex-col rounded-xl overflow-hidden">
                    <label class="w-full bg-sky-700 text-white p-3 text-2xl" for="webContact">Webseiten Kontakt (Link, Email, Username)</label>
                    <div class="p-5">
                        <input class="p-2 w-full bg-white" type="text" name="webContact" placeholder="support@email.com" value="<?= htmlspecialchars($webConfig->WebContact) ?>">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button id="webConfigFormSaveBtn" type="submit" class="bg-green-400 cursor-pointer text-white rounded-md p-2 text-xl">Speichern</button>
                </div>

            </form>

            <!-- Icon / Image Section -->
            <div>
                <!-- Image -->
                <div></div>
                <!-- Icon -->
                <div></div>
            </div>

        </section>

    </main>

    <script src="/assets/js/updateWebConfigs.js"></script>

</body>

</html>