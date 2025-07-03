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
        <nav class="flex gap-10 w-full bg-sky-500 p-5 shadow-lg text-white justify-between">
            <div class="flex gap-2 text-3xl items-center">
                <i class="fa-solid fa-cloud"></i>
                <h1>MythosMorph</h1>
            </div>

            <div class="flex gap-5 text-2xl">
                <a href="/admin">Home</a>
                <a href="/admin/editor">Editor</a>
                <a href="/admin/settings">Web-Einstellungen</a>
            </div>
        </nav>

        <section class="w-full h-full flex">

            <!-- Editor -->
            <aside class="w-[400px] h-full bg-sky-700 flex flex-col text-white">
                <!-- Accordion: Widgets -->
                <div class="border-b border-sky-500">
                    <button
                        onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-4 py-3 hover:bg-sky-600 focus:outline-none">
                        <span><i class="fa-solid fa-code"></i> Widgets</span>
                        <svg class="h-4 w-4 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 bg-sky-600">

                        <!-- Inhalt -->

                    </div>
                </div>

                <!-- Accordion: Layout -->
                <div class="border-b border-sky-500">
                    <button
                        onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-4 py-3 hover:bg-sky-600 focus:outline-none">
                        <span><i class="fa-solid fa-layer-group"></i> Layout</span>
                        <svg class="h-4 w-4 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 bg-sky-600">

                        <!-- Inhalt -->


                    </div>
                </div>

                <!-- Accordion: Core Einstellungen -->
                <div>
                    <button
                        onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-4 py-3 hover:bg-sky-600 focus:outline-none">
                        <span><i class="fa-solid fa-brush"></i> Core Einstellungen</span>
                        <svg class="h-4 w-4 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 bg-sky-600">
                        <div class="flex flex-col p-5 gap-2">

                            <!-- More -->

                            <button id="newPageBtn" class="cursor-pointer bg-sky-500 p-3 rounded-md hover:bg-sky-300">
                                Neue Seite erstellen
                            </button>
                            <button class="cursor-pointer bg-sky-500 p-3 rounded-md hover:bg-sky-300">
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
                    <input type="text" name="title" placeholder="Titel" required class="border p-2 rounded" />
                    <input type="text" name="meta_title" placeholder="Meta-Titel" class="border p-2 rounded" />
                    <textarea name="meta_description" placeholder="Meta-Beschreibung" rows="3" class="border p-2 rounded"></textarea>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" id="cancelBtn" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Abbrechen</button>
                        <button type="submit" class="px-4 py-2 bg-sky-500 text-white rounded hover:bg-sky-600">Erstellen</button>
                    </div>
                </form>
            </div>
        </div>


    </main>

    <script src="/assets/js/createPagePopUp.js"></script>
    <script src="/assets/js/accordion.js"></script>

</body>

</html>