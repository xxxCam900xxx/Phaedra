<?php

require_once '../api/login/IsLoggedIn.php';

?>

<?php
$year = date("Y");
$file = $_SERVER["DOCUMENT_ROOT"] . "/data/visits.json";

$visitorData = [];
if (file_exists($file)) {
    $visitorData = json_decode(file_get_contents($file), true);
}
$visitorCount = $visitorData[$year] ?? 0;
?>

<?php
$year = date("Y");
$file = $_SERVER["DOCUMENT_ROOT"] . "/data/errors.json";

$errorData = [];
if (file_exists($file)) {
    $errorData = json_decode(file_get_contents($file), true);
}
$errorCount = $errorData[$year] ?? 0;
?>

<?php
function folderSize(string $dir): int
{
    $size = 0;

    // Öffne Verzeichnis
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $path = $dir . DIRECTORY_SEPARATOR . $file;

        if (is_file($path)) {
            $size += filesize($path);
        } elseif (is_dir($path)) {
            // Rekursiver Aufruf für Unterordner
            $size += folderSize($path);
        }
    }

    return $size;
}

function formatSize(int $bytes): string {
    $units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($units) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}

$uploadFolder = $_SERVER["DOCUMENT_ROOT"] . '/upload';

if (!is_dir($uploadFolder)) {
    die("Ordner $uploadFolder existiert nicht.");
}

$totalSizeBytes = folderSize($uploadFolder);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("../configs/head.php"); ?>
    <title>Phaedra - Adminberreich</title>
</head>

<body class="admin-background">

    <main class="flex flex-row h-screen">

        <!-- Navigation -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/navigation/adminNavigation.php" ?>
        <div class="platzhalter w-[100px] h-screen"></div>

        <!-- Dashboard Informationen -->
        <section class="flex justify-center items-center flex-wrap gap-10 p-10 w-full">

            <!-- Fehlermeldungen dieses Jahr -->
            <div class="relative bg-white rounded-xl shadow-md p-6 max-h-[200px] h-full max-w-md w-full">
                <h2 class="text-2xl font-medium phaedra-primary-color">Fehlermeldungen dieses Jahr</h2>
                <hr class="my-2 border-gray-300">
                <p class="p-5 flex justify-center items-center grow-1 text-6xl font-bold text-indigo-900"><?php echo $errorCount; ?></p>
                <div class="absolute -bottom-4 right-[-20px] bg-indigo-200 rounded-lg w-[50px] flex justify-center items-center aspect-square shadow">
                    <i class="fas fa-bug text-indigo-900 text-2xl"></i>
                </div>
            </div>

            <!-- Views dieses Jahr -->
            <div class="relative bg-white rounded-xl shadow-md p-6 max-h-[200px] h-full max-w-md w-full">
                <h2 class="text-2xl font-medium phaedra-primary-color">Views dieses Jahr</h2>
                <hr class="my-2 border-gray-300">
                <p class="p-5 flex justify-center items-center grow-1 text-6xl font-bold text-indigo-900"><?php echo $visitorCount; ?></p>
                <div class="absolute -bottom-4 right-[-20px] bg-indigo-200 rounded-lg w-[50px] flex justify-center items-center aspect-square shadow">
                    <i class="fas fa-eye text-indigo-900 text-2xl"></i>
                </div>
            </div>

            <!-- Verbrauchter Speicherplatz -->
            <div class="relative bg-white rounded-xl shadow-md p-6 max-h-[200px] h-full max-w-md w-full">
                <h2 class="text-2xl font-medium phaedra-primary-color">Verbrauchter Speicherplatz</h2>
                <hr class="my-2 border-gray-300">
                <p class="p-5 flex justify-center items-center grow-1 text-6xl font-bold text-indigo-900"><?= formatSize($totalSizeBytes) ?></p>
                <div class="absolute -bottom-4 right-[-20px] bg-indigo-200 rounded-lg w-[50px] flex justify-center items-center aspect-square shadow">
                    <i class="fas fa-database text-indigo-900 text-2xl"></i>
                </div>
            </div>

        </section>

    </main>

</body>

</html>