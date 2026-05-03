<?php
// api/cart.php — GET: list | POST: add/update | DELETE: remove
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) { jsonResponse(['error' => 'Login required'], 401); }

$db     = getDB();
$userId = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $db->prepare(
        'SELECT ci.id, ci.product_id, ci.quantity, p.name, p.price, p.img, p.description
         FROM cart_items ci
         JOIN products p ON p.id = ci.product_id
         WHERE ci.user_id = ?
         ORDER BY ci.added_at DESC'
    );
    $stmt->execute([$userId]);
    $items = $stmt->fetchAll();
    foreach ($items as &$i) { $i['price'] = (float)$i['price']; $i['product_id'] = (int)$i['product_id']; $i['quantity'] = (int)$i['quantity']; }
    jsonResponse(['items' => $items]);
}

$data      = json_decode(file_get_contents('php://input'), true) ?? [];
$productId = (int)($data['product_id'] ?? 0);
$quantity  = (int)($data['quantity']   ?? 1);

if ($method === 'POST') {
    if (!$productId) jsonResponse(['error' => 'product_id required'], 400);
    // Verify product exists
    $chk = $db->prepare('SELECT id FROM products WHERE id = ?');
    $chk->execute([$productId]);
    if (!$chk->fetch()) jsonResponse(['error' => 'Product not found'], 404);

    $stmt = $db->prepare(
        'INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?,?,?)
         ON DUPLICATE KEY UPDATE quantity = quantity + ?'
    );
    $stmt->execute([$userId, $productId, $quantity, $quantity]);
    jsonResponse(['success' => true, 'message' => 'Added to cart']);
}

if ($method === 'PUT') {
    if (!$productId) jsonResponse(['error' => 'product_id required'], 400);
    if ($quantity < 1) {
        $stmt = $db->prepare('DELETE FROM cart_items WHERE user_id=? AND product_id=?');
        $stmt->execute([$userId, $productId]);
    } else {
        $stmt = $db->prepare('UPDATE cart_items SET quantity=? WHERE user_id=? AND product_id=?');
        $stmt->execute([$quantity, $userId, $productId]);
    }
    jsonResponse(['success' => true]);
}

if ($method === 'DELETE') {
    if ($productId) {
        $stmt = $db->prepare('DELETE FROM cart_items WHERE user_id=? AND product_id=?');
        $stmt->execute([$userId, $productId]);
    } else {
        $stmt = $db->prepare('DELETE FROM cart_items WHERE user_id=?');
        $stmt->execute([$userId]);
    }
    jsonResponse(['success' => true]);
}

jsonResponse(['error' => 'Method not allowed'], 405);
