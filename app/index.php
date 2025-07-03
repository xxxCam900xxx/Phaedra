<?php
require_once "./api/launcher/isSetupCompleted.php";
checkWebLauncherCompleted();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("configs/head.php"); ?>
    <title>Welcome Site</title>
</head>

<body class="w-full min-h-screen flex flex-col">
    <div class="preheader h-[30px] w-full bg-sky-800">

    </div>
    <!-- Header -->
    <header class="h-[60px] w-full bg-sky-300">

    </header>
    <!-- Dynamic Content -->
    <main class="flex flex-col flex-1 p-5">
        <div id="content-container" class="content flex flex-1">
            <!-- Inhalt hier -->
        </div>
    </main>
    <!-- Footer -->
    <footer class="h-[100px] bg-gray-800">

    </footer>

    <script>
        // Prüfen, ob die Seite in einem iframe läuft
        if (window !== window.top) {
            // iframe erkannt, Klasse hinzufügen
            document.getElementById('content-container').classList.add('border', 'border-dashed', 'border-gray-500');
        }
    </script>
</body>

</html>
