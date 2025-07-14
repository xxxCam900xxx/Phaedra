<?php
require_once "../api/launcher/isSetupCompleted.php";
checkWebLauncherCompleted(true)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("../configs/head.php"); ?>
    <title>MythosMorph - Launcher</title>
</head>

<body class="bg-black">

    <main class="bg-black flex flex-col gap-5 min-h-screen text-emerald-300 p-5">

        <!-- Title Launcher -->
        <div class="flex gap-2 items-center text-4xl">
            <i class="fa-solid fa-cloud"></i>
            <h1>MythosMorph</h1>
        </div>

        <!-- Terminal / Form -->
        <div>
            <div id="terminal" class="font-mono text-lg overflow-y-auto flex flex-col gap-1"></div>
            <input
                type="text"
                id="hidden-input"
                class="absolute opacity-0 pointer-events-none"
                autocomplete="off" />
        </div>

    </main>

    <script src="/assets/js/terminal.js"></script>

</body>

</html>