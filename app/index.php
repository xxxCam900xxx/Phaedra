<?php
require_once "./api/launcher/isSetupCompleted.php";
checkWebLauncherCompleted();
require_once "./api/editor/getLayouts.php";

/* PathURL */
$Request_URI = substr($_SERVER["REQUEST_URI"], 1);
if ($Request_URI === '') {
    $Request_URI = 'index';
}

$pageStmt = executeStatement(
    "SELECT ID FROM Pages WHERE PathURL = ? LIMIT 1",
    [$Request_URI],
    "s"
);
$pageStmt->bind_result($pageId);
if (!$pageStmt->fetch()) {
    http_response_code(404);
    echo json_encode(['error' => 'Seite nicht gefunden']);
    exit;
}
$pageStmt->close();

$contentStmt = executeStatement(
    "SELECT ID FROM PageContent WHERE PageID = ? LIMIT 1",
    [$pageId],
    "i"
);
$contentStmt->bind_result($pageContentId);
if (!$contentStmt->fetch()) {
    http_response_code(404);
    echo json_encode(['error' => 'Kein Seiteninhalt gefunden']);
    exit;
}
$contentStmt->close();

// Daten holen
$layouts = getLayoutsByPageContent($pageContentId);


// --- Nach dem Abrufen neue Sortierung schreiben ---
$newSort = 10;
$stmtUpdate = $conn->prepare("UPDATE Layout SET Sort = ? WHERE ID = ?");

foreach ($layouts as $layout) {
    $id = (int) $layout['id'];
    $stmtUpdate->bind_param("ii", $newSort, $id);
    $stmtUpdate->execute();
    $newSort += 10;
}
$stmtUpdate->close();
?>

<!DOCTYPE html>
<html lang="en" data-pageContentId="<?= $pageContentId ?>">

<head>
    <?php require("configs/head.php"); ?>
    <title>Welcome Site</title>
</head>

<body class="w-full min-h-screen flex flex-col">
    <div class="preheader h-[30px] w-full bg-sky-800">

    </div>
    <!-- Header -->
    <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/navigation/dynamicNavigation.php" ?>

    <!-- Dynamic Content -->
    <main class="flex flex-col flex-1 gap-5 p-[10%] pt-5 pb-5">
        <!-- Dynamic Layout Creation -->
        <section class="flex flex-col gap-10" id="dynamicContent">

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
        <div id="content-container"
            class="hidden flex h-[100px] p-5 items-center justify-center text-4xl text-gray-400">
            <i class="fa-solid fa-plus"></i>
        </div>
    </main>
    <!-- Footer -->
    <footer class="h-[100px] bg-gray-800">

    </footer>


    <!-- PopUps -->
    <div id="layoutContextMenu">
        <button id="deleteWidgetBtn">Widget löschen</button>
        <button id="deleteLayoutBtn">Layout löschen</button>
    </div>

    <?php
        require_once $_SERVER["DOCUMENT_ROOT"] . ("/assets/components/popups/textWidgetPopUp.php")
    ?>


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

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        if (window !== window.top) {
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('dynamicContent');

                Sortable.create(container, {
                    animation: 150,
                    handle: '.Layout',
                    onEnd: function(evt) {
                        // Reihenfolge auslesen
                        const newOrder = Array.from(container.children).map((el, index) => ({
                            id: el.dataset.layoutId,
                            sort: index + 1
                        }));

                        console.log('Neue Reihenfolge:', newOrder);

                        // Fetch zum Backend
                        fetch('/api/editor/updateStructure.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    order: newOrder
                                })
                            })
                            .then(r => r.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('Struktur aktualisiert.');
                                    window.location.reload();
                                } else {
                                    console.error('Fehler:', data.message);
                                }
                            })
                            .catch(e => console.error('Netzwerkfehler:', e));
                    }
                });
            });
        }
    </script>

</body>

</html>