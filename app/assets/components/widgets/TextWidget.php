<h1 class="text-4xl font-semibold">
    <?php echo htmlspecialchars($widgetData['Titel'] ?? 'Kein Titel'); ?>
</h1>
<p class="text-lg">
    <?php echo nl2br(htmlspecialchars($widgetData['Content'] ?? '')); ?>
</p>