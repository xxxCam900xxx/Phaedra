<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/api/editor/widgets/getWidget.php"; ?>

<div class="Layout w-full flex gap-5 items-center"
    data-layout-id="<?= htmlspecialchars($layoutID) ?>"
    data-layout-type="<?= htmlspecialchars($type) ?>">

    <?php for ($i = 1; $i <= 2; $i++):
        $widgetIdKey = "no{$i}_widget_id";
        $widgetTypeKey = "no{$i}_widget_type";

        $hasWidget = !empty($data[$widgetIdKey]) && !empty($data[$widgetTypeKey]);
        $widgetId = $hasWidget ? (int)$data[$widgetIdKey] : '';
        $widgetType = $hasWidget ? htmlspecialchars($data[$widgetTypeKey]) : '';

        // Dynamische Breite je nach Layout-Typ
        $widthClass = "";
        if ($type === 'BigLeftSplitLayout') {
            $widthClass = $i === 1 ? 'w-2/3' : 'w-1/3';
        } else if ($type === "BigRightSplitLayout") {
            $widthClass = $i === 1 ? 'w-1/3' : 'w-2/3';
        }
    ?>
        <div class="Widget <?= $widthClass ?> <?php if (!$hasWidget) echo "min-h-[100px]"; ?>"
            data-widget-slot="<?= $i ?>"
            <?= $hasWidget ? "data-widget-id=\"$widgetId\" data-widget-type=\"$widgetType\"" : "" ?>>

            <?php if ($hasWidget):
                $widgetData = getWidgetData($widgetType, $widgetId);
                if ($widgetData):
                    $widgetFile = $_SERVER['DOCUMENT_ROOT'] . "/assets/components/widgets/{$widgetType}.php";
                    if (file_exists($widgetFile)):
                        include $widgetFile;
                    else: ?>
                        <div class="text-red-500">
                            Widget-Komponente nicht gefunden: <?= htmlspecialchars($widgetType) ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div>Widget-Daten nicht gefunden</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endfor; ?>

</div>