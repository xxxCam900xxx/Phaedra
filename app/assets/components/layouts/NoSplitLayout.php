<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/api/editor/widgets/getWidget.php" ?>

<div class="Layout w-full min-h-[100px] flex gap-5" 
     data-layout-id="<?= htmlspecialchars($layoutID) ?>" 
     data-layout-type="<?= htmlspecialchars($type) ?>">

    <?php
    // Widget vorhanden?
    $hasWidget = !empty($data['no1_widget_id']) && !empty($data['no1_widget_type']);
    $widgetId = $hasWidget ? (int)$data['no1_widget_id'] : '';
    $widgetType = $hasWidget ? htmlspecialchars($data['no1_widget_type']) : '';
    ?>

    <div class="Widget w-full min-h-[100px]"
         data-widget-slot="1"
         <?= $hasWidget ? "data-widget-id=\"$widgetId\" data-widget-type=\"$widgetType\"" : "" ?>>
         
        <?php if ($hasWidget): ?>
            <?php
            // Widgetdaten laden
            $widgetData = getWidgetData($widgetType, $widgetId);

            if ($widgetData) {
                $widgetFile = $_SERVER['DOCUMENT_ROOT'] . "/assets/components/widgets/{$widgetType}.php";
                if (file_exists($widgetFile)) {
                    include $widgetFile;
                } else {
                    echo "<div class='text-red-500'>Widget-Komponente nicht gefunden: " . htmlspecialchars($widgetType) . "</div>";
                }
            } else {
            }
            ?>
        <?php endif; ?>
    </div>
</div>