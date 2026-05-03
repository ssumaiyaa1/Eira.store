<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
header('Content-Type: application/json');
if (!isAdmin()) { jsonResponse(['error' => 'Unauthorized'], 401); }
$db = getDB();
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true) ?? [];
    $id   = (int)($data['id'] ?? 0);
    if ($id) { $db->prepare('DELETE FROM contact_messages WHERE id = ?')->execute([$id]); }
    jsonResponse(['success' => true]);
}
$msgs = $db->query('SELECT * FROM contact_messages ORDER BY created_at DESC')->fetchAll();
jsonResponse(['messages' => $msgs]);
