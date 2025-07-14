<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

header("Content-Type: application/json");

// --- Input prüfen ---
$input = json_decode(file_get_contents("php://input"), true);
$requiredFields = [
    "clipboardWidgetID",
    "clipboardWidgetType",
    "clipboardWidgetSlot",
    "clipboardLayoutType",
    "clipboardLayoutId",
    "curretnWidgetSlot",
    "currentLayoutType",
    "currentLayoutId"
];

foreach ($requiredFields as $field) {
    if (!isset($input[$field]) || $input[$field] === "") {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Fehlendes Feld: $field"]);
        exit;
    }
}

// --- Werte zuweisen ---
$widgetId = (int) $input["clipboardWidgetID"];
$widgetType = $input["clipboardWidgetType"];
$oldSlot = $input["clipboardWidgetSlot"];
$oldLayoutType = $input["clipboardLayoutType"];
$oldLayoutId = (int) $input["clipboardLayoutId"];

$newSlot = $input["curretnWidgetSlot"];
$newLayoutType = $input["currentLayoutType"];
$newLayoutId = (int) $input["currentLayoutId"];

// Sicherheitsprüfung
$allowedWidgetTypes = ['TextWidget', "ImageWidget", "RepoCrawlerWidget", "FaqWidget", "TextTypingWidget", "VideoWidget", "SocialWidget", "ContactFormWidget"];
if (!in_array($widgetType, $allowedWidgetTypes, true)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Widget-Typ nicht erlaubt"]);
    exit;
}

$conn = getConnection();

// --- 1. Alten Slot auf NULL setzen ---
$oldIdField = "No{$oldSlot}_WidgetID";
$oldTypeField = "No{$oldSlot}_WidgetType";

$sqlClearOld = "UPDATE {$oldLayoutType} SET $oldIdField = NULL, $oldTypeField = NULL WHERE ID = ?";
$stmt = $conn->prepare($sqlClearOld);
$stmt->bind_param("i", $oldLayoutId);
$stmt->execute();
$stmt->close();

// --- 2. Neuen Slot setzen ---
$newIdField = "No{$newSlot}_WidgetID";
$newTypeField = "No{$newSlot}_WidgetType";

$sqlInsertNew = "UPDATE {$newLayoutType} SET $newIdField = ?, $newTypeField = ? WHERE ID = ?";
$stmt = $conn->prepare($sqlInsertNew);
$stmt->bind_param("isi", $widgetId, $widgetType, $newLayoutId);
$stmt->execute();
$stmt->close();

echo json_encode(["success" => true, "message" => "Widget verschoben"]);