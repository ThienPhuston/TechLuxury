<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read input (support JSON or standard POST)
    $input = json_decode(file_get_contents('php://input'), true);
    $username = trim($input['username'] ?? $_POST['username'] ?? '');
    $password = $input['password'] ?? $_POST['password'] ?? '';

    $is_admin = filter_var($input['is_admin'] ?? $_POST['is_admin'] ?? false, FILTER_VALIDATE_BOOLEAN);

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin!']);
        exit;
    }

    try {
        // Find user by username or email
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email LIMIT 1");
        $stmt->execute(['username' => $username, 'email' => $username]);
        $user = $stmt->fetch();

        if ($user) {
            // Check gate permissions
            if ($is_admin) {
                if ($user['role'] !== 'admin' || $user['username'] !== 'admin') {
                    echo json_encode(['success' => false, 'message' => 'Chỉ tài khoản admin mới được phép truy cập trang quản trị!']);
                    exit;
                }
            } else {
                if ($user['role'] === 'admin') {
                    echo json_encode(['success' => false, 'message' => 'Tài khoản quản trị không được phép đăng nhập tại đây!']);
                    exit;
                }
            }
            // Password verification with fallback to plaintext
            $auth_success = false;
            if (password_verify($password, $user['password'])) {
                $auth_success = true;
            } elseif ($password === $user['password']) {
                // For compatibility, if database password is in plaintext
                $auth_success = true;
                // Dynamically update the database password to be secure bcrypt hash
                $new_hash = password_hash($password, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
                $update_stmt->execute(['password' => $new_hash, 'id' => $user['id']]);
            }

            if ($auth_success) {
                if ($user['status'] !== 'active') {
                    echo json_encode(['success' => false, 'message' => 'Tài khoản của bạn đã bị khóa!']);
                    exit;
                }

                // Initialize session
                $session_user = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'fullname' => $user['fullname'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'status' => $user['status']
                ];
                $_SESSION['user'] = $session_user;

                echo json_encode([
                    'success' => true,
                    'message' => 'Đăng nhập thành công!',
                    'user' => $session_user
                ]);
                exit;
            }
        }

        echo json_encode(['success' => false, 'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác!']);
        exit;

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Phương thức yêu cầu không hợp lệ!']);
    exit;
}
?>
