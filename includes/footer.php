<footer>
    <div class="footer-inner">
        <div class="footer-brand">
            <img src="image/logo.png" alt="Eira" class="footer-logo">
            <p>Handcrafted with love, delivered to your door.</p>
        </div>
        <div class="footer-links">
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="favorites.php">Favorites</a>
            <a href="contact.php">Contact</a>
        </div>
    </div>
    <div class="footer-bottom">© 2026 Eira Store. All rights reserved.</div>
</footer>

<div id="toast"></div>

<!-- Order Popup Form -->
<div id="popupForm" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;">
    <div id="orderFormBox" style="background:#fff;padding:32px;border-radius:16px;width:min(95%,480px);position:relative;max-height:90vh;overflow-y:auto;">
        <button type="button" onclick="closeForm()" style="position:absolute;top:12px;right:16px;background:none;border:none;font-size:20px;cursor:pointer;">✕</button>
        <h2 style="color:rgb(74,23,122);margin-bottom:4px;font-family:'Playfair Display',serif;">Place Your Order</h2>
        <p style="color:#888;font-size:13px;margin-bottom:20px;">Fill in your details and we'll deliver to you 💜</p>

        <div id="orderSummaryBox" style="background:#faf7ff;border-radius:10px;padding:14px;margin-bottom:18px;display:none;">
            <div style="font-weight:600;font-size:14px;color:rgb(74,23,122);margin-bottom:8px;">Order Summary</div>
            <div id="orderSummaryItems"></div>
            <div style="border-top:1px solid #e0d6f5;margin-top:10px;padding-top:10px;display:flex;justify-content:space-between;font-weight:700;">
                <span>Total</span><span id="orderSummaryTotal" style="color:rgb(74,23,122);"></span>
            </div>
        </div>

        <form id="orderform" onsubmit="submitOrder(event)" style="display:flex;flex-direction:column;gap:14px;">
            <div>
                <label style="font-size:13px;font-weight:500;display:block;margin-bottom:4px;">Your Name *</label>
                <input type="text" id="orderCustomerName" required placeholder="Full name"
                    style="width:100%;padding:10px 14px;border:1px solid #e0d6f5;border-radius:8px;font-size:14px;box-sizing:border-box;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:500;display:block;margin-bottom:4px;">Phone Number *</label>
                <input type="tel" id="orderPhone" required placeholder="+964 7xx xxx xxxx"
                    style="width:100%;padding:10px 14px;border:1px solid #e0d6f5;border-radius:8px;font-size:14px;box-sizing:border-box;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:500;display:block;margin-bottom:4px;">Delivery Address *</label>
                <input type="text" id="orderAddress" required placeholder="City, neighborhood, street..."
                    style="width:100%;padding:10px 14px;border:1px solid #e0d6f5;border-radius:8px;font-size:14px;box-sizing:border-box;">
            </div>
            <div>
                <label style="font-size:13px;font-weight:500;display:block;margin-bottom:4px;">Preferred Delivery Time *</label>
                <select id="orderDeliveryTime" required
                    style="width:100%;padding:10px 14px;border:1px solid #e0d6f5;border-radius:8px;font-size:14px;box-sizing:border-box;background:#fff;">
                    <option value="">— Select time slot —</option>
                    <option value="Morning (9AM – 12PM)">Morning (9AM – 12PM)</option>
                    <option value="Afternoon (12PM – 4PM)">Afternoon (12PM – 4PM)</option>
                    <option value="Evening (4PM – 8PM)">Evening (4PM – 8PM)</option>
                    <option value="Any time">Any time</option>
                </select>
            </div>
            <div>
                <label style="font-size:13px;font-weight:500;display:block;margin-bottom:4px;">Notes (optional)</label>
                <textarea id="orderNotes" rows="2" placeholder="Any special instructions..."
                    style="width:100%;padding:10px 14px;border:1px solid #e0d6f5;border-radius:8px;font-size:14px;box-sizing:border-box;resize:vertical;"></textarea>
            </div>
            <input type="hidden" id="orderProductsJson" value="">
            <button type="submit" class="orderBtn" style="width:100%;padding:14px;font-size:15px;">Confirm Order 💜</button>
        </form>
    </div>
</div>

<script src="script.js"></script>
