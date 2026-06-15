<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $order_code = trim($input['order_code'] ?? '');
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

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Cập nhật trạng thái đơn hàng thành công!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng hoặc trạng thái không đổi!']);
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
