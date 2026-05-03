<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
header('Content-Type: application/json');
if (!isAdmin()) { jsonResponse(['error' => 'Unauthorized'], 401); }
$db = getDB();
$users = $db->query('SELECT id, name, email, created_at FROM users ORDER BY created_at DESC')->fetchAll();
foreach ($users as &$u) {
    $cnt = $db->prepare('SELECT COUNT(*) FROM orders WHERE user_id = ?');
    $cnt->execute([$u['id']]);
    $u['order_count'] = (int)$cnt->fetchColumn();
}
jsonResponse(['users' => $users]);
