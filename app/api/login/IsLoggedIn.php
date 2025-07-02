<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/api/config/database.php';
session_start();

function redirectToLogin()
{
    header('Location: /admin/login');
    exit;
}

if (!isset($_COOKIE['session_key'])) {
    redirectToLogin();
}

$sessionKey = $_COOKIE['session_key'];

// Nutzer mit SessionKey und gültigem Ablauf suchen
$stmt = executeStatement(
    "SELECT id, SessionTokenExpireDate FROM Users WHERE SessionToken = ?",
    [$sessionKey],
    "s"
);
$stmt->bind_result($id, $sessionExpire);
$found = $stmt->fetch();
$stmt->close();

if (!$found) {
    redirectToLogin();
}

$now = new DateTime();
$expire = new DateTime($sessionExpire);

if ($now > $expire) {
    // Session abgelaufen, Key löschen
    $delStmt = executeStatement(
        "UPDATE Users SET SessionToken = NULL, SessionTokenExpireDate = NULL WHERE id = ?",
        [$id],
        "i"
    );
    $delStmt->close();

    redirectToLogin();
}

// Session verlängern (weitere 1 Stunde)
$newExpire = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');
$updateStmt = executeStatement(
    "UPDATE Users SET SessionTokenExpireDate = ? WHERE id = ?",
    [$newExpire, $id],
    "si"
);
$updateStmt->close();

// Cookie neu setzen
setcookie('session_key', $sessionKey, strtotime($newExpire), '/', '', false, true);

// User-ID in Session speichern
$_SESSION['user_id'] = $id;
