<?php
$pageTitle = 'Cart – Eira Store';
require_once 'includes/auth.php';
if (!isLoggedIn()) { header('Location: login.php'); exit; }
require_once 'includes/header.php';
?>

<section style="padding:120px 40px 60px;max-width:900px;margin:auto;">
    <h2 style="font-family:'Playfair Display',serif;font-size:36px;color:rgb(74,23,122);text-align:center;margin-bottom:8px;">Your Cart</h2>
    <p style="text-align:center;color:#aaa;margin-bottom:36px;">Review your items before ordering</p>

    <div id="cartPageItems"></div>

    <div id="cartPageEmpty" style="text-align:center;padding:60px;color:#aaa;display:none;">
        <div style="font-size:52px;margin-bottom:16px;"><i class="fa-solid fa-basket-shopping" style="color:rgb(70,28,97);"></i></div>
        <p>Your cart is empty.</p>
        <a href="products.php" class="orderBtn" style="display:inline-block;margin-top:16px;text-decoration:none;">Shop Now</a>
    </div>

    <div id="cartPageFooter" style="display:none;margin-top:30px;border-top:2px solid #f0e8ff;padding-top:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <span style="font-size:22px;font-weight:600;">Total:</span>
            <span id="cartPageTotal" style="font-size:24px;font-weight:700;color:rgb(74,23,122);"></span>
        </div>
        <button class="orderBtn" onclick="doCartCheckout()" style="width:100%;font-size:16px;padding:14px;">Place Order →</button>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<script>
let cartData = [];

async function renderCartPage() {
    const items  = document.getElementById('cartPageItems');
    const empty  = document.getElementById('cartPageEmpty');
    const foot   = document.getElementById('cartPageFooter');

    try {
        const res  = await fetch('api/cart.php');
        const data = await res.json();
        cartData   = data.items || [];
    } catch(e) { cartData = []; }

    if (!cartData.length) {
        items.innerHTML = '';
        empty.style.display = 'block';
        foot.style.display  = 'none';
        document.querySelectorAll('#cartCount').forEach(el => el.textContent = 0);
        return;
    }

    empty.style.display = 'none';
    foot.style.display  = 'block';

    const total = cartData.reduce((s, i) => s + i.price * i.quantity, 0);
    document.getElementById('cartPageTotal').textContent = '$' + total.toFixed(2);
    const count = cartData.reduce((s, i) => s + i.quantity, 0);
    document.querySelectorAll('#cartCount').forEach(el => el.textContent = count);

    items.innerHTML = cartData.map(item => `
      <div style="display:flex;gap:16px;align-items:center;padding:18px;border-bottom:1px solid #f0e8ff;flex-wrap:wrap;">
        <img src="${item.img}" alt="${escHtml(item.name)}"
             style="width:80px;height:80px;object-fit:cover;border-radius:10px;flex-shrink:0;">
        <div style="flex:1;min-width:160px;">
          <div style="font-weight:600;font-size:16px;">${escHtml(item.name)}</div>
          <div style="color:#888;font-size:14px;margin-top:3px;">$${item.price.toFixed(2)} each</div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
          <button class="cqty-btn" onclick="changeQty(${item.product_id},-1)">−</button>
          <span style="font-size:16px;font-weight:600;min-width:24px;text-align:center;">${item.quantity}</span>
          <button class="cqty-btn" onclick="changeQty(${item.product_id},1)">+</button>
          <span style="font-weight:600;min-width:60px;text-align:right;color:rgb(74,23,122);">$${(item.price*item.quantity).toFixed(2)}</span>
          <button class="crm-btn" onclick="removeItem(${item.product_id})">✕</button>
        </div>
      </div>`).join('');
}

async function changeQty(productId, delta) {
    const item = cartData.find(i => i.product_id === productId);
    if (!item) return;
    const newQty = item.quantity + delta;
    await fetch('api/cart.php', {
        method: 'PUT',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify({ product_id: productId, quantity: newQty })
    });
    renderCartPage();
}

async function removeItem(productId) {
    await fetch('api/cart.php', {
        method: 'DELETE',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify({ product_id: productId })
    });
    renderCartPage();
}

function doCartCheckout() {
    if (!cartData.length) return;
    openCartCheckout(cartData);
}

renderCartPage();
</script>
