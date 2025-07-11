<!-- Page Structure PopUp -->
<div id="showPageStructure" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-96 relative">
        <h2 class="text-xl mb-4">Seitenstruktur</h2>
        <div class="flex flex-col gap-2" id="pageListContainer">
            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . '/api/editor/pages/getAllPages.php';
            $pages = getAllPages();

            if ($pages === false) {
                echo "Fehler beim Laden der Seiten.";
            } else {
                foreach ($pages as $page) {

            ?>
                    <div class="p-2 text-lg flex justify-between hover:bg-gray-200 rounded-md trainsition duration-300" data-id="<?= $page['id'] ?>">
                        <?= $page['nav_title'] ?>
                        <div class="flex gap-2">
                            <p class="min-w-[50px] text-center rounded-md bg-sky-300"><?= $page['sort'] ?></p>
                            <!-- Update -->
                            <button class="cursor-pointer flex items-center justify-center w-[30px] h-[30px] hover:text-white hover:bg-sky-500 rounded-md trainsition duration-300" onclick="openUpdatePagePopUp('<?= $page['id'] ?>', '<?= $page['nav_title'] ?>', '<?= $page['pathURL'] ?>', '<?= $page['page_title'] ?>', '<?= $page['meta_description'] ?>', '<?= $page['sort'] ?>')"><i class="fa-solid fa-file-pen"></i></button>
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