<?php
header('Content-Type: application/json');

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

$conn = getConnection();

$input = json_decode(file_get_contents("php://input"), true);
$layoutId = isset($input["layoutId"]) ? (int)$input["layoutId"] : 0;

if ($layoutId <= 0) {
    echo json_encode(["success" => false, "message" => "Ungültige Layout-ID."]);
    exit;
}

// Zuerst Typ ermitteln
$stmtType = executeStatement(
    "SELECT Type FROM Layout WHERE ID = ?",
    [$layoutId],
    "i"
);
$stmtType->bind_result($type);
if (!$stmtType->fetch()) {
    echo json_encode(["success" => false, "message" => "Layout nicht gefunden."]);
    exit;
}
$stmtType->close();

// Sub-Tabelle löschen
switch ($type) {
    case "NoSplitLayout":
        executeStatement("DELETE FROM NoSplitLayout WHERE ID = ?", [$layoutId], "i")->close();
        break;
    case "TwoSplitLayout":
        executeStatement("DELETE FROM TwoSplitLayout WHERE ID = ?", [$layoutId], "i")->close();
        break;
    case "ThreeSplitLayout":
        executeStatement("DELETE FROM ThreeSplitLayout WHERE ID = ?", [$layoutId], "i")->close();
        break;
    case "BigLeftSplitLayout":
        executeStatement("DELETE FROM BigLeftSplitLayout WHERE ID = ?", [$layoutId], "i")->close();
        break;
    case "BigRightSplitLayout":
        executeStatement("DELETE FROM BigRightSplitLayout WHERE ID = ?", [$layoutId], "i")->close();
        break;
}

// Haupttabelle löschen
executeStatement("DELETE FROM Layout WHERE ID = ?", [$layoutId], "i")->close();

// Immer JSON zurückgeben
echo json_encode(["success" => true]);
exit;
