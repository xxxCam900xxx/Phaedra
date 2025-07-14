<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

function getSocials(bool $isShown = false): ?array
{
    $conditions = [];

    if ($isShown) {
        $conditions[] = "IsShown = 1";
    }

    // Query zusammensetzen
    $query = "SELECT * FROM Socials";
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $query .= " ORDER BY Created_At DESC";

    // Abfrage ausführen
    $selectStmt = executeStatement($query);
    if (!$selectStmt) {
        return null;
    }

    $selectStmt->bind_result($id, $icon, $socialURL, $isShown, $createDate);

    $data = [];

    while ($selectStmt->fetch()) {
        $data[] = [
            'id'       => $id,
            'icon' => $icon,
            'socialURL' => $socialURL,
            'isShown'  => $isShown,
            'createDate' => $createDate
        ];
    }

    return $data;
}
