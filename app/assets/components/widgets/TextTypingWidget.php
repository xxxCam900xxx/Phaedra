<h1 class="text-2xl font-bold text-gray-800 flex items-center">
    <span id="typingText" data-typing-list="<?= ($widgetData['RotationText'] ?? ''); ?>"></span>
    <span class="blinking-cursor">|</span>
</h1>
<p>
    <?= ($widgetData['Content'] ?? ''); ?>
</p>

<script src="/assets/js/widgets/textTypingWidget.js"></script>