<?php

require_once '../../api/login/IsLoggedIn.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("../../configs/head.php"); ?>
    <title>MythosMorph - Editor</title>
</head>

<body>

    <main class="flex flex-col h-screen">

        <!-- Navigation -->
        <nav class="flex gap-10 w-full bg-sky-500 p-5 shadow-lg text-white justify-between">
            <div class="flex gap-2 text-3xl items-center">
                <i class="fa-solid fa-cloud"></i>
                <h1>MythosMorph</h1>
            </div>

            <div class="flex gap-5 text-2xl">
                <a href="/admin">Home</a>
                <a href="/admin/editor">Editor</a>
                <a href="/admin/settings">Web-Einstellungen</a>
            </div>
        </nav>

        <!-- Dashboard Informationen -->
        <section></section>

    </main>

</body>

</html>