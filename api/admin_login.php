<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { jsonResponse(['error' => 'Method not allowed'], 405); }

$data     = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$email    = trim($data['email']    ?? '');
$password = trim($data['password'] ?? '');

if (!$email || !$password) { jsonResponse(['error' => 'Email and password required'], 400); }

$db   = getDB();
$stmt = $db->prepare('SELECT id, name, email, password FROM admins WHERE email = ?');
$stmt->execute([$email]);
$admin = $stmt->fetch();

if (!$admin || !password_verify($password, $admin['password'])) {
    jsonResponse(['error' => 'Invalid credentials'], 401);
}

$_SESSION['admin_id']    = $admin['id'];
$_SESSION['admin_name']  = $admin['name'];
$_SESSION['admin_email'] = $admin['email'];

jsonResponse(['success' => true]);
