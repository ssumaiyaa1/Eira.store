<?php
// api/favorites.php — GET: list | POST: toggle
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) { jsonResponse(['error' => 'Login required'], 401); }

$db     = getDB();
$userId = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $db->prepare(
        'SELECT p.id, p.name, p.price, p.img, p.description, p.category, p.badge, p.badge_type, p.rating, p.review_count
         FROM favorites f
         JOIN products p ON p.id = f.product_id
         WHERE f.user_id = ?
         ORDER BY f.added_at DESC'
    );
    $stmt->execute([$userId]);
    $items = $stmt->fetchAll();
    // Also return just IDs for quick lookup
    $ids = array_map(fn($i) => (int)$i['id'], $items);
    foreach ($items as &$i) { $i['price'] = (float)$i['price']; $i['id'] = (int)$i['id']; }
    jsonResponse(['favorites' => $items, 'ids' => $ids]);
}

if ($method === 'POST') {
    $data      = json_decode(file_get_contents('php://input'), true) ?? [];
    $productId = (int)($data['product_id'] ?? 0);
    if (!$productId) jsonResponse(['error' => 'product_id required'], 400);

    // Check if already favorited
    $chk = $db->prepare('SELECT id FROM favorites WHERE user_id=? AND product_id=?');
    $chk->execute([$userId, $productId]);
    if ($chk->fetch()) {
        // Remove
        $del = $db->prepare('DELETE FROM favorites WHERE user_id=? AND product_id=?');
        $del->execute([$userId, $productId]);
        jsonResponse(['success' => true, 'action' => 'removed']);
    } else {
        // Add
        $ins = $db->prepare('INSERT IGNORE INTO favorites (user_id, product_id) VALUES (?,?)');
        $ins->execute([$userId, $productId]);
        jsonResponse(['success' => true, 'action' => 'added']);
    }
}

jsonResponse(['error' => 'Method not allowed'], 405);
