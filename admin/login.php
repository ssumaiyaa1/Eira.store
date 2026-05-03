<?php
require_once '../includes/auth.php';
if (isAdmin()) { header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Login – Eira Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d5f0c685f3.js" crossorigin="anonymous"></script>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{background:linear-gradient(135deg,#1C0A2E 0%,#4A1272 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;font-family:'Jost',sans-serif;}
        .card{background:#fff;border-radius:20px;padding:48px 40px;width:min(100%,420px);box-shadow:0 20px 60px rgba(0,0,0,.3);}
        .logo{text-align:center;margin-bottom:28px;}
        .logo h1{font-family:'Playfair Display',serif;color:#4A1272;font-size:28px;margin-top:8px;}
        .logo p{color:#888;font-size:13px;margin-top:4px;}
        label{display:block;font-size:13px;font-weight:500;margin-bottom:5px;color:#333;}
        input{width:100%;padding:12px 16px;border:1px solid #e0d6f5;border-radius:10px;font-size:15px;outline:none;transition:border .2s;margin-bottom:16px;}
        input:focus{border-color:#4A1272;}
        .btn{width:100%;padding:14px;background:linear-gradient(135deg,#4A1272,#7C3AED);color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:500;cursor:pointer;font-family:'Jost',sans-serif;}
        .btn:hover{opacity:.9;}
        #msg{display:none;padding:12px;border-radius:8px;margin-bottom:16px;text-align:center;font-size:14px;}
        .back{text-align:center;margin-top:20px;font-size:13px;color:#888;}
        .back a{color:#4A1272;font-weight:600;text-decoration:none;}
    </style>
</head>
<body>
<div class="card">
    <div class="logo">
        <i class="fa-solid fa-shield-halved" style="font-size:36px;color:#4A1272;"></i>
        <h1>Admin Panel</h1>
        <p>Eira Store Management</p>
    </div>
    <div id="msg"></div>
    <form id="adminLoginForm">
        <label>Email Address</label>
        <input type="email" id="email" placeholder="admin@eira.store" required>
        <label>Password</label>
        <input type="password" id="password" placeholder="••••••••" required>
        <button type="submit" class="btn">Sign In</button>
    </form>
    <div class="back"><a href="../index.php">← Back to Store</a></div>
</div>
<script>
document.getElementById('adminLoginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = this.querySelector('button');
    btn.disabled = true; btn.textContent = 'Signing in…';
    const msg = document.getElementById('msg');
    const res  = await fetch('../api/admin_login.php', {
        method: 'POST', headers: {'Content-Type':'application/json'},
        body: JSON.stringify({ email: document.getElementById('email').value, password: document.getElementById('password').value })
    });
    const data = await res.json();
    msg.style.display = 'block';
    if (data.success) {
        msg.style.cssText = 'display:block;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;padding:12px;border-radius:8px;text-align:center;font-size:14px;margin-bottom:16px;';
        msg.textContent = 'Welcome! Redirecting…';
        setTimeout(() => location.href = 'index.php', 700);
    } else {
        msg.style.cssText = 'display:block;background:#fef2f2;color:#991b1b;border:1px solid #fecaca;padding:12px;border-radius:8px;text-align:center;font-size:14px;margin-bottom:16px;';
        msg.textContent = data.error || 'Login failed';
        btn.disabled = false; btn.textContent = 'Sign In';
    }
});
</script>
</body>
</html>
