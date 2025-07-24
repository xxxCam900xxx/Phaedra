<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/widgets/getRepoCrawler.php";

// Einstellungen
$forgejoBase = $widgetData['ForgejoURL'];
$forgejoUser = $widgetData['ForgejoUsername'];
$githubUser = $widgetData['GithubUsername'];

$repos = fetchRepos($forgejoBase, $forgejoUser, $githubUser);
?>

<h1 class="text-3xl font-bold mb-6 text-gray-800">Public Repositories</h1>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
    <?php foreach ($repos as $repo): ?>
        <div class="flex flex-col gap-2 bg-white rounded-2xl shadow-lg p-5 hover:shadow-lg transition">
            <a href="<?= htmlspecialchars($repo['url']) ?>"
                class="text-blue-600 font-semibold text-lg hover:underline block"
                target="_blank" rel="noopener noreferrer">
                <?= htmlspecialchars($repo['name']) ?>
            </a>
            <?php if (!empty($repo['description'])): ?>
                <span class="text-gray-700 text-sm">
                    <?= htmlspecialchars($repo['description']) ?>
                </span>
            <?php endif; ?>
            <?php if (!empty($repo['tags'])): ?>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($repo['tags'] as $tag): ?>
                        <span class="px-2 py-1 text-xs button rounded-full">
                            <?= htmlspecialchars($tag) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>