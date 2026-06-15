<?php
session_start();
if (isset($_SESSION['user']) && $_SESSION['user']['username'] === 'admin' && $_SESSION['user']['role'] === 'admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHLUXURY - Admin Portal Login</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap-custom.css">

    <style>
        body {
            background-color: #090c13;
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Luxury Ambient Glow Background */
        .ambient-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.08) 0%, rgba(212, 175, 55, 0) 70%);
            filter: blur(50px);
            z-index: 0;
            pointer-events: none;
        }

        .admin-login-card {
            background: rgba(15, 19, 28, 0.75);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 50px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.05);
            z-index: 1;
            position: relative;
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .admin-logo {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 3px;
            background: linear-gradient(135deg, #ffffff 30%, var(--accent-gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
            margin-bottom: 5px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group-custom i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #8f9cae;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .input-group-custom input {
            width: 100%;
            padding: 14px 16px 14px 45px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            color: #ffffff;
            font-size: 13px;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-group-custom input:focus {
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--accent-gold);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.15);
        }

        .input-group-custom input:focus + i {
            color: var(--accent-gold);
        }

        .btn-admin-login {
            background: linear-gradient(135deg, #d4af37 0%, #b89020 100%);
            color: #000000;
            border: none;
            padding: 14px 0;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            width: 100%;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-admin-login:hover {
            background: linear-gradient(135deg, #f1c40f 0%, #d4af37 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
        }

        .btn-admin-login:active {
            transform: translateY(0);
        }

        .back-to-store {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #8f9cae;
            font-size: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 25px;
        }

        .back-to-store:hover {
            color: var(--accent-gold);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="ambient-glow"></div>

    <div class="admin-login-card text-center">
        <div class="mb-4">
            <span class="admin-logo">TECHLUXURY</span>
            <p class="text-secondary m-0" style="font-size: 12px; letter-spacing: 1px;">BẢNG ĐIỀU KHIỂN QUẢN TRỊ</p>
        </div>

        <form id="admin-login-form" action="javascript:void(0)">
            <div class="input-group-custom">
                <input type="text" id="admin-user" placeholder="Tên đăng nhập quản trị viên" required autocomplete="username">
                <i class="fas fa-user-shield"></i>
            </div>

            <div class="input-group-custom">
                <input type="password" id="admin-pass" placeholder="Mật khẩu bảo mật" required autocomplete="current-password">
                <i class="fas fa-lock"></i>
            </div>

            <div id="admin-error-box" class="text-danger small mb-3 text-center" style="display: none; font-weight: 600;"></div>

            <button type="submit" class="btn-admin-login">ĐĂNG NHẬP HỆ THỐNG</button>
        </form>

        <a href="../index.php" class="back-to-store">
            <i class="fas fa-arrow-left"></i> Quay lại Cửa hàng
        </a>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("admin-login-form");
            const errorBox = document.getElementById("admin-error-box");

            form.addEventListener("submit", function(e) {
                e.preventDefault();
                
                const userVal = document.getElementById("admin-user").value.trim();
                const passVal = document.getElementById("admin-pass").value;

                errorBox.style.display = "none";

                // Enforce that only 'admin' user is allowed to proceed
                if (userVal !== "admin") {
                    errorBox.textContent = "Lỗi: Chỉ tài khoản admin mới được phép truy cập trang quản trị!";
                    errorBox.style.display = "block";
                    return;
                }

                // Call the unified login API
                fetch("../Account/login_process.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        username: userVal,
                        password: passVal,
                        is_admin: true
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.user.role === "admin" && data.user.username === "admin") {
                        // Sync localStorage
                        localStorage.setItem("logged_in_user", JSON.stringify(data.user));
                        alert("Xác thực admin thành công! Đang chuyển hướng...");
                        window.location.href = "index.php";
                    } else {
                        errorBox.textContent = "Lỗi: Tài khoản hoặc mật khẩu admin không chính xác!";
                        errorBox.style.display = "block";
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    errorBox.textContent = "Không thể kết nối đến máy chủ!";
                    errorBox.style.display = "block";
                });
            });
        });
    </script>
</body>

</html>
