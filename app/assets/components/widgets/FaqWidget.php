<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/api/faqs/getFaqs.php";

$faqs = getFaqs(true, true);
?>

<h1 class="text-3xl font-bold mb-6">FAQs</h1>

<div id="faqAccordion">
    <?php foreach ($faqs as $index => $faq): ?>
        <?php if (!empty($faq['answer']) && $faq['isShown']): ?>
            <div class="overflow-hidden">
                <button
                    class="w-full flex justify-between items-center px-4 py-3 border-b hover:bg-gray-50 transition font-medium text-left text-2xl"
                    onclick="toggleFaq(<?= $index ?>)">
                    <span><?= htmlspecialchars($faq['question']) ?></span>
                    <i id="icon-<?= $index ?>" class="fas fa-chevron-down transform transition-transform duration-300"></i>
                </button>

                <div id="answer-<?= $index ?>"
                    class="faq-content max-h-0 overflow-hidden px-4 transition-all duration-500">
                    <div class="py-3">
                        <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<!-- Frage stellen -->
<div class="mt-10 bg-gray-100 rounded-lg p-10 flex flex-row justify-around items-center gap-10 w-fit">
    <div class="w-1/2">
        <h2 class="text-2xl font-semibold mb-3">Hast du noch Fragen?</h2>
        <form id="newFaqQuestionForm" class="space-y-4">
            <div>
                <input type="text" name="Question"
                    class="w-full border border-gray-300 bg-white px-3 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                    placeholder="Stelle hier deine Frage..." required />
            </div>
            <button type="submit"
                class="button px-4 py-2 rounded-md transition">Frage stellen</button>
        </form>
    </div>
    <div class="w-1/2">
        <h2>Bla Bla Bla</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium id eligendi iure incidunt, adipisci doloribus placeat libero. Similique laudantium recusandae quisquam totam impedit dolores ducimus veritatis cumque minus, cum praesentium rerum blanditiis, molestiae error assumenda! Eius inventore odit id, vel, ducimus alias distinctio fuga repellat voluptatum a nobis praesentium impedit!</p>
    </div>
</div>

<script src="/assets/js/widgets/faqWidget.js"></script>