<?php 
session_start();
// Calculate the relative path prefix dynamically
$project_root = realpath(dirname(dirname(__FILE__)));
$script_dir = realpath(dirname($_SERVER['SCRIPT_FILENAME']));

// Normalize slashes for cross-platform support (Windows/Linux)
$project_root = str_replace('\\', '/', $project_root);
$script_dir = str_replace('\\', '/', $script_dir);

$relative_path = '';
if (strpos($script_dir, $project_root) === 0) {
    $sub_path = substr($script_dir, strlen($project_root));
    $sub_path = trim($sub_path, '/');
    if ($sub_path !== '') {
        $depth = count(explode('/', $sub_path));
        $relative_path = str_repeat('../', $depth);
    }
}
$path_prefix = $relative_path;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TECHLUXURY - Công Nghệ Đẳng Cấp</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS (Fixed Integrity Check by removing faulty hashes) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/bootstrap-custom.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<header>
    <div class="top-header">
        <a href="<?php echo $path_prefix; ?>index.php" class="logo">
            TECHLUXURY
        </a>

        <!-- Dynamic Live Search Bar -->
        <div class="search-container">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="header-search-input" placeholder="Tìm kiếm sản phẩm công nghệ...">
            </div>
        </div>

        <nav>
            <ul>
                <li><a href="<?php echo $path_prefix; ?>index.php">Trang chủ</a></li>
                <li><a href="<?php echo $path_prefix; ?>page/product.php">Sản phẩm</a></li>
                <li><a href="<?php echo $path_prefix; ?>page/about.php">Giới thiệu</a></li>
                <li><a href="<?php echo $path_prefix; ?>page/contact.php">Liên hệ</a></li>
            </ul>
        </nav>

        <!-- Luxury Header Actions -->
        <div class="header-actions">
            <div id="user-header-status" class="d-inline-block">
                <a href="<?php echo $path_prefix; ?>Account/login.php" class="action-link" title="Đăng nhập">
                    <i class="far fa-user"></i>
                </a>
            </div>
            <a href="javascript:void(0)" class="action-link position-relative" id="cart-trigger" title="Giỏ hàng">
                <i class="fas fa-shopping-bag"></i>
                <span class="cart-badge">0</span>
            </a>
        </div>
    </div>
</header>

<style>
.user-dropdown {
    position: relative;
    display: inline-block;
}
.user-trigger {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    border-radius: 20px;
    transition: all 0.3s ease;
}
.user-trigger:hover {
    background: rgba(255, 255, 255, 0.03);
}
.user-dropdown-menu {
    position: absolute;
    right: 0;
    top: calc(100% + 12px);
    background: #0f131c;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    padding: 10px;
    min-width: 200px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.user-dropdown:hover .user-dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}
.user-dropdown-info {
    padding: 8px 12px;
}
.user-dropdown-info h6 {
    font-size: 13px;
    font-weight: 700;
    color: var(--text-white);
    margin: 0;
}
.user-dropdown-info span {
    font-size: 11px;
    color: var(--text-secondary);
}
.user-dropdown-menu a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    color: var(--text-secondary) !important;
    text-decoration: none;
    font-size: 13px;
    border-radius: 8px;
    transition: all 0.2s ease;
}
.user-dropdown-menu a:hover {
    background: rgba(255, 255, 255, 0.05);
    color: var(--accent-gold) !important;
}
.user-dropdown-menu a.logout-btn:hover {
    background: rgba(255, 71, 87, 0.08);
    color: #ff4757 !important;
}
.dropdown-divider {
    height: 1px;
    background: rgba(255, 255, 255, 0.06);
    margin: 6px 0;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const userStatusContainer = document.getElementById("user-header-status");
    const prefix = "<?php echo $path_prefix; ?>";
    
    // Đồng bộ session PHP với localStorage và xử lý tự động đăng xuất nếu không chọn Ghi nhớ đăng nhập
    const phpUser = <?php echo isset($_SESSION['user']) ? json_encode($_SESSION['user']) : 'null'; ?>;
    if (phpUser) {
        localStorage.setItem("logged_in_user", JSON.stringify(phpUser));
        if (localStorage.getItem("remember_me") !== "true") {
            if (!sessionStorage.getItem("session_active")) {
                sessionStorage.setItem("session_active", "true");
                window.location.href = prefix + "Account/logout.php";
                return;
            }
        }
    } else {
        localStorage.removeItem("logged_in_user");
    }
    sessionStorage.setItem("session_active", "true");
    
    const loggedInUser = phpUser;
    
    if (loggedInUser && userStatusContainer) {
        let adminLink = "";
        if (loggedInUser.role === "admin") {
            adminLink = `
                <a href="${prefix}admin/index.php">
                    <i class="fas fa-chart-line"></i> Trang quản trị
                </a>
                <div class="dropdown-divider"></div>
            `;
        }
        
        userStatusContainer.innerHTML = `
            <div class="user-dropdown">
                <div class="user-trigger">
                    <span class="welcome-text d-none d-md-inline" style="font-size: 12px; color: var(--text-secondary); font-weight: 500;">
                        Xin chào, <strong style="color: var(--accent-gold); font-weight: 700;">${loggedInUser.fullname}</strong>
                    </span>
                    <i class="fas fa-user-circle" style="font-size: 20px; color: var(--accent-gold);"></i>
                </div>
                <div class="user-dropdown-menu">
                    <div class="user-dropdown-info">
                        <h6>${loggedInUser.fullname}</h6>
                        <span>${loggedInUser.role === 'admin' ? 'Quyền quản trị' : 'Thành viên VIP'}</span>
                    </div>
                    <div class="dropdown-divider"></div>
                    ${adminLink}
                    <a href="${prefix}page/order_history.php">
                        <i class="fas fa-history"></i> Lịch sử đơn hàng
                    </a>
                    <a href="javascript:void(0)" class="logout-btn" id="header-logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                </div>
            </div>
        `;
        
        // Bắt sự kiện đăng xuất
        const logoutBtn = document.getElementById("header-logout-btn");
        if (logoutBtn) {
            logoutBtn.addEventListener("click", function() {
                localStorage.removeItem("logged_in_user");
                alert("Bạn đã đăng xuất!");
                window.location.href = prefix + "Account/logout.php";
            });
        }
    }
});
</script>