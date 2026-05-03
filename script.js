/* =========================================================
   EIRA STORE — script.js
   ========================================================= */

// ─── NAVBAR: highlight active link ──────────────────────
(function() {
  const path = window.location.pathname.split('/').pop() || 'index.php';
  document.querySelectorAll('nav a').forEach(link => {
    const href = link.getAttribute('href') || '';
    if (href && href !== '#' && path.includes(href.replace(/^\.\//, ''))) {
      link.classList.add('active');
    }
  });
})();

// ─── FAQ TOGGLE ──────────────────────────────────────────
function toggleFaq(el) {
  const item = el.parentElement;
  const open = item.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
  if (!open) item.classList.add('open');
}

// ─── CART — DB-backed (login required) ──────────────────
async function addToCartById(productId, name, price) {
  if (!IS_LOGGED_IN) {
    showToast('Please login to add to cart 💜');
    setTimeout(() => location.href = 'login.php', 1200);
    return;
  }
  try {
    const res = await fetch('api/cart.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify({ product_id: productId, quantity: 1 })
    });
    const data = await res.json();
    if (data.success) {
      showToast(`"${name}" added to cart 🛍️`);
      bumpBadge();
      await refreshCartCount();
    } else {
      showToast(data.error || 'Could not add to cart');
    }
  } catch(e) { showToast('Network error'); }
}

async function refreshCartCount() {
  if (!IS_LOGGED_IN) return;
  try {
    const res  = await fetch('api/cart.php');
    const data = await res.json();
    const count = (data.items || []).reduce((s, i) => s + i.quantity, 0);
    document.querySelectorAll('#cartCount').forEach(el => el.textContent = count);
  } catch(e) {}
}

// ─── FAVORITES — DB-backed (login required) ─────────────
async function toggleFavorite(productId, btn) {
  if (!IS_LOGGED_IN) {
    showToast('Please login to save favorites 💜');
    setTimeout(() => location.href = 'login.php', 1200);
    return;
  }
  try {
    const res  = await fetch('api/favorites.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify({ product_id: productId })
    });
    const data = await res.json();
    if (data.success) {
      const added = data.action === 'added';
      if (btn) {
        btn.classList.toggle('liked', added);
        btn.textContent = added ? '♥' : '♡';
        if (added) { btn.style.transform='scale(1.4)'; setTimeout(()=>btn.style.transform='',300); }
      }
      showToast(added ? '♥ Saved to favorites' : 'Removed from favorites');
      await refreshFavCount();
      if (typeof renderFavoritesPage === 'function') renderFavoritesPage();
    }
  } catch(e) { showToast('Network error'); }
}

async function refreshFavCount() {
  if (!IS_LOGGED_IN) return;
  try {
    const res  = await fetch('api/favorites.php');
    const data = await res.json();
    const count = (data.ids || []).length;
    document.querySelectorAll('#favCount').forEach(el => el.textContent = count);
  } catch(e) {}
}

// ─── RENDER PRODUCT GRID ────────────────────────────────
async function renderProducts(products, containerId) {
  const grid = document.getElementById(containerId);
  if (!grid) return;

  let favIds = [];
  if (IS_LOGGED_IN) {
    try {
      const res  = await fetch('api/favorites.php');
      const data = await res.json();
      favIds = data.ids || [];
    } catch(e) {}
  }

  if (!products.length) {
    grid.innerHTML = '<p style="text-align:center;color:#888;padding:40px">No products found.</p>';
    return;
  }
  grid.innerHTML = products.map(p => `
    <div class="product" data-id="${p.id}" data-category="${p.category}">
      ${p.badge ? `<div class="prod-badge ${p.badge_type || ''}">${p.badge}</div>` : ''}
      <img src="${p.img}" alt="${escHtml(p.name)}" onclick="openProductModal(${p.id})" style="cursor:pointer">
      <h3 onclick="openProductModal(${p.id})" style="cursor:pointer">${escHtml(p.name)}</h3>
      <div class="product-price" style="padding-left: 20px;">$${parseFloat(p.price).toFixed(2  )}</div>
      <p class="product-desc-short">${escHtml(p.description)}</p>
      <div class="product-actions-row">
        <button class="like-btn ${favIds.includes(p.id)?'liked':''}" onclick="toggleFavorite(${p.id},this)">${favIds.includes(p.id)?'♥':'♡'}</button>
        <button class="orderBtn cart-btn" style="font-size:13px;padding:8px 12px" onclick="addToCartById(${p.id},'${escHtml(p.name)}',${p.price})">🛒 Add to Cart</button>
      </div>
    </div>`).join('');
}

// ─── PRODUCT DETAIL MODAL ────────────────────────────────
async function openProductModal(id) {
  let favIds = [];
  if (IS_LOGGED_IN) {
    try { const r = await fetch('api/favorites.php'); const d = await r.json(); favIds = d.ids||[]; } catch(e){}
  }
  try {
    const res  = await fetch('api/products.php');
    const data = await res.json();
    const p    = data.products.find(x => x.id === id);
    if (!p) return;
    const isFav = favIds.includes(id);

    document.getElementById('productModal')?.remove();
    const modal = document.createElement('div');
    modal.id = 'productModal';
    modal.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9998;display:flex;align-items:center;justify-content:center;padding:20px;';
    modal.innerHTML = `
      <div style="background:#fff;border-radius:20px;width:min(90vw,820px);max-height:90vh;overflow-y:auto;padding:36px;position:relative;">
        <button onclick="document.getElementById('productModal').remove()" style="position:absolute;top:16px;right:20px;background:none;border:none;font-size:22px;cursor:pointer;color:#888">✕</button>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:36px;">
          <div>
            <img src="${p.img}" alt="${escHtml(p.name)}" style="width:100%;border-radius:14px;object-fit:cover;max-height:320px;">
          </div>
          <div>
            <span style="background:#f0e8ff;color:rgb(86, 23, 122);font-size:12px;padding:4px 12px;border-radius:20px;">${p.category.charAt(0).toUpperCase()+p.category.slice(1)}</span>
            <h2 style="font-family:'Playfair Display',serif;margin:12px 0 6px;">${escHtml(p.name)}</h2>
            <div style="font-size:22px;font-weight:700;color:rgb(86, 23, 122); padding-left:5px; ">$${parseFloat(p.price).toFixed(2)}</div>
            <div style="color:#f59e0b;font-size:18px;margin-bottom:16px;">${'★'.repeat(Math.round(p.rating))}${'☆'.repeat(5-Math.round(p.rating))} <span style="color:#888;font-size:14px;">${p.rating} · ${p.review_count} reviews</span></div>
            <p style="color:#555;line-height:1.7;margin-bottom:18px;">${escHtml(p.desc_long)}</p>
            <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:22px;">
              ${(p.features||[]).map(f=>`<span style="background:#faf7ff;border:1px solid #e0d6f5;padding:5px 12px;border-radius:20px;font-size:13px;color:rgb(74,23,122);">✓ ${escHtml(f)}</span>`).join('')}
            </div>
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
              <button onclick="this.nextElementSibling.textContent=Math.max(1,parseInt(this.nextElementSibling.textContent)-1)" style="width:32px;height:32px;border-radius:50%;border:1px solid #ddd;font-size:18px;cursor:pointer;background:#fff;">−</button>
              <span id="pm-qty" style="font-size:18px;font-weight:600;min-width:24px;text-align:center;">1</span>
              <button onclick="this.previousElementSibling.textContent=parseInt(this.previousElementSibling.textContent)+1" style="width:32px;height:32px;border-radius:50%;border:1px solid #ddd;font-size:18px;cursor:pointer;background:#fff;">+</button>
            </div>
            <div style="display:flex;gap:10px;">
              <button class="orderBtn" style="flex:1;padding:12px;" onclick="pmAddToCart(${p.id},'${escHtml(p.name)}',${p.price})">🛒 Add to Cart</button>
              <button class="like-btn ${isFav?'liked':''}" id="pm-fav-btn" onclick="toggleFavorite(${p.id},this)" style="padding:12px 16px;">${isFav?'♥':'♡'}</button>
            </div>
          </div>
        </div>
      </div>`;
    document.body.appendChild(modal);
    modal.addEventListener('click', e => { if (e.target === modal) modal.remove(); });
  } catch(e) {}
}

function pmAddToCart(id, name, price) {
  const qty = parseInt(document.getElementById('pm-qty')?.textContent || 1);
  for (let i = 0; i < qty; i++) addToCartById(id, name, price);
}

// ─── ORDER FORM ──────────────────────────────────────────
// Opens with a list of products [{product_id, name, price, quantity}]
function openOrderForm(products) {
  if (!IS_LOGGED_IN) {
    showToast('Please login to place an order 💜');
    setTimeout(() => location.href = 'login.php', 1200);
    return;
  }
  const popup = document.getElementById('popupForm');
  if (!popup) return;
  popup.style.display = 'flex';

  // Populate summary
  const summaryBox   = document.getElementById('orderSummaryBox');
  const summaryItems = document.getElementById('orderSummaryItems');
  const summaryTotal = document.getElementById('orderSummaryTotal');
  if (summaryBox && products && products.length) {
    summaryBox.style.display = 'block';
    let total = 0;
    summaryItems.innerHTML = products.map(p => {
      const line = p.price * p.quantity;
      total += line;
      return `<div style="display:flex;justify-content:space-between;font-size:13px;padding:3px 0;">
        <span>${escHtml(p.name)} × ${p.quantity}</span>
        <span>$${line.toFixed(2)}</span>
      </div>`;
    }).join('');
    summaryTotal.textContent = '$' + total.toFixed(2);
  } else if (summaryBox) {
    summaryBox.style.display = 'none';
  }
  document.getElementById('orderProductsJson').value = JSON.stringify(products || []);
}

function openForm(productName, productId, price) {
  openOrderForm([{product_id: productId, name: productName, price: parseFloat(price), quantity: 1}]);
}

function openCartCheckout(cartItems) {
  const products = cartItems.map(i => ({
    product_id: i.product_id, name: i.name, price: i.price, quantity: i.quantity
  }));
  // Mark as from_cart in the form
 openOrderForm(products);
  document.getElementById('orderProductsJson').value = JSON.stringify({products, from_cart: true});
}

function closeForm() {
  const popup = document.getElementById('popupForm');
  if (popup) popup.style.display = 'none';
}

async function submitOrder(e) {
  e.preventDefault();
  const customerName = document.getElementById('orderCustomerName').value.trim();
  const phone        = document.getElementById('orderPhone').value.trim();
  const address      = document.getElementById('orderAddress').value.trim();
  const deliveryTime = document.getElementById('orderDeliveryTime').value;
  const notes        = document.getElementById('orderNotes').value.trim();
  const raw          = document.getElementById('orderProductsJson').value;

  let products = [], fromCart = false;
  try {
    const parsed = JSON.parse(raw);
    if (Array.isArray(parsed)) { products = parsed; }
    else { products = parsed.products || []; fromCart = !!parsed.from_cart; }
  } catch(err) {}

  if (!customerName || !phone || !address || !deliveryTime) { showToast('Please fill in all required fields'); return; }
  if (!products.length) { showToast('No products selected'); return; }

  const btn = e.target.querySelector('button[type=submit]');
  btn.disabled = true; btn.textContent = 'Placing order…';

  try {
    const res  = await fetch('api/order.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify({ customer_name: customerName, phone, address, delivery_time: deliveryTime, notes, products, from_cart: fromCart })
    });
    const data = await res.json();
    if (data.success) {
      showToast(data.message);
      closeForm();
      e.target.reset();
      // If on cart page, re-render
      if (typeof renderCartPage === 'function') renderCartPage();
      await refreshCartCount();
    } else {
      showToast(data.error || 'Order failed');
    }
  } catch(err) { showToast('Network error'); }
  btn.disabled = false; btn.textContent = 'Confirm Order 💜';
}

// ─── BADGE ANIMATION ────────────────────────────────────
function bumpBadge() {
  document.querySelectorAll('#cartCount').forEach(b => {
    b.style.transform = 'scale(1.6)';
    setTimeout(() => b.style.transform = '', 300);
  });
}

// ─── TOAST ───────────────────────────────────────────────
let toastTimer;
function showToast(msg) {
  const t = document.getElementById('toast');
  if (!t) return;
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => t.classList.remove('show'), 3200);
}

// ─── ESCAPE HTML ────────────────────────────────────────
function escHtml(s) {
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}

// ─── INIT ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  const popup = document.getElementById('popupForm');
  if (popup) popup.addEventListener('click', e => { if (e.target === popup) closeForm(); });
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeForm(); document.getElementById('productModal')?.remove(); }
  });
  if (IS_LOGGED_IN) { refreshCartCount(); refreshFavCount(); }
});
