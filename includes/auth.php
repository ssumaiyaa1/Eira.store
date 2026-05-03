<?php
// includes/auth.php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

function isLoggedIn(): bool { return isset($_SESSION['user_id']); }

function currentUser(): ?array {
    if (!isLoggedIn()) return null;
    return ['id' => $_SESSION['user_id'], 'name' => $_SESSION['user_name'], 'email' => $_SESSION['user_email']];
}

function requireLogin(): void {
    if (!isLoggedIn()) { header('Location: login.php'); exit; }
}

function isAdmin(): bool { return isset($_SESSION['admin_id']); }

function currentAdmin(): ?array {
    if (!isAdmin()) return null;
    return ['id' => $_SESSION['admin_id'], 'name' => $_SESSION['admin_name'], 'email' => $_SESSION['admin_email']];
}

function requireAdmin(): void {
    if (!isAdmin()) { header('Location: admin/login.php'); exit; }
}

function jsonResponse(array $data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
