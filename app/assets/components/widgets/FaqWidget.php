<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/faqs/getFaqs.php";

$faqs = getFaqs(true, true);
?>

<h2 class="text-3xl font-bold mb-6">FAQs</h2>

<div id="faqAccordion">
    <?php foreach ($faqs as $index => $faq): ?>
        <?php if (!empty($faq['answer']) && $faq['isShown']): ?>
            <div class="overflow-hidden">
                <button
                    class="w-full flex justify-between items-center px-4 py-3 bg-sky-100 hover:bg-gray-50 transition font-medium text-left text-gray-800"
                    onclick="toggleFaq(<?= $index ?>)">
                    <span><?= htmlspecialchars($faq['question']) ?></span>
                    <i id="icon-<?= $index ?>" class="fas fa-chevron-down transform transition-transform duration-300"></i>
                </button>

                <div id="answer-<?= $index ?>"
                    class="faq-content bg-gray-100 max-h-0 overflow-hidden px-4 text-gray-700 transition-all duration-500">
                    <div class="py-3">
                        <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<!-- Frage stellen -->
<div class="mt-10">
    <h2 class="text-2xl font-semibold mb-3">Hast du noch Fragen?</h2>
    <form id="newFaqQuestionForm" class="space-y-4">
        <div>
            <label for="inputQuestion" class="block text-gray-700 font-medium mb-1">Deine Frage</label>
            <input type="text" name="Question"
                class="w-full border border-gray-300 px-3 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                placeholder="Stelle hier deine Frage..." required />
        </div>
        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Frage stellen</button>
    </form>
</div>

<script src="/assets/js/widgets/faqWidget.js"></script>