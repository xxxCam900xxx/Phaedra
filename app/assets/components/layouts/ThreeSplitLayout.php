<?php

/** @var array $data enthält z.B.: [ 'no1_widget_id' => 42 ] */
?>

<div class="Layout w-full h-[100px] flex gap-5" data-layout-id="<?php echo $layoutID ?>">
    <div class="Widget w-full h-full">
        <?php
        if (isset($data['no1_widget_id']))
            htmlspecialchars($data['no1_widget_id'])
        ?>
    </div>
    <div class="Widget w-full h-full">
        <?php
        if (isset($data['no2_widget_id']))
            htmlspecialchars($data['no2_widget_id'])
        ?>
    </div>
    <div class="Widget w-full h-full">
        <?php
        if (isset($data['no3_widget_id']))
            htmlspecialchars($data['no3_widget_id'])
        ?>
    </div>
</div>