<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/webconfig/getWebConfig.php';

$webConfig = getWebConfig();
?>
<footer class="min-h-[100px] bg-gray-800 text-white p-10 pl-[10%] pr-[10%] flex justify-between gap-5">

    <!-- Domain Section -->
    <div>
        <h1 class="text-4xl"><?= htmlspecialchars($webConfig->WebsiteName) ?></h1>
        <h2 class="text-lg font-semibold"><?= htmlspecialchars($webConfig->WebHostName) ?></h2>
        <p class="text-sm">Kontakt: <?= htmlspecialchars($webConfig->WebContact) ?></p>
    </div>

    <!-- Contact Section -->
    <div>
        <?php if ($webConfig->WebLogoURL != null) {
            $logoURL = "";
            $logoURL = $webConfig->WebLogoURL;
        ?>
            <img class="w-[100px] h-[100px] object-fit" src='<?= $logoURL ?>' alt="">
        <?php } ?>
    </div>

</footer>