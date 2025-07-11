<h1 class="text-4xl font-semibold" data-title="<?= ($widgetData['Titel'] ?? ''); ?>">
    <?php echo htmlspecialchars($widgetData['Titel'] ?? 'Kein Titel'); ?>
</h1>
<p class="text-lg break-all" data-title="<?= ($widgetData['Content'] ?? ''); ?>">
    <?php echo nl2br(htmlspecialchars($widgetData['Content'] ?? '')); ?>
</p>