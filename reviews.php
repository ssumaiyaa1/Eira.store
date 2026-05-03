<?php
$pageTitle = 'Reviews – Eira Store';
require_once 'includes/header.php';
require_once 'includes/db.php';

$db = getDB();

// Aggregate stats
$stats = $db->query(
    'SELECT COUNT(*) AS total,
            AVG(rating) AS avg_rating,
            SUM(rating=5) AS r5,
            SUM(rating=4) AS r4,
            SUM(rating=3) AS r3,
            SUM(rating=2) AS r2,
            SUM(rating=1) AS r1
     FROM reviews'
)->fetch();

$total     = (int)$stats['total'];
$avgRating = $total ? round((float)$stats['avg_rating'], 1) : 0;

function pct($count, $total) {
    return $total > 0 ? round(($count / $total) * 100) : 0;
}

// Fetch products for dropdown
$products = $db->query('SELECT name FROM products ORDER BY name')->fetchAll(PDO::FETCH_COLUMN);
?>

<section id="review" style="padding-top: 80px ;
    background: linear-gradient(to right, #f3e9ff, #ffffff);">
    <h2 style="padding: 40px 0 10px 0;
    font-size: 40px;
    letter-spacing: 1.1;
    color: rgb(74, 23, 122);
    margin-bottom: 20px;
    text-align: center;
    font-family:'Playfair Display',serif;  ">Customer Reviews</h2>

    <!-- Summary -->
    <div class="reviews-summary">
        <div class="rating-big">
            <span class="rating-num"><?= $avgRating ?></span>
            <div class="rating-stars-big"><?= str_repeat('★', round($avgRating)) . str_repeat('☆', 5 - round($avgRating)) ?></div>
            <span class="rating-count">Based on <?= $total ?> review<?= $total !== 1 ? 's' : '' ?></span>
        </div>
        <div class="rating-bars">
            <?php foreach ([5,4,3,2,1] as $star): ?>
            <div class="rbar-row">
                <span><?= $star ?>★</span>
                <div class="rbar"><div class="rbar-fill" style="--w:<?= pct($stats["r{$star}"], $total) ?>%"></div></div>
                <span><?= pct($stats["r{$star}"], $total) ?>%</span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Reviews Grid (loaded via JS) -->
    <div class="reviews-grid" id="reviewsGrid">
        <p>Loading reviews…</p>
    </div>

    <div>
        <button class="orderBtn" onclick="openReviewForm()" style="align-itme:center;margin:40px 45%; width:max-content"><i class="fa-solid fa-pen" style="color: rgb(255, 255, 255);"></i> Write a Review</button>
    </div>
</section>

<!-- Review Modal -->
<div id="reviewModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:36px;border-radius:16px;width:min(90%,480px);position:relative;">
        <button onclick="closeReviewForm()" style="position:absolute;top:12px;right:16px;background:none;border:none;font-size:20px;cursor:pointer;">✕</button>
        <h2 style="color:rgb(74,23,122);margin-bottom:20px;">Write a Review</h2>
        <div id="reviewFormMsg" style="display:none;padding:10px;border-radius:8px;margin-bottom:14px;text-align:center;"></div>
        <label style="display:block;margin-bottom:6px;font-weight:500;">Your Name</label>
        <input type="text" id="rv-name" placeholder="Your name" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;margin-bottom:14px;box-sizing:border-box;">
        <label style="display:block;margin-bottom:6px;font-weight:500;">Product</label>
        <select id="rv-product" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;margin-bottom:14px;box-sizing:border-box;">
            <option value="">Select a product…</option>
            <?php foreach ($products as $p): ?>
            <option value="<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></option>
            <?php endforeach; ?>
        </select>
        <label style="display:block;margin-bottom:6px;font-weight:500;">Rating</label>
        <div id="starPicker" style="font-size:28px;margin-bottom:14px;cursor:pointer;color:#ddd;">
            <span data-val="1">★</span><span data-val="2">★</span><span data-val="3">★</span><span data-val="4">★</span><span data-val="5">★</span>
        </div>
        <input type="hidden" id="rv-rating" value="0">
        <label style="display:block;margin-bottom:6px;font-weight:500;">Your Review</label>
        <textarea id="rv-text" rows="4" placeholder="Share your experience…" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;margin-bottom:14px;resize:vertical;box-sizing:border-box;"></textarea>
        <button class="orderBtn" onclick="submitReview()" style="width:100%;">Submit Review</button>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<script>
// Load reviews from DB
function loadReviews() {
    fetch('api/reviews.php')
      .then(r => r.json())
      .then(data => {
        const grid = document.getElementById('reviewsGrid');
        if (!data.reviews.length) {
            grid.innerHTML = '<p style="text-align:center;color:#aaa">No reviews yet. Be the first!</p>';
            return;
        }
        grid.innerHTML = data.reviews.map(r => `
          <div class="review-card">
            <div class="review-top">
              <div class="review-avatar">${r.reviewer_name[0].toUpperCase()}</div>
              <div>
                <div class="review-name">${escHtml(r.reviewer_name)}</div>
                <div class="review-date">${r.date}</div>
                <div class="review-product-lbl">✦ ${escHtml(r.product_name)}</div>
              </div>
            </div>
            <div class="review-stars">${'★'.repeat(r.rating)}${'☆'.repeat(5-r.rating)}</div>
            <div class="review-text">${escHtml(r.review_text)}</div>
          </div>`).join('');
    });
}
loadReviews();

function openReviewForm()  { document.getElementById('reviewModal').style.display='flex'; }
function closeReviewForm() { document.getElementById('reviewModal').style.display='none'; }

// Star picker
document.querySelectorAll('#starPicker span').forEach(star => {
    star.addEventListener('click', () => {
        const val = parseInt(star.dataset.val);
        document.getElementById('rv-rating').value = val;
        document.querySelectorAll('#starPicker span').forEach((s,i) => {
            s.style.color = i < val ? '#f59e0b' : '#ddd';
        });
    });
    star.addEventListener('mouseenter', () => {
        const val = parseInt(star.dataset.val);
        document.querySelectorAll('#starPicker span').forEach((s,i) => s.style.color = i < val ? '#f59e0b' : '#ddd');
    });
});
document.getElementById('starPicker').addEventListener('mouseleave', () => {
    const cur = parseInt(document.getElementById('rv-rating').value) || 0;
    document.querySelectorAll('#starPicker span').forEach((s,i) => s.style.color = i < cur ? '#f59e0b' : '#ddd');
});

async function submitReview() {
    const name    = document.getElementById('rv-name').value.trim();
    const product = document.getElementById('rv-product').value;
    const rating  = parseInt(document.getElementById('rv-rating').value);
    const text    = document.getElementById('rv-text').value.trim();

    if (!name || !product || !rating || !text) { showToast('Please fill in all fields ✏️'); return; }

    const res  = await fetch('api/reviews.php', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify({ reviewer_name: name, product_name: product, rating, review_text: text })
    });
    const data = await res.json();

    const msg = document.getElementById('reviewFormMsg');
    msg.style.display = 'block';
    if (data.success) {
        msg.style.background='#f0fdf4'; msg.style.color='#166534'; msg.style.border='1px solid #bbf7d0';
        msg.textContent = data.message;
        setTimeout(() => { closeReviewForm(); loadReviews(); }, 1500);
    } else {
        msg.style.background='#fef2f2'; msg.style.color='#991b1b'; msg.style.border='1px solid #fecaca';
        msg.textContent = data.error;
    }
}

function escHtml(s) {
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>
