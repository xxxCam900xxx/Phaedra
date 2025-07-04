<?php
require_once "./api/launcher/isSetupCompleted.php";
checkWebLauncherCompleted();

// getLayouts laden
require_once "./api/editor/getLayouts.php";

// Daten holen
$layouts = getLayoutsByPageContent(1);
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
    <main class="flex flex-col flex-1 gap-5 p-5">
        <!-- Dynamic Layout Creation -->
        <section class="flex flex-col gap-4">

            <?php foreach ($layouts as $layout): ?>
                <?php
                $layoutID = $layout['id'];
                $type = $layout['type'];
                $data = $layout['data'];

                // Hier includen Sie Ihre Komponenten
                $file = $_SERVER["DOCUMENT_ROOT"] . '/assets/components/layouts/' . $type . '.php';

                if (file_exists($file)) {
                    include $file;
                } else {
                    echo "<div class='text-red-500'>Unbekanntes Layout: " . htmlspecialchars($type) . "</div>";
                }
                ?>
            <?php endforeach; ?>

        </section>

        <!-- Editor Section -->
        <div id="content-container" class="hidden flex h-[100px] p-5 items-center justify-center text-4xl text-gray-400">
            <i class="fa-solid fa-plus"></i>
        </div>
    </main>
    <!-- Footer -->
    <footer class="h-[100px] bg-gray-800">

    </footer>

    <div id="layoutContextMenu">
        <button id="deleteLayoutBtn">Layout löschen</button>
    </div>

    <script src="/assets/js/editor.js"></script>
    <script src="/assets/js/editorContextMenu.js"></script>

    <script>
        fetch('/api/editor/getLayouts.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    pageContentId: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Layouts:', data.layouts);
            })
            .catch(error => {
                console.error('Fehler beim Abruf:', error);
            });
    </script>
</body>

</html>