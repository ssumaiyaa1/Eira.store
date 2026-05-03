<?php
// api/admin_products.php — GET|POST|PUT|DELETE
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');
if (!isAdmin()) { jsonResponse(['error' => 'Unauthorized'], 401); }

$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $rows = $db->query('SELECT * FROM products ORDER BY id DESC')->fetchAll();
    foreach ($rows as &$r) { $r['features'] = json_decode($r['features'], true) ?? []; $r['price'] = (float)$r['price']; }
    jsonResponse(['products' => $rows]);
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];

if ($method === 'POST') {
    $required = ['name','price','category','img','description','desc_long','features'];
    foreach ($required as $f) { if (empty($data[$f])) { jsonResponse(['error' => "Field $f required"], 400); } }
    $features = is_array($data['features']) ? json_encode($data['features']) : $data['features'];
    $stmt = $db->prepare('INSERT INTO products (name,price,category,img,badge,badge_type,description,desc_long,features) VALUES (?,?,?,?,?,?,?,?,?)');
    $stmt->execute([$data['name'],(float)$data['price'],$data['category'],$data['img'],$data['badge']??null,$data['badge_type']??null,$data['description'],$data['desc_long'],$features]);
    jsonResponse(['success' => true, 'id' => $db->lastInsertId()]);
}

if ($method === 'PUT') {
    $id = (int)($data['id'] ?? 0);
    if (!$id) { jsonResponse(['error' => 'id required'], 400); }
    $features = is_array($data['features']) ? json_encode($data['features']) : $data['features'];
    $stmt = $db->prepare('UPDATE products SET name=?,price=?,category=?,img=?,badge=?,badge_type=?,description=?,desc_long=?,features=? WHERE id=?');
    $stmt->execute([$data['name'],(float)$data['price'],$data['category'],$data['img'],$data['badge']??null,$data['badge_type']??null,$data['description'],$data['desc_long'],$features,$id]);
    jsonResponse(['success' => true]);
}

if ($method === 'DELETE') {
    $id = (int)($data['id'] ?? 0);
    if (!$id) { jsonResponse(['error' => 'id required'], 400); }
    $db->prepare('DELETE FROM products WHERE id = ?')->execute([$id]);
    jsonResponse(['success' => true]);
}

jsonResponse(['error' => 'Method not allowed'], 405);
