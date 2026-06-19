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
    } catch (PDOException $e) {
        // Fallback or ignore if table does not exist yet (it will be created by database.sql)
    }
} catch (PDOException $e) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
}
?>
