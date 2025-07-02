<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';

function checkWebLauncherCompleted()
{
    $stmt = executeStatement("SELECT WebLauncherCompleted FROM WebConfig WHERE ID = 1");

    if (!$stmt) {
        echo "Fehler beim Ausführen der Abfrage.";
        exit;
    }

    $stmt->bind_result($webLauncherCompleted);
    $hasRow = $stmt->fetch();
    $stmt->close();

    if ($hasRow) {
        // Prüfung, ob 'true'
        if ($webLauncherCompleted !== 'true') {
            header("Location: /launcher");
            exit;
        }
    } else {
        // Kein Datensatz gefunden => Weiterleitung
        header("Location: /launcher");
        exit;
    }
}
