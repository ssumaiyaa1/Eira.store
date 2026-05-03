<?php
require_once '../includes/auth.php';
requireAdmin();
$admin = currentAdmin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Dashboard – Eira Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d5f0c685f3.js" crossorigin="anonymous"></script>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{background:#f4f0fa;font-family:'Jost',sans-serif;display:flex;min-height:100vh;}

        /* Sidebar */
        .sidebar{width:240px;background:linear-gradient(180deg,#1C0A2E 0%,#4A1272 100%);color:#fff;padding:28px 0;flex-shrink:0;position:sticky;top:0;height:100vh;overflow-y:auto;}
        .sidebar-logo{padding:0 24px 28px;border-bottom:1px solid rgba(255,255,255,.15);}
        .sidebar-logo h2{font-family:'Playfair Display',serif;font-size:20px;}
        .sidebar-logo p{font-size:12px;opacity:.6;margin-top:3px;}
        .nav-section{padding:20px 24px 8px;font-size:10px;text-transform:uppercase;letter-spacing:1.5px;opacity:.5;}
        .sidebar a{display:flex;align-items:center;gap:10px;padding:12px 24px;color:rgba(255,255,255,.8);text-decoration:none;font-size:14px;transition:all .2s;}
        .sidebar a:hover,.sidebar a.active{background:rgba(255,255,255,.12);color:#fff;}
        .sidebar a i{width:18px;text-align:center;}
        .sidebar-footer{margin-top:auto;padding:20px 24px;border-top:1px solid rgba(255,255,255,.15);}
        .sidebar-footer a{display:flex;align-items:center;gap:8px;color:rgba(255,255,255,.7);text-decoration:none;font-size:13px;}

        /* Main */
        .main{flex:1;overflow-x:hidden;}
        .topbar{background:#fff;padding:18px 32px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e8e0f0;position:sticky;top:0;z-index:10;}
        .topbar h1{font-size:20px;font-weight:600;color:#1C0A2E;}
        .topbar-user{font-size:13px;color:#888;}
        .content{padding:32px;}

        /* Stats */
        .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:20px;margin-bottom:32px;}
        .stat-card{background:#fff;border-radius:14px;padding:24px;display:flex;align-items:center;gap:16px;box-shadow:0 2px 12px rgba(74,18,114,.07);}
        .stat-icon{width:50px;height:50px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
        .stat-val{font-size:26px;font-weight:700;color:#1C0A2E;line-height:1;}
        .stat-label{font-size:13px;color:#888;margin-top:4px;}

        /* Tables */
        .card{background:#fff;border-radius:14px;box-shadow:0 2px 12px rgba(74,18,114,.07);overflow:hidden;margin-bottom:28px;}
        .card-header{padding:20px 24px;border-bottom:1px solid #f0e8ff;display:flex;justify-content:space-between;align-items:center;}
        .card-header h2{font-size:16px;font-weight:600;color:#1C0A2E;}
        table{width:100%;border-collapse:collapse;}
        th{background:#faf7ff;text-align:left;padding:12px 16px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:#666;font-weight:500;}
        td{padding:14px 16px;border-bottom:1px solid #f5f0fa;font-size:14px;color:#333;vertical-align:middle;}
        tr:last-child td{border-bottom:none;}
        tr:hover td{background:#fefbff;}

        /* Badges */
        .badge{padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;display:inline-block;}
        .badge-pending{background:#fff7ed;color:#c2410c;}
        .badge-confirmed{background:#eff6ff;color:#1d4ed8;}
        .badge-shipped{background:#f5f3ff;color:#6d28d9;}
        .badge-delivered{background:#f0fdf4;color:#166534;}
        .badge-cancelled{background:#fef2f2;color:#991b1b;}

        /* Buttons */
        .btn{padding:8px 16px;border:none;border-radius:8px;cursor:pointer;font-family:'Jost',sans-serif;font-size:13px;font-weight:500;transition:all .2s;}
        .btn-primary{background:#4A1272;color:#fff;}
        .btn-primary:hover{background:#3b0e5c;}
        .btn-sm{padding:5px 12px;font-size:12px;}
        .btn-danger{background:#fef2f2;color:#991b1b;border:1px solid #fecaca;}
        .btn-danger:hover{background:#fee2e2;}

        /* Tabs */
        .tabs{display:flex;gap:4px;padding:0 24px;border-bottom:1px solid #f0e8ff;background:#fff;}
        .tab{padding:14px 20px;cursor:pointer;font-size:14px;color:#888;border-bottom:2px solid transparent;transition:all .2s;}
        .tab.active{color:#4A1272;border-bottom-color:#4A1272;font-weight:500;}

        /* Section panels */
        .panel{display:none;} .panel.active{display:block;}

        /* Form */
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
        .form-group{display:flex;flex-direction:column;gap:5px;}
        .form-group label{font-size:13px;font-weight:500;color:#444;}
        .form-group input,.form-group select,.form-group textarea{padding:10px 14px;border:1px solid #e0d6f5;border-radius:8px;font-size:14px;font-family:'Jost',sans-serif;outline:none;}
        .form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:#4A1272;}
        .form-full{grid-column:1/-1;}
        .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:100;align-items:center;justify-content:center;}
        .modal-overlay.open{display:flex;}
        .modal-box{background:#fff;border-radius:16px;padding:32px;width:min(95%,560px);max-height:85vh;overflow-y:auto;position:relative;}
        .modal-box h3{font-size:18px;font-weight:600;margin-bottom:20px;color:#1C0A2E;}
        select.status-sel{padding:6px 12px;border:1px solid #e0d6f5;border-radius:8px;font-size:13px;background:#fff;cursor:pointer;}

        img.prod-thumb{width:44px;height:44px;object-fit:cover;border-radius:8px;}

        @media(max-width:768px){.sidebar{display:none;}.content{padding:16px;}.form-grid{grid-template-columns:1fr;}}
    </style>
</head>
<body>
<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <h2>Eira Admin</h2>
        <p>Store Management</p>
    </div>
    <div class="nav-section">Main</div>
    <a href="#" onclick="switchTab('dashboard')" class="active" id="nav-dashboard"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
    <a href="#" onclick="switchTab('orders')" id="nav-orders"><i class="fa-solid fa-box"></i> Orders</a>
    <a href="#" onclick="switchTab('products')" id="nav-products"><i class="fa-solid fa-store"></i> Products</a>
    <div class="nav-section">People</div>
    <a href="#" onclick="switchTab('users')" id="nav-users"><i class="fa-solid fa-users"></i> Users</a>
    <a href="#" onclick="switchTab('messages')" id="nav-messages"><i class="fa-solid fa-envelope"></i> Messages</a>
    <div class="sidebar-footer" style="padding-top:20px;">
        <a href="../index.php" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Store</a>
        <a href="../api/admin_logout.php" style="margin-top:10px;color:rgba(255,100,100,.8)"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</aside>

<!-- Main -->
<main class="main">
    <div class="topbar">
        <h1 id="topbar-title">Dashboard</h1>
        <span class="topbar-user"><i class="fa-regular fa-user"></i> <?= htmlspecialchars($admin['name']) ?></span>
    </div>
    <div class="content">

        <!-- DASHBOARD -->
        <div class="panel active" id="panel-dashboard">
            <div class="stats-grid" id="statsGrid">
                <div class="stat-card"><div class="stat-icon" style="background:#f0e8ff;"><i class="fa-solid fa-box" style="color:#4A1272;"></i></div><div><div class="stat-val" id="stat-orders">—</div><div class="stat-label">Total Orders</div></div></div>
                <div class="stat-card"><div class="stat-icon" style="background:#fff7ed;"><i class="fa-solid fa-clock" style="color:#c2410c;"></i></div><div><div class="stat-val" id="stat-pending">—</div><div class="stat-label">Pending</div></div></div>
                <div class="stat-card"><div class="stat-icon" style="background:#f0fdf4;"><i class="fa-solid fa-dollar-sign" style="color:#166534;"></i></div><div><div class="stat-val" id="stat-revenue">—</div><div class="stat-label">Revenue</div></div></div>
                <div class="stat-card"><div class="stat-icon" style="background:#eff6ff;"><i class="fa-solid fa-users" style="color:#1d4ed8;"></i></div><div><div class="stat-val" id="stat-users">—</div><div class="stat-label">Users</div></div></div>
                <div class="stat-card"><div class="stat-icon" style="background:#fdf4ff;"><i class="fa-solid fa-store" style="color:#7e22ce;"></i></div><div><div class="stat-val" id="stat-products">—</div><div class="stat-label">Products</div></div></div>
                <div class="stat-card"><div class="stat-icon" style="background:#fef9c3;"><i class="fa-solid fa-envelope" style="color:#a16207;"></i></div><div><div class="stat-val" id="stat-messages">—</div><div class="stat-label">Messages</div></div></div>
            </div>
            <div class="card">
                <div class="card-header"><h2>Recent Orders</h2></div>
                <table><thead><tr><th>#</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
                <tbody id="recentOrdersBody"></tbody></table>
            </div>
        </div>

        <!-- ORDERS -->
        <div class="panel" id="panel-orders">
            <div class="card">
                <div class="card-header"><h2>All Orders</h2><input type="text" placeholder="Search orders…" oninput="filterOrders(this.value)" style="padding:8px 14px;border:1px solid #e0d6f5;border-radius:8px;font-size:13px;width:220px;"></div>
                <table><thead><tr><th>#</th><th>Customer</th><th>Phone</th><th>Address</th><th>Time</th><th>Items</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
                <tbody id="ordersBody"></tbody></table>
            </div>
        </div>

        <!-- PRODUCTS -->
        <div class="panel" id="panel-products">
            <div class="card">
                <div class="card-header"><h2>Products</h2><button class="btn btn-primary" onclick="openProductModal()">+ Add Product</button></div>
                <table><thead><tr><th>Img</th><th>Name</th><th>Category</th><th>Price</th><th>Rating</th><th>Actions</th></tr></thead>
                <tbody id="productsBody"></tbody></table>
            </div>
        </div>

        <!-- USERS -->
        <div class="panel" id="panel-users">
            <div class="card">
                <div class="card-header"><h2>Registered Users</h2></div>
                <table><thead><tr><th>Name</th><th>Email</th><th>Orders</th><th>Joined</th></tr></thead>
                <tbody id="usersBody"></tbody></table>
            </div>
        </div>

        <!-- MESSAGES -->
        <div class="panel" id="panel-messages">
            <div class="card">
                <div class="card-header"><h2>Contact Messages</h2></div>
                <table><thead><tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Image</th>
                <th>Date</th>
                <th></th>
                </tr></thead>
                <tbody id="messagesBody"></tbody></table>
            </div>
        </div>

    </div><!-- /content -->
</main>

<!-- Product Modal -->
<div class="modal-overlay" id="productModal" onclick="if(event.target===this)closeProductModal()">
    <div class="modal-box">
        <button onclick="closeProductModal()" style="position:absolute;top:14px;right:18px;background:none;border:none;font-size:20px;cursor:pointer;">✕</button>
        <h3 id="productModalTitle">Add Product</h3>
        <form id="productForm" onsubmit="saveProduct(event)">
            <div class="form-grid">
                <div class="form-group"><label>Name *</label><input type="text" id="pName" required></div>
                <div class="form-group"><label>Price ($) *</label><input type="number" id="pPrice" step="0.01" min="0" required></div>
                <div class="form-group"><label>Category *</label>
                    <select id="pCategory" required>
                        <option value="">— Select —</option>
                        <option value="bag">Bag</option><option value="accessory">Accessory</option>
                        <option value="keychain">Keychain</option><option value="candle">Candle</option><option value="cup">Cup</option>
                    </select>
                </div>
                <div class="form-group"><label>Image path *</label><input type="text" id="pImg" placeholder="image/bag.jpg" required></div>
                <div class="form-group"><label>Badge text</label><input type="text" id="pBadge" placeholder="New, Bestseller…"></div>
                <div class="form-group"><label>Badge type</label>
                    <select id="pBadgeType"><option value="">None</option><option value="new">New</option><option value="bestseller">Bestseller</option></select>
                </div>
                <div class="form-group form-full"><label>Short Description *</label><input type="text" id="pDesc" required></div>
                <div class="form-group form-full"><label>Long Description *</label><textarea id="pDescLong" rows="3" required></textarea></div>
                <div class="form-group form-full"><label>Features (one per line) *</label><textarea id="pFeatures" rows="4" placeholder="100% Cotton Canvas&#10;Hand-stitched&#10;Washable" required></textarea></div>
            </div>
            <input type="hidden" id="pId" value="">
            <div style="margin-top:20px;display:flex;justify-content:flex-end;gap:10px;">
                <button type="button" class="btn" onclick="closeProductModal()" style="background:#f5f0fa;">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </form>
    </div>
</div>

<script>
let allOrders = [], allProducts = [];

// ─── TAB SWITCHING ──────────────────────────────────────
function switchTab(tab) {
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.sidebar a').forEach(a => a.classList.remove('active'));
    document.getElementById('panel-' + tab).classList.add('active');
    document.getElementById('nav-' + tab)?.classList.add('active');
    document.getElementById('topbar-title').textContent = tab.charAt(0).toUpperCase() + tab.slice(1);
    if (tab === 'orders')   loadOrders();
    if (tab === 'products') loadProducts();
    if (tab === 'users')    loadUsers();
    if (tab === 'messages') loadMessages();
}

// ─── STATS ──────────────────────────────────────────────
async function loadStats() {
    const res  = await fetch('../api/admin_stats.php');
    const data = await res.json();
    document.getElementById('stat-orders').textContent   = data.total_orders;
    document.getElementById('stat-pending').textContent  = data.pending_orders;
    document.getElementById('stat-revenue').textContent  = '$' + data.total_revenue.toFixed(0);
    document.getElementById('stat-users').textContent    = data.total_users;
    document.getElementById('stat-products').textContent = data.total_products;
    document.getElementById('stat-messages').textContent = data.total_messages;
}

// ─── ORDERS ─────────────────────────────────────────────
async function loadOrders(forDash = false) {
    const res  = await fetch('../api/admin_orders.php');
    const data = await res.json();
    allOrders  = data.orders || [];
    renderOrdersTable(allOrders, forDash);
}

function renderOrdersTable(orders, forDash = false) {
    const tbody = document.getElementById(forDash ? 'recentOrdersBody' : 'ordersBody');
    if (!tbody) return;
    const list  = forDash ? orders.slice(0, 6) : orders;
    const statusClass = {pending:'badge-pending',confirmed:'badge-confirmed',shipped:'badge-shipped',delivered:'badge-delivered',cancelled:'badge-cancelled'};
    if (forDash) {
        tbody.innerHTML = list.map(o => `
          <tr>
            <td>#${o.id}</td>
            <td>${esc(o.customer_name)}</td>
            <td style="font-weight:600;color:#4A1272;">$${parseFloat(o.total_price).toFixed(2)}</td>
            <td><span class="badge ${statusClass[o.status]||''}">${o.status}</span></td>
            <td style="color:#888;font-size:12px;">${fmtDate(o.created_at)}</td>
          </tr>`).join('');
        return;
    }
    tbody.innerHTML = list.map(o => `
      <tr>
        <td>#${o.id}</td>
        <td><div style="font-weight:500;">${esc(o.customer_name)}</div>${o.user_name?`<div style="font-size:11px;color:#888;">${esc(o.user_name)}</div>`:''}</td>
        <td>${esc(o.phone)}</td>
        <td style="font-size:12px;max-width:120px;">${esc(o.address)}</td>
        <td style="font-size:12px;">${esc(o.delivery_time)}</td>
        <td style="font-size:12px;">
          ${(o.items||[]).map(i=>`<div style="display:flex;align-items:center;gap:5px;margin-bottom:3px;">
            <img src="../${i.product_img}" style="width:28px;height:28px;object-fit:cover;border-radius:5px;">
            <span>${esc(i.product_name)} ×${i.quantity}</span>
          </div>`).join('')}
        </td>
        <td style="font-weight:600;color:#4A1272;">$${parseFloat(o.total_price).toFixed(2)}</td>
        <td>
          <select class="status-sel" onchange="updateStatus(${o.id},this.value)">
            ${['pending','confirmed','shipped','delivered','cancelled'].map(s=>`<option value="${s}" ${o.status===s?'selected':''}>${s}</option>`).join('')}
          </select>
        </td>
        <td style="color:#888;font-size:12px;">${fmtDate(o.created_at)}</td>
      </tr>`).join('');
}

function filterOrders(q) {
    const f = allOrders.filter(o =>
        esc(o.customer_name).toLowerCase().includes(q.toLowerCase()) ||
        String(o.id).includes(q) ||
        o.phone.includes(q)
    );
    renderOrdersTable(f);
}

async function updateStatus(orderId, status) {
    await fetch('../api/admin_orders.php', {
        method: 'PUT', headers: {'Content-Type':'application/json'},
        body: JSON.stringify({ order_id: orderId, status })
    });
    showMsg('Status updated ✓');
    loadStats();
}

// ─── PRODUCTS ────────────────────────────────────────────
async function loadProducts() {
    const res  = await fetch('../api/admin_products.php');
    const data = await res.json();
    allProducts = data.products || [];
    const tbody = document.getElementById('productsBody');
    tbody.innerHTML = allProducts.map(p => `
      <tr>
        <td><img class="prod-thumb" src="../${p.img}" alt=""></td>
        <td style="font-weight:500;">${esc(p.name)}<br><span style="font-size:11px;color:#888;">${p.badge||''}</span></td>
        <td>${p.category}</td>
        <td style="font-weight:600;color:#4A1272;">$${p.price.toFixed(2)}</td>
        <td>⭐ ${p.rating} <span style="color:#aaa;font-size:11px;">(${p.review_count})</span></td>
        <td>
          <button class="btn btn-sm btn-primary" onclick="editProduct(${p.id})" style="margin-right:6px;">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="deleteProduct(${p.id})">Delete</button>
        </td>
      </tr>`).join('');
}

function openProductModal(id) {
    document.getElementById('productModal').classList.add('open');
    document.getElementById('productForm').reset();
    document.getElementById('pId').value = '';
    document.getElementById('productModalTitle').textContent = 'Add Product';
}

function editProduct(id) {
    const p = allProducts.find(x => x.id === id);
    if (!p) return;
    document.getElementById('productModalTitle').textContent = 'Edit Product';
    document.getElementById('pId').value       = p.id;
    document.getElementById('pName').value     = p.name;
    document.getElementById('pPrice').value    = p.price;
    document.getElementById('pCategory').value = p.category;
    document.getElementById('pImg').value      = p.img;
    document.getElementById('pBadge').value    = p.badge || '';
    document.getElementById('pBadgeType').value= p.badge_type || '';
    document.getElementById('pDesc').value     = p.description;
    document.getElementById('pDescLong').value = p.desc_long;
    document.getElementById('pFeatures').value = (p.features||[]).join('\n');
    document.getElementById('productModal').classList.add('open');
}

function closeProductModal() { document.getElementById('productModal').classList.remove('open'); }

async function saveProduct(e) {
    e.preventDefault();
    const id       = document.getElementById('pId').value;
    const features = document.getElementById('pFeatures').value.split('\n').map(s=>s.trim()).filter(Boolean);
    const payload  = {
        name: document.getElementById('pName').value, price: document.getElementById('pPrice').value,
        category: document.getElementById('pCategory').value, img: document.getElementById('pImg').value,
        badge: document.getElementById('pBadge').value, badge_type: document.getElementById('pBadgeType').value,
        description: document.getElementById('pDesc').value, desc_long: document.getElementById('pDescLong').value,
        features
    };
    if (id) payload.id = parseInt(id);
    await fetch('../api/admin_products.php', {
        method: id ? 'PUT' : 'POST', headers: {'Content-Type':'application/json'},
        body: JSON.stringify(payload)
    });
    closeProductModal();
    loadProducts();
    showMsg(id ? 'Product updated ✓' : 'Product added ✓');
}

async function deleteProduct(id) {
    if (!confirm('Delete this product?')) return;
    await fetch('../api/admin_products.php', {
        method: 'DELETE', headers: {'Content-Type':'application/json'},
        body: JSON.stringify({ id })
    });
    loadProducts(); showMsg('Product deleted');
}

// ─── USERS ───────────────────────────────────────────────
async function loadUsers() {
    const res  = await fetch('../api/admin_users.php');
    const data = await res.json();
    const tbody= document.getElementById('usersBody');
    tbody.innerHTML = (data.users||[]).map(u => `
      <tr>
        <td style="font-weight:500;">${esc(u.name)}</td>
        <td style="color:#888;">${esc(u.email)}</td>
        <td><span class="badge" style="background:#eff6ff;color:#1d4ed8;">${u.order_count} orders</span></td>
        <td style="color:#888;font-size:12px;">${fmtDate(u.created_at)}</td>
      </tr>`).join('');
}

// ─── MESSAGES ────────────────────────────────────────────
async function loadMessages() {
    const res  = await fetch('../api/admin_messages.php');
    const data = await res.json();
    const tbody= document.getElementById('messagesBody');
    tbody.innerHTML = (data.messages||[]).map(function(m) {
        const imgCell = m.image_path
            ? '<a href="../' + esc(m.image_path) + '" target="_blank"><img src="../' + esc(m.image_path) + '" style="width:48px;height:48px;object-fit:cover;border-radius:8px;cursor:pointer;"></a>'
            : '<span style="color:#aaa;font-size:12px;">—</span>';
        return '<tr>'
            + '<td style="font-weight:500;">'                          + esc(m.name)    + '</td>'
            + '<td style="color:#888;">'                               + esc(m.email)   + '</td>'
            + '<td style="max-width:300px;font-size:13px;color:#555;">'+ esc(m.message) + '</td>'
            + '<td>' + imgCell + '</td>'
            + '<td style="color:#888;font-size:12px;">'                + fmtDate(m.created_at) + '</td>'
            + '<td><button class="btn btn-sm btn-danger" onclick="deleteMessage(' + m.id + ')">Delete</button></td>'
            + '</tr>';
    }).join('');
}

async function deleteMessage(id) {
    if (!confirm('Delete this message?')) return;
    await fetch('../api/admin_messages.php', {
        method: 'DELETE', headers: {'Content-Type':'application/json'},
        body: JSON.stringify({ id })
    });
    loadMessages();
}

// ─── HELPERS ─────────────────────────────────────────────
function esc(s) { return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
function fmtDate(d) { return new Date(d).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'}); }
let msgTimer;
function showMsg(m) {
    const el = document.createElement('div');
    el.textContent = m;
    el.style.cssText = 'position:fixed;bottom:24px;right:24px;background:#4A1272;color:#fff;padding:12px 20px;border-radius:10px;font-size:14px;z-index:999;box-shadow:0 4px 20px rgba(0,0,0,.2);';
    document.body.appendChild(el);
    setTimeout(() => el.remove(), 2500);
}

// Init
loadStats();
loadOrders(true);
</script>
</body>
</html>
