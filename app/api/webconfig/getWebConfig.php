<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

/**
 * Gibt alle WebConfis oder False zurück.
 *
 * @return object|false
 */
function getWebConfig(): object|false
{
    $query = "SELECT WebsiteName, WebHostName, WebLogoURL, WebContact FROM WebConfig WHERE ID = 1";
    $selectStmt = executeStatement($query);

    $selectStmt->bind_result($WebsiteName, $WebHostName, $WebLogoURL, $WebContact);
    if (!$selectStmt->fetch()) {
        http_response_code(404);
        echo json_encode(['error' => 'Seite nicht gefunden']);
        exit;
    }

    $webConfig = (object) [
        'WebsiteName'  => $WebsiteName,
        'WebHostName'  => $WebHostName,
        'WebLogoURL'   => $WebLogoURL,
        'WebContact'   => $WebContact
    ];

    $selectStmt->close();
    return $webConfig;
}
