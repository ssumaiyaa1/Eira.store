-- =====================================================
--  Eira Store — MySQL Database Schema (Full Version)
-- =====================================================

CREATE DATABASE IF NOT EXISTS eira_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE eira_store;

CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admins (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(150) NOT NULL,
    price        DECIMAL(10,2) NOT NULL,
    category     VARCHAR(50) NOT NULL,
    img          VARCHAR(255) NOT NULL,
    badge        VARCHAR(50) DEFAULT NULL,
    badge_type   VARCHAR(50) DEFAULT NULL,
    description  VARCHAR(255) NOT NULL,
    desc_long    TEXT NOT NULL,
    features     TEXT NOT NULL,
    rating       DECIMAL(3,1) DEFAULT 0,
    review_count INT DEFAULT 0,
    created_at   DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS cart_items (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    product_id INT NOT NULL,
    quantity   INT NOT NULL DEFAULT 1,
    added_at   DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY uq_user_product (user_id, product_id)
);

CREATE TABLE IF NOT EXISTS favorites (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    product_id INT NOT NULL,
    added_at   DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY uq_user_fav (user_id, product_id)
);

CREATE TABLE IF NOT EXISTS orders (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    user_id       INT DEFAULT NULL,
    customer_name VARCHAR(100) NOT NULL,
    phone         VARCHAR(30)  NOT NULL,
    address       VARCHAR(255) NOT NULL,
    delivery_time VARCHAR(100) NOT NULL,
    notes         TEXT DEFAULT NULL,
    status        ENUM('pending','confirmed','shipped','delivered','cancelled') DEFAULT 'pending',
    total_price   DECIMAL(10,2) NOT NULL DEFAULT 0,
    created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS order_items (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    order_id     INT NOT NULL,
    product_id   INT DEFAULT NULL,
    product_name VARCHAR(150) NOT NULL,
    product_img  VARCHAR(255) NOT NULL DEFAULT '',
    unit_price   DECIMAL(10,2) NOT NULL,
    quantity     INT NOT NULL DEFAULT 1,
    FOREIGN KEY (order_id)   REFERENCES orders(id)   ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS reviews (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    user_id       INT DEFAULT NULL,
    reviewer_name VARCHAR(100) NOT NULL,
    product_name  VARCHAR(150) NOT NULL,
    rating        TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    review_text   TEXT NOT NULL,
    created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS contact_messages (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    message    TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Default admin: password = admin123
INSERT IGNORE INTO admins (name, email, password) VALUES
('Admin', 'admin@eira.store', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT IGNORE INTO products (name, price, category, img, badge, badge_type, description, desc_long, features, rating, review_count) VALUES
('Handmade Bag', 45.00, 'bag', 'image/bag.jpg', 'New', 'new',
 'Premium hand-stitched craftsmanship',
 'This beautiful handmade bag is lovingly crafted using premium cotton canvas and reinforced stitching.',
 '["100% Cotton Canvas","Hand-stitched","Magnetic Clasp","Inner Pocket","Washable"]', 4.9, 32),
('Pearl Necklace', 28.00, 'accessory', 'image/accessories.jpg', NULL, NULL,
 'Elegant pearl and crystal centerpiece',
 'A statement piece featuring hand-knotted freshwater pearls and a stunning crystal pendant.',
 '["Freshwater Pearls","Silver-plated Chain","Crystal Pendant","Adjustable Length","Gift Box"]', 4.8, 19),
('Bracelet Set', 18.00, 'accessory', 'image/bracelet.jpg', 'Bestseller', 'bestseller',
 'Natural stone beaded bracelets',
 'A stunning collection of 5 natural stone beaded bracelets with genuine gemstones.',
 '["Genuine Gemstones","Elastic Cord","Set of 5","Linen Pouch","Unisex"]', 5.0, 47),
('Cute Keychain', 12.00, 'keychain', 'image/keychain.jpg', NULL, NULL,
 'Handknit heart charm keychain',
 'A charming heart-shaped keychain handknit with soft macrame cord.',
 '["Handknit Macrame","Steel Key Ring","2.5 inch Size","Custom Colors","Lightweight"]', 4.7, 23),
('Soy Candle', 22.00, 'candle', 'image/candle.jpg', NULL, NULL,
 'Hand-poured with calming scents',
 'Hand-poured using 100% natural soy wax, scented with lavender, vanilla, and cedarwood.',
 '["100% Soy Wax","40-Hour Burn","Cotton Wick","Lavender Vanilla","Frosted Glass Jar"]', 4.9, 38),
('Tote Bag', 38.00, 'bag', 'image/bag.jpg', NULL, NULL,
 'Customizable canvas tote bag',
 'A spacious and sturdy canvas tote built for everyday use. Fully customizable.',
 '["12oz Canvas","Customizable","Double Seams","Long Straps","20lb Capacity"]', 4.6, 14);

INSERT IGNORE INTO reviews (reviewer_name, product_name, rating, review_text) VALUES
('Lina M.',  'Bracelet Set',   5, 'Absolutely stunning! The gemstone colors are so vibrant.'),
('Zara K.',  'Pearl Necklace', 5, 'I ordered this as a gift and she was in tears. Exceptional quality.'),
('Hana R.',  'Handmade Bag',   5, 'The craftsmanship on this bag is incredible. Looks even better in person.'),
('Nour A.',  'Soy Candle',     5, 'The scent is absolutely divine. Just the right amount of warmth.'),
('Yara S.',  'Cute Keychain',  4, 'So cute and well made! The stitching is tight and durable.'),
('Dina F.',  'Tote Bag',       5, 'Had my name embroidered on this and it looks SO good.');
