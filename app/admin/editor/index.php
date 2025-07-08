<?php

require_once '../../api/login/IsLoggedIn.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("../../configs/head.php"); ?>
    <title>MythosMorph - Editor</title>
    <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body>

    <main class="flex flex-col h-screen">

        <!-- Navigation -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/navigation/adminNavigation.php" ?>

        <section class="w-full h-full flex">

            <!-- Editor -->
            <aside class="w-[400px] h-full bg-sky-700 flex flex-col text-white">
                <!-- Accordion: Widgets -->
                <div class="border-b border-sky-500">
                    <button onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-4 py-3 hover:bg-sky-600 focus:outline-none">
                        <span><i class="fa-solid fa-code"></i> Widgets</span>
                        <svg class="h-4 w-4 transform transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 bg-sky-600">

                        <!-- Inhalt -->
                        <div class="flex flex-col p-5 gap-2">
                            <div id="ThreeSplitLayoutDropBox"
                                class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                data-dropbox-type="TextWidget" ondragstart="handleDragStart(event)">
                                Textbox
                            </div>
                            <div class="flex flex-col p-5 gap-2"></div>
                        </div>
                    </div>

                    <!-- Accordion: Layout -->
                    <div class="border-b border-sky-500">
                        <button onclick="toggleAccordion(this)"
                            class="w-full flex justify-between items-center px-4 py-3 hover:bg-sky-600 focus:outline-none">
                            <span><i class="fa-solid fa-layer-group"></i> Layout</span>
                            <svg class="h-4 w-4 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 bg-sky-600">
                            <div class="flex flex-col p-5 gap-2">
                                <!-- Inhalt -->
                                <div id="NoSplitLayoutDropBox"
                                    class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                    data-dropbox-type="NoSplitLayout" ondragstart="handleDragStart(event)">
                                    NoSplitLayout
                                </div>

                                <div id="TwoSplitLayoutDropBox"
                                    class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                    data-dropbox-type="TwoSplitLayout" ondragstart="handleDragStart(event)">
                                    TwoSplitLayout
                                </div>

                                <div id="ThreeSplitLayoutDropBox"
                                    class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                    data-dropbox-type="ThreeSplitLayout" ondragstart="handleDragStart(event)">
                                    ThreeSplitLayout
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Accordion: Core Einstellungen -->
                    <div>
                        <button onclick="toggleAccordion(this)"
                            class="w-full flex justify-between items-center px-4 py-3 hover:bg-sky-600 focus:outline-none">
                            <span><i class="fa-solid fa-brush"></i> Core Einstellungen</span>
                            <svg class="h-4 w-4 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 bg-sky-600">
                            <div class="flex flex-col p-5 gap-2">

                                <!-- More -->

                                <button id="newPageBtn"
                                    class="cursor-pointer bg-sky-500 p-3 rounded-md hover:bg-sky-300">
                                    Neue Seite erstellen
                                </button>
                                <button id="showPageStructureBtn"
                                    class="cursor-pointer bg-sky-500 p-3 rounded-md hover:bg-sky-300">
                                    Seiten struktur
                                </button>
                            </div>
                        </div>
                    </div>
            </aside>

            <!-- Website -->
            <div class="pl-5 pt-5 pr-5 w-full h-full">
                <div class="h-full shadow-xl rounded-tl-lg rounded-tr-lg overflow-hidden">
                    <iframe id="editor" src="/" frameborder="0" class="w-full h-full"></iframe>
                </div>
            </div>

        </section>

        <!-- Modal -->
        <div id="newPageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg p-6 w-96">
                <h2 class="text-xl mb-4">Neue Seite erstellen</h2>
                <form id="newPageForm" class="flex flex-col gap-3">
                    <input type="text" name="id" class="hidden" />
                    <input type="text" name="title" placeholder="Titel" required class="border p-2 rounded" />
                    <input type="text" name="pathURL" placeholder="pathURL" required class="border p-2 rounded" />
                    <input type="text" name="meta_title" placeholder="Meta-Titel" class="border p-2 rounded" />
                    <textarea name="meta_description" placeholder="Meta-Beschreibung" rows="3"
                        class="border p-2 rounded"></textarea>
                    <input type="number" name="sort" placeholder="Sortierung" class="border p-2 rounded" />

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" id="cancelBtn"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Abbrechen</button>
                        <button type="submit"
                            class="px-4 py-2 bg-sky-500 text-white rounded hover:bg-sky-600">Erstellen</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="showPageStructure" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg p-6 w-96 relative">
                <h2 class="text-xl mb-4">Seitenstruktur</h2>
                <div class="flex flex-col gap-2">
                    <?php
                    require_once $_SERVER['DOCUMENT_ROOT'] . '/api/editor/pages/getAllPages.php';
                    $pages = getAllPages();
                    ?>
                    <!-- Forech bauen -->
                    <?php

                    if ($pages === false) {
                        echo "Fehler beim Laden der Seiten.";
                    } else {
                        foreach ($pages as $page) {

                    ?>
                            <div class="p-2 text-lg flex justify-between hover:bg-gray-200 rounded-md trainsition duration-300">
                                <?= $page['title'] ?>
                                <div class="flex gap-2">
                                    <!-- Update -->
                                    <button class="cursor-pointer flex items-center justify-center w-[30px] h-[30px] hover:text-white hover:bg-sky-500 rounded-md trainsition duration-300" onclick="openUpdatePagePopUp('<?= $page['id'] ?>', '<?= $page['title'] ?>', '<?= $page['pathURL'] ?>', '<?= $page['meta_title'] ?>', '<?= $page['meta_description'] ?>', '<?= $page['sort'] ?>')"><i class="fa-solid fa-file-pen"></i></button>
                                    <!-- Delete -->
                                    <button class="cursor-pointer flex items-center justify-center w-[30px] h-[30px] hover:text-white hover:bg-red-500 rounded-md trainsition duration-300" onclick="deletePageById(<?= $page['id'] ?>)"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                    <?php
                        }
                    }

                    ?>
                </div>
                <button type="button" id="showPageStructureCancelBtn"
                    class="px-4 absolute top-5 right-5 py-2 bg-gray-300 rounded hover:bg-gray-400 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>


    </main>

    <script src="/assets/js/showPagesPopUp.js"></script>
    <script src="/assets/js/createPagePopUp.js"></script>
    <script src="/assets/js/accordion.js"></script>
    <script src="/assets/js/editor.js"></script>

</body>

</html>