<?php
$pageTitle = 'Products – Eira Store';
require_once 'includes/header.php';
$catFilter = htmlspecialchars($_GET['cat'] ?? 'all');
?>

<section id="products" style="padding-top:90px;">
    <h2>Products</h2>
    <input type="text" id="searchBox" placeholder="🔍  Search products…" oninput="searchProducts()"
        style="display:block;margin:0 auto 20px;padding:10px 18px;width:min(90%,400px);border:1px solid #ddd;border-radius:30px;font-size:15px;outline:none;">

    <div class="filter-tags">
        <button class="ftag <?= $catFilter==='all'?'active':'' ?>" data-cat="all" onclick="filterProducts('all',this)">All</button>
        <button class="ftag <?= $catFilter==='bag'?'active':'' ?>" data-cat="bag" onclick="filterProducts('bag',this)">Bags</button>
        <button class="ftag <?= $catFilter==='accessory'?'active':'' ?>" data-cat="accessory" onclick="filterProducts('accessory',this)">Accessories</button>
        <button class="ftag <?= $catFilter==='keychain'?'active':'' ?>" data-cat="keychain" onclick="filterProducts('keychain',this)">Keychains</button>
        <button class="ftag <?= $catFilter==='candle'?'active':'' ?>" data-cat="candle" onclick="filterProducts('candle',this)">Candles</button>
        <button class="ftag <?= $catFilter==='cup'?'active':'' ?>" data-cat="cup" onclick="filterProducts('cup',this)">Cups</button>
        <a href="customizeCup.php"><button class="ftag">Customize Cup</button></a>
        <a href="customizeBag.php"><button class="ftag">Customize Bag</button></a>

        
    </div>

    <div class="product-grid" id="productList">
        <p style="text-align:center;color:#aaa;padding:40px">Loading products…</p>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<script>
const INIT_CAT = '<?= $catFilter ?>';

fetch('api/products.php')
  .then(r => r.json())
  .then(data => {
    window._allProducts = data.products;
    filterProducts(INIT_CAT, document.querySelector('.ftag.active'));
  });

function searchProducts() {
  const q      = document.getElementById('searchBox').value;
  const active = document.querySelector('.ftag.active');
  const cat    = active ? active.dataset.cat : 'all';
  applyFilter(cat, q);
}

function filterProducts(cat, btn) {
  document.querySelectorAll('.ftag').forEach(t => t.classList.remove('active'));
  if (btn) btn.classList.add('active');
  applyFilter(cat, document.getElementById('searchBox').value);
}

function applyFilter(cat, q) {
  const list = window._allProducts || [];
  const filtered = list.filter(p =>
    (cat === 'all' || p.category === cat) &&
    p.name.toLowerCase().includes((q||'').toLowerCase())
  );
  renderProducts(filtered, 'productList');
}
</script>
