<?php
// api/order.php — POST: place order (single product or cart checkout)
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) { jsonResponse(['error' => 'Login required. Please login to place an order.'], 401); }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { jsonResponse(['error' => 'Method not allowed'], 405); }

$data         = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$customerName = trim($data['customer_name']   ?? '');
$phone        = trim($data['phone']           ?? '');
$address      = trim($data['address']         ?? '');
$deliveryTime = trim($data['delivery_time']   ?? '');
$notes        = trim($data['notes']           ?? '');
$products     = $data['products']             ?? []; // [{product_id, quantity}]

if (!$customerName || !$phone || !$address || !$deliveryTime) {
    jsonResponse(['error' => 'Please fill in all required fields'], 400);
}
if (empty($products)) { jsonResponse(['error' => 'No products specified'], 400); }

$db     = getDB();
$userId = $_SESSION['user_id'];

// Calculate total and validate products
$totalPrice = 0;
$orderItems = [];
foreach ($products as $item) {
    $pid = (int)($item['product_id'] ?? 0);
    $qty = max(1, (int)($item['quantity'] ?? 1));
    if (!$pid) continue;
    $stmt = $db->prepare('SELECT id, name, price, img FROM products WHERE id = ?');
    $stmt->execute([$pid]);
    $prod = $stmt->fetch();
    if (!$prod) continue;
    $lineTotal    = $prod['price'] * $qty;
    $totalPrice  += $lineTotal;
    $orderItems[] = ['product_id' => $pid, 'product_name' => $prod['name'], 'product_img' => $prod['img'], 'unit_price' => $prod['price'], 'quantity' => $qty];
}
if (empty($orderItems)) { jsonResponse(['error' => 'No valid products found'], 400); }

$db->beginTransaction();
try {
    $stmt = $db->prepare(
        'INSERT INTO orders (user_id, customer_name, phone, address, delivery_time, notes, total_price)
         VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([$userId, $customerName, $phone, $address, $deliveryTime, $notes ?: null, $totalPrice]);
    $orderId = $db->lastInsertId();

    $itemStmt = $db->prepare(
        'INSERT INTO order_items (order_id, product_id, product_name, product_img, unit_price, quantity)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    foreach ($orderItems as $oi) {
        $itemStmt->execute([$orderId, $oi['product_id'], $oi['product_name'], $oi['product_img'], $oi['unit_price'], $oi['quantity']]);
    }

    // If ordering from cart, clear the cart
    if (!empty($data['from_cart'])) {
        $del = $db->prepare('DELETE FROM cart_items WHERE user_id = ?');
        $del->execute([$userId]);
    }

    $db->commit();
    jsonResponse(['success' => true, 'order_id' => $orderId, 'message' => "Order placed! We'll contact you soon 💜"]);
} catch (Exception $e) {
    $db->rollBack();
    jsonResponse(['error' => 'Order failed. Please try again.'], 500);
}
