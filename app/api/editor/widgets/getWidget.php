<?php
function getWidgetData(string $widgetType, int $widgetId): ?array {
    // Liste erlaubter Widget-Tabellen (Sicherheit)
    $allowedTypes = ['TextWidget', /* weitere hier */];

    if (!in_array($widgetType, $allowedTypes, true)) {
        return null;
    }

    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM {$widgetType} WHERE ID = ?");
    $stmt->bind_param("i", $widgetId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    return $data ?: null;
}
