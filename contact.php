
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$pageTitle = 'Contact – Eira Store';
require_once 'includes/header.php';
?>

<section id="contact" >
    <h2 >Get In Touch</h2>
    <p style="text-align:center;color:#888;margin-bottom:36px;">Have a question or custom order request? We'd love to hear from you.</p>

    <div id="contactMsg" style="display:none;padding:14px 20px;border-radius:10px;margin-bottom:20px;text-align:center;font-weight:500;"></div>

    <form  action="#" method="POST" id="contactForm" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:16px;">
        <div>
            <label>Your Name</label><br>
            <input type="text" id="cName" placeholder="e.g. Sara Ahmed" required>
        </div>
        <div>
            <label>Email Address</label><br>
            <input type="email" name="email" id="cEmail" placeholder="you@example.com" required>
        </div>
        <div>
            <label style="width: 50%;font-size:22px;">Upload Image</label>
            <input type="file" id="file" name="image" style="width:50%;color:var(--ink);" accept="image/*">
         
        </div>
        <div>
            <label >Message</label><br>
            <textarea id="cMessage" rows="5" placeholder="Tell us what you need…" required></textarea>
        </div>
        <button type="submit" class="orderBtn">Send Message</button>
    </form>

    <div style="margin-top:50px;text-align:center;color:#888;">
        <p>Or reach us on Instagram: <a href="https://www.instagram.com/eira.store/" target="_blank" style="color:rgb(74,23,122);">@eira.store</a></p>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<script>
document.getElementById('contactForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type=submit]');
    btn.disabled = true;
    btn.textContent = 'Sending…';

    const formData = new FormData();
    formData.append('name',    document.getElementById('cName').value);
    formData.append('email',   document.getElementById('cEmail').value);
    formData.append('message', document.getElementById('cMessage').value);
    if (document.getElementById('file').files[0]) {
        formData.append('image', document.getElementById('file').files[0]);
    }

    const res = await fetch('api/contact.php', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();
    const msg  = document.getElementById('contactMsg');
    msg.style.display = 'block';

    if (data.success) {
        msg.style.background = '#f0fdf4';
        msg.style.color       = '#166534';
        msg.style.border      = '1px solid #bbf7d0';
        msg.textContent       = data.message;
        this.reset();
    } else {
        msg.style.background = '#fef2f2';
        msg.style.color       = '#991b1b';
        msg.style.border      = '1px solid #fecaca';
        msg.textContent       = data.error || 'Something went wrong.';
    }
    btn.disabled = false;
    btn.textContent = 'Send Message';
});
</script>
