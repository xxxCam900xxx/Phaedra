<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';

/**
 * Liest die Konfiguration aus der Tabelle WebConfig mit ID=1 aus.
 * @return array|null Assoziatives Array mit den Spaltenwerten oder null wenn kein Eintrag gefunden wurde.
 */
function getWebConfig()
{
    // SQL-Abfrage vorbereiten und Statement ausführen
    $stmt = executeStatement("SELECT WebLauncherCompleted FROM WebConfig WHERE ID = 1");

    if (!$stmt) {
        // Statement konnte nicht ausgeführt werden
        return null;
    }

    // Ergebnis an Variablen binden
    $stmt->bind_result($webLauncherCompleted);

    // Prüfen, ob eine Zeile gefunden wurde
    if ($stmt->fetch()) {
        // Ergebnis als assoziatives Array zurückgeben
        return ['WebLauncherCompleted' => $webLauncherCompleted];
    } else {
        // Kein Eintrag gefunden
        return null;
    }
}

// Beispiel: WebConfig auslesen und Wert WebLauncherCompleted ausgeben
$config = getWebConfig();
if ($config === null) {
    echo "Keine Konfiguration in WebConfig gefunden.";
} else {
    echo "WebLauncherCompleted: " . htmlspecialchars($config['WebLauncherCompleted']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("configs/head.php"); ?>
    <title>MythosMorph - Launcher</title>
</head>

<body>

    <main class="bg-black flex flex-col gap-5 h-screen text-emerald-300 p-5">

        <!-- Title Launcher -->
        <div class="flex gap-2 items-center text-4xl">
            <i class="fa-solid fa-cloud"></i>
            <h1>MythosMorph</h1>
        </div>

        <!-- Terminal / Form -->
        <div>
            <div id="terminal" class="font-mono text-lg overflow-y-auto flex flex-col gap-1"></div>
            <input
                type="text"
                id="hidden-input"
                class="absolute opacity-0 pointer-events-none"
                autocomplete="off" />
        </div>

    </main>

    <script src="/assets/js/terminal.js"></script>

</body>

</html>