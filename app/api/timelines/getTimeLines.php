<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

function getTimeLines(string $from = "", string $to = ""): ?array
{
    $conditions = [];

    // Bedingungen zusammenbauen
    if ($from != "" && $to != "") {
        $conditions[] = "Date BETWEEN $from AND $to";
    }

    // Query zusammensetzen
    $query = "SELECT * FROM Timeline";
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $query .= " ORDER BY Date DESC";

    // Abfrage ausführen
    $selectStmt = executeStatement($query);
    if (!$selectStmt) {
        return null;
    }

    $selectStmt->bind_result(
        $id,
        $date,
        $title,
        $description,
        $link,
        $createDate
    );

    $data = [];

    while ($selectStmt->fetch()) {
        $data[] = [
            'ID'            => $id,
            'Date'          => $date,
            'Title'         => $title,
            'Description'   => $description,
            'Link'          => $link,
            'Created_At'    => $createDate
        ];
    }

    return $data;
}
