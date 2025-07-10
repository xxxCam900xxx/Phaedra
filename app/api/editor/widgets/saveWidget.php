<?php
require_once '../../config/database.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['widgetId'], $input['widgetType'], $input['widgetContent'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Fehlende Parameter']);
    exit;
}

$widgetId = (int)$input['widgetId'];
$widgetType = $input['widgetType'];
$widgetContent = $input['widgetContent'];

// Sicherheit: erlaubte Tabellen prüfen
$allowedTypes = ['TextWidget', 'ImageWidget', "RepoCrawlerWidget"];
if (!in_array($widgetType, $allowedTypes, true)) {
    echo json_encode(['success' => false, 'message' => 'Ungültiger Widget-Typ']);
    exit;
}

$conn = getConnection();

// Beispiel für TextWidget mit Spalten Titel und Content
switch ($widgetType) {
    case 'TextWidget':
        $stmt = $conn->prepare("UPDATE TextWidget SET Titel = ?, Content = ? WHERE ID = ?");
        $stmt->bind_param('ssi', $widgetContent['Title'], $widgetContent['Content'], $widgetId);
        $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => true]);
        break;
    case 'ImageWidget':
        $stmt = $conn->prepare("UPDATE ImageWidget SET ImageURL = ?, ImageDesc = ? WHERE ID = ?");
        $stmt->bind_param('ssi', $widgetContent['ImageURL'], $widgetContent['ImageDesc'], $widgetId);
        $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => true]);
        break;
    case 'RepoCrawlerWidget':
        $stmt = $conn->prepare("UPDATE RepoCrawlerWidget SET ForgejoURL = ?, ForgejoUsername = ?, GithubUsername = ? WHERE ID = ?");
        $stmt->bind_param('sssi', $widgetContent['ForgejoURL'], $widgetContent['ForgejoUsername'], $widgetContent['GithubUsername'], $widgetId);
        $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => true]);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Widget-Typ nicht implementiert']);
        break;
}

exit;
