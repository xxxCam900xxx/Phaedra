<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';

/**
 * Gibt alle Seiten mit ID, Nav_Title und PathURL zurück.
 *
 * @return array|false
 */
function getAllPages(): array|false
{
    $conn = getConnection();

    $sql = "SELECT ID, Nav_Title, Meta_Description, Page_Title, PathURL, Sort FROM Pages ORDER BY Sort ASC";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        error_log("Fehler beim Prepare-Statement: " . $conn->error);
        return false;
    }

    if (!$stmt->execute()) {
        error_log("Fehler beim Ausführen des Statements: " . $stmt->error);
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();
    $pages = [];

    while ($row = $result->fetch_assoc()) {
        $pages[] = [
            'id' => $row['ID'],
            'nav_title' => $row['Nav_Title'],
            'page_title' => $row['Page_Title'],
            'meta_description' => $row['Meta_Description'],
            'pathURL' => $row['PathURL'],
            'sort' => $row['Sort']
        ];
    }

    $stmt->close();
    return $pages;
}