<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/api/editor/widgets/getWidget.php"; ?>

<div class="Layout w-full min-h-[100px] flex gap-5" 
     data-layout-id="<?= htmlspecialchars($layoutID) ?>" 
     data-layout-type="<?= htmlspecialchars($type) ?>">

    <?php for ($i = 1; $i <= 3; $i++): 
        $widgetIdKey = "no{$i}_widget_id";
        $widgetTypeKey = "no{$i}_widget_type";

        $hasWidget = !empty($data[$widgetIdKey]) && !empty($data[$widgetTypeKey]);
        $widgetId = $hasWidget ? (int)$data[$widgetIdKey] : '';
        $widgetType = $hasWidget ? htmlspecialchars($data[$widgetTypeKey]) : '';
    ?>
        <div class="Widget w-full min-h-[100px]" 
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