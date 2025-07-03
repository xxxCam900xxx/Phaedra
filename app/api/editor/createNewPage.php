<?php
header('Content-Type: application/json');
require_once '../login/IsLoggedIn.php'; // Optional: Zugriff prüfen
require_once '../config/database.php'; // Ihre executeStatement-Funktion laden

// JSON Input parsen
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['title'])) {
    echo json_encode(['success' => false, 'error' => 'Titel fehlt']);
    exit;
}

$titel = $data['title'];
$metaTitle = $data['meta_title'] ?? '';
$metaDescription = $data['meta_description'] ?? '';

// 1. Leeren PageContent-Datensatz anlegen
$queryContent = "
    INSERT INTO PageContent (LayoutID) VALUES (NULL)
";
$stmtContent = executeStatement($queryContent);
if ($stmtContent->affected_rows <= 0) {
    echo json_encode(['success' => false, 'error' => 'PageContent konnte nicht erstellt werden']);
    exit;
}
$pageContentID = $stmtContent->insert_id;

// 2. Page-Datensatz anlegen, mit PageContentID verknüpft
$queryPage = "
    INSERT INTO Pages (Titel, Meta_Title, Meta_Description, PageContentID)
    VALUES (?, ?, ?, ?)
";
$paramsPage = [$titel, $metaTitle, $metaDescription, $pageContentID];
$typesPage = "sssi"; // 3 Strings + 1 Integer

$stmtPage = executeStatement($queryPage, $paramsPage, $typesPage);

if ($stmtPage->affected_rows > 0) {
    echo json_encode([
        'success' => true,
        'page_id' => $stmtPage->insert_id,
        'page_content_id' => $pageContentID
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'Seite konnte nicht erstellt werden']);
}