<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

// Use $_POST now (FormData, not JSON)
$name    = trim($_POST['name']    ?? '');
$email   = trim($_POST['email']   ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name || !$email || !$message) {
    jsonResponse(['error' => 'All fields are required'], 400);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['error' => 'Invalid email address'], 400);
}

// --- Handle image upload ---
$imagePath = null;

if (!empty($_FILES['image']['tmp_name'])) {
    $file     = $_FILES['image'];
    $maxSize  = 5 * 1024 * 1024; // 5 MB
    $allowed  = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

    if ($file['size'] > $maxSize) {
        jsonResponse(['error' => 'Image must be under 5 MB'], 400);
    }

    // Verify MIME type from the actual file, not the browser header
    $finfo    = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    if (!in_array($mimeType, $allowed)) {
        jsonResponse(['error' => 'Only JPEG, PNG, WebP, or GIF images allowed'], 400);
    }

    $uploadDir = '../uploads/contact/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Random name prevents overwriting and path-traversal attacks
    $ext       = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName  = bin2hex(random_bytes(16)) . '.' . strtolower($ext);
    $destPath  = $uploadDir . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        jsonResponse(['error' => 'Failed to save image'], 500);
    }

    $imagePath = 'uploads/contact/' . $fileName; // relative path saved to DB
}

// --- Save to database (image_path can be NULL if no image) ---
$db   = getDB();
$stmt = $db->prepare(
    'INSERT INTO contact_messages (name, email, message, image_path) VALUES (?, ?, ?, ?)'
);
$stmt->execute([$name, $email, $message, $imagePath]);

jsonResponse(['success' => true, 'message' => "Thank you! We'll get back to you soon 💜"]);