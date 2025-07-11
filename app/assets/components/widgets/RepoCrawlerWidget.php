<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/widgets/getRepoCrawler.php";

// Einstellungen
$forgejoBase = $widgetData['ForgejoURL'];
$forgejoUser = $widgetData['ForgejoUsername'];
$githubUser = $widgetData['GithubUsername'];

$repos = fetchRepos($forgejoBase, $forgejoUser, $githubUser);

echo print_r($repos);
?>

<h1 class="text-3xl font-bold mb-6 text-gray-800">Public Repositories</h1>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php foreach ($repos as $repo): ?>
        <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
            <a href="<?= htmlspecialchars($repo['url']) ?>"
                class="text-blue-600 font-semibold text-lg hover:underline block mb-2"
                target="_blank" rel="noopener noreferrer">
                <?= htmlspecialchars($repo['name']) ?>
            </a>
            <?php if (!empty($repo['description'])): ?>
                <p class="text-gray-700 text-sm mb-3">
                    <?= htmlspecialchars($repo['description']) ?>
                </p>
            <?php endif; ?>
            <?php if (!empty($repo['tags'])): ?>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($repo['tags'] as $tag): ?>
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                            <?= htmlspecialchars($tag) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>