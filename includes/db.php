<?php
if (!defined('DB_HOST')) {
    // Dynamic absolute path to project configuration
    $project_root = str_replace('\\', '/', realpath(dirname(dirname(__FILE__))));
    include_once($project_root . '/admin/config/config.php');
}

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Auto-migrate tables columns if missing
    try {
        $check_cost = $conn->query("SHOW COLUMNS FROM `products` LIKE 'cost_price'")->fetch();
        if (!$check_cost) {
            $conn->exec("ALTER TABLE `products` ADD COLUMN `cost_price` DECIMAL(15,2) NOT NULL DEFAULT 0 AFTER `price`");
        }
        $check_stock = $conn->query("SHOW COLUMNS FROM `products` LIKE 'stock'")->fetch();
        if (!$check_stock) {
            $conn->exec("ALTER TABLE `products` ADD COLUMN `stock` INT NOT NULL DEFAULT 10 AFTER `cost_price`");
        }
        $check_user_id = $conn->query("SHOW COLUMNS FROM `orders` LIKE 'user_id'")->fetch();
        if (!$check_user_id) {
            $conn->exec("ALTER TABLE `orders` ADD COLUMN `user_id` INT NULL AFTER `id`");
            $conn->exec("ALTER TABLE `orders` ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL");
        }

        // Auto-create categories table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS `categories` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(50) NOT NULL UNIQUE,
                `display_name` VARCHAR(100) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        
        // Seed default categories if empty
        $check_cats = $conn->query("SELECT COUNT(*) FROM `categories`")->fetchColumn();
        if ($check_cats == 0) {
            $conn->exec("
                INSERT INTO `categories` (`name`, `display_name`) VALUES
                ('laptop', 'Laptop'),
                ('phone', 'Điện thoại'),
                ('accessory', 'Phụ kiện')
            ");
        }

        // Auto-create brands table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS `brands` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(50) NOT NULL UNIQUE,
                `display_name` VARCHAR(100) NOT NULL,
                `logo_img` VARCHAR(255) DEFAULT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Seed default brands if empty
        $check_brands = $conn->query("SELECT COUNT(*) FROM `brands`")->fetchColumn();
        if ($check_brands == 0) {
            $conn->exec("
                INSERT INTO `brands` (`name`, `display_name`, `logo_img`) VALUES
                ('apple', 'Apple', 'apple-logo.png'),
                ('samsung', 'Samsung', 'samsung-logo.png'),
                ('dell', 'Dell', 'dell-logo.png'),
                ('asus', 'Asus', 'asus-logo.png'),
                ('sony', 'Sony', 'sony-logo.png'),
                ('xiaomi', 'Xiaomi', 'xiaomi-logo.png')
            ");
        }

        // Auto-migrate products to add brand_id column and foreign key if missing
        $check_brand_id = $conn->query("SHOW COLUMNS FROM `products` LIKE 'brand_id'")->fetch();
        if (!$check_brand_id) {
            $conn->exec("ALTER TABLE `products` ADD COLUMN `brand_id` INT NULL AFTER `category`");
            $conn->exec("ALTER TABLE `products` ADD CONSTRAINT `fk_products_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL");
            
            // Link existing seed products to brand_id
            $conn->exec("UPDATE `products` SET `brand_id` = (SELECT `id` FROM `brands` WHERE `name` = 'apple') WHERE LCASE(`name`) LIKE '%macbook%' OR LCASE(`name`) LIKE '%iphone%' OR LCASE(`name`) LIKE '%airpod%'");
            $conn->exec("UPDATE `products` SET `brand_id` = (SELECT `id` FROM `brands` WHERE `name` = 'samsung') WHERE LCASE(`name`) LIKE '%samsung%' OR LCASE(`name`) LIKE '%galaxy%' OR LCASE(`name`) LIKE '%buds%'");
            $conn->exec("UPDATE `products` SET `brand_id` = (SELECT `id` FROM `brands` WHERE `name` = 'dell') WHERE LCASE(`name`) LIKE '%dell%'");
            $conn->exec("UPDATE `products` SET `brand_id` = (SELECT `id` FROM `brands` WHERE `name` = 'asus') WHERE LCASE(`name`) LIKE '%asus%' OR LCASE(`name`) LIKE '%rog%'");
            $conn->exec("UPDATE `products` SET `brand_id` = (SELECT `id` FROM `brands` WHERE `name` = 'sony') WHERE LCASE(`name`) LIKE '%sony%'");
            $conn->exec("UPDATE `products` SET `brand_id` = (SELECT `id` FROM `brands` WHERE `name` = 'xiaomi') WHERE LCASE(`name`) LIKE '%xiaomi%'");
        }

        // Auto-create product_reviews table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS `product_reviews` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `product_id` INT NOT NULL,
                `user_fullname` VARCHAR(100) NOT NULL,
                `rating` INT NOT NULL DEFAULT 5,
                `comment` TEXT DEFAULT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Seed default product reviews if empty
        $check_reviews = $conn->query("SELECT COUNT(*) FROM `product_reviews`")->fetchColumn();
        if ($check_reviews == 0) {
            // Get some active product IDs
            $product_ids = $conn->query("SELECT id FROM `products` ORDER BY id ASC LIMIT 5")->fetchAll(PDO::FETCH_COLUMN);
            if (count($product_ids) >= 4) {
                $conn->exec("
                    INSERT INTO `product_reviews` (`product_id`, `user_fullname`, `rating`, `comment`) VALUES
                    (" . $product_ids[0] . ", 'Trần Minh Hoàng', 5, 'Máy siêu mạnh, màn hình đẹp xuất sắc. Rất đáng tiền!'),
                    (" . $product_ids[0] . ", 'Lê Thị Mai', 4, 'Thiết kế đẹp nhưng hơi nặng một chút. Hiệu năng tuyệt vời.'),
                    (" . $product_ids[1] . ", 'Nguyễn Văn Nam', 5, 'Dòng XPS này dùng làm văn phòng và đồ họa nhẹ rất mượt mà.'),
                    (" . $product_ids[2] . ", 'Phạm Thanh Sơn', 5, 'iPhone 16 Pro Max chụp ảnh quá đỉnh, màu titan tự nhiên rất đẹp.'),
                    (" . $product_ids[2] . ", 'Đỗ Mỹ Linh', 5, 'Pin trâu, dùng cả ngày không hết. Màn hình siêu mượt.'),
                    (" . $product_ids[3] . ", 'Vũ Hoàng Hải', 4, 'Bút S-Pen rất tiện, tuy nhiên máy hơi to so với tay mình.')
                ");
            }
        }

        // Auto-create import_vouchers table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS `import_vouchers` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `voucher_code` VARCHAR(20) NOT NULL UNIQUE,
                `provider` VARCHAR(100) NOT NULL,
                `total_amount` DECIMAL(15,2) NOT NULL DEFAULT 0,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Auto-create import_voucher_items table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS `import_voucher_items` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `voucher_id` INT NOT NULL,
                `product_id` INT NOT NULL,
                `quantity` INT NOT NULL,
                `import_price` DECIMAL(15,2) NOT NULL,
                FOREIGN KEY (`voucher_id`) REFERENCES `import_vouchers` (`id`) ON DELETE CASCADE,
                FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Auto-create coupons table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS `coupons` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `code` VARCHAR(50) NOT NULL UNIQUE,
                `discount_type` VARCHAR(20) NOT NULL,
                `discount_value` DECIMAL(15,2) NOT NULL,
                `min_order_value` DECIMAL(15,2) NOT NULL DEFAULT 0,
                `max_discount` DECIMAL(15,2) DEFAULT NULL,
                `max_uses` INT NOT NULL DEFAULT -1,
                `used_count` INT NOT NULL DEFAULT 0,
                `expiry_date` DATE DEFAULT NULL,
                `status` VARCHAR(20) NOT NULL DEFAULT 'active'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        $check_max_uses = $conn->query("SHOW COLUMNS FROM `coupons` LIKE 'max_uses'")->fetch();
        if (!$check_max_uses) {
            $conn->exec("ALTER TABLE `coupons` ADD COLUMN `max_uses` INT NOT NULL DEFAULT -1 AFTER `max_discount`");
        }
        $check_used_count = $conn->query("SHOW COLUMNS FROM `coupons` LIKE 'used_count'")->fetch();
        if (!$check_used_count) {
            $conn->exec("ALTER TABLE `coupons` ADD COLUMN `used_count` INT NOT NULL DEFAULT 0 AFTER `max_uses`");
        }

        // Seed default coupons if table is empty
        $check_coupons = $conn->query("SELECT COUNT(*) FROM `coupons`")->fetchColumn();
        if ($check_coupons == 0) {
            $conn->exec("
                INSERT INTO `coupons` (`code`, `discount_type`, `discount_value`, `min_order_value`, `max_discount`, `max_uses`, `used_count`, `status`) VALUES
                ('TECHLUXURY500', 'fixed', 500000, 2000000, 500000, -1, 0, 'active'),
                ('GOLD10', 'percent', 10, 5000000, 2000000, -1, 0, 'active')
            ");
        }

        // Auto-migrate orders table to add coupon_code and discount_amount columns
        $check_coupon_code = $conn->query("SHOW COLUMNS FROM `orders` LIKE 'coupon_code'")->fetch();
        if (!$check_coupon_code) {
            $conn->exec("ALTER TABLE `orders` ADD COLUMN `coupon_code` VARCHAR(50) NULL AFTER `payment_method`");
        }
        $check_discount_amount = $conn->query("SHOW COLUMNS FROM `orders` LIKE 'discount_amount'")->fetch();
        if (!$check_discount_amount) {
            $conn->exec("ALTER TABLE `orders` ADD COLUMN `discount_amount` DECIMAL(15,2) NOT NULL DEFAULT 0 AFTER `coupon_code`");
        }
        // Auto-create newsletter_subscribers table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `email` VARCHAR(150) NOT NULL UNIQUE,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    } catch (PDOException $e) {
        // Fallback or ignore if table does not exist yet (it will be created by database.sql)
    }
} catch (PDOException $e) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
}
?>
