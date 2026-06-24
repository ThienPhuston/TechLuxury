<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = isset($input['email']) ? trim($input['email']) : '';

    if (empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập địa chỉ email của bạn!']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Địa chỉ email không đúng định dạng!']);
        exit;
    }

    try {
        // Check if duplicate
        $stmt = $conn->prepare("SELECT id FROM newsletter_subscribers WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email này đã đăng ký nhận tin từ trước!']);
            exit;
        }

        // Insert
        $insert = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (:email)");
        $insert->execute(['email' => $email]);

        echo json_encode([
            'success' => true,
            'message' => 'Đăng ký nhận thông tin khuyến mãi thành công! Ưu đãi đặc quyền của bạn đã được kích hoạt.'
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
