<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

$input = json_decode(file_get_contents("php://input"), true);

// Pflichtfelder prüfen
if (
    !isset($input["meta_description"], $input["page_title"], $input["pathURL"], $input["nav_title"])
) {
    http_response_code(400);
    echo json_encode(['error' => 'Fehlende Felder']);
    exit;
}

// Werte übernehmen
$meta_description = $input["meta_description"];
$page_title       = $input["page_title"];
$pathURL          = $input["pathURL"];
$nav_title        = $input["nav_title"];

// Sort behandeln: falls leer oder nicht gesetzt → max(Sort) + 1
$sort = (isset($input["sort"]) && trim($input["sort"]) !== "") ? (int)$input["sort"] : null;

$conn = getConnection();

// Falls Sort leer ist: höchsten aktuellen Wert + 1 holen
if (is_null($sort)) {
    $res = $conn->query("SELECT MAX(Sort) AS max_sort FROM Pages");
    $row = $res->fetch_assoc();
    $sort = isset($row["max_sort"]) ? ((int)$row["max_sort"]) + 1 : 1;
}

// Update oder Insert unterscheiden
if (!empty($input["id"])) {
    // UPDATE
    $id = (int)$input["id"];
    $updateStmt = executeStatement(
        "UPDATE Pages SET Nav_Title = ?, PathURL = ?, Meta_Description = ?, Page_Title = ?, Sort = ? WHERE ID = ?",
        [$nav_title, $pathURL, $meta_description, $page_title, $sort, $id],
        "ssssii"
    );

    if ($updateStmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'updated' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Keine Änderung vorgenommen oder ungültige ID']);
    }
} else {
    // INSERT
    $stmt = "INSERT INTO Pages (Nav_Title, PathURL, Meta_Description, Page_Title, Sort) VALUES (?, ?, ?, ?, ?)";
    $param = [$nav_title, $pathURL, $meta_description, $page_title, $sort];
    $types = "ssssi";

    $insertStmt = executeStatement($stmt, $param, $types);
    $newPageID = $insertStmt->insert_id;

    // Leeren PageContent-Datensatz hinzufügen
    $stmt2 = "INSERT INTO PageContent (PageID) VALUES (?)";
    $param2 = [$newPageID];
    $types2 = "i";
    executeStatement($stmt2, $param2, $types2);

    echo json_encode([
        'success' => true,
        'created' => true,
        'pageId'  => $newPageID
    ]);
}