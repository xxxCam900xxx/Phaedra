<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

/**
 * Holt alle Bilder aus der Tabelle Images
 * @return array
 */
function getAllImages(): array
{
    $images = [];
    $stmt = executeStatement("SELECT ID, ImageURL FROM Images");

    $stmt->bind_result($id, $imageURL);

    while ($stmt->fetch()) {
        $images[] = [
            'id' => $id,
            'url' => $imageURL,
        ];
    }

    $stmt->close();
    return $images;
}