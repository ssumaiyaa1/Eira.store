<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
header('Content-Type: application/json');
if (!isAdmin()) { jsonResponse(['error' => 'Unauthorized'], 401); }
$db = getDB();
$stats = [
    'total_orders'   => (int)$db->query('SELECT COUNT(*) FROM orders')->fetchColumn(),
    'pending_orders' => (int)$db->query("SELECT COUNT(*) FROM orders WHERE status='pending'")->fetchColumn(),
    'total_revenue'  => (float)$db->query("SELECT COALESCE(SUM(total_price),0) FROM orders WHERE status != 'cancelled'")->fetchColumn(),
    'total_users'    => (int)$db->query('SELECT COUNT(*) FROM users')->fetchColumn(),
    'total_products' => (int)$db->query('SELECT COUNT(*) FROM products')->fetchColumn(),
    'total_messages' => (int)$db->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn(),
];
jsonResponse($stats);
