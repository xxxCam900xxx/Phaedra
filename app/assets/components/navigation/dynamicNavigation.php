<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/editor/pages/getAllPages.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/webconfig/getWebConfig.php';

$webConfig = getWebConfig();
$pages = getAllPages();
?>

<div class="preheader h-[30px] w-full flex justify-between pl-[10%] pr-[10%] flex-wrap">
<span>What's the best thing about a Boolean? Even if you're wrong, you're only off by a bit.</span>
<span><?= $webConfig->WebContact ?></span>
</div>
<header class="h-[60px] w-full flex items-center justify-between gap-5 pl-[10%] pr-[10%]">
    <div class="flex items-center justify-between gap-5">
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
    </div>
    <a href="/admin/login" class="rounded-md cursor-pointer text-white p-1 pr-2 pl-2 h-fit">
        <?php if (isset($_SESSION['user_id'])) {
            echo "Admin";
        } else {
            echo "Login";
        }
        ?>
    </a>
</header>