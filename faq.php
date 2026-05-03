<?php
// FIXED: viewport meta was broken: width=\, initial-scale=1.0
$pageTitle = 'FAQ – Eira Store';
require_once 'includes/header.php';
?>

<section id="page-faq">
    <div >
        <h2>Frequently Asked Questions</h2>
        <p style="color:#888;">Everything you need to know before ordering</p>
    </div>

    <div class="faq-wrap">
        <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">How long does delivery take? <span class="faq-icon">+</span></div>
            <div class="faq-a">We process orders within 1–2 business days. Delivery takes 3–7 days depending on your location. You'll receive a confirmation message once your order ships.</div>
        </div>
        <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">Can I customise my order? <span class="faq-icon">+</span></div>
            <div class="faq-a">Yes! Many products can be personalised. Leave a note at checkout or message us on Instagram @eira.store and we'll be happy to help.</div>
        </div>
        <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">What payment methods do you accept? <span class="faq-icon">+</span></div>
            <div class="faq-a">We accept cash on delivery, bank transfer, and digital wallets. Select your preferred method at checkout.</div>
        </div>
        <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">Do you offer gift wrapping? <span class="faq-icon">+</span></div>
            <div class="faq-a">Yes! All products come beautifully packaged. We offer special gift wrapping on request — just mention it in your order notes.</div>
        </div>
        <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">What is your return policy? <span class="faq-icon">+</span></div>
            <div class="faq-a">If there's an issue with your order, contact us within 3 days of receiving it and we'll do our best to make it right.</div>
        </div>
        <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">Are your products truly handmade? <span class="faq-icon">+</span></div>
            <div class="faq-a">Absolutely. Every single item is crafted by hand with care. Each piece is slightly unique — which makes it all the more special!</div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
