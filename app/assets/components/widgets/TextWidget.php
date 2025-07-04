<!-- nur Inhalt, keine äußeren divs -->
<h3><?php echo htmlspecialchars($widgetData['Titel'] ?? 'Kein Titel'); ?></h3>
<p><?php echo nl2br(htmlspecialchars($widgetData['Content'] ?? '')); ?></p>
