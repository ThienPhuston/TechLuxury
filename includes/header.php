<?php 
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
            <a href="<?php echo $path_prefix; ?>Account/login.php" class="action-link" title="Đăng nhập">
                <i class="far fa-user"></i>
            </a>
            <a href="javascript:void(0)" class="action-link position-relative" id="cart-trigger" title="Giỏ hàng">
                <i class="fas fa-shopping-bag"></i>
                <span class="cart-badge">0</span>
            </a>
        </div>
    </div>
</header>