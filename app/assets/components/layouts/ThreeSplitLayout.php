<?php

/** @var array $data enthält z.B.: [ 'no1_widget_id' => 42 ] */
?>

<div class="Layout w-full h-[100px] flex gap-5" data-layout-id="<?= htmlspecialchars($layoutID) ?>"
    data-layout-type="<?= htmlspecialchars($type) ?>">
    <div class="Widget w-full h-full" data-Widget-Slot="1">
        <?php
        if (!empty($data['no1_widget_id']) && !empty($data['no1_widget_type'])) {
            $widgetId = (int) $data['no1_widget_id'];
            $widgetType = $data['no1_widget_type'];

            // Widgetdaten laden
            $widgetData = getWidgetData($widgetType, $widgetId);

            if ($widgetData) {
                // Widget-Komponenten-Datei (Pfad anpassen)
                $widgetFile = $_SERVER['DOCUMENT_ROOT'] . "/assets/components/widgets/{$widgetType}.php";

                if (file_exists($widgetFile)) {
                    include $widgetFile; // Diese Datei nutzt $widgetData zum Rendern
                } else {
                    echo "<div class='text-red-500'>Widget-Komponente nicht gefunden: " . htmlspecialchars($widgetType) . "</div>";
                }
            } else {
                echo "<div>Widget-Daten nicht gefunden</div>";
            }
        } else {
            echo "<div>Kein Widget gesetzt</div>";
        }
        ?>
    </div>
    <div class="Widget w-full h-full" data-Widget-Slot="2">
        <?php
        if (!empty($data['no2_widget_id']) && !empty($data['no2_widget_type'])) {
            $widgetId = (int) $data['no2_widget_id'];
            $widgetType = $data['no2_widget_type'];

            // Widgetdaten laden
            $widgetData = getWidgetData($widgetType, $widgetId);

            if ($widgetData) {
                // Widget-Komponenten-Datei (Pfad anpassen)
                $widgetFile = $_SERVER['DOCUMENT_ROOT'] . "/assets/components/widgets/{$widgetType}.php";

                if (file_exists($widgetFile)) {
                    include $widgetFile; // Diese Datei nutzt $widgetData zum Rendern
                } else {
                    echo "<div class='text-red-500'>Widget-Komponente nicht gefunden: " . htmlspecialchars($widgetType) . "</div>";
                }
            } else {
                echo "<div>Widget-Daten nicht gefunden</div>";
            }
        } else {
            echo "<div>Kein Widget gesetzt</div>";
        }
        ?>
    </div>
    <div class="Widget w-full h-full" data-Widget-Slot="3">
        <?php
        if (!empty($data['no3_widget_id']) && !empty($data['no3_widget_type'])) {
            $widgetId = (int) $data['no3_widget_id'];
            $widgetType = $data['no3_widget_type'];

            // Widgetdaten laden
            $widgetData = getWidgetData($widgetType, $widgetId);

            if ($widgetData) {
                // Widget-Komponenten-Datei (Pfad anpassen)
                $widgetFile = $_SERVER['DOCUMENT_ROOT'] . "/assets/components/widgets/{$widgetType}.php";

                if (file_exists($widgetFile)) {
                    include $widgetFile; // Diese Datei nutzt $widgetData zum Rendern
                } else {
                    echo "<div class='text-red-500'>Widget-Komponente nicht gefunden: " . htmlspecialchars($widgetType) . "</div>";
                }
            } else {
                echo "<div>Widget-Daten nicht gefunden</div>";
            }
        } else {
            echo "<div>Kein Widget gesetzt</div>";
        }
        ?>
    </div>
</div>