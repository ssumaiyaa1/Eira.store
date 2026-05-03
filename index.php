<?php
$pageTitle = 'Eira Store – Handcrafted with Love';
require_once 'includes/header.php';
?>

<main>
<!-- Home Section -->
<section id="home">
    <div class="container">
        <div class="home-content">
            <div class="content-text">
                <h3><i class="fa-solid fa-heart"></i> HANDCRAFTED WITH LOVE</h3>
                <h1>Where every piece tells a story</h1>
                <p>Discover our curated collection of handmade accessories, bags, keychains, and candles — crafted with care for people who love beautiful things.</p>
                <a href="products.php">Shop Now</a>
                <a href="about.php">Our Story</a>
            </div>
            <div class="content-img">
                <img src="image/hs-image.png" alt="Eira Store Products">
                <p>Cup</p><p>Candle</p><p>Keychain</p><p>Tote Bag</p><p>Accessories</p><p>Bracelet</p>
            </div>
        </div>
        <div class="marquee-band">
            <div class="marquee-inner">
                <div class="mdot"> &hearts; Handcrafted Bags</div><div class="mdot"> &hearts; Pearl Jewelry</div>
                <div class="mdot"> &hearts; Beaded Bracelets</div><div class="mdot"> &hearts; Soy Candles</div>
                <div class="mdot"> &hearts; Heart Keychains</div><div class="mdot"> &hearts; Custom Orders</div>
                <div class="mdot"> &hearts; Handcrafted Bags</div><div class="mdot"> &hearts; Pearl Jewelry</div>
                <div class="mdot"> &hearts; Beaded Bracelets</div><div class="mdot"> &hearts; Soy Candles</div>
            </div>
        </div>
    </div>
</section>

<!-- CATEGORIES -->
<section id="categories">
    <h2>Our Categories</h2>
    <div class="cat-grid">
        <div class="cat-item" onclick="location.href='products.php?cat=bag'"><img src="image/bag.jpg" alt="Bags"><h3>Bags</h3></div>
        <div class="cat-item" onclick="location.href='products.php?cat=accessory'"><img src="image/accessories.jpg" alt="Accessories"><h3>Accessories</h3></div>
        <div class="cat-item" onclick="location.href='products.php?cat=keychain'"><img src="image/keychain.jpg" alt="Keychains"><h3>Keychains</h3></div>
        <div class="cat-item" onclick="location.href='products.php?cat=candle'"><img src="image/candle.jpg" alt="Candles"><h3>Candles</h3></div>
        <div class="cat-item" onclick="location.href='products.php?cat=cup'"><img src="image/cup.jpg" alt="Cups"><h3>Cups</h3></div>
    </div>
</section>

<!-- Featured Products -->
<section id="products">
    <h2>Featured Products</h2>
    <div class="product-grid" id="productList">
        <p style="text-align:center;color:#aaa;padding:40px">Loading products…</p>
    </div>
    <div style="text-align:center;margin-top:30px">
        <a href="products.php" class="orderBtn" style="display:inline-block;text-decoration:none;">View All Products →</a>
    </div>
</section>
</main>

<button onclick="document.location='https://www.instagram.com/eira.store/'" id="instaBtn" title="Go to Instagram">Instagram</button>

<?php require_once 'includes/footer.php'; ?>
<script>
fetch('api/products.php')
  .then(r => r.json())
  .then(data => { renderProducts(data.products.slice(0,3), 'productList'); });
</script>
