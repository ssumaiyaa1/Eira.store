<?php
require_once 'includes/db.php';

$newPassword = 'sara12309';
$hash        = password_hash($newPassword, PASSWORD_BCRYPT);

$db   = getDB();
$stmt = $db->prepare(
    'UPDATE admins SET password = ? WHERE email = ?'
);
$stmt->execute([$hash, 'admin@eira.store']);

echo '<h2>Success!</h2>';
echo '<p>Password has been set to: <strong>' . $newPassword . '</strong></p>';
echo '<p style="color:red;font-weight:bold;">DELETE THIS FILE NOW!</p>';
echo '<p>Generated hash: ' . $hash . '</p>';
?>