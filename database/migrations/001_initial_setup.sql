-- ============================================
-- SO Framework - Initial Database Setup
-- ============================================
-- This migration creates all required tables for the framework
-- Run with: mysql -u root -p database_name < 001_initial_setup.sql
-- ============================================

-- 1. Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_remember_token (remember_token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Posts Table
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Password Resets Table
CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    INDEX idx_email (email),
    INDEX idx_token (token),
    INDEX idx_expires_at (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Sessions Table (Database-driven sessions)
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Jobs Table (Queue system)
CREATE TABLE IF NOT EXISTS jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX jobs_queue_index (queue)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Failed Jobs Table
CREATE TABLE IF NOT EXISTS failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX failed_jobs_uuid_index (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Job Batches Table
CREATE TABLE IF NOT EXISTS job_batches (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Notifications Table
CREATE TABLE IF NOT EXISTS notifications (
    id CHAR(36) NOT NULL PRIMARY KEY,
    type VARCHAR(255) NOT NULL,
    notifiable_type VARCHAR(255) NOT NULL,
    notifiable_id BIGINT UNSIGNED NOT NULL,
    data TEXT NOT NULL,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX notifications_notifiable_type_notifiable_id_index (notifiable_type, notifiable_id),
    INDEX notifications_read_at_index (read_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Activity Log Table (Audit trail)
CREATE TABLE IF NOT EXISTS activity_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    log_name VARCHAR(255) NULL,
    description TEXT NOT NULL,
    subject_type VARCHAR(255) NULL,
    subject_id BIGINT UNSIGNED NULL,
    event VARCHAR(255) NULL,
    causer_type VARCHAR(255) NULL,
    causer_id BIGINT UNSIGNED NULL,
    properties JSON NULL,
    batch_uuid CHAR(36) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX subject (subject_type, subject_id),
    INDEX causer (causer_type, causer_id),
    INDEX log_name (log_name),
    INDEX created_at_index (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Cache Table
CREATE TABLE IF NOT EXISTS cache (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL,
    INDEX cache_expiration_index (expiration)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Cache Locks Table
CREATE TABLE IF NOT EXISTS cache_locks (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Personal Access Tokens Table (API authentication)
CREATE TABLE IF NOT EXISTS personal_access_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    abilities TEXT NULL,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX personal_access_tokens_tokenable_type_tokenable_id_index (tokenable_type, tokenable_id),
    INDEX personal_access_tokens_token_index (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. Migrations Table (Track migrations)
CREATE TABLE IF NOT EXISTS migrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DEMO TABLES - Routing & Feature Demos
-- ============================================

-- 14. Categories Table (Nested/hierarchical data)
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    parent_id INT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_parent_id (parent_id),
    INDEX idx_is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. Products Table (Full-featured with soft deletes)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    sku VARCHAR(100) NOT NULL UNIQUE,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock INT NOT NULL DEFAULT 0,
    status ENUM('active', 'inactive', 'draft') DEFAULT 'draft',
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_category_id (category_id),
    INDEX idx_slug (slug),
    INDEX idx_sku (sku),
    INDEX idx_status (status),
    INDEX idx_price (price),
    INDEX idx_deleted_at (deleted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 16. Tags Table (Many-to-many demo)
CREATE TABLE IF NOT EXISTS tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 17. Product Tags Pivot Table
CREATE TABLE IF NOT EXISTS product_tags (
    product_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (product_id, tag_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 18. Reviews Table (Nested resource demo)
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    title VARCHAR(255) NOT NULL,
    comment TEXT NULL,
    is_approved TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_product_id (product_id),
    INDEX idx_user_id (user_id),
    INDEX idx_rating (rating),
    INDEX idx_is_approved (is_approved)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DUMMY DATA
-- ============================================

-- Demo user (password: password123)
INSERT IGNORE INTO users (id, name, email, password) VALUES
(1, 'Admin User', 'admin@example.com', '$argon2id$v=19$m=65536,t=4,p=1$d3dUWjdQeHlKUkNPdmxZYg$FkH3VwT8R5cSJmqXYQ2K+Dg8nL6mZ5P9vX1wB0kA3hY'),
(2, 'John Doe', 'john@example.com', '$argon2id$v=19$m=65536,t=4,p=1$d3dUWjdQeHlKUkNPdmxZYg$FkH3VwT8R5cSJmqXYQ2K+Dg8nL6mZ5P9vX1wB0kA3hY'),
(3, 'Jane Smith', 'jane@example.com', '$argon2id$v=19$m=65536,t=4,p=1$d3dUWjdQeHlKUkNPdmxZYg$FkH3VwT8R5cSJmqXYQ2K+Dg8nL6mZ5P9vX1wB0kA3hY');

-- Categories (parent + child hierarchy)
INSERT IGNORE INTO categories (id, name, slug, description, parent_id, is_active) VALUES
(1, 'Electronics',   'electronics',   'Electronic devices and gadgets',    NULL, 1),
(2, 'Clothing',      'clothing',      'Apparel and fashion',               NULL, 1),
(3, 'Books',         'books',         'Physical and digital books',        NULL, 1),
(4, 'Home & Garden', 'home-garden',   'Home improvement and garden items', NULL, 1),
(5, 'Laptops',       'laptops',       'Portable computers',               1,    1),
(6, 'Smartphones',   'smartphones',   'Mobile phones and accessories',    1,    1),
(7, 'Mens Wear',     'mens-wear',     'Clothing for men',                 2,    1),
(8, 'Fiction',       'fiction',        'Fiction books and novels',         3,    0);

-- Products (various statuses, categories, prices)
INSERT IGNORE INTO products (id, category_id, name, slug, sku, price, stock, status, description) VALUES
(1,  5, 'Laptop Pro 15',         'laptop-pro-15',         'LP15-001',  1299.99, 25,  'active',   'High-performance 15-inch laptop with M3 chip'),
(2,  5, 'Laptop Air 13',         'laptop-air-13',         'LA13-002',   999.99, 50,  'active',   'Ultra-thin 13-inch laptop, perfect for travel'),
(3,  6, 'SmartPhone X',          'smartphone-x',          'SPX-003',    899.99, 100, 'active',   'Flagship smartphone with 6.7-inch OLED display'),
(4,  6, 'SmartPhone Lite',       'smartphone-lite',       'SPL-004',    499.99, 200, 'active',   'Affordable smartphone with great camera'),
(5,  1, 'Wireless Earbuds Pro',  'wireless-earbuds-pro',  'WEP-005',   199.99, 150, 'active',   'Noise-cancelling wireless earbuds'),
(6,  7, 'Classic Polo Shirt',    'classic-polo-shirt',    'CPS-006',    49.99,  300, 'active',   'Premium cotton polo in multiple colors'),
(7,  7, 'Slim Fit Jeans',        'slim-fit-jeans',        'SFJ-007',    79.99,  180, 'active',   'Modern slim-fit denim jeans'),
(8,  2, 'Running Shoes',         'running-shoes',         'RS-008',     129.99, 80,  'active',   'Lightweight running shoes with cushioned sole'),
(9,  3, 'PHP Design Patterns',   'php-design-patterns',   'PDP-009',    39.99,  60,  'active',   'Complete guide to design patterns in PHP'),
(10, 8, 'The Great Novel',       'the-great-novel',       'TGN-010',    14.99,  400, 'active',   'Bestselling fiction novel of the year'),
(11, 4, 'Garden Tool Set',       'garden-tool-set',       'GTS-011',    89.99,  45,  'inactive', 'Professional 5-piece garden tool kit'),
(12, 4, 'Smart LED Bulb',        'smart-led-bulb',        'SLB-012',    24.99,  500, 'active',   'WiFi-enabled color-changing LED bulb'),
(13, 1, '4K Webcam',             '4k-webcam',             '4KW-013',    149.99, 0,   'inactive', '4K Ultra HD webcam with auto-focus'),
(14, 5, 'Budget Laptop 14',      'budget-laptop-14',      'BL14-014',   599.99, 35,  'draft',    'Entry-level 14-inch laptop for students'),
(15, 6, 'SmartPhone Ultra',      'smartphone-ultra',      'SPU-015',   1499.99, 10,  'draft',    'Next-gen smartphone, coming soon');

-- Tags
INSERT IGNORE INTO tags (id, name, slug) VALUES
(1, 'New Arrival',  'new-arrival'),
(2, 'Best Seller',  'best-seller'),
(3, 'On Sale',      'on-sale'),
(4, 'Premium',      'premium'),
(5, 'Eco Friendly', 'eco-friendly'),
(6, 'Limited',      'limited'),
(7, 'Trending',     'trending'),
(8, 'Budget',       'budget');

-- Product-Tag relationships
INSERT IGNORE INTO product_tags (product_id, tag_id) VALUES
(1, 4), (1, 2),
(2, 1), (2, 7),
(3, 1), (3, 4), (3, 7),
(4, 8), (4, 2),
(5, 1), (5, 7),
(6, 2), (6, 5),
(7, 3), (7, 7),
(8, 2), (8, 5),
(9, 4),
(10, 2), (10, 3),
(11, 5),
(12, 1), (12, 8),
(14, 8),
(15, 6), (15, 4);

-- Reviews
INSERT IGNORE INTO reviews (id, product_id, user_id, rating, title, comment, is_approved) VALUES
(1,  1, 1, 5, 'Incredible performance', 'Best laptop I have ever owned. The M3 chip is blazing fast.', 1),
(2,  1, 2, 4, 'Great but pricey',       'Amazing build quality, wish it was a bit cheaper.', 1),
(3,  2, 3, 5, 'Perfect travel companion', 'So light and the battery lasts forever.', 1),
(4,  3, 1, 4, 'Beautiful display',       'The OLED screen is stunning, camera could be better.', 1),
(5,  3, 2, 3, 'Good but overheats',      'Gets warm during gaming sessions.', 1),
(6,  4, 3, 5, 'Best value phone',        'Unbeatable at this price point.', 1),
(7,  5, 1, 5, 'Sound quality is amazing', 'Noise cancellation is top-notch.', 1),
(8,  6, 2, 4, 'Comfortable fit',         'Soft fabric and true to size.', 1),
(9,  9, 1, 5, 'Must-read for PHP devs',  'Covers all major patterns with real examples.', 1),
(10, 9, 3, 4, 'Solid reference book',    'Well-written, good for intermediate developers.', 1),
(11, 10, 2, 3, 'Decent read',            'Interesting plot but slow in the middle.', 0),
(12, 12, 1, 4, 'Easy to setup',          'Connected to WiFi in seconds. Great app.', 1);
