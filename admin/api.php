<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Require admin authentication
if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== 'admin' || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Quyền truy cập bị từ chối!']);
    exit;
}

require_once '../includes/db.php';

// Auto-create settings table if not exists for convenience
try {
    $conn->exec("
        CREATE TABLE IF NOT EXISTS `settings` (
            `key` VARCHAR(50) PRIMARY KEY,
            `value` TEXT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    
    // Seed default settings if empty
    $check_settings = $conn->query("SELECT COUNT(*) FROM settings")->fetchColumn();
    if ($check_settings == 0) {
        $defaults = [
            'shopName' => 'TECHLUXURY',
            'hotline' => '1900.8989',
            'email' => 'support@techluxury.vn',
            'address' => '123 Đường Lê Lợi, Quận 1, TP. Hồ Chí Minh',
            'discount' => '10',
            'maintenance' => 'active'
        ];
        $insert_setting = $conn->prepare("INSERT INTO settings (`key`, `value`) VALUES (:key, :value)");
        foreach ($defaults as $key => $val) {
            $insert_setting->execute(['key' => $key, 'value' => $val]);
        }
    }
} catch (PDOException $e) {
    // Fail silently or log
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'overview':
        try {
            // Doanh thu thực tế (orders with status: Đã thanh toán, Đang giao hàng, Hoàn thành)
            $rev_stmt = $conn->query("
                SELECT SUM(total_amount) AS revenue 
                FROM orders 
                WHERE status IN ('Đã thanh toán', 'Đang giao hàng', 'Hoàn thành')
            ");
            $revenue = floatval($rev_stmt->fetchColumn() ?? 0);

            // Total orders
            $orders_count = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();

            // Total products
            $products_count = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();

            // Total customers (users with role 'user')
            $customers_count = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn();

            // Recent 5 orders
            $recent_stmt = $conn->query("
                SELECT order_code, customer_name, total_amount, payment_method, status 
                FROM orders 
                ORDER BY id DESC 
                LIMIT 5
            ");
            $recent_orders = $recent_stmt->fetchAll();

            echo json_encode([
                'success' => true,
                'revenue' => $revenue,
                'orders_count' => intval($orders_count),
                'products_count' => intval($products_count),
                'customers_count' => intval($customers_count),
                'recent_orders' => $recent_orders
            ]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'products_list':
        try {
            $stmt = $conn->query("
                SELECT p.*,
                       COALESCE((SELECT SUM(ivi.quantity) FROM import_voucher_items ivi WHERE ivi.product_id = p.id), 0) AS total_imported,
                       COALESCE((SELECT SUM(oi.quantity) FROM order_items oi JOIN orders o ON o.id = oi.order_id WHERE oi.product_name = p.name AND o.status != 'Đã hủy'), 0) AS total_exported
                FROM products p 
                ORDER BY p.id DESC
            ");
            $products = $stmt->fetchAll();
            echo json_encode(['success' => true, 'products' => $products]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'save_product':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            $name = trim($input['name'] ?? '');
            $price = floatval($input['price'] ?? 0);
            $cost_price = floatval($input['costPrice'] ?? 0);
            $stock = intval($input['stock'] ?? 0);
            $category = trim($input['category'] ?? '');
            $is_sale = intval($input['isSale'] ?? 0);
            $img = trim($input['img'] ?? '');
            $specs = trim($input['specs'] ?? '');

            if (empty($name) || $price <= 0 || $cost_price < 0 || $stock < 0 || empty($category) || empty($img)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin hợp lệ (Giá và Tồn kho không được âm)!']);
                exit;
            }

            if ($price < $cost_price) {
                echo json_encode(['success' => false, 'message' => 'Giá bán phải lớn hơn hoặc bằng giá nhập (không thể bán lỗ)!']);
                exit;
            }

            try {
                if (!empty($id)) {
                    // Update mode
                    $stmt = $conn->prepare("
                        UPDATE products 
                        SET name = :name, price = :price, cost_price = :cost_price, stock = :stock, category = :category, is_sale = :is_sale, img = :img, specs = :specs 
                        WHERE id = :id
                    ");
                    $stmt->execute([
                        'name' => $name,
                        'price' => $price,
                        'cost_price' => $cost_price,
                        'stock' => $stock,
                        'category' => $category,
                        'is_sale' => $is_sale,
                        'img' => $img,
                        'specs' => $specs,
                        'id' => $id
                    ]);
                    echo json_encode(['success' => true, 'message' => 'Cập nhật sản phẩm thành công!']);
                } else {
                    // Insert mode
                    $stmt = $conn->prepare("
                        INSERT INTO products (name, price, cost_price, stock, category, is_sale, img, specs) 
                        VALUES (:name, :price, :cost_price, :stock, :category, :is_sale, :img, :specs)
                    ");
                    $stmt->execute([
                        'name' => $name,
                        'price' => $price,
                        'cost_price' => $cost_price,
                        'stock' => $stock,
                        'category' => $category,
                        'is_sale' => $is_sale,
                        'img' => $img,
                        'specs' => $specs
                    ]);
                    echo json_encode(['success' => true, 'message' => 'Thêm sản phẩm thành công!']);
                }
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        break;

    case 'delete_product':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ!']);
                exit;
            }
            try {
                $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
                $stmt->execute(['id' => $id]);
                echo json_encode(['success' => true, 'message' => 'Xóa sản phẩm thành công!']);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        break;

    case 'orders_list':
        try {
            // Get all orders
            $stmt = $conn->query("SELECT * FROM orders ORDER BY id DESC");
            $orders = $stmt->fetchAll();
            
            // Get all order items grouped by order_id
            foreach ($orders as &$order) {
                $item_stmt = $conn->prepare("SELECT product_name AS title, price, quantity FROM order_items WHERE order_id = :order_id");
                $item_stmt->execute(['order_id' => $order['id']]);
                $order['items'] = $item_stmt->fetchAll();
                $order['grandTotal'] = $order['total_amount'];
                $order['orderId'] = $order['order_code'];
                $order['customerName'] = $order['customer_name'];
                $order['paymentMethod'] = $order['payment_method'];
                $order['date'] = date('Y-m-d', strtotime($order['created_at']));
            }
            
            echo json_encode(['success' => true, 'orders' => $orders]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'update_order_status':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $order_code = trim($input['orderId'] ?? '');
            $new_status = trim($input['status'] ?? '');

            if (empty($order_code) || empty($new_status)) {
                echo json_encode(['success' => false, 'message' => 'Thông tin cập nhật không đầy đủ!']);
                exit;
            }

            try {
                $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE order_code = :code");
                $stmt->execute([
                    'status' => $new_status,
                    'code' => $order_code
                ]);
                echo json_encode(['success' => true, 'message' => 'Cập nhật trạng thái đơn hàng thành công!']);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        break;

    case 'customers_list':
        try {
            $stmt = $conn->query("SELECT id, username, fullname, email, role, status FROM users ORDER BY id DESC");
            $users = $stmt->fetchAll();
            echo json_encode(['success' => true, 'users' => $users]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'toggle_customer_role':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            $role = trim($input['role'] ?? '');

            if (!$id || empty($role)) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu yêu cầu không hợp lệ!']);
                exit;
            }

            try {
                $stmt = $conn->prepare("UPDATE users SET role = :role WHERE id = :id");
                $stmt->execute(['role' => $role, 'id' => $id]);
                echo json_encode(['success' => true, 'message' => 'Cập nhật vai trò thành công!']);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        break;

    case 'toggle_customer_status':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            $status = trim($input['status'] ?? '');

            if (!$id || empty($status)) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu yêu cầu không hợp lệ!']);
                exit;
            }

            // Prevent self blocking
            if ($id == $_SESSION['user']['id']) {
                echo json_encode(['success' => false, 'message' => 'Không thể tự khóa tài khoản của chính mình!']);
                exit;
            }

            try {
                $stmt = $conn->prepare("UPDATE users SET status = :status WHERE id = :id");
                $stmt->execute(['status' => $status, 'id' => $id]);
                echo json_encode(['success' => true, 'message' => 'Cập nhật trạng thái thành công!']);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        break;

    case 'get_settings':
        try {
            $stmt = $conn->query("SELECT * FROM settings");
            $rows = $stmt->fetchAll();
            $settings = [];
            foreach ($rows as $row) {
                $settings[$row['key']] = $row['value'];
            }
            echo json_encode(['success' => true, 'settings' => $settings]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'save_settings':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            try {
                $stmt = $conn->prepare("INSERT INTO settings (`key`, `value`) VALUES (:key, :value) ON DUPLICATE KEY UPDATE `value` = :value");
                foreach ($input as $key => $val) {
                    $stmt->execute(['key' => $key, 'value' => $val]);
                }
                echo json_encode(['success' => true, 'message' => 'Cập nhật cấu hình hệ thống thành công!']);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        break;

    case 'upload_image':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['success' => false, 'message' => 'Lỗi tải tệp tin lên máy chủ!']);
                exit;
            }

            $file = $_FILES['image'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!in_array($ext, $allowed)) {
                echo json_encode(['success' => false, 'message' => 'Định dạng tệp không được hỗ trợ (chỉ cho phép JPG, JPEG, PNG, GIF, WEBP)!']);
                exit;
            }

            // Verify it is a valid image
            $check = getimagesize($file['tmp_name']);
            if ($check === false) {
                echo json_encode(['success' => false, 'message' => 'Tệp tải lên không phải là định dạng hình ảnh hợp lệ!']);
                exit;
            }

            // Normalize and unique filename
            $clean_name = preg_replace('/[^a-zA-Z0-9._-]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
            $new_filename = time() . '_' . $clean_name . '.' . $ext;
            $target_dir = '../images/';

            // Ensure directory exists
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            $target_file = $target_dir . $new_filename;

            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                echo json_encode(['success' => true, 'message' => 'Tải ảnh lên thành công!', 'filename' => $new_filename]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể lưu tệp ảnh vào thư mục máy chủ!']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ!']);
        }
        break;


    case 'categories_list':
        try {
            $stmt = $conn->query("SELECT * FROM categories ORDER BY id ASC");
            $cats = $stmt->fetchAll();
            echo json_encode(['success' => true, 'categories' => $cats]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'save_category':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            $name = trim($input['name'] ?? '');
            $display_name = trim($input['display_name'] ?? '');

            if (empty($name) || empty($display_name)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin!']);
                exit;
            }

            $name = strtolower(preg_replace('/[^a-zA-Z0-9-]/', '', $name));

            try {
                if (!empty($id)) {
                    $stmt = $conn->prepare("UPDATE categories SET name = :name, display_name = :display_name WHERE id = :id");
                    $stmt->execute(['name' => $name, 'display_name' => $display_name, 'id' => $id]);
                    echo json_encode(['success' => true, 'message' => 'Cập nhật danh mục thành công!']);
                } else {
                    $stmt = $conn->prepare("INSERT INTO categories (name, display_name) VALUES (:name, :display_name)");
                    $stmt->execute(['name' => $name, 'display_name' => $display_name]);
                    echo json_encode(['success' => true, 'message' => 'Thêm danh mục thành công!']);
                }
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => 'Lỗi: Danh mục đã tồn tại hoặc lỗi CSDL!']);
            }
        }
        break;

    case 'delete_category':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID danh mục không hợp lệ!']);
                exit;
            }
            try {
                $stmt = $conn->prepare("DELETE FROM categories WHERE id = :id");
                $stmt->execute(['id' => $id]);
                echo json_encode(['success' => true, 'message' => 'Xóa danh mục thành công!']);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        break;

    case 'vouchers_list':
        try {
            $stmt = $conn->query("SELECT * FROM import_vouchers ORDER BY id DESC");
            $vouchers = $stmt->fetchAll();
            foreach ($vouchers as &$v) {
                $item_stmt = $conn->prepare("
                    SELECT ivi.*, p.name AS product_name 
                    FROM import_voucher_items ivi
                    JOIN products p ON p.id = ivi.product_id
                    WHERE ivi.voucher_id = :voucher_id
                ");
                $item_stmt->execute(['voucher_id' => $v['id']]);
                $v['items'] = $item_stmt->fetchAll();
            }
            echo json_encode(['success' => true, 'vouchers' => $vouchers]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'save_voucher':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            $voucher_code = trim($input['voucher_code'] ?? '');
            $provider = trim($input['provider'] ?? '');
            $items = $input['items'] ?? [];

            if (empty($voucher_code) || empty($provider) || empty($items)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin phiếu nhập!']);
                exit;
            }

            try {
                $conn->beginTransaction();

                $total_amount = 0;
                foreach ($items as $item) {
                    $total_amount += intval($item['quantity']) * floatval($item['import_price']);
                }

                if (!empty($id)) {
                    // Revert old stock changes
                    $old_items_stmt = $conn->prepare("SELECT * FROM import_voucher_items WHERE voucher_id = :vid");
                    $old_items_stmt->execute(['vid' => $id]);
                    $old_items = $old_items_stmt->fetchAll();

                    $revert_stock = $conn->prepare("UPDATE products SET stock = stock - :qty WHERE id = :pid");
                    foreach ($old_items as $oi) {
                        $revert_stock->execute(['qty' => $oi['quantity'], 'pid' => $oi['product_id']]);
                    }

                    // Delete old items
                    $del_items = $conn->prepare("DELETE FROM import_voucher_items WHERE voucher_id = :vid");
                    $del_items->execute(['vid' => $id]);

                    // Update header
                    $up_v = $conn->prepare("UPDATE import_vouchers SET voucher_code = :code, provider = :provider, total_amount = :total WHERE id = :id");
                    $up_v->execute(['code' => $voucher_code, 'provider' => $provider, 'total' => $total_amount, 'id' => $id]);
                    $voucher_id = $id;
                } else {
                    // Insert header
                    $ins_v = $conn->prepare("INSERT INTO import_vouchers (voucher_code, provider, total_amount) VALUES (:code, :provider, :total)");
                    $ins_v->execute(['code' => $voucher_code, 'provider' => $provider, 'total' => $total_amount]);
                    $voucher_id = $conn->lastInsertId();
                }

                // Insert items & update product stock & cost_price
                $ins_item = $conn->prepare("INSERT INTO import_voucher_items (voucher_id, product_id, quantity, import_price) VALUES (:vid, :pid, :qty, :price)");
                $add_stock = $conn->prepare("UPDATE products SET stock = stock + :qty, cost_price = :price WHERE id = :pid");

                foreach ($items as $item) {
                    $pid = intval($item['product_id']);
                    $qty = intval($item['quantity']);
                    $price = floatval($item['import_price']);

                    $ins_item->execute(['vid' => $voucher_id, 'pid' => $pid, 'qty' => $qty, 'price' => $price]);
                    $add_stock->execute(['qty' => $qty, 'price' => $price, 'pid' => $pid]);
                }

                $conn->commit();
                echo json_encode(['success' => true, 'message' => 'Lưu phiếu nhập thành công!']);
            } catch (Exception $e) {
                if ($conn->inTransaction()) {
                    $conn->rollBack();
                }
                echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
            }
        }
        break;

    case 'delete_voucher':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            if (!$id) {
                echo json_encode(['success' => false, 'message' => 'ID phiếu nhập không hợp lệ!']);
                exit;
            }

            try {
                $conn->beginTransaction();

                $old_items_stmt = $conn->prepare("SELECT * FROM import_voucher_items WHERE voucher_id = :vid");
                $old_items_stmt->execute(['vid' => $id]);
                $old_items = $old_items_stmt->fetchAll();

                $revert_stock = $conn->prepare("UPDATE products SET stock = stock - :qty WHERE id = :pid");
                foreach ($old_items as $oi) {
                    $revert_stock->execute(['qty' => $oi['quantity'], 'pid' => $oi['product_id']]);
                }

                $del_v = $conn->prepare("DELETE FROM import_vouchers WHERE id = :id");
                $del_v->execute(['id' => $id]);

                $conn->commit();
                echo json_encode(['success' => true, 'message' => 'Xóa phiếu nhập và hoàn tác kho thành công!']);
            } catch (Exception $e) {
                if ($conn->inTransaction()) {
                    $conn->rollBack();
                }
                echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
            }
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Hành động không hợp lệ!']);
        break;
}
?>
