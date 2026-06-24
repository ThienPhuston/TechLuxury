<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $order_code = trim($input['order_code'] ?? '');
    $new_status = trim($input['status'] ?? '');

    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để thực hiện chức năng này!']);
        exit;
    }

    if (empty($order_code) || empty($new_status)) {
        echo json_encode(['success' => false, 'message' => 'Thông tin cập nhật không đầy đủ!']);
        exit;
    }

    try {
        // Chỉ cho phép cập nhật trạng thái nếu là admin hoặc chính chủ sở hữu đơn hàng
        if ($_SESSION['user']['role'] === 'admin') {
            $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE order_code = :code");
            $stmt->execute([
                'status' => $new_status,
                'code' => $order_code
            ]);
        } else {
            $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE order_code = :code AND user_id = :user_id");
            $stmt->execute([
                'status' => $new_status,
                'code' => $order_code,
                'user_id' => $_SESSION['user']['id']
            ]);
        }

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Cập nhật trạng thái đơn hàng thành công!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng hoặc bạn không có quyền cập nhật đơn hàng này!']);
        }
        exit;

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Phương thức yêu cầu không hợp lệ!']);
    exit;
}
?>
