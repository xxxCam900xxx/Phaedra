<?php

function getJsonWithHeaders($url, $headers = []) {
    $allHeaders = array_merge(["User-Agent: PHP"], $headers);
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => implode("\r\n", $allHeaders)
        ]
    ];
    $context = stream_context_create($opts);
    $json = @file_get_contents($url, false, $context);
    return $json ? json_decode($json, true) : null;
}

function getJson($url) {
    return getJsonWithHeaders($url); // nur User-Agent
}

function fetchRepos($forgejoBase, $forgejoUser, $githubUser) {
    $cacheFile = __DIR__ . '/cache/repos.json';
    $cacheTTL = 60 * 60 * 12; // 12 Stunden

    // Prüfen ob Cache existiert & aktuell ist
    if (file_exists($cacheFile)) {
        $lastModified = filemtime($cacheFile);
        if ((time() - $lastModified) < $cacheTTL) {
            $cached = file_get_contents($cacheFile);
            if ($cached) {
                $decoded = json_decode($cached, true);
                if (is_array($decoded)) {
                    return $decoded;
                }
            }
        }
    }

    // === Versuche Forgejo ===
    $forgejoUrl = "$forgejoBase/api/v1/users/$forgejoUser/repos";
    $repos = getJson($forgejoUrl);

    $result = [];

    if ($repos && count($repos) > 0) {
        foreach ($repos as $repo) {
            if (strtolower($repo["name"]) === strtolower($forgejoUser)) {
                continue;
            }

            $repoName = $repo["name"];
            $tagsUrl = "$forgejoBase/api/v1/repos/$forgejoUser/$repoName/tags";
            $tags = getJson($tagsUrl);
            $tagNames = [];

            if ($tags && is_array($tags)) {
                foreach ($tags as $tag) {
                    $tagNames[] = $tag["name"];
                }
            }

            $result[] = [
                "name" => $repoName,
                "url" => $repo["html_url"],
                "description" => $repo["description"],
                "tags" => $tagNames
            ];
        }
    } else {
        // === Fallback zu GitHub ===
        $githubUrl = "https://api.github.com/users/$githubUser/repos";
        $repos = getJson($githubUrl);

        if (!$repos || !is_array($repos)) {
            return [];
        }

        foreach ($repos as $repo) {
            if (strtolower($repo["name"]) === strtolower($githubUser)) {
                continue;
            }

            $topicsUrl = "https://api.github.com/repos/$githubUser/{$repo['name']}/topics";
            $topics = getJsonWithHeaders($topicsUrl, [
                "Accept: application/vnd.github+json"
            ]);

            $topicNames = [];
            if ($topics && isset($topics['names']) && is_array($topics['names'])) {
                $topicNames = $topics['names'];
            }

            $result[] = [
                "name" => $repo["name"],
                "url" => $repo["html_url"],
                "description" => $repo["description"],
                "tags" => $topicNames
            ];
        }
    }

    // Cache speichern
    if (!is_dir(__DIR__ . '/cache')) {
        mkdir(__DIR__ . '/cache', 0777, true);
    }
    file_put_contents($cacheFile, json_encode($result, JSON_PRETTY_PRINT));

    return $result;
}