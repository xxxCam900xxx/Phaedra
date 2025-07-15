<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/api/login/IsLoggedIn.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/timeLines/getTimeLines.php";

$timeLines = getTimeLines();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <?php require $_SERVER["DOCUMENT_ROOT"] . "/configs/head.php"; ?>
    <title>MythosMorph - TimeLine Bereich</title>
</head>

<body>
    <main class="flex flex-col min-h-screen">
        <!-- Navigation -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/navigation/adminNavigation.php" ?>

        <section class="flex flex-col lg:flex-row gap-8 p-8">
            <!-- TimeLine Tabellen Liste -->
            <div class="w-full lg:w-2/3 flex flex-col gap-5">
                <h2 class="text-2xl font-semibold">TimeLine Übersicht</h2>
                <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                    <thead class="bg-gray-100 text-left text-sm font-medium text-gray-700">
                        <tr>
                            <th class="px-4 py-3 border-b">Datum</th>
                            <th class="px-4 py-3 border-b">Titel</th>
                            <th class="px-4 py-3 border-b">Beschreibung</th>
                            <th class="px-4 py-3 border-b">Link</th>
                            <th class="px-4 py-3 border-b"></th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-200">
                        <?php foreach ($timeLines as $timeLine): 
                            $dateWithoutTime = strtotime($timeLine['Date']); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3"><?= date('d.m.Y', $dateWithoutTime); ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($timeLine['Title']) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($timeLine['Description']) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($timeLine['Link']) ?></td>
                                <td class="px-4 py-3 flex gap-2 justify-end">
                                    <button
                                        class="text-blue-600 hover:underline text-sm"
                                        onclick="editTimeLine(this)"
                                        data-id="<?= $timeLine['ID'] ?>"
                                        data-date="<?= htmlspecialchars(date('Y-m-d', $dateWithoutTime), ENT_QUOTES) ?>"
                                        data-title="<?= htmlspecialchars($timeLine['Title'], ENT_QUOTES) ?>"
                                        data-description="<?= htmlspecialchars($timeLine['Description'], ENT_QUOTES) ?>"
                                        data-link="<?= htmlspecialchars($timeLine['Link'], ENT_QUOTES) ?>">
                                        Bearbeiten
                                    </button>
                                    <button
                                        class="text-blue-600 hover:underline text-sm"
                                        onclick="deleteTimeLine(this)"
                                        data-id="<?= $timeLine['ID'] ?>">
                                        Löschen
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <button
                    class="text-white hover:bg-blue-500 cursor-pointer transition duration-300 p-3 rounded-md bg-sky-300"
                    onclick="editTimeLine(this)"
                    data-id=""
                    data-date=""
                    data-title=""
                    data-description=""
                    data-link="">
                    Neue TimeLine erstellen
                </button>
            </div>

            <!-- Bearbeitungsformular -->
            <div class="w-full lg:w-1/3">
                <h2 class="text-2xl font-semibold mb-4">TimeLine bearbeiten</h2>
                <form id="newTimeLineForm" class="bg-white shadow-sm rounded-lg p-6 space-y-5 border border-gray-200">
                    <input type="hidden" name="ID" id="ID">

                    <div>
                        <label for="Date" class="block font-medium text-gray-700 mb-1">Datum</label>
                        <input type="date" name="Date" id="Date"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="Title" class="block font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="Title" id="Title"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label for="Description" class="block font-medium text-gray-700 mb-1">Beschreibung</label>
                        <textarea name="Description" id="Description" rows="4"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200"></textarea>
                    </div>

                    <div>
                        <label for="Link" class="block font-medium text-gray-700 mb-1">URL *Optional</label>
                        <input type="text" name="Link" id="Link"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Speichern</button>
                </form>
            </div>
        </section>

        <script src="/assets/js/forms/timelineForm.js"></script>
    </main>
</body>

</html>