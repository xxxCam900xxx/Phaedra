<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/timeLines/getTimeLines.php";
$timeLines = getTimeLines();
?>

<div class="relative">
    <!-- Vertikale Linie -->
    <div class="absolute left-4 top-0 bottom-0 border-l-2 border-gray-300"></div>

    <?php foreach ($timeLines as $timeLine): ?>
        <div class="mb-5 mt-5 pl-12 relative">
            <!-- Punkt -->
            <div class="absolute left-1.5 top-3 w-5 h-5 primary-color rounded-full border-2 border-white shadow"></div>
            
            <!-- Box -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-4 relative">
                <span class="text-sm text-gray-500"><?= htmlspecialchars($timeLine['Date']) ?></span>
                <h3 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($timeLine['Title']) ?></h3>
                <p class="text-gray-600 mb-2 text-wrap break-all"><?= htmlspecialchars($timeLine['Description']) ?></p>
                <?php if (!empty($timeLine['Link'])): ?>
                    <a href="<?= htmlspecialchars($timeLine['Link']) ?>" target="_blank" class="text-2xl inline-flex items-center gap-1 absolute top-5 right-5">
                        <i class="fas fa-link"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>