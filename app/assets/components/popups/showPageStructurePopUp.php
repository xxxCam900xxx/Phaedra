<!-- Page Structure PopUp -->
<div id="showPageStructure" class="fixed inset-0 phaedra-popup-background flex items-center justify-center hidden">

    <div class="bg-white rounded-lg w-96 relative shadow-xl">

        <!-- Close Button -->
        <button id="showPageStructureCancelBtn" class="absolute shadow-xl cursor-pointer text-xl top-[-15px] right-[-15px] w-[40px] h-[40px] phaedra-scondary-backgroundcolor z-index-10 rounded-md">
            <i class="fa-solid fa-x"></i>
        </button>

        <!-- HeadTitle -->
        <div class="phaedra-scondary-backgroundcolor p-5 rounded-t-md">
            <h2 class="text-2xl font-semibold">Seitenstruktur</h2>
        </div>

        <div class="flex flex-col p-5 gap-2 overflow-auto max-h-[500px]" id="pageListContainer">
            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . '/api/editor/pages/getAllPages.php';
            $pages = getAllPages();

            if ($pages === false) {
                echo "Fehler beim Laden der Seiten.";
            } else {
                foreach ($pages as $page) {

            ?>
                    <div class="flex gap-2 w-fulll items-center" data-id="<?= $page['id'] ?>">
                        <div class="p-2 w-full text-lg flex justify-between phaedra-scondary-backgroundcolor rounded-md trainsition duration-300">
                            <?= $page['nav_title'] ?>
                            <div class="flex gap-2">
                                <p class="min-w-[50px] text-center rounded-md bg-white"><?= $page['sort'] ?></p>
                            </div>
                        </div>
                        <!-- Update -->
                        <button class="cursor-pointer text-xl phaedra-scondary-backgroundcolor flex items-center justify-center h-[44px] aspect-square hover:text-white hover:bg-sky-500 rounded-md trainsition duration-300" onclick="openUpdatePagePopUp('<?= $page['id'] ?>', '<?= $page['nav_title'] ?>', '<?= $page['pathURL'] ?>', '<?= $page['page_title'] ?>', '<?= $page['meta_description'] ?>', '<?= $page['sort'] ?>')"><i class="fa-solid fa-file-pen"></i></button>
                        <!-- Delete -->
                        <button class="cursor-pointer text-xl phaedra-scondary-backgroundcolor flex items-center justify-center h-[44px] aspect-square hover:text-white hover:bg-red-500 rounded-md trainsition duration-300" onclick="deletePageById(<?= $page['id'] ?>)"><i class="fa-solid fa-trash"></i></button>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>