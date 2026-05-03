<?php
// api/reviews.php
// GET  → returns all reviews as JSON
// POST → submits a new review: reviewer_name, product_name, rating, review_text
require_once '../includes/db.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $db->query(
        'SELECT reviewer_name, product_name, rating, review_text,
                DATE_FORMAT(created_at, "%b %Y") AS date
         FROM reviews
         ORDER BY created_at DESC'
    );
    jsonResponse(['reviews' => $stmt->fetchAll()]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;

    $name    = trim($data['reviewer_name'] ?? '');
    $product = trim($data['product_name']  ?? '');
    $rating  = (int)($data['rating']       ?? 0);
    $text    = trim($data['review_text']   ?? '');

    if (!$name || !$product || !$rating || !$text) {
        jsonResponse(['error' => 'Please fill in all fields'], 400);
    }
    if ($rating < 1 || $rating > 5) {
        jsonResponse(['error' => 'Rating must be between 1 and 5'], 400);
    }

    $userId = isLoggedIn() ? $_SESSION['user_id'] : null;

    $stmt = $db->prepare(
        'INSERT INTO reviews (user_id, reviewer_name, product_name, rating, review_text)
         VALUES (?, ?, ?, ?, ?)'
    );
    $stmt->execute([$userId, $name, $product, $rating, $text]);

    jsonResponse(['success' => true, 'message' => 'Thank you for your review! 💜']);
}

jsonResponse(['error' => 'Method not allowed'], 405);
