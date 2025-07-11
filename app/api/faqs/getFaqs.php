<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

function getFaqs(bool $isAnswered = false, bool $isShown = false): ?array
{
    $conditions = [];

    // Bedingungen zusammenbauen
    if ($isAnswered) {
        $conditions[] = "Answer IS NOT NULL";
    }
    if ($isShown) {
        $conditions[] = "IsShown = 1";
    }

    // Query zusammensetzen
    $query = "SELECT * FROM Faqs";
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $query .= " ORDER BY Created_At DESC";

    // Abfrage ausführen
    $selectStmt = executeStatement($query);
    if (!$selectStmt) {
        return null;
    }

    $selectStmt->bind_result($id, $question, $answer, $isShown, $createDate);

    $data = [];

    while ($selectStmt->fetch()) {
        $data[] = [
            'id'       => $id,
            'question' => $question,
            'answer'   => $answer,
            'isShown'  => $isShown,
            'createDate' => $createDate
        ];
    }

    return $data;
}
