<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/widgets/getRepoCrawler.php";

// Einstellungen
$forgejoBase = $widgetData['ForgejoURL'];
$forgejoUser = $widgetData['ForgejoUsername'];
$githubUser = $widgetData['GithubUsername'];

$repos = fetchRepos($forgejoBase, $forgejoUser, $githubUser);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Public Repositories</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 1rem;
            background: #f9f9f9;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill,minmax(250px,1fr));
            gap: 1rem;
        }
        .repo {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgb(0 0 0 / 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: box-shadow 0.2s ease;
        }
        .repo:hover {
            box-shadow: 0 5px 15px rgb(0 0 0 / 0.2);
        }
        .repo a {
            font-weight: bold;
            font-size: 1.1rem;
            color: #0366d6;
            text-decoration: none;
            margin-bottom: 0.5rem;
        }
        .repo a:hover {
            text-decoration: underline;
        }
        .description {
            flex-grow: 1;
            margin-bottom: 0.5rem;
            color: #444;
        }
        .tags {
            font-size: 0.9rem;
            color: #555;
        }
        .tag {
            display: inline-block;
            background: #e1ecf4;
            color: #0366d6;
            border-radius: 3px;
            padding: 2px 6px;
            margin-right: 4px;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <h1>Public Repositories</h1>
    <div class="grid">
        <?php foreach ($repos as $repo): ?>
            <div class="repo">
                <a href="<?= htmlspecialchars($repo['url']) ?>" target="_blank" rel="noopener noreferrer">
                    <?= htmlspecialchars($repo['name']) ?>
                </a>
                <?php if ($repo['description']): ?>
                    <div class="description"><?= htmlspecialchars($repo['description']) ?></div>
                <?php endif; ?>
                <?php if (!empty($repo['tags'])): ?>
                    <div class="tags">
                        <?php foreach ($repo['tags'] as $tag): ?>
                            <span class="tag"><?= htmlspecialchars($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
