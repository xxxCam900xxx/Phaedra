<?php
require_once "./api/launcher/isSetupCompleted.php";
checkWebLauncherCompleted();
require_once "./api/editor/getLayouts.php";
session_start();

/* PathURL */
$Request_URI = substr($_SERVER["REQUEST_URI"], 1);

if ($Request_URI === '') {

    $getFirstSortPageAsIndexStmt = executeStatement("SELECT PathURL FROM Pages WHERE Sort = 0 LIMIT 1");
    $getFirstSortPageAsIndexStmt->bind_result($indexURL);
    $getFirstSortPageAsIndexStmt->fetch();

    $Request_URI = $indexURL;
}

$pageStmt = executeStatement(
    "SELECT ID, Page_Title, Meta_Description FROM Pages WHERE PathURL = ? LIMIT 1",
    [$Request_URI],
    "s"
);
$pageStmt->bind_result($pageId, $pageTitle, $pageMetaDesc);
if (!$pageStmt->fetch()) {
    http_response_code(404);
    echo json_encode(['error' => $Request_URI]);
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


require_once $_SERVER['DOCUMENT_ROOT'] . '/api/webconfig/getWebConfig.php';

$webConfig = getWebConfig();
?>

<!DOCTYPE html>
<html lang="en" data-pageContentId="<?= $pageContentId ?>">

<head>
    <?php require("configs/head.php"); ?>
    <meta name="description" content="<?= htmlspecialchars($pageMetaDesc) ?>">
    <meta name="keywords" content="">
    <meta name="author" content="<?= htmlspecialchars($webConfig->WebHostName) ?>">
    <title><?= $pageTitle ?></title>

    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/api/editor/design/getEditorStyles.php';
    $styles = getWebDesign();

    $data = $styles['data'] ?? [];
    ?>
    <style>
        :root {
            --primary-color: <?= htmlspecialchars($data['Primary_Color'] ?? '#1D4ED8') ?>;
            --secondary-color: <?= htmlspecialchars($data['Secondary_Color'] ?? '#2563EB') ?>;
            --background-color: <?= htmlspecialchars($data['Background_Color'] ?? '#ffffff') ?>;
            --footer-color: <?= htmlspecialchars($data['Footer_Color'] ?? '#111827') ?>;

            --h1-size: <?= htmlspecialchars($data['Heading1_Size'] ?? '36') ?>px;
            --h2-size: <?= htmlspecialchars($data['Heading2_Size'] ?? '28') ?>px;
            --p-size: <?= htmlspecialchars($data['Paragraph_Size'] ?? '18') ?>px;

            --h1-weight: <?= htmlspecialchars($data['Heading1_Weight'] ?? '700') ?>;
            --h2-weight: <?= htmlspecialchars($data['Heading2_Weight'] ?? '600') ?>;
            --p-weight: <?= htmlspecialchars($data['Paragraph_Weight'] ?? '400') ?>;

            --link-color: <?= htmlspecialchars($data['Link_Color'] ?? '#1D4ED8') ?>;
            --link-hover-color: <?= htmlspecialchars($data['LinkHover_Color'] ?? '#93C5FD') ?>;

            --link-btn-color: <?= htmlspecialchars($data['LinkBtn_TextColor'] ?? '#000000ff') ?>;
            --link-btn-background-color: <?= htmlspecialchars($data['LinkBtn_Color'] ?? '#cacacaff') ?>;
            --link-btn-background-hover-color: <?= htmlspecialchars($data['LinkHoverBtn_Color'] ?? '#8e8e8eff') ?>;

            --main-gap: <?= htmlspecialchars($data['Section_Gap'] . "px" ?? '5px') ?>;
        }

        * {
            transition: all each 0.3s;
        }

        body {
            background-color: var(--background-color);
            font-size: var(--p-size);
            font-weight: var(--p-weight);
        }

        #dynamicContent {
            gap: var(--main-gap) !important;
        }

        .button {
            color: var(--link-btn-color);
            background-color: var(--link-btn-background-color);
        }

        .button:hover {
            background-color: var(--link-btn-background-hover-color);
        }

        h1 {
            font-size: var(--h1-size);
            font-weight: var(--h1-weight);
        }

        h2 {
            font-size: var(--h2-size);
            font-weight: var(--h2-weight);
        }

        footer {
            background-color: var(--footer-color);
        }

        .primary-color {
            background-color: var(--primary-color);
        }

        .secondary-color {
            background-color: var(--secondary-color);
        }

        a {
            color: var(--link-color);
            transition: color 0.3s;
        }

        a:hover {
            color: var(--link-hover-color);
        }
    </style>

</head>

<body class="w-full min-h-screen flex flex-col">
    <div class="preheader h-[30px] w-full bg-sky-800 secondary-color">

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

    <!-- Header -->
    <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/footer/dynamicFooter.php" ?>

    <!-- PopUps -->
    <div id="layoutContextMenu">
        <button id="copydeleteWidgetBtn">Widget verschieben</button>
        <button id="pasteWidgetBtn">Widget einfügen</button>
        <button id="updateWidgetBtn">Widget bearbeiten</button>
        <button id="deleteWidgetBtn">Widget löschen</button>
        <button id="deleteLayoutBtn">Layout löschen</button>
    </div>

    <?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/popups/textWidgetPopUp.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/popups/imageWidgetPopUp.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/popups/repoCrawlerWidgetPopUp.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/popups/textTypingWidgetPopUp.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/popups/videoWidgetPopUp.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/popups/timeLineWidgetPopUp.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/built-in/scrollToTopBtn.php";
    ?>

    <!-- PopUps -->
    <script src="/assets/js/popups/createImagePopUp.js"></script>
    <script src="/assets/js/popups/createRepoCrawlerPopUp.js"></script>
    <script src="/assets/js/popups/createTextWidgetPopUp.js"></script>
    <script src="/assets/js/popups/createTextTypingWidgetPopUp.js"></script>
    <script src="/assets/js/popups/createVideoWidgetPopUp.js"></script>
    <script src="/assets/js/popups/createTimeLinePopUp.js"></script>

    <!-- Editor Relevant -->
    <script src="/assets/js/editor.js"></script>
    <script src="/assets/js/editorWidgets.js"></script>
    <script src="/assets/js/editorContextMenu.js"></script>

    <!-- Other Functionalites -->
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