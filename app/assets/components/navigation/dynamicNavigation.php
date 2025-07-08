<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/editor/pages/getAllPages.php';

$pages = getAllPages();
?>

<header class="h-[60px] w-full bg-sky-300 flex gap-5 pl-[10%] pr-[10%]">
    <a href="/" class="logo h-full bg-black w-[60px]"></a>
    <nav class="flex gap-2 items-center">
        <?php

        if ($pages === false) {
            echo "Fehler beim Laden der Seiten.";
        } else {
            foreach ($pages as $page) {

        ?>
                <a
                    href="<?= $page['pathURL'] ?>"
                    class="p-2 text-lg rounded-md hover:text-white hover:bg-sky-500 trainsition duration-300"
                    >
                    <?= $page['title'] ?>
                </a>
        <?php
            }
        }

        ?>
    </nav>
</header>