<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';

/**
 * Gibt alle Seiten mit ID, Titel und PathURL zurück.
 *
 * @return array|false
 */
function getAllPages(): array|false
{
    $conn = getConnection();

    $sql = "SELECT ID, Titel, PathURL FROM Pages ORDER BY Titel ASC";
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
            'title' => $row['Titel'],
            'pathURL' => $row['PathURL']
        ];
    }

    $stmt->close();
    return $pages;
}