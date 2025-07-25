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
            --primary-color: <?= htmlspecialchars($data['Primary_Color'] ?? '#4f1dd8ff') ?>;
            --secondary-color: <?= htmlspecialchars($data['Secondary_Color'] ?? '#2563EB') ?>;
            --background-color: <?= htmlspecialchars($data['Background_Color'] ?? '#ffffff') ?>;

            --h1-size: <?= htmlspecialchars($data['Heading1_Size'] ?? '36') ?>px;
            --h1-weight: <?= htmlspecialchars($data['Heading1_Weight'] ?? '700') ?>;

            --h2-size: <?= htmlspecialchars($data['Heading2_Size'] ?? '28') ?>px;
            --h2-weight: <?= htmlspecialchars($data['Heading2_Weight'] ?? '600') ?>;

            --p-size: <?= htmlspecialchars($data['Paragraph_Size'] ?? '18') ?>px;
            --p-weight: <?= htmlspecialchars($data['Paragraph_Weight'] ?? '400') ?>;

            --link-color: <?= htmlspecialchars($data['Link_Color'] ?? '#1D4ED8') ?>;
            --link-hover-color: <?= htmlspecialchars($data['LinkHover_Color'] ?? '#93C5FD') ?>;

            --link-btn-color: <?= htmlspecialchars($data['LinkBtn_TextColor'] ?? '#000000ff') ?>;
            --link-btn-bg: <?= htmlspecialchars($data['LinkBtn_Color'] ?? '#cacacaff') ?>;
            --link-btn-bg-hover: <?= htmlspecialchars($data['LinkHoverBtn_Color'] ?? '#8e8e8eff') ?>;

            --section-gap: <?= htmlspecialchars($data['Section_Gap'] ?? '5') ?>px;

            --footer-color: <?= htmlspecialchars($data['Footer_Color'] ?? '#111827') ?>;
            --footer-bg: <?= htmlspecialchars($data['Footer_BackgroundColor'] ?? '#f3f4f6') ?>;
            --footer-link: <?= htmlspecialchars($data['Footer_LinkColor'] ?? '#1D4ED8') ?>;

            --footer-end-bg: <?= htmlspecialchars($data['FooterEnd_BackgroundColor'] ?? '#e5e7eb') ?>;
            --footer-end-color: <?= htmlspecialchars($data['FooterEnd_Color'] ?? '#1f2937') ?>;

            --header-bg: <?= htmlspecialchars($data['Header_BackgroundColor'] ?? '#ffffff') ?>;
            --header-link: <?= htmlspecialchars($data['Header_LinkColor'] ?? '#000000') ?>;

            --preheader-color: <?= htmlspecialchars($data['PreHeader_Color'] ?? '#1f2937') ?>;
            --preheader-bg: <?= htmlspecialchars($data['PreHeader_BackgroundColor'] ?? '#e5e7eb') ?>;
        }

        * {
            transition: all 0.3s ease;
        }

        body {
            background-color: var(--background-color);
        }

        #dynamicContent {
            gap: var(--section-gap) !important;
        }

        #livePage h1 {
            font-size: var(--h1-size);
            font-weight: var(--h1-weight);
        }

        #livePage h2 {
            font-size: var(--h2-size);
            font-weight: var(--h2-weight);
        }

        #livePage p {
            font-size: var(--p-size);
            font-weight: var(--p-weight);
        }

        #livePage a {
            color: var(--link-color);
            transition: color 0.3s;
        }

        #livePage a:hover {
            color: var(--link-hover-color);
        }

        #livePage .button {
            color: var(--link-btn-color);
            background-color: var(--link-btn-bg);
        }

        #livePage .button:hover {
            background-color: var(--link-btn-bg-hover);
        }

        #livePage footer {
            background-color: var(--footer-bg);
            color: var(--footer-color);
        }

        #livePage footer a {
            color: var(--footer-link);
        }

        #livePage .footerEnd {
            background-color: var(--footer-end-bg);
        }

        #livePage .footerEnd a {
            color: var(--footer-end-color);
        }

        #livePage header {
            background-color: var(--header-bg);
        }

        #livePage header a {
            color: var(--header-link);
        }

        #livePage .preheader {
            color: var(--preheader-color);
            background-color: var(--preheader-bg);
        }

        #livePage .primary-color {
            background-color: var(--primary-color);
        }

        #livePage .secondary-color {
            background-color: var(--secondary-color);
        }
    </style>

</head>

<body class="w-full min-h-screen flex flex-col">
    <div id="livePage" class="w-full min-h-screen flex flex-col">
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
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/footer/dynamicFooter.php" ?>
    </div>

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
    <script>
        if (!localStorage.getItem("visit_id")) {
            localStorage.setItem("visit_id", crypto.randomUUID());
            fetch("/api/login/track_visitor.php", {
                method: "POST"
            });
        }
    </script>
    <script>
        const originalFetch = window.fetch;

        window.fetch = async function(...args) {
            try {
                const response = await originalFetch.apply(this, args);

                const clonedResponse = response.clone();

                try {
                    const data = await clonedResponse.json();

                    if (data.success === false || data.error === true) {
                        // Fehler gefunden — sende Tracking-Request
                        fetch("/api/tracking/track_errors.php", {
                            method: "POST"
                        });
                    }
                } catch {
                    // JSON Parsing fehlgeschlagen, ignoriere
                }

                return response;

            } catch (networkError) {
                // Bei Netzwerkfehler auch tracken
                fetch("/api/tracking/track_errors.php", {
                    method: "POST"
                });
                throw networkError;
            }
        };
    </script>

</body>

</html>