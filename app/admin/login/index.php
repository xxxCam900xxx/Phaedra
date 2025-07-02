<?php
require_once '../../api/launcher/isSetupCompleted.php';

// Nur wenn Launcher abgeschlossen
checkWebLauncherCompleted();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("../../configs/head.php"); ?>
    <title>MythosMorph - Login</title>
</head>

<body>

    <main class="h-screen flex flex-row">

        <section class="w-4/7 h-screen flex flex-col gap-10 items-center justify-center">

            <div class="flex flex-col items-center">
                <h1 class="text-6xl font-semibold">MythosMorph</h1>
                <h2 class="text-3xl">Melden Sie sich ganz gemütlich an</h2>
            </div>

            <form action="" class="space-y-4 w-full max-w-lg mx-auto">
                <!-- Benutzerfeld -->
                <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2">
                    <i class="fa-solid fa-user text-emerald-400 text-3xl"></i>
                    <input
                        type="text"
                        placeholder="Benutzer"
                        class="ml-2 w-full outline-none text-gray-700 placeholder-gray-400 text-2xl" />
                </div>

                <!-- Passwortfeld -->
                <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2">
                    <i class="fa-solid fa-lock text-emerald-400 text-3xl"></i>
                    <input
                        type="password"
                        placeholder="Passwort"
                        class="ml-2 w-full outline-none text-gray-700 placeholder-gray-400 text-2xl" />
                </div>

                <button
                    type="submit"
                    class="w-full bg-emerald-400 cursor-pointer text-white font-semibold py-2 rounded hover:bg-emerald-600 transition">
                    Anmelden
                </button>
            </form>

            <a class="text-emerald-400" href="/credits">Hier kommen Sie zu den Credits</a>

        </section>

        <aside class="w-3/7 h-screen bg-emerald-300 flex flex-col justify-center items-center gap-2 text-white">

            <i class="fa-solid fa-cloud text-8xl"></i>
            <h1 class="text-5xl font-semibold">Willkommen Zurück!</h1>
            <p class="text-2xl" id="quotes">Hier liegen Random Quotes</p>

        </aside>

    </main>

</body>

</html>