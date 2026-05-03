<?php
$pageTitle = 'Login – Eira Store';
require_once 'includes/auth.php';
// If already logged in, redirect home
if (isLoggedIn()) { header('Location: index.php'); exit; }
require_once 'includes/header.php';
?>

<section style="min-height:70vh;display:flex;align-items:center;justify-content:center;padding:120px 20px 40px 20px;">
    <div style="background:#fff;border-radius:20px;box-shadow:0 8px 40px rgba(74,23,122,.12);padding:48px 40px;width:min(100%,420px);">
        <div style="text-align:center;margin-bottom:32px;">
            <img src="image/logo.png" alt="Eira" height="70">
            <h2 style="margin-top:12px;font-family:'Playfair Display',serif;">Welcome Back</h2>
            <p style="color:#888;font-size:14px;">Sign in to your Eira account</p>
        </div>

        <div id="loginMsg" style="display:none;padding:12px 16px;border-radius:10px;margin-bottom:20px;text-align:center;font-size:14px;"></div>

        <form id="loginForm" style="display:flex;flex-direction:column;gap:16px;">
            <div>
                <label style="display:block;margin-bottom:6px;font-weight:500;font-size:14px;">Email Address</label>
                <input type="email" id="loginEmail" placeholder="you@example.com" required
                       style="width:100%;padding:12px 16px;border:1px solid #e0d6f5;border-radius:10px;font-size:15px;box-sizing:border-box;outline:none;transition:border .2s;"
                       onfocus="this.style.borderColor='rgb(74,23,122)'" onblur="this.style.borderColor='#e0d6f5'">
            </div>
            <div>
                <label style="display:block;margin-bottom:6px;font-weight:500;font-size:14px;">Password</label>
                <input type="password" id="loginPassword" placeholder="••••••••" required
                       style="width:100%;padding:12px 16px;border:1px solid #e0d6f5;border-radius:10px;font-size:15px;box-sizing:border-box;outline:none;transition:border .2s;"
                       onfocus="this.style.borderColor='rgb(74,23,122)'" onblur="this.style.borderColor='#e0d6f5'">
            </div>
            <button type="submit" class="orderBtn" style="width:100%;padding:14px;font-size:15px;margin-top:4px;">Sign In</button>
        </form>

        <p style="text-align:center;margin-top:24px;font-size:14px;color:#888;">
            Don't have an account? <a href="register.php" style="color:rgb(74,23,122);font-weight:600;">Sign Up</a>
        </p>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type=submit]');
    btn.disabled = true;
    btn.textContent = 'Signing in…';

    const res  = await fetch('api/login.php', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify({
            email:    document.getElementById('loginEmail').value,
            password: document.getElementById('loginPassword').value
        })
    });
    const data = await res.json();
    const msg  = document.getElementById('loginMsg');
    msg.style.display = 'block';

    if (data.success) {
        msg.style.background='#f0fdf4'; msg.style.color='#166534'; msg.style.border='1px solid #bbf7d0';
        msg.textContent = 'Welcome back! Redirecting…';
        setTimeout(() => location.href = 'index.php', 800);
    } else {
        msg.style.background='#fef2f2'; msg.style.color='#991b1b'; msg.style.border='1px solid #fecaca';
        msg.textContent = data.error || 'Login failed.';
        btn.disabled = false;
        btn.textContent = 'Sign In';
    }
});
</script>
