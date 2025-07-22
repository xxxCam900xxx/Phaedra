<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/api/login/IsLoggedIn.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/faqs/getFaqs.php";

$faqs = getFaqs();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <?php require $_SERVER["DOCUMENT_ROOT"] . "/configs/head.php"; ?>
    <title>Phaedra - FAQ Bereich</title>
</head>

<body class="admin-background">

    <main class="flex flex-row h-screen">
        <!-- Navigation -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/navigation/adminNavigation.php" ?>
        <div class="platzhalter w-[100px] h-screen"></div>

        <section class="flex flex-col w-full lg:flex-row gap-8 p-8">
            <!-- FAQ Tabellen Liste -->
            <div class="w-full lg:w-2/3 flex flex-col gap-5 bg-white overflow-hidden rounded-lg shadow-lg h-fit">
                <h2 class="text-2xl phaedra-scondary-backgroundcolor font-semibold p-5">FAQ Übersicht</h2>
                <div class="px-5">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                        <thead class="phaedra-scondary-backgroundcolor text-left text-sm font-medium">
                            <tr>
                                <th class="px-4 py-3 border-b">Frage</th>
                                <th class="px-4 py-3 border-b">Beantwortet?</th>
                                <th class="px-4 py-3 border-b">Aktiv?</th>
                                <th class="px-4 py-3 border-b">Erstellt</th>
                                <th class="px-4 py-3 border-b"></th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-200">
                            <?php foreach ($faqs as $faq): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3"><?= htmlspecialchars($faq['question']) ?></td>
                                    <td class="px-4 py-3">
                                        <?php if ($faq['answer'] != ""): ?>
                                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                                        <?php else: ?>
                                            <span class="inline-block w-3 h-3 bg-gray-400 rounded-full"></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php if ($faq['isShown'] == "true"): ?>
                                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                                        <?php else: ?>
                                            <span class="inline-block w-3 h-3 bg-gray-400 rounded-full"></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3"><?= htmlspecialchars($faq['createDate']) ?></td>
                                    <td class="px-4 py-3 flex gap-2 justify-end">
                                        <button
                                            class="text-blue-600 hover:underline text-sm"
                                            onclick="editFAQ(this)"
                                            data-id="<?= $faq['id'] ?>"
                                            data-question="<?= htmlspecialchars($faq['question'], ENT_QUOTES) ?>"
                                            data-answer="<?= htmlspecialchars($faq['answer'], ENT_QUOTES) ?>"
                                            data-active="<?= $faq['isShown'] == "true" ? '1' : '0' ?>">
                                            Bearbeiten
                                        </button>
                                        <button
                                            class="text-blue-600 hover:underline text-sm"
                                            onclick="deleteFAQ(this)"
                                            data-id="<?= $faq['id'] ?>">
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
                        onclick="editFAQ(this)"
                        data-id=""
                        data-question=""
                        data-answer=""
                        data-active="0">
                        Neue FAQ erstellen
                    </button>
                </div>
            </div>

            <!-- Bearbeitungsformular -->
            <div class="w-full lg:w-1/3 bg-white shadow-lg rounded-lg h-fit overflow-hidden">
                <h2 class="text-2xl font-semibold mb-4 p-5 phaedra-scondary-backgroundcolor">FAQ bearbeiten</h2>
                <form id="newFaqQuestionForm" class="space-y-5 px-5 pb-5">
                    <input type="hidden" name="ID" id="ID">

                    <div>
                        <label class="text-2xl phaedra-primary-color font-semibold" for="Question">Frage</label>
                        <input type="text" name="Question" id="Question"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>

                    <div>
                        <label class="text-2xl phaedra-primary-color font-semibold" for="Answer">Antwort</label>
                        <textarea name="Answer" id="Answer" rows="4"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-200"></textarea>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="IsShown" id="IsShown"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label class="text-2xl phaedra-primary-color font-semibold" for="IsShown">Aktivieren</label>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button id="webConfigFormSaveBtn" type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white py-2 px-4 rounded w-fit">
                            Speichern
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <script>
            function editFAQ(button) {
                document.getElementById('ID').value = button.dataset.id;
                document.getElementById('Question').value = button.dataset.question;
                document.getElementById('Answer').value = button.dataset.answer;
                document.getElementById('IsShown').checked = button.dataset.active === "1";
            }

            function deleteFAQ(button) {
                fetch("/api/faqs/deleteFaq.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            faqId: button.dataset.id
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) window.location.reload();
                        else alert("Fehler beim Löschen: " + (data.message || "Unbekannter Fehler"));
                    })
                    .catch(err => alert("Netzwerkfehler: " + err));
            }
        </script>
        <script src="/assets/js/widgets/faqWidget.js"></script>
    </main>
</body>

</html>