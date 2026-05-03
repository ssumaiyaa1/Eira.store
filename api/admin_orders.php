<?php
// api/admin_orders.php — GET: all orders | PUT: update status
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');
if (!isAdmin()) { jsonResponse(['error' => 'Unauthorized'], 401); }

$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $db->query(
        'SELECT o.id, o.customer_name, o.phone, o.address, o.delivery_time, o.notes,
                o.status, o.total_price, o.created_at,
                u.name AS user_name, u.email AS user_email
         FROM orders o
         LEFT JOIN users u ON u.id = o.user_id
         ORDER BY o.created_at DESC'
    );
    $orders = $stmt->fetchAll();
    foreach ($orders as &$o) {
        $o['total_price'] = (float)$o['total_price'];
        $iStmt = $db->prepare(
            'SELECT oi.product_name, oi.product_img, oi.unit_price, oi.quantity
             FROM order_items oi WHERE oi.order_id = ?'
        );
        $iStmt->execute([$o['id']]);
        $o['items'] = $iStmt->fetchAll();
        foreach ($o['items'] as &$i) { $i['unit_price'] = (float)$i['unit_price']; }
    }
    jsonResponse(['orders' => $orders]);
}

if ($method === 'PUT') {
    $data    = json_decode(file_get_contents('php://input'), true) ?? [];
    $orderId = (int)($data['order_id'] ?? 0);
    $status  = $data['status'] ?? '';
    $allowed = ['pending','confirmed','shipped','delivered','cancelled'];
    if (!$orderId || !in_array($status, $allowed)) { jsonResponse(['error' => 'Invalid data'], 400); }
    $stmt = $db->prepare('UPDATE orders SET status = ? WHERE id = ?');
    $stmt->execute([$status, $orderId]);
    jsonResponse(['success' => true]);
}

jsonResponse(['error' => 'Method not allowed'], 405);
