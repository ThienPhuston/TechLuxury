<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read input (support JSON)
    $input = json_decode(file_get_contents('php://input'), true);
    
    $customer_name = trim($input['customer_name'] ?? '');
    $phone = trim($input['phone'] ?? '');
    $address = trim($input['address'] ?? '');
    $notes = trim($input['notes'] ?? '');
    $payment_method = trim($input['payment_method'] ?? 'cod');
    $cart = $input['cart'] ?? [];

    if (empty($customer_name) || empty($phone) || empty($address) || empty($cart)) {
        echo json_encode(['success' => false, 'message' => 'Thông tin đặt hàng không đầy đủ!']);
        exit;
    }

    try {
        // Calculate total amount and pre-verify stock
        $total_amount = 0;
        foreach ($cart as $item) {
            $price = intval($item['price']);
            $qty = intval($item['quantity']);
            $total_amount += $price * $qty;

            // Pre-check stock
            $prod_stmt = $conn->prepare("SELECT stock FROM products WHERE name = :name LIMIT 1");
            $prod_stmt->execute(['name' => $item['title']]);
            $prod = $prod_stmt->fetch();
            if (!$prod) {
                echo json_encode(['success' => false, 'message' => 'Sản phẩm "' . $item['title'] . '" không tồn tại trên hệ thống!']);
                exit;
            }
            if ($prod['stock'] < $qty) {
                echo json_encode(['success' => false, 'message' => 'Sản phẩm "' . $item['title'] . '" chỉ còn lại ' . $prod['stock'] . ' chiếc trong kho! Vui lòng giảm số lượng.']);
                exit;
            }
        }

        // Generate unique order code (TL-XXXX)
        $order_code = '';
        $is_unique = false;
        while (!$is_unique) {
            $rand = rand(1000, 9999);
            $order_code = 'TL-' . $rand;
            
            // Check uniqueness
            $check_stmt = $conn->prepare("SELECT id FROM orders WHERE order_code = :code");
            $check_stmt->execute(['code' => $order_code]);
            if (!$check_stmt->fetch()) {
                $is_unique = true;
            }
        }

        // Start transaction
        $conn->beginTransaction();

        // Initial order status based on payment method
        $status = ($payment_method === 'cod') ? 'Đang xử lý' : 'Chờ thanh toán';

        // Get user_id if logged in
        $user_id = isset($_SESSION['user']['id']) ? intval($_SESSION['user']['id']) : null;

        // Insert into orders
        $order_stmt = $conn->prepare("
            INSERT INTO orders (user_id, order_code, customer_name, phone, address, notes, payment_method, total_amount, status) 
            VALUES (:user_id, :order_code, :customer_name, :phone, :address, :notes, :payment_method, :total_amount, :status)
        ");
        $order_stmt->execute([
            'user_id' => $user_id,
            'order_code' => $order_code,
            'customer_name' => $customer_name,
            'phone' => $phone,
            'address' => $address,
            'notes' => $notes,
            'payment_method' => $payment_method,
            'total_amount' => $total_amount,
            'status' => $status
        ]);
        
        $order_id = $conn->lastInsertId();

        // Insert order items & deduct stock
        $item_stmt = $conn->prepare("
            INSERT INTO order_items (order_id, product_name, price, quantity) 
            VALUES (:order_id, :product_name, :price, :quantity)
        ");
        $update_stock_stmt = $conn->prepare("
            UPDATE products SET stock = stock - :qty WHERE name = :name
        ");

        foreach ($cart as $item) {
            // Deduct stock and insert item
            $qty = intval($item['quantity']);
            
            // Safety double check inside transaction
            $prod_stmt = $conn->prepare("SELECT stock FROM products WHERE name = :name FOR UPDATE");
            $prod_stmt->execute(['name' => $item['title']]);
            $prod = $prod_stmt->fetch();
            
            if (!$prod || $prod['stock'] < $qty) {
                throw new Exception('Sản phẩm "' . $item['title'] . '" không đủ tồn kho!');
            }

            $item_stmt->execute([
                'order_id' => $order_id,
                'product_name' => $item['title'],
                'price' => $item['price'],
                'quantity' => $qty
            ]);

            $update_stock_stmt->execute([
                'qty' => $qty,
                'name' => $item['title']
            ]);
        }

        // Commit transaction
        $conn->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Đặt hàng thành công!',
            'orderId' => $order_code,
            'db_id' => $order_id,
            'paymentMethod' => $payment_method,
            'totalAmount' => $total_amount
        ]);
        exit;

    } catch (Exception $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        echo json_encode(['success' => false, 'message' => 'Lỗi xử lý đơn hàng: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Phương thức yêu cầu không hợp lệ!']);
    exit;
}
?>
