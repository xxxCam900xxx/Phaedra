<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/editor/pages/getAllPages.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/webconfig/getWebConfig.php';

$webConfig = getWebConfig();
$pages = getAllPages();
?>

<header class="h-[60px] w-full flex gap-5 pl-[10%] pr-[10%] primary-color">
    <?php if ($webConfig->WebLogoURL != null) {
        $logoURL = "";
        $logoURL = $webConfig->WebLogoURL;
    ?>
        <a href="/" class="logo h-full bg-black w-[60px]">
            <img class="w-[60px] h-[60px] object-fit" src='<?= $logoURL ?>' alt="">
        </a>
    <?php } ?>
    <nav class="flex gap-2 items-center">
        <?php

        if ($pages === false) {
            echo "Fehler beim Laden der Seiten.";
        } else {
            foreach ($pages as $page) {

        ?>
                <a
                    href="<?= $page['pathURL'] ?>"
                    class="p-2 text-lg rounded-md hover:text-white trainsition duration-300">
                    <?= $page['nav_title'] ?>
                </a>
        <?php
            }
        }

        ?>
    </nav>
</header>