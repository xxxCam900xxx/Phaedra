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

        <section class="p-5 w-full gap-5 flex justify-center items-center">

            <form id="userProfileChangesForm" class="flex flex-col gap-5 min-w-[500px] bg-white p-5 rounded-md shadow-lg">

                <div>
                    <label class="text-2xl font-semibold phaedra-primary-color" for="oldPassword">Altes Passwort:</label>
                    <input class="p-2 w-full rounded-md border border-blue-800" type="password" name="oldPassword" value="">
                </div>

                <div>
                    <label class="text-2xl font-semibold phaedra-primary-color" for="password">Passwort bestätigen:</label>
                    <input class="p-2 w-full rounded-md border border-blue-800" type="password" name="password" value="">
                </div>

                <div>
                    <label class="text-2xl font-semibold phaedra-primary-color" for="verifyPassword">Passwort bestätigen:</label>
                    <input class="p-2 w-full rounded-md border border-blue-800" type="password" name="verifyPassword" value="">
                </div>

                <div class="flex justify-end">
                    <button id="webConfigFormSaveBtn" type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white py-2 px-4 rounded w-fit">
                        Speichern
                    </button>
                </div>

            </form>


        </section>

    </main>

    <script src="/assets/js/updateUserLogin.js"></script>

</body>

</html>