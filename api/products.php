<?php
// api/products.php — GET: returns all products as JSON
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

$db   = getDB();
$stmt = $db->query('SELECT * FROM products ORDER BY id ASC');
$rows = $stmt->fetchAll();

// Decode features JSON string → array
foreach ($rows as &$row) {
    $row['features'] = json_decode($row['features'], true) ?? [];
    $row['price']    = (float)$row['price'];
    $row['rating']   = (float)$row['rating'];
}

jsonResponse(['products' => $rows]);
