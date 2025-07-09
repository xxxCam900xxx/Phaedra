<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

$input = json_decode(file_get_contents("php://input"), true);
if (!isset($input["webName"], $input["webHostName"], $input["webContact"])) {
    http_response_code(400);
    echo json_encode(['error' => 'Fehlende Felder']);
    exit;
}

$webName = $input["webName"];
$webHostName = $input["webHostName"];
$webContact = $input["webContact"];

$stmt = "UPDATE WebConfig SET WebsiteName = ?, WebHostName = ?, WebContact = ? WHERE ID = 1";
$params = [$webName, $webHostName, $webContact];
$types = "sss";
$updateStmt = executeStatement($stmt, $params, $types);

echo json_encode([
    'success' => true,
]);
