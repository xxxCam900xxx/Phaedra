<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/editor/pages/getAllPages.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/webconfig/getWebConfig.php';

$webConfig = getWebConfig();
$pages = getAllPages();
?>

<header class="h-[60px] w-full bg-sky-300 flex gap-5 pl-[10%] pr-[10%]">
    <a href="/" class="logo h-full bg-black w-[60px]">
        <?php if ($webConfig->WebLogoURL != null) {
            $logoURL = "";
            $logoURL = $webConfig->WebLogoURL;
        ?>
            <img class="w-[60px] h-[60px] object-fit" src='<?= $logoURL ?>' alt="">
        <?php } ?>
    </a>
    <nav class="flex gap-2 items-center">
        <?php

        if ($pages === false) {
            echo "Fehler beim Laden der Seiten.";
        } else {
            foreach ($pages as $page) {

        ?>
                <a
                    href="<?= $page['pathURL'] ?>"
                    class="p-2 text-lg rounded-md hover:text-white hover:bg-sky-500 trainsition duration-300">
                    <?= $page['nav_title'] ?>
                </a>
        <?php
            }
        }

        ?>
    </nav>
</header>