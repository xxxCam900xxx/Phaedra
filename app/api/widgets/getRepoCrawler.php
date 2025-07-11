<?php
function getJsonWithHeaders($url, $headers = []) {
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: PHP\r\n" . implode("\r\n", $headers)
        ]
    ];
    $context = stream_context_create($opts);
    $json = @file_get_contents($url, false, $context);
    return $json ? json_decode($json, true) : null;
}

function fetchRepos($forgejoBase, $forgejoUser, $githubUser) {
    function getJson($url) {
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "User-Agent: PHP\r\n"
            ]
        ];
        $context = stream_context_create($opts);
        $json = @file_get_contents($url, false, $context);
        return $json ? json_decode($json, true) : null;
    }

    // Forgejo Repos holen
    $forgejoUrl = "$forgejoBase/api/v1/users/$forgejoUser/repos";
    $repos = getJson($forgejoUrl);

    if (!$repos || count($repos) === 0) {
        // Fallback: GitHub
        $githubUrl = "https://api.github.com/users/$githubUser/repos";
        $repos = getJson($githubUrl);
        if (!$repos) return [];

        $result = [];
        foreach ($repos as $repo) {
            if ($repo["name"] === $githubUser) {
                // Repo-Name = Username, also überspringen
                continue;
            }

            // GitHub Topics holen
            $topicsUrl = "https://api.github.com/repos/$githubUser/{$repo['name']}/topics";
            $topics = getJsonWithHeaders($topicsUrl, [
                "Accept: application/vnd.github.mercy-preview+json"
            ]);
            $topicNames = [];
            if ($topics && isset($topics['names'])) {
                $topicNames = $topics['names'];
            }

            $result[] = [
                "name" => $repo["name"],
                "url" => $repo["html_url"],
                "description" => $repo["description"],
                "tags" => $topicNames
            ];
        }
        return $result;
    }

    // Forgejo tags separat holen
    $result = [];
    foreach ($repos as $repo) {
        if ($repo["name"] === $forgejoUser) {
            continue; // Repo-Name = Username, überspringen
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
            "name" => $repo["name"],
            "url" => $repo["html_url"],
            "description" => $repo["description"],
            "tags" => $tagNames
        ];
    }
    return $result;
}