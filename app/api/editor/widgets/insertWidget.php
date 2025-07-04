<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['layoutId'], $data['widgetType'], $data['slot'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$layoutId = (int)$data['layoutId'];
$widgetType = $data['widgetType'];
$slot = $data['slot'];

// 1️⃣ Widget erzeugen
$stmt1 = null;

if ($widgetType === "TextWidget") {
    $stmt1 = executeStatement(
        "INSERT INTO TextWidget (Content) VALUES (NULL)"
    );
} elseif ($widgetType === "ImageWidget") {
    $stmt1 = executeStatement(
        "INSERT INTO ImageWidget (ImageURL) VALUES (NULL)"
    );
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid widget type']);
    exit;
}

$newWidgetId = $stmt1->insert_id;

// 2️⃣ Layout-Detailtabelle holen (NoSplitLayout, TwoSplitLayout, ThreeSplitLayout)
$stmtLayout = executeStatement(
    "SELECT Type FROM Layout WHERE ID = ?",
    [$layoutId],
    "i"
);
$resultLayout = $stmtLayout->get_result();
$rowLayout = $resultLayout->fetch_assoc();

if (!$rowLayout) {
    http_response_code(404);
    echo json_encode(['error' => 'Layout not found']);
    exit;
}

$layoutType = $rowLayout['Type'];

// 3️⃣ Update des Slots
$tableName = "";
$columnName = "";

if ($layoutType === "NoSplitLayout") {
    $tableName = "NoSplitLayout";
    if ($slot !== "no1") {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid slot for NoSplitLayout']);
        exit;
    }
    $columnName = "No1_WidgetID";
} elseif ($layoutType === "TwoSplitLayout") {
    $tableName = "TwoSplitLayout";
    if (!in_array($slot, ["no1", "no2"])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid slot for TwoSplitLayout']);
        exit;
    }
    $columnName = ucfirst($slot) . "_WidgetID";
} elseif ($layoutType === "ThreeSplitLayout") {
    $tableName = "ThreeSplitLayout";
    if (!in_array($slot, ["no1", "no2", "no3"])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid slot for ThreeSplitLayout']);
        exit;
    }
    $columnName = ucfirst($slot) . "_WidgetID";
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Unknown layout type']);
    exit;
}

// 4️⃣ Update Statement
$stmtUpdate = executeStatement(
    "UPDATE $tableName SET $columnName = ? WHERE ID = ?",
    [$newWidgetId, $layoutId],
    "ii"
);

// Erfolg zurückgeben
echo json_encode([
    'success' => true,
    'widgetId' => $newWidgetId
]);