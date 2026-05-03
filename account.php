<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$pageTitle = 'My Account – Eira Store';
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/db.php';

$user = currentUser();

// Fetch user's orders with items
$db   = getDB();
$stmt = $db->prepare(
    'SELECT o.id, o.status, o.total_price, o.created_at,
            GROUP_CONCAT(oi.product_name SEPARATOR ", ") AS product_names,
            SUM(oi.quantity) AS total_qty
     FROM orders o
     LEFT JOIN order_items oi ON oi.order_id = o.id
     WHERE o.user_id = ?
     GROUP BY o.id
     ORDER BY o.created_at DESC'
);
$stmt->execute([$user['id']]);
$orders = $stmt->fetchAll();

$statusColors = [
    'pending'   => '#f59e0b',
    'confirmed' => '#3b82f6',
    'shipped'   => '#8b5cf6',
    'delivered' => '#10b981',
    'cancelled' => '#ef4444',
];

require_once 'includes/header.php';
?>

<section style="padding-top: 120px;">
    <div style="border: 1px solid var(--ink); width:50%; border-radius:10px; min-height: 80vh; margin: auto; margin-bottom:50px; padding:50px;">

        <h2 style="font-family:'Playfair Display',serif; margin-bottom:6px; background-color: var(--background); padding:10px; border-radius:10px; color:var(--ink);">My Account</h2>
        <p style="color:#888; margin-bottom:36px;">Welcome back, <strong><?= htmlspecialchars($user['name']) ?></strong> <i class="fa-solid fa-hand-spock" style="color: hsl(267, 32%, 35%);"></i></p>
        <hr>

        <!-- Account Info Card -->
        <div style="background:#faf7ff; border-radius:16px; padding:10px; margin-bottom:40px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
            <div>
                <div style="font-weight:600; font-size:18px; color:var(--ink);"><?= htmlspecialchars($user['name']) ?></div>
                <div style="color:#888; font-size:14px; margin-top:4px;"><?= htmlspecialchars($user['email']) ?></div>
            </div>
            <a href="api/logout.php" style="background:#fff; border:1px solid #e0d6f5; color:rgb(74,23,122); padding:10px 22px; border-radius:30px; font-size:14px; text-decoration:none; font-weight:500;">Log Out</a>
        </div>
        <hr>

        <!-- Orders -->
        <h3 style="margin-bottom:20px;">My Orders</h3>

        <?php if (count($orders) === 0): ?>
        <div style="text-align:center; padding:50px; color:#aaa;">
            <div style="font-size:48px; margin-bottom:12px;"><i class="fa-solid fa-box-open" style="color: hsl(267, 32%, 35%);"></i></div>
            <p>You haven't placed any orders yet.</p>
            <a href="products.php" style="display:inline-block; margin-top:16px; text-decoration:none; background:var(--ink); color:#fff; padding:10px 24px; border-radius:30px; font-size:14px;">Start Shopping</a>
        </div>
        <?php else: ?>
        <div style="display:flex; flex-direction:column; gap:14px;">
            <?php foreach ($orders as $order): ?>
            <div style="border:1px solid #f0e8ff; border-radius:14px; padding:20px 24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                <div>
                    <div style="font-weight:600;"><?= htmlspecialchars($order['product_names'] ?? 'N/A') ?></div>
                    <div style="font-size:13px; color:#888; margin-top:4px;">
                        Qty: <?= $order['total_qty'] ?> · $<?= number_format($order['total_price'], 2) ?>
                        · <?= date('M j, Y', strtotime($order['created_at'])) ?>
                    </div>
                </div>
                <span style="background:<?= $statusColors[$order['status']] ?? '#888' ?>22; color:<?= $statusColors[$order['status']] ?? '#888' ?>; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:600; text-transform:capitalize;">
                    <?= htmlspecialchars($order['status']) ?>
                </span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>

<script src="script.js"></script>
<?php require_once 'includes/footer.php'; ?>