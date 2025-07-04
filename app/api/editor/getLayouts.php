<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";
$conn = getConnection();

function getLayoutsByPageContent($pageContentId) {
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
                $stmtDetail = $conn->prepare("SELECT No1_WidgetID FROM NoSplitLayout WHERE ID = ?");
                $stmtDetail->bind_param("i", $layoutId);
                $stmtDetail->execute();
                $resDetail = $stmtDetail->get_result();
                $detailRow = $resDetail->fetch_assoc();
                $data = ['no1_widget_id' => $detailRow['No1_WidgetID']];
                $stmtDetail->close();
                break;

            case 'TwoSplitLayout':
                $stmtDetail = $conn->prepare("SELECT Left_WidgetID, Right_WidgetID FROM TwoSplitLayout WHERE ID = ?");
                $stmtDetail->bind_param("i", $layoutId);
                $stmtDetail->execute();
                $resDetail = $stmtDetail->get_result();
                $detailRow = $resDetail->fetch_assoc();
                $data = [
                    'left_widget_id' => $detailRow['Left_WidgetID'],
                    'right_widget_id' => $detailRow['Right_WidgetID']
                ];
                $stmtDetail->close();
                break;

            case 'ThreeSplitLayout':
                $stmtDetail = $conn->prepare("SELECT One_WidgetID, Two_WidgetID, Three_WidgetID FROM ThreeSplitLayout WHERE ID = ?");
                $stmtDetail->bind_param("i", $layoutId);
                $stmtDetail->execute();
                $resDetail = $stmtDetail->get_result();
                $detailRow = $resDetail->fetch_assoc();
                $data = [
                    'one_widget_id' => $detailRow['One_WidgetID'],
                    'two_widget_id' => $detailRow['Two_WidgetID'],
                    'three_widget_id' => $detailRow['Three_WidgetID']
                ];
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