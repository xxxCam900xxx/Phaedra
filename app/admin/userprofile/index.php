<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/api/login/IsLoggedIn.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/configs/head.php"; ?>
    <title>Phaedra - Benutzerprofil</title>
</head>

<body class="admin-background">

    <main class="flex flex-row h-screen">

        <!-- Navigation -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/navigation/adminNavigation.php" ?>
        <div class="platzhalter w-[100px] h-screen"></div>

        <section class="p-5 w-full gap-5 flex justify-center">

            <form id="userProfileChangesForm" class="flex flex-col gap-5 w-full max-w-[1000px]">

                <div class="w-full bg-sky-100 flex flex-col rounded-xl overflow-hidden">
                    <label class="w-full bg-sky-700 text-white p-3 text-2xl" for="password">Passwort bestätigen:</label>
                    <div class="p-5">
                        <input class="p-2 w-full bg-white" type="password" name="password" placeholder="password" value="">
                    </div>
                </div>

                <div class="w-full bg-sky-100 flex flex-col rounded-xl overflow-hidden">
                    <label class="w-full bg-sky-700 text-white p-3 text-2xl" for="verifyPassword">Passwort bestätigen:</label>
                    <div class="p-5">
                        <input class="p-2 w-full bg-white" type="text" name="verifyPassword" placeholder="verifyPassword" value="">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button id="webConfigFormSaveBtn" type="submit" class="bg-green-400 cursor-pointer text-white rounded-md p-2 text-xl">
                        Speichern
                    </button>
                </div>

            </form>


        </section>

    </main>

    <script src="/assets/js/updateUserLogin.js"></script>

</body>

</html>