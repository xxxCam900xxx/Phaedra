<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";
$conn = getConnection();

function getLayoutsByPageContent($pageContentId)
{
    global $conn;

    $stmt = $conn->prepare("SELECT ID, Type, Sort FROM Layout WHERE PageContentID = ? ORDER BY Sort ASC");
    $stmt->bind_param("i", $pageContentId);
    $stmt->execute();
    $result = $stmt->get_result();

    $layouts = [];
    while ($row = $result->fetch_assoc()) {
        $layoutId = (int)$row['ID'];
        $type = $row['Type'];
        $sort = (int)$row['Sort'];
        $data = [];

        switch ($type) {
            case 'NoSplitLayout':
                $stmtDetail = $conn->prepare("SELECT No1_WidgetID, No1_WidgetType FROM NoSplitLayout WHERE ID = ?");
                $stmtDetail->bind_param("i", $layoutId);
                $stmtDetail->execute();
                $resDetail = $stmtDetail->get_result();
                $detailRow = $resDetail->fetch_assoc();
                if ($detailRow) {
                    $data = [
                        'no1_widget_id' => $detailRow['No1_WidgetID'],
                        'no1_widget_type' => $detailRow['No1_WidgetType']
                    ];
                } else {
                    $data = [];
                }
                $stmtDetail->close();
                break;

            case 'TwoSplitLayout':
                $stmtDetail = $conn->prepare("SELECT No1_WidgetID, No1_WidgetType, No2_WidgetID, No2_WidgetType FROM TwoSplitLayout WHERE ID = ?");
                $stmtDetail->bind_param("i", $layoutId);
                $stmtDetail->execute();
                $resDetail = $stmtDetail->get_result();
                $detailRow = $resDetail->fetch_assoc();
                if ($detailRow) {
                    $data = [
                        'no1_widget_id' => $detailRow['No1_WidgetID'],
                        'no1_widget_type' => $detailRow['No1_WidgetType'],
                        'no2_widget_id' => $detailRow['No2_WidgetID'],
                        'no2_widget_type' => $detailRow['No2_WidgetType']
                    ];
                } else {
                    $data = [];
                }
                $stmtDetail->close();
                break;

            case 'ThreeSplitLayout':
                $stmtDetail = $conn->prepare("SELECT No1_WidgetID, No1_WidgetType, No2_WidgetID, No2_WidgetType, No3_WidgetID, No3_WidgetType FROM ThreeSplitLayout WHERE ID = ?");
                $stmtDetail->bind_param("i", $layoutId);
                $stmtDetail->execute();
                $resDetail = $stmtDetail->get_result();
                $detailRow = $resDetail->fetch_assoc();
                if ($detailRow) {
                    $data = [
                        'no1_widget_id' => $detailRow['No1_WidgetID'],
                        'no1_widget_type' => $detailRow['No1_WidgetType'],
                        'no2_widget_id' => $detailRow['No2_WidgetID'],
                        'no2_widget_type' => $detailRow['No2_WidgetType'],
                        'no3_widget_id' => $detailRow['No3_WidgetID'],
                        'no3_widget_type' => $detailRow['No3_WidgetType']
                    ];
                } else {
                    $data = [];
                }
                $stmtDetail->close();
                break;
        }

        $layouts[] = [
            'id' => $layoutId,
            'type' => $type,
            'sort' => $sort,
            'data' => $data
        ];
    }
    $stmt->close();
    return $layouts;
}