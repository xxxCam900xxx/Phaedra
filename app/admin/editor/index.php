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
                <div>
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
                            <div id="TextWidget"
                                class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                data-dropbox-type="TextWidget" ondragstart="handleDragStart(event)">
                                Textbox
                            </div>
                            <div id="ImageWidget"
                                class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                data-dropbox-type="ImageWidget" ondragstart="handleDragStart(event)">
                                Imagebox
                            </div>
                            <div id="RepoCrawlerWidget"
                                class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                data-dropbox-type="RepoCrawlerWidget" ondragstart="handleDragStart(event)">
                                Repository-Crawler
                            </div>
                            <div id="FaqWidget"
                                class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                data-dropbox-type="FaqWidget" ondragstart="handleDragStart(event)">
                                FAQ
                            </div>
                            <div id="TextTypingWidget"
                                class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                data-dropbox-type="TextTypingWidget" ondragstart="handleDragStart(event)">
                                Getippter Text
                            </div>
                            <div id="VideoWidget"
                                class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                data-dropbox-type="VideoWidget" ondragstart="handleDragStart(event)">
                                Video
                            </div>
                            <div id="SocialWidget"
                                class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                data-dropbox-type="SocialWidget" ondragstart="handleDragStart(event)">
                                SocialWidget
                            </div>
                            <div id="ContactFormWidget"
                                class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                data-dropbox-type="ContactFormWidget" ondragstart="handleDragStart(event)">
                                Kontaktformular
                            </div>
                            <div id="TimelineWidget"
                                class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                data-dropbox-type="TimelineWidget" ondragstart="handleDragStart(event)">
                                Timeline
                            </div>
                        </div>
                    </div>

                    <!-- Accordion: Layout -->
                    <div>
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

                                <div id="BigLeftSplitLayout"
                                    class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                    data-dropbox-type="BigLeftSplitLayout" ondragstart="handleDragStart(event)">
                                    2/3
                                </div>

                                <div id="BigRightSplitLayout"
                                    class="cursor-grab bg-sky-500 p-3 rounded-md hover:bg-sky-300" draggable="true"
                                    data-dropbox-type="BigRightSplitLayout" ondragstart="handleDragStart(event)">
                                    1/3
                                </div>

                            </div>
                        </div>
                    </div>

                    <div>
                        <button onclick="toggleAccordion(this)"
                            class="w-full flex justify-between items-center px-4 py-3 hover:bg-sky-600 focus:outline-none">
                            <span><i class="fa-solid fa-brush"></i> Design</span>
                            <svg class="h-4 w-4 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 bg-sky-600">
                            <div class="flex flex-col p-5 gap-4" id="editorSettings">
                                <!-- Primärfarbe -->
                                <div class="flex items-center gap-3">
                                    <label class="w-40">Primärfarbe</label>
                                    <input type="color" name="Primary_Color" value="#1D4ED8" data-style-target=".primary-color" data-style-prop="background-color" />
                                </div>

                                <!-- Secondarycolor -->
                                <div class="flex items-center gap-3">
                                    <label class="w-40">Sekundärefarbe</label>
                                    <input type="color" name="Secondary_Color" value="#1D4ED8" data-style-target=".secondary-color" data-style-prop="background-color" />
                                </div>

                                <!-- Hintergrundfarbe -->
                                <div class="flex items-center gap-3">
                                    <label class="w-40">Hintergrundfarbe</label>
                                    <input type="color" name="Background_Color" value="#ffffff" data-style-target="body" data-style-prop="background-color" />
                                </div>

                                <!-- Footercolor -->
                                <div class="flex items-center gap-3">
                                    <label class="w-40">Footerfarbe</label>
                                    <input type="color" name="Footer_Color" value="#1D4ED8" data-style-target="footer" data-style-prop="background-color" />
                                </div>

                                <!-- H1 Schriftgröße -->
                                <div class="flex items-center gap-3">
                                    <label class="w-40">H1 Größe</label>
                                    <input type="range" name="Heading1_Size" min="16" max="72" value="36" data-style-target="h1" data-style-prop="fontSize" />
                                    <span class="font-mono" id="Heading1_SizeLabel">36px</span>
                                </div>

                                <!-- H1 Gewicht -->
                                <div class="flex items-center gap-3">
                                    <label class="w-40">H1 Gewicht</label>
                                    <input type="range" name="Heading1_Weight" min="100" max="900" step="100" value="700" data-style-target="h1" data-style-prop="fontWeight" />
                                    <span class="font-mono" id="Heading1_WeightLabel">700</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <label class="w-40">H2 Grösse</label>
                                    <input type="range" name="Heading2_Size" min="16" max="72" value="36" data-style-target="h2" data-style-prop="fontSize" />
                                    <span class="font-mono" id="Heading2_SizeLabel">36px</span>
                                </div>

                                <!-- H1 Gewicht -->
                                <div class="flex items-center gap-3">
                                    <label class="w-40">H2 Gewicht</label>
                                    <input type="range" name="Heading2_Weight" min="100" max="900" step="100" value="700" data-style-target="h2" data-style-prop="fontWeight" />
                                    <span class="font-mono" id="Heading2_Weight">700</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <label class="w-40">Paragraph Grösse</label>
                                    <input type="range" name="Paragraph_Size" min="16" max="72" value="36" data-style-target="p" data-style-prop="fontSize" />
                                    <span class="font-mono" id="Paragraph_SizeLabel">36px</span>
                                </div>

                                <!-- Hp Gewicht -->
                                <div class="flex items-center gap-3">
                                    <label class="w-40">Paragraph Gewicht</label>
                                    <input type="range" name="Paragraph_Weight" min="100" max="900" step="100" value="700" data-style-target="p" data-style-prop="fontWeight" />
                                    <span class="font-mono" id="Paragraph_WeightLabel">700</span>
                                </div>

                                <!-- Linkfarbe -->
                                <div class="flex items-center gap-3">
                                    <label class="w-40">Link - Textfarbe</label>
                                    <input type="color" name="Link_Color" value="#ffffffff" data-style-target="a" data-style-prop="color" />
                                </div>

                                <!-- Link Hoverfarbe -->
                                <div class="flex items-center gap-3">
                                    <label class="w-40">Link - Hover Textfarbe</label>
                                    <input type="color" name="LinkHover_Color" value="#ffffffff" data-hover-color />
                                </div>

                                <!-- Link-Button Textfarbe -->
                                 <div class="flex items-center gap-3">
                                    <label class="w-40">Link Button - Textfarbe</label>
                                    <input type="color" name="LinkBtn_TextColor" value="#ffffffff" data-style-target=".button" data-style-prop="color" />
                                </div>
                                <!-- Link-Button Hintergrundfarbe -->
                                 <div class="flex items-center gap-3">
                                    <label class="w-40">Link Button - Hintergrundfarbe</label>
                                    <input type="color" name="LinkBtn_Color" value="#ffffffff" data-style-target=".button" data-style-prop="background-color" />
                                </div>
                                <!-- Link-Button Hover Hintergrundfarbe -->
                                 <div class="flex items-center gap-3">
                                    <label class="w-40">Link Button - Hover Hintergrundfarbe</label>
                                    <input type="color" name="LinkHoverBtn_Color" value="#ffffffff" data-btn-hover-color />
                                </div>

                                <!-- Section Abstand -->
                                <div class="flex items-center gap-3">
                                    <label class="w-40">Sektionen - Abstände</label>
                                    <input type="range" name="Section_Gap" min="0" max="100" value="5" data-section-gab />
                                    <span class="font-mono" id="Section_GapLabel">5px</span>
                                </div>

                                <button id="saveEditorStyles" class="bg-emerald-500 hover:bg-emerald-600 text-white py-2 px-4 rounded mt-5 w-fit">Speichern</button>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion: Webseiten verwaltung -->
                    <div>
                        <button onclick="toggleAccordion(this)"
                            class="w-full flex justify-between items-center px-4 py-3 hover:bg-sky-600 focus:outline-none">
                            <span><i class="fa-solid fa-file"></i> Seiten</span>
                            <svg class="h-4 w-4 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 bg-sky-600">
                            <div class="flex flex-col p-5 gap-2">
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

        <?php
            require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/popups/newPagePopUp.php";
            require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/popups/showPageStructurePopUp.php";
        ?>

    </main>

    <!-- Editor Functionalitys -->
    <script src="/assets/js/editor.js"></script>
    <script src="/assets/js/editorDesign.js"></script>
    <script src="/assets/js/editorWidgets.js"></script>

    <!-- PopUps -->
    <script src="/assets/js/showPagesPopUp.js"></script>
    <script src="/assets/js/createPagePopUp.js"></script>

    <!-- Other Features -->
    <script src="/assets/js/accordion.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const pageList = document.getElementById('pageListContainer');

            Sortable.create(pageList, {
                animation: 150,
                onEnd: function() {
                    const newOrder = Array.from(pageList.children).map((el, index) => ({
                        id: el.dataset.id,
                        sort: (index) * 10 // oder einfach index + 1, je nach Sort-Strategie
                    }));

                    console.log("Neue Seitenreihenfolge:", newOrder);

                    fetch('/api/editor/pages/updatePageSort.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                order: newOrder
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                console.log("Sortierung gespeichert");
                                window.location.reload();
                            } else {
                                alert("Fehler beim Speichern: " + (data.message || 'Unbekannter Fehler'));
                            }
                        })
                        .catch(err => {
                            console.error("Netzwerkfehler beim Speichern der Sortierung", err);
                        });
                }
            });
        });
    </script>

</body>

</html>