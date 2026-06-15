<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read input (support JSON or standard POST)
    $input = json_decode(file_get_contents('php://input'), true);
    $fullname = trim($input['fullname'] ?? $_POST['fullname'] ?? '');
    $username = trim($input['username'] ?? $_POST['username'] ?? '');
    $email = trim($input['email'] ?? $_POST['email'] ?? '');
    $password = $input['password'] ?? $_POST['password'] ?? '';

    if (empty($fullname) || empty($username) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ các thông tin bắt buộc!']);
        exit;
    }

    if (strlen($username) < 3) {
        echo json_encode(['success' => false, 'message' => 'Tên đăng nhập phải chứa ít nhất 3 ký tự!']);
        exit;
    }

    try {
        // Check if username or email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1");
        $stmt->execute(['username' => $username, 'email' => $email]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Tên đăng nhập hoặc Email đã được sử dụng!']);
            exit;
        }

        // Hash the password using secure bcrypt
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user record
        $insert_stmt = $conn->prepare("INSERT INTO users (username, password, fullname, email, role, status) VALUES (:username, :password, :fullname, :email, 'user', 'active')");
        $insert_stmt->execute([
            'username' => $username,
            'password' => $hashed_password,
            'fullname' => $fullname,
            'email' => $email
        ]);

        echo json_encode(['success' => true, 'message' => 'Đăng ký tài khoản thành công!']);
        exit;

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi lưu thông tin: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Phương thức yêu cầu không hợp lệ!']);
    exit;
}
?>
