<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/socials/getSocials.php";

$socials = getSocials(true);
?>

<div class="flex gap-2">
    <?php foreach ($socials as $index => $social): ?>
        <a 
        href="<?= $social['socialURL'] ?>"
        class="button flex items-center justify-center text-4xl w-[50px] aspect-square rounded-xl"
        >
        <i class="<?= $social['icon'] ?>"></i>
    </a>
    <?php endforeach; ?>
</div>