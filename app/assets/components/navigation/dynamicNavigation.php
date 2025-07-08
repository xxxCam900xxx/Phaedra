<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/editor/pages/getAllPages.php';

$pages = getAllPages();
?>

<header class="h-[60px] w-full bg-sky-300 flex gap-2">
    <div class="logo h-full"></div>
    <nav>
        <?php

        if ($pages === false) {
            echo "Fehler beim Laden der Seiten.";
        } else {
            foreach ($pages as $page) {

                ?>
                <a href="<?= $page['pathURL'] ?>"><?= $page['title'] ?></a>
                <?php
            }
        }

        ?>
    </nav>
</header>