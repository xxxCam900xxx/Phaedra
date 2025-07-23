<?php

require_once '../../api/login/IsLoggedIn.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("../../configs/head.php"); ?>
    <title>Phaedra - Editor</title>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="admin-background">

    <main class="flex flex-row h-screen">

        <!-- Navigation -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/components/navigation/adminNavigation.php" ?>
        <div class="platzhalter w-[100px] h-screen"></div>

        <section class="w-full h-full flex">

            <!-- Website -->
            <div class="pl-8 pt-5 pr-8 w-full h-full">
                <div class="h-full shadow-xl rounded-tl-lg rounded-tr-lg overflow-hidden">
                    <iframe id="editor" src="/" frameborder="0" class="w-full h-full"></iframe>
                </div>
            </div>

            <!-- Editor -->
            <aside class="w-[350px] h-full bg-white flex flex-col p-5">

                <?php



                ?>

                <!-- Accordion: Widgets -->
                <div>
                    <button onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-4 py-3 hover:bg-sky-600 font-semibold focus:outline-none phaedra-scondary-backgroundcolor rounded-md cursor-pointer">
                        <span class="flex items-center gap-2 text-2xl"><i class="fa-solid fa-icons"></i> Widgets</span>
                        <svg class="h-6 w-6 transform transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content flex flex-col gap-2 max-h-0 overflow-hidden transition-all duration-500 pt-2 mr-10">

                        <?php
                        $widgets = [
                            ["id" => "TextWidget", "name" => "Textbox"],
                            ["id" => "ImageWidget", "name" => "Imagebox"],
                            ["id" => "RepoCrawlerWidget", "name" => "Repository-Crawler"],
                            ["id" => "FaqWidget", "name" => "FAQ"],
                            ["id" => "TextTypingWidget", "name" => "Getippter Text"],
                            ["id" => "VideoWidget", "name" => "Video"],
                            ["id" => "SocialWidget", "name" => "SocialWidget"],
                            ["id" => "ContactFormWidget", "name" => "Kontaktformular"],
                            ["id" => "TimelineWidget", "name" => "Timeline"],
                        ];
                        ?>

                        <?php foreach ($widgets as $widget): ?>
                            <div id="<?= $widget['id'] ?>"
                                class="cursor-grab phaedra-scondary-backgroundcolor rounded-md p-3 flex items-center justify-between"
                                draggable="true"
                                data-dropbox-type="<?= $widget['id'] ?>"
                                ondragstart="handleDragStart(event)">
                                <?= htmlspecialchars($widget['name']) ?>
                                <i class="fa-solid fa-plus"></i>
                            </div>
                        <?php endforeach; ?>

                        <div class="mb-5"></div>

                    </div>
                </div>


                <!-- Accordion: Layout -->
                <div>
                    <button onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-4 py-3 hover:bg-sky-600 font-semibold focus:outline-none phaedra-scondary-backgroundcolor rounded-md cursor-pointer">
                        <span class="flex items-center gap-2 text-2xl"><i class="fa-solid fa-layer-group"></i> Layouts</span>
                        <svg class="h-6 w-6 transform transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content flex flex-col gap-2 max-h-0 overflow-hidden transition-all duration-500 pt-2 mr-10">

                        <?php
                        $layouts = [
                            ["id" => "NoSplitLayout", "name" => "NoSplitLayout"],
                            ["id" => "TwoSplitLayout", "name" => "2SplitLayout"],
                            ["id" => "ThreeSplitLayout", "name" => "3SplitLayout"],
                            ["id" => "BigLeftSplitLayout", "name" => "BigLeftSplitLayout"],
                            ["id" => "BigRightSplitLayout", "name" => "BigRightSplitLayout"],
                        ];
                        ?>

                        <?php foreach ($layouts as $layout): ?>
                            <div id="<?= $layout['id'] ?>"
                                class="cursor-grab phaedra-scondary-backgroundcolor rounded-md p-3 flex items-center justify-between"
                                draggable="true"
                                data-dropbox-type="<?= $layout['id'] ?>"
                                ondragstart="handleDragStart(event)">
                                <?= htmlspecialchars($layout['name']) ?>
                                <i class="fa-solid fa-plus"></i>
                            </div>
                        <?php endforeach; ?>

                        <div class="mb-5"></div>

                    </div>
                </div>
                </div>

                <div>
                    <button onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-4 py-3 hover:bg-sky-600 font-semibold focus:outline-none phaedra-scondary-backgroundcolor rounded-md cursor-pointer">
                        <span class="flex items-center gap-2 text-2xl"><i class="fa-solid fa-brush"></i> Design</span>
                        <svg class="h-6 w-6 transform transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="editorSettings" class="accordion-content flex flex-col gap-2 max-h-0 overflow-hidden transition-all duration-500 pt-2 mr-5">

                        <?php
                        $settings = [
                            ["id" => "Primary_Color", "label" => "Primärfarbe", "type" => "color", "target" => ".primary-color", "prop" => "background-color"],
                            ["id" => "Secondary_Color", "label" => "Sekundärfarbe", "type" => "color", "target" => ".secondary-color", "prop" => "background-color"],
                            ["id" => "Background_Color", "label" => "Hintergrundfarbe", "type" => "color", "target" => "body", "prop" => "background-color"],

                            ["id" => "Heading1_Size", "label" => "H1 Size", "type" => "range", "target" => "h1", "prop" => "fontSize", "min" => 16, "max" => 72, "value" => 36],
                            ["id" => "Heading1_Weight", "label" => "H1 Weight", "type" => "range", "target" => "h1", "prop" => "fontWeight", "min" => 100, "max" => 900, "step" => 100, "value" => 700],

                            ["id" => "Heading2_Size", "label" => "H2 Size", "type" => "range", "target" => "h2", "prop" => "fontSize", "min" => 16, "max" => 72, "value" => 36],
                            ["id" => "Heading2_Weight", "label" => "H2 Weight", "type" => "range", "target" => "h2", "prop" => "fontWeight", "min" => 100, "max" => 900, "step" => 100, "value" => 700],

                            ["id" => "Paragraph_Size", "label" => "P Size", "type" => "range", "target" => "p", "prop" => "fontSize", "min" => 16, "max" => 72, "value" => 36],
                            ["id" => "Paragraph_Weight", "label" => "P Weight", "type" => "range", "target" => "p", "prop" => "fontWeight", "min" => 100, "max" => 900, "step" => 100, "value" => 700],

                            ["id" => "Link_Color", "label" => "Link Color", "type" => "color", "target" => "a", "prop" => "color"],
                            ["id" => "LinkHover_Color", "label" => "Link Hover", "type" => "color", "hover" => true],

                            ["id" => "LinkBtn_TextColor", "label" => "LinkButton Color", "type" => "color", "target" => ".button", "prop" => "color"],
                            ["id" => "LinkBtn_Color", "label" => "LinkButton BG-Color", "type" => "color", "target" => ".button", "prop" => "background-color"],
                            ["id" => "LinkHoverBtn_Color", "label" => "LinkButton BG-Hover", "type" => "color", "hoverButton" => true],

                            ["id" => "Section_Gap", "label" => "Sections Gap", "type" => "range", "sectionGap" => true, "min" => 0, "max" => 100, "value" => 5],

                            ["id" => "Footer_Color", "label" => "Footerfarbe", "type" => "color", "target" => "footer", "prop" => "color"],
                            ["id" => "Footer_BackgroundColor", "label" => "Footerhintergrundfarbe", "type" => "color", "target" => "footer", "prop" => "background-color"],
                            ["id" => "Footer_LinkColor", "label" => "Footer Linkfarbe", "type" => "color", "target" => "footer a", "prop" => "color"],

                            ["id" => "FooterEnd_BackgroundColor", "label" => "FooterEndhintergrundfarbe", "type" => "color", "target" => ".footerEnd", "prop" => "background-color"],
                            ["id" => "FooterEnd_Color", "label" => "FooterEndfarbe", "type" => "color", "target" => ".footerEnd a", "prop" => "color"],

                            ["id" => "Header_BackgroundColor", "label" => "Headerhintergrundfarbe", "type" => "color", "target" => "header", "prop" => "background-color"],
                            ["id" => "Header_LinkColor", "label" => "Header Linkfarbe", "type" => "color", "target" => "header a", "prop" => "color"],

                            ["id" => "PreHeader_Color", "label" => "PreHeaderfarbe", "type" => "color", "target" => ".preheader", "prop" => "color"],
                            ["id" => "PreHeader_BackgroundColor", "label" => "PreHeaderhintergrundfarbe", "type" => "color", "target" => ".preheader", "prop" => "background-color"],
                        ];
                        ?>

                        <div class="min-h-[500px] overflow-scroll flex flex-col gap-2">
                            <?php foreach ($settings as $setting): ?>
                                <div class="cursor-grab w-full phaedra-scondary-backgroundcolor rounded-md p-2 flex items-center justify-between">
                                    <label for="<?= htmlspecialchars($setting['id']) ?>" class="w-40"><?= htmlspecialchars($setting['label']) ?></label>

                                    <?php if ($setting['type'] === 'color'): ?>
                                        <input
                                            type="color"
                                            id="<?= htmlspecialchars($setting['id']) ?>"
                                            name="<?= htmlspecialchars($setting['id']) ?>"
                                            <?= isset($setting['value']) ? 'value="' . htmlspecialchars($setting['value']) . '"' : '' ?>
                                            <?= isset($setting['target']) ? 'data-style-target="' . htmlspecialchars($setting['target']) . '"' : '' ?>
                                            <?= isset($setting['prop']) ? 'data-style-prop="' . htmlspecialchars($setting['prop']) . '"' : '' ?>
                                            <?= isset($setting['hover']) && $setting['hover'] ? 'data-hover-color' : '' ?>
                                            <?= isset($setting['hoverButton']) && $setting['hoverButton'] ? 'data-btn-hover-color' : '' ?> />
                                    <?php elseif ($setting['type'] === 'range'): ?>
                                        <input
                                            type="range"
                                            name="<?= htmlspecialchars($setting['id']) ?>"
                                            value="<?= htmlspecialchars($setting['value']) ?>"
                                            min="<?= htmlspecialchars($setting['min']) ?>"
                                            max="<?= htmlspecialchars($setting['max']) ?>"
                                            <?= isset($setting['step']) ? 'step="' . htmlspecialchars($setting['step']) . '"' : '' ?>
                                            <?= isset($setting['target']) ? 'data-style-target="' . htmlspecialchars($setting['target']) . '"' : '' ?>
                                            <?= isset($setting['prop']) ? 'data-style-prop="' . htmlspecialchars($setting['prop']) . '"' : '' ?>
                                            <?= isset($setting['sectionGap']) && $setting['sectionGap'] ? 'data-section-gap' : '' ?> />
                                        <span class="font-mono" id="<?= htmlspecialchars($setting['id']) ?>Label">
                                            <?= htmlspecialchars($setting['value']) ?><?= (isset($setting['prop']) && $setting['prop'] === 'fontSize') ? 'px' : '' ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button id="saveEditorStyles" class="bg-emerald-500 hover:bg-emerald-600 text-white py-2 px-4 rounded mb-5 w-fit">Speichern</button>
                    </div>
                </div>
                </div>

                <!-- Accordion: Webseiten verwaltung -->
                <div>
                    <button onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-4 py-3 hover:bg-sky-600 font-semibold focus:outline-none phaedra-scondary-backgroundcolor rounded-md cursor-pointer">
                        <span class="flex items-center gap-2 text-2xl"><i class="fa-solid fa-file-lines"></i> Seiten</span>
                        <svg class="h-6 w-6 transform transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content flex flex-col gap-2 max-h-0 overflow-hidden transition-all duration-500 pt-2 mr-10">
                        <button id="newPageBtn"
                            class="cursor-grab phaedra-scondary-backgroundcolor rounded-md p-3 flex items-center justify-between">
                            Neue Seite
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        <button id="showPageStructureBtn"
                            class="cursor-grab phaedra-scondary-backgroundcolor rounded-md p-3 flex items-center justify-between">
                            Seitenstruktur
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    </div>
                </div>
            </aside>

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