
CREATE DATABASE IF NOT EXISTS `techluxury` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `techluxury`;

-- Table: users
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `fullname` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `role` VARCHAR(10) NOT NULL DEFAULT 'user', -- 'admin' or 'user'
    `status` VARCHAR(10) NOT NULL DEFAULT 'active', -- 'active' or 'blocked'
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: products
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(15,2) NOT NULL,
    `cost_price` DECIMAL(15,2) NOT NULL DEFAULT 0,
    `stock` INT NOT NULL DEFAULT 10,
    `category` VARCHAR(50) NOT NULL, -- 'laptop', 'phone', 'accessory'
    `is_sale` TINYINT(1) NOT NULL DEFAULT 0, -- 0 or 1
    `img` VARCHAR(255) NOT NULL, -- image filename (e.g. ip16pm.webp)
    `specs` TEXT DEFAULT NULL, -- specs string
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: orders
CREATE TABLE IF NOT EXISTS `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NULL,
    `order_code` VARCHAR(20) NOT NULL UNIQUE, -- order code (e.g. TL-1234)
    `customer_name` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `address` TEXT NOT NULL,
    `notes` TEXT DEFAULT NULL,
    `payment_method` VARCHAR(20) NOT NULL, -- 'cod', 'bank', 'card'
    `total_amount` DECIMAL(15,2) NOT NULL,
    `status` VARCHAR(50) NOT NULL DEFAULT 'Chờ thanh toán', -- 'Chờ thanh toán', 'Đang xử lý', 'Đã thanh toán', 'Đang giao hàng', 'Hoàn thành', 'Đã hủy'
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: order_items
CREATE TABLE IF NOT EXISTS `order_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `product_name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(15,2) NOT NULL,
    `quantity` INT NOT NULL,
    FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed default users
-- Note: bcrypt hash for 'admin' is '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' (usually matches password 'password' but we will use plain check OR verify)
-- We will insert 'admin' and 'user' passwords as '$2y$10$cFEFzQG4GZ/lVv7o66G2K.L0.Bw7qMh.p1/KfeJ.2t54n3W.91B6G' (which is 'admin' and 'user' hashes, or we'll allow plaintext checks)
INSERT INTO `users` (`username`, `password`, `fullname`, `email`, `role`, `status`) VALUES
('admin', 'admin', 'Admin Premium', 'admin@techluxury.vn', 'admin', 'active'), -- will be auto-hashed on first login
('user', 'user', 'Nguyễn Văn Hùng', 'hungnv@gmail.com', 'user', 'active') -- will be auto-hashed on first login
ON DUPLICATE KEY UPDATE `username`=`username`;
 
-- Seed default products
INSERT INTO `products` (`name`, `price`, `cost_price`, `stock`, `category`, `is_sale`, `img`, `specs`) VALUES
('Macbook Pro M4', 59990000, 48000000, 15, 'laptop', 1, 'macbook-pro-14-inch-m4-pro-24gb-1tb-20gpu-bac-1-639104240462766154-750x500.jpg', 'Chip Apple M4, RAM 16G, SSD 512G, Màn Liquid Retina'),
('Dell XPS 15', 45990000, 38000000, 8, 'laptop', 0, 'DELL.webp', 'Intel Core i7, RAM 16G, SSD 512G, Màn OLED Touch'),
('iPhone 16 Pro Max', 35990000, 29000000, 25, 'phone', 1, 'ip16pm.webp', 'Chip A18 Pro, Camera 48MP Zoom 5x, Khung Titanium'),
('Samsung S24 Ultra', 31990000, 25000000, 12, 'phone', 0, 'Galaxy s24ultra.webp', 'Snapdragon 8 Gen 3, Camera 200MP, Bút S-Pen, Galaxy AI'),
('AirPods Pro Max', 12990000, 10000000, 30, 'accessory', 1, 'AIRPOD.webp', 'ANC Đỉnh cao, Âm thanh Spatial, Pin 20H, Bao da Smart'),
('Galaxy Buds 3', 5990000, 4500000, 50, 'accessory', 0, 'Galaxy bud3.webp', 'Chống nước IPX7, Bluetooth 5.3, Âm bass ấm, Galaxy AI'),
('iPhone 16 Standard', 22990000, 18500000, 18, 'phone', 0, 'ip16standard.webp', 'Chip A18 Bionic, Camera 48MP, Dynamic Island, 128GB'),
('ASUS ROG Strix G16', 38490000, 31000000, 6, 'laptop', 0, 'ASUS ROG.webp', 'Nvidia RTX 4060, Intel i7-13650HX, RAM 16G, Màn 165Hz'),
('Xiaomi 14 Ultra Leica', 26990000, 21000000, 14, 'phone', 1, 'XIAOMI.webp', 'Ống kính Leica, Snapdragon 8 Gen 3, Sạc nhanh 90W, 50MP');
-- Table: categories
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE,
    `display_name` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed default categories
INSERT INTO `categories` (`name`, `display_name`) VALUES
('laptop', 'Laptop'),
('phone', 'Điện thoại'),
('accessory', 'Phụ kiện')
ON DUPLICATE KEY UPDATE `name`=`name`;

-- Table: import_vouchers
CREATE TABLE IF NOT EXISTS `import_vouchers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `voucher_code` VARCHAR(20) NOT NULL UNIQUE,
    `provider` VARCHAR(100) NOT NULL,
    `total_amount` DECIMAL(15,2) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: import_voucher_items
CREATE TABLE IF NOT EXISTS `import_voucher_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `voucher_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `quantity` INT NOT NULL,
    `import_price` DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (`voucher_id`) REFERENCES `import_vouchers` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

