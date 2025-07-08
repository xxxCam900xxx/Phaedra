<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

$input = json_decode(file_get_contents("php://input"), true);
if (!isset($input["id"])) {
    exit;
}

$pageId = $input["id"];

$stmt = "DELETE FROM Pages WHERE ID = ?";
$param = [$pageId];
$type = "i";
$deleteStmt = executeStatement($stmt, $param, $type);

echo json_encode([
    'success' => true,
]);