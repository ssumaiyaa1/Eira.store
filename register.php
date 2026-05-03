<?php
$pageTitle = 'Sign Up – Eira Store';
require_once 'includes/auth.php';
if (isLoggedIn()) { header('Location: index.php'); exit; }
require_once 'includes/header.php';
?>

<section style="padding:100px;">
    <div style="background:#fff;border-radius:20px;box-shadow:0 8px 40px rgba(74,23,122,.12);padding:48px 40px;width:min(100%,420px);margin:auto">
        <div style="text-align:center;margin-bottom:32px;">
            <img src="image/logo.png" alt="Eira" height="70">
            <h2 style="margin-top:12px;font-family:'Playfair Display',serif;">Create an Account</h2>
            <p style="color:#888;font-size:14px;">Join the Eira community</p>
        </div>

        <div id="registerMsg" style="display:none;padding:12px 16px;border-radius:10px;margin-bottom:20px;text-align:center;font-size:14px;"></div>

        <form id="registerForm" style="display:flex;flex-direction:column;gap:16px;">
            <div>
                <label style="display:block;margin-bottom:6px;font-weight:500;font-size:14px;">Full Name</label>
                <input type="text" id="regName" placeholder="Sara Ahmed" required
                       style="width:100%;padding:12px 16px;border:1px solid #e0d6f5;border-radius:10px;font-size:15px;box-sizing:border-box;outline:none;transition:border .2s;"
                       onfocus="this.style.borderColor='rgb(74,23,122)'" onblur="this.style.borderColor='#e0d6f5'">
            </div>
            <div>
                <label style="display:block;margin-bottom:6px;font-weight:500;font-size:14px;">Email Address</label>
                <input type="email" id="regEmail" placeholder="you@example.com" required
                       style="width:100%;padding:12px 16px;border:1px solid #e0d6f5;border-radius:10px;font-size:15px;box-sizing:border-box;outline:none;transition:border .2s;"
                       onfocus="this.style.borderColor='rgb(74,23,122)'" onblur="this.style.borderColor='#e0d6f5'">
            </div>
            <div>
                <label style="display:block;margin-bottom:6px;font-weight:500;font-size:14px;">Password</label>
                <input type="password" id="regPassword" placeholder="Min. 6 characters" required minlength="6"
                       style="width:100%;padding:12px 16px;border:1px solid #e0d6f5;border-radius:10px;font-size:15px;box-sizing:border-box;outline:none;transition:border .2s;"
                       onfocus="this.style.borderColor='rgb(74,23,122)'" onblur="this.style.borderColor='#e0d6f5'">
            </div>
            <div>
                <label style="display:block;margin-bottom:6px;font-weight:500;font-size:14px;">Confirm Password</label>
                <input type="password" id="regConfirm" placeholder="Re-enter password" required
                       style="width:100%;padding:12px 16px;border:1px solid #e0d6f5;border-radius:10px;font-size:15px;box-sizing:border-box;outline:none;transition:border .2s;"
                       onfocus="this.style.borderColor='rgb(74,23,122)'" onblur="this.style.borderColor='#e0d6f5'">
            </div>
            <button type="submit" class="orderBtn" style="width:100%;padding:14px;font-size:15px;margin-top:4px;">Create Account</button>
        </form>

        <p style="text-align:center;margin-top:24px;font-size:14px;color:#888;">
            Already have an account? <a href="login.php" style="color:rgb(74,23,122);font-weight:600;">Sign In</a>
        </p>
    </div>
</section>



<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const msg = document.getElementById('registerMsg');
    msg.style.display = 'none';

    const password = document.getElementById('regPassword').value;
    const confirm  = document.getElementById('regConfirm').value;
    if (password !== confirm) {
        msg.style.display='block'; msg.style.background='#fef2f2'; msg.style.color='#991b1b'; msg.style.border='1px solid #fecaca';
        msg.textContent = 'Passwords do not match.';
        return;
    }

    const btn = this.querySelector('button[type=submit]');
    btn.disabled = true;
    btn.textContent = 'Creating account…';

    const res  = await fetch('api/register.php', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify({
            name:     document.getElementById('regName').value,
            email:    document.getElementById('regEmail').value,
            password: password
        })
    });
    const data = await res.json();
    msg.style.display = 'block';

    if (data.success) {
        msg.style.background='#f0fdf4'; msg.style.color='#166534'; msg.style.border='1px solid #bbf7d0';
        msg.textContent = 'Account created! Redirecting…';
        setTimeout(() => location.href = 'index.php', 800);
    } else {
        msg.style.background='#fef2f2'; msg.style.color='#991b1b'; msg.style.border='1px solid #fecaca';
        msg.textContent = data.error || 'Registration failed.';
        btn.disabled = false;
        btn.textContent = 'Create Account';
    }
});
</script>
