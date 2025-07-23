<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/webconfig/getWebConfig.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/socials/getSocials.php";

$socials = getSocials(true);
$webConfig = getWebConfig();
?>

<footer class="min-h-[100px] bg-gray-800 text-white p-10 pl-[10%] pr-[10%] flex justify-between gap-5">

    <!-- Domain Section -->
    <div class="flex flex-col justify-between">
        <h1 class="text-4xl"><?= htmlspecialchars($webConfig->WebsiteName) ?></h1>
        <div>
            <h2 class="text-lg font-semibold"><?= htmlspecialchars($webConfig->WebHostName) ?></h2>
            <a href="mailto:<?= htmlspecialchars($webConfig->WebContact) ?>" class="text-sm"><?= htmlspecialchars($webConfig->WebContact) ?></a>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="flex flex-col gap-5 justify-between">
        <?php if ($webConfig->WebLogoURL != null) {
            $logoURL = "";
            $logoURL = $webConfig->WebLogoURL;
        ?>
            <img class="w-[100px] h-[100px] object-fit" src='<?= $logoURL ?>' alt="">
        <?php } ?>
        <div class="flex gap-2 justify-end">
            <?php foreach ($socials as $index => $social): ?>
                <a
                    href="<?= $social['socialURL'] ?>"
                    class="flex items-center justify-center text-2xl secondary-color w-[40px] aspect-square rounded-xl">
                    <i class="<?= $social['icon'] ?>"></i>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

</footer>

<div class="footerEnd p-5 pl-[10%] pr-[10%] flex justify-center gap-5">
    <a class="text-black" href="https://github.com/xxxCam900xxx/Phaedra">Credits Phaedra</a>
</div>