<?php

/** @var array $data enthält z.B.: [ 'no1_widget_id' => 42 ] */
?>

<div class="Layout w-full h-[100px] flex bg-sky-100">
    <div class="Widget w-full h-full">
        <?= htmlspecialchars($data['no1_widget_id']) ?>
    </div>
</div>