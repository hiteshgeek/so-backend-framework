-- ============================================
-- SO Framework - Demo/Testing Tables Migration
-- ============================================
-- This migration creates DEMO tables for testing the framework
-- These tables go in your main application database
-- Run with: mysql -u root -p < 002_demo_tables.sql
--
-- Table Constants Reference: App\Constants\DatabaseTables
-- Database Connection: app('db')
--
-- NOTE: These are DEMO tables. You can safely remove or modify them
-- for your production application.
-- ============================================

-- Create database if it doesn't exist
-- IMPORTANT: Change 'so_framework' to your application database name
CREATE DATABASE IF NOT EXISTS so_framework
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Use the database
USE so_framework;

-- ============================================

-- 1. Posts Table (Demo content)
-- Constant: DatabaseTables::POSTS
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Categories Table (Nested/hierarchical data demo)
-- Constant: DatabaseTables::CATEGORIES
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

-- 3. Products Table (Full-featured demo with soft deletes)
-- Constant: DatabaseTables::PRODUCTS
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

-- 4. Tags Table (Many-to-many demo)
-- Constant: DatabaseTables::TAGS
CREATE TABLE IF NOT EXISTS tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Product Tags Pivot Table (Many-to-many relationship)
-- Constant: DatabaseTables::PRODUCT_TAGS
CREATE TABLE IF NOT EXISTS product_tags (
    product_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (product_id, tag_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Reviews Table (Nested resource demo)
-- Constant: DatabaseTables::REVIEWS
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
    INDEX idx_product_id (product_id),
    INDEX idx_user_id (user_id),
    INDEX idx_rating (rating),
    INDEX idx_is_approved (is_approved)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DEMO DATA (Optional - for testing)
-- ============================================
-- This section inserts sample data for testing purposes.
-- You can safely remove this entire section for production.
-- ============================================

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
-- Note: user_id references users in so_essentials.users table
-- Make sure you have created demo users first (see 001_framework_essentials.sql)
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

-- ============================================
-- END OF DEMO TABLES
-- ============================================
-- Total Tables: 6 (posts, categories, products, tags, product_tags, reviews)
-- Database: Your application database
-- Access: app('db')->table(DatabaseTables::CONSTANT_NAME)
--
-- To remove demo tables and data for production:
-- DROP TABLE IF EXISTS reviews, product_tags, tags, products, categories, posts;
-- ============================================
