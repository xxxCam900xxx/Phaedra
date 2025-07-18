<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/api/login/IsLoggedIn.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/socials/getSocials.php";

$socials = getSocials();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <?php require $_SERVER["DOCUMENT_ROOT"] . "/configs/head.php"; ?>
    <title>Phaedra - Socials Bereich</title>
</head>

<body class="admin-background">

    <main class="flex flex-row h-screen">
        <!-- Navigation -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/navigation/adminNavigation.php" ?>
        <div class="platzhalter w-[100px] h-screen"></div>

        <section class="flex flex-col lg:flex-row gap-8 p-8">
            <!-- FAQ Tabellen Liste -->
            <div class="w-full lg:w-2/3 flex flex-col gap-5">
                <h2 class="text-2xl font-semibold">Social Übersicht</h2>
                <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                    <thead class="bg-gray-100 text-left text-sm font-medium text-gray-700">
                        <tr>
                            <th class="px-4 py-3 border-b">Icon</th>
                            <th class="px-4 py-3 border-b">Social Link</th>
                            <th class="px-4 py-3 border-b">Aktiv?</th>
                            <th class="px-4 py-3 border-b">Erstellt</th>
                            <th class="px-4 py-3 border-b"></th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-200">
                        <?php foreach ($socials as $social): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 flex gap-5 items-center">
                                    <i class="<?= htmlspecialchars($social['icon']) ?>"></i>
                                    <?= htmlspecialchars($social['icon']) ?>
                                <td class="px-4 py-3"><?= htmlspecialchars($social['socialURL']) ?></td>
                                <td class="px-4 py-3">
                                    <?php if ($social['isShown'] == "true"): ?>
                                        <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                                    <?php else: ?>
                                        <span class="inline-block w-3 h-3 bg-gray-400 rounded-full"></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3"><?= htmlspecialchars($social['createDate']) ?></td>
                                <td class="px-4 py-3 flex gap-2 justify-end">
                                    <button
                                        class="text-blue-600 hover:underline text-sm"
                                        onclick="editsocial(this)"
                                        data-id="<?= $social['id'] ?>"
                                        data-icon="<?= htmlspecialchars($social['icon'], ENT_QUOTES) ?>"
                                        data-social="<?= htmlspecialchars($social['socialURL'], ENT_QUOTES) ?>"
                                        data-active="<?= $social['isShown'] == "true" ? '1' : '0' ?>">
                                        Bearbeiten
                                    </button>
                                    <button
                                        class="text-blue-600 hover:underline text-sm"
                                        onclick="deletesocial(this)"
                                        data-id="<?= $social['id'] ?>">
                                        Löschen
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <button
                    class="text-white hover:bg-blue-500 cursor-pointer transition duration-300 p-3 rounded-md bg-sky-300"
                    onclick="editsocial(this)"
                    data-id=""
                    data-icon=""
                    data-social=""
                    data-active="0">
                    Neue social erstellen
                </button>
            </div>

            <!-- Bearbeitungsformular -->
            <div class="w-full lg:w-1/3">
                <h2 class="text-2xl font-semibold mb-4">Social bearbeiten</h2>
                <form id="newSocialForm" class="bg-white shadow-sm rounded-lg p-6 space-y-5 border border-gray-200">
                    <input type="hidden" name="ID" id="ID">

                    <div>
                        <label for="Icon" class="block font-medium text-gray-700 mb-1">Icon (Benutze Font-Awsome Klassen)</label>
                        <input type="text" name="Icon" id="Icon"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="Social" class="block font-medium text-gray-700 mb-1">Social</label>
                        <input type="text" name="Social" id="Social"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="IsShown" id="IsShown"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="IsShown" class="text-sm text-gray-700">Aktivieren</label>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Speichern</button>
                </form>
            </div>
        </section>

        <script src="/assets/js/forms/socialForm.js"></script>
    </main>
</body>

</html>