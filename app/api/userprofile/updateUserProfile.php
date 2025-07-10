<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$input = json_decode(file_get_contents("php://input"), true);

if (
    !isset($input["password"], $input["verifyPassword"]) ||
    empty($input["password"]) ||
    empty($input["verifyPassword"])
) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Fehlende oder leere Felder.']);
    exit;
}

$password = $input["password"];
$verifyPassword = $input["verifyPassword"];

if ($password !== $verifyPassword) {
    echo json_encode(['success' => false, 'message' => 'Die Passwörter stimmen nicht überein.']);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$query = "UPDATE Users SET Password = ? WHERE Username = 'admin'";
$params = [$hashedPassword];
$types = "s";

$updateStmt = executeStatement($query, $params, $types);

if ($updateStmt === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Datenbankfehler beim Aktualisieren des Passworts.']);
    exit;
}

echo json_encode(['success' => true, 'message' => 'Passwort wurde erfolgreich geändert.']);