<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

/**
 * Holt das gehashte Passwort des Admins (User ID = 1)
 */
function getCurrentUserPassword(): string|false
{
    $query = "SELECT Password FROM Users WHERE ID = 1";
    $stmt = executeStatement($query);

    if (!$stmt) return false;

    $stmt->bind_result($hashedPassword);
    if (!$stmt->fetch()) {
        $stmt->close();
        return false;
    }

    $stmt->close();
    return $hashedPassword;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json");

    $input = json_decode(file_get_contents("php://input"), true);
    $oldPassword = $input["oldPassword"] ?? null;

    if (!$oldPassword) {
        echo json_encode(["success" => false, "message" => "Kein Passwort übermittelt"]);
        exit;
    }

    $storedHash = getCurrentUserPassword();

    if (!$storedHash) {
        echo json_encode(["success" => false, "message" => "Benutzer nicht gefunden"]);
        exit;
    }

    $valid = password_verify($oldPassword, $storedHash);

    echo json_encode(["success" => true, "valid" => $valid]);
    exit;
}