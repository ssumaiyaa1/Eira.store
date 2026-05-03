<?php
// FIXED: title was "Eire" (typo), image path used backslash image\lightpur.jpg
$pageTitle = 'About – Eira Store';
require_once 'includes/header.php';
?>

<section id="about">
    <div class="about-container">
        <h2>Our History</h2>
        <!-- FIXED: was image\lightpur.jpg (backslash, breaks on web) -->
        <img class="about-img" src="image/lightpur.jpg" alt="Eira Workshop">

        <div class="timeline">
            <div class="timeline-item">
                <h3>2021 – Private Orders</h3>
                <p>We started offering custom handcrafted items to close friends and family.</p>
            </div>
            <div class="timeline-item">
                <h3>2023 – Online Launch</h3>
                <p>Eira Store officially moved online and started serving customers nationwide.</p>
            </div>
            <div class="timeline-item">
                <h3>2024 &amp; 2025 – Product Expansion</h3>
                <p>We added new categories such as accessories, candles, and customized keychains.</p>
            </div>
            <div class="timeline-item">
                <h3>2026 – The Future</h3>
                <p>More collections, more stories, and a bigger community of people who believe handmade is always better.</p>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
