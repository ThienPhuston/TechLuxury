<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once '../includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để áp dụng mã giảm giá!']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $code = isset($input['coupon_code']) ? trim($input['coupon_code']) : '';
    $subtotal = isset($input['subtotal']) ? floatval($input['subtotal']) : 0;

    if (empty($code)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập mã giảm giá!']);
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT * FROM coupons WHERE code = :code LIMIT 1");
        $stmt->execute(['code' => $code]);
        $coupon = $stmt->fetch();

        if (!$coupon) {
            echo json_encode(['success' => false, 'message' => 'Mã giảm giá không chính xác hoặc không tồn tại!']);
            exit;
        }

        if ($coupon['status'] !== 'active') {
            echo json_encode(['success' => false, 'message' => 'Mã giảm giá này đã tạm ngưng hoạt động!']);
            exit;
        }

        if ($coupon['expiry_date'] !== null && strtotime($coupon['expiry_date']) < time()) {
            echo json_encode(['success' => false, 'message' => 'Mã giảm giá này đã hết hạn sử dụng!']);
            exit;
        }

        if (isset($coupon['max_uses']) && intval($coupon['max_uses']) !== -1 && intval($coupon['used_count']) >= intval($coupon['max_uses'])) {
            echo json_encode(['success' => false, 'message' => 'Mã giảm giá này đã hết lượt sử dụng!']);
            exit;
        }

        if ($subtotal < floatval($coupon['min_order_value'])) {
            echo json_encode([
                'success' => false, 
                'message' => 'Mã giảm giá này chỉ áp dụng cho đơn hàng từ ' . number_format($coupon['min_order_value'], 0, '', '.') . 'đ trở lên!'
            ]);
            exit;
        }

        // Calculate discount amount
        $discount_amount = 0;
        if ($coupon['discount_type'] === 'fixed') {
            $discount_amount = floatval($coupon['discount_value']);
        } elseif ($coupon['discount_type'] === 'percent') {
            $discount_amount = $subtotal * (floatval($coupon['discount_value']) / 100);
            if ($coupon['max_discount'] !== null && $discount_amount > floatval($coupon['max_discount'])) {
                $discount_amount = floatval($coupon['max_discount']);
            }
        }

        // Make sure discount is not larger than subtotal
        if ($discount_amount > $subtotal) {
            $discount_amount = $subtotal;
        }

        echo json_encode([
            'success' => true,
            'code' => $coupon['code'],
            'discount_amount' => $discount_amount,
            'message' => 'Áp dụng mã giảm giá thành công! Giảm ngay ' . number_format($discount_amount, 0, '', '.') . 'đ.'
        ]);
        exit;

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi kết nối cơ sở dữ liệu: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Phương thức yêu cầu không hợp lệ!']);
    exit;
}
?>
