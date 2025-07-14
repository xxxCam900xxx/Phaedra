<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

/**
 * Holt Widget-Daten aus der Datenbank
 */
function getWidgetData(string $widgetType, int $widgetId): ?array
{
    $allowedTypes = ['TextWidget', "ImageWidget", "RepoCrawlerWidget", "FaqWidget", "TextTypingWidget", "VideoWidget"];

    if (!in_array($widgetType, $allowedTypes, true)) {
        return null;
    }

    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM {$widgetType} WHERE ID = ?");
    if (!$stmt) return null;

    $stmt->bind_param("i", $widgetId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    return $data ?: null;
}

// Falls Datei direkt aufgerufen wird (z.B. per Fetch)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input["widgetId"], $input["widgetType"])) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "Fehlende Parameter"
        ]);
        exit;
    }

    $widgetId = (int) $input["widgetId"];
    $widgetType = $input["widgetType"];

    $data = getWidgetData($widgetType, $widgetId);

    if (!$data) {
        http_response_code(404);
        echo json_encode([
            "success" => false,
            "message" => "Widget nicht gefunden"
        ]);
        exit;
    }

    // Spezifisches Format je nach Typ
    $formatted = [];

    switch ($widgetType) {
        case "TextWidget":
            $formatted = [
                "Title" => $data["Titel"] ?? "",
                "Content" => $data["Content"] ?? ""
            ];
            break;

        case "ImageWidget":
            $formatted = [
                "ImageURL" => $data["ImageURL"] ?? "",
                "ImageDesc" => $data["ImageDesc"] ?? ""
            ];
            break;

        case "RepoCrawlerWidget":
            $formatted = [
                "ForgejoURL" => $data["ForgejoURL"] ?? "",
                "ForgejoUsername" => $data["ForgejoUsername"] ?? "",
                "GithubUsername" => $data["GithubUsername"] ?? ""
            ];
            break;

        case "FaqWidget":
            break;

        case "TextTypingWidget":
            $formatted = [
                "RotationText" => $data["RotationText"] ?? "",
                "Content" => $data["Content"] ?? ""
            ];
            break;

        case "VideoWidget":
            $formatted = [
                "VideoURL" => $data["VideoURL"] ?? "",
                "VideoDesc" => $data["VideoDesc"] ?? ""
            ];
            break;

        default:
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Unbekannter Widget-Typ"
            ]);
            exit;
    }

    echo json_encode([
        "success" => true,
        "content" => $formatted
    ]);
    exit;
}
