<?php
require_once __DIR__ . '/auth.php';
$user      = currentUser();
$pageTitle = $pageTitle ?? 'Eira Store';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="image/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="image/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="image/favicon/favicon-16x16.png">
    <link rel="manifest" href="image/favicon/site.webmanifest">
    <script src="https://kit.fontawesome.com/d5f0c685f3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400;500&family=Share+Tech+Mono&display=swap" rel="stylesheet">
</head>
<body>
<header id="header">
    <nav>
        <div class="logo">
            <a href="index.php"><img src="image/logo.png" alt="Store logo" height="100px"></a>
        </div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="reviews.php">Reviews</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if ($user): ?>
                <li><a href="favorites.php"><i class="fa-regular fa-heart"></i> <span id="favCount">0</span></a></li>
                <li><a href="cart.php"><i class="fa-solid fa-cart-arrow-down fa-lg"></i> <span id="cartCount">0</span></a></li>
                <li><a href="account.php"><i class="fa-regular fa-user"></i> <?= htmlspecialchars($user['name']) ?></a></li>
            <?php else: ?>
                <li><a href="favorites.php" onclick="return requireLoginAlert()"><i class="fa-regular fa-heart"></i></a></li>
                <li><a href="cart.php" onclick="return requireLoginAlert()"><i class="fa-solid fa-cart-arrow-down fa-lg"></i></a></li>
                <li><a href="login.php"><i class="fa-regular fa-user"></i> Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<script>
const IS_LOGGED_IN = <?= $user ? 'true' : 'false' ?>;
function requireLoginAlert() {
    if (!IS_LOGGED_IN) { showToast('Please login to use this feature 💜'); setTimeout(()=>location.href='login.php',1200); return false; }
    return true;
}
</script>
