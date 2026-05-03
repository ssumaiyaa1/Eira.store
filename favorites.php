<?php
$pageTitle = 'Favorites – Eira Store';
require_once 'includes/auth.php';
if (!isLoggedIn()) { header('Location: login.php'); exit; }
require_once 'includes/header.php';
?>

<section style="padding:120px 40px 60px;">
    <h2 style="text-align:center;margin-bottom:6px;color:var(--ink);font-family:'Playfair Display',serif;font-size:36px;">Your Favorites</h2>
    <p style="text-align:center;color:#888;margin-bottom:36px;">Items you've saved ♥</p>
    <div class="product-grid" id="fav-grid"></div>
    <div id="fav-empty" style="text-align:center;padding:60px;color:#aaa;display:none;">
        <div style="font-size:52px;margin-bottom:16px;">♡</div>
        <p>No favorites yet.</p>
        <a href="products.php" class="orderBtn" style="display:inline-block;margin-top:16px;text-decoration:none;">Browse Products</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
<script>
async function renderFavoritesPage() {
    const grid  = document.getElementById('fav-grid');
    const empty = document.getElementById('fav-empty');
    try {
        const res  = await fetch('api/favorites.php');
        const data = await res.json();
        const favs = data.favorites || [];
        if (!favs.length) { grid.innerHTML=''; empty.style.display='block'; return; }
        empty.style.display = 'none';
        await renderProducts(favs, 'fav-grid');
    } catch(e) { empty.style.display='block'; }
}
renderFavoritesPage();
</script>
