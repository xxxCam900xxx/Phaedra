<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/api/login/IsLoggedIn.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/timeLines/getTimeLines.php";

$timeLines = getTimeLines();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <?php require $_SERVER["DOCUMENT_ROOT"] . "/configs/head.php"; ?>
    <title>Phaedra - TimeLine Bereich</title>
</head>

<body class="admin-background">

    <main class="flex flex-row h-screen">
        <!-- Navigation -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/navigation/adminNavigation.php" ?>
        <div class="platzhalter w-[100px] h-screen"></div>

        <section class="flex flex-col w-full lg:flex-row gap-8 p-8">
            <!-- TimeLine Tabellen Liste -->
            <div class="w-full lg:w-2/3 flex flex-col gap-5 bg-white overflow-hidden rounded-lg shadow-lg h-fit">
                <h2 class="text-2xl phaedra-scondary-backgroundcolor font-semibold p-5">TimeLine Übersicht</h2>
                <div class="px-5">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                        <thead class="phaedra-scondary-backgroundcolor text-left text-sm font-medium">
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
                </div>
                <div class="flex justify-end pb-5 px-5">
                    <button
                        class="phaedra-scondary-backgroundcolor w-fit text-white cursor-pointer transition duration-300 p-3 rounded-md"
                        onclick="editTimeLine(this)"
                        data-id=""
                        data-date=""
                        data-title=""
                        data-description=""
                        data-link="">
                        Neue TimeLine erstellen
                    </button>
                </div>
            </div>

            <!-- Bearbeitungsformular -->
            <div class="w-full lg:w-1/3 bg-white shadow-lg rounded-lg h-fit overflow-hidden">
                <h2 class="text-2xl font-semibold mb-4 p-5 phaedra-scondary-backgroundcolor">TimeLine bearbeiten</h2>
                <form id="newTimeLineForm" class="space-y-5 px-5 pb-5">
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

                    <div class="flex justify-end mt-6">
                        <button id="webConfigFormSaveBtn" type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white py-2 px-4 rounded w-fit">
                            Speichern
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <script src="/assets/js/forms/timelineForm.js"></script>
    </main>
</body>

</html>