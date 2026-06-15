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
        <div class="search-container position-relative" id="header-search-container">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="header-search-input" placeholder="Tìm kiếm sản phẩm công nghệ..." autocomplete="off">
                <button type="button" class="filter-toggle-btn" id="header-filter-toggle" title="Bộ lọc nâng cao">
                    <i class="fas fa-sliders-h"></i>
                </button>
            </div>
            
            <!-- Beautiful Dropdown Advanced Search Panel -->
            <div class="search-advanced-dropdown" id="header-search-dropdown">
                <div class="dropdown-arrow"></div>
                <div class="dropdown-header d-flex justify-content-between align-items-center mb-3">
                    <h5 class="m-0"><i class="fas fa-filter text-gold"></i> TÌM KIẾM NÂNG CAO</h5>
                    <button type="button" class="btn-clear-filters text-secondary" id="header-clear-btn">
                        <i class="fas fa-undo"></i> Đặt lại
                    </button>
                </div>
                
                <div class="dropdown-body">
                    <!-- Category Selection -->
                    <div class="filter-group mb-3">
                        <label class="filter-label">Danh mục sản phẩm</label>
                        <div class="filter-chips" id="header-category-chips">
                            <span class="filter-chip active" data-value="all">Tất cả</span>
                            <span class="filter-chip" data-value="laptop">Laptop</span>
                            <span class="filter-chip" data-value="phone">Điện thoại</span>
                            <span class="filter-chip" data-value="accessory">Phụ kiện</span>
                        </div>
                    </div>
                    
                    <!-- Brand Selection -->
                    <div class="filter-group mb-3">
                        <label class="filter-label">Thương hiệu</label>
                        <div class="filter-chips" id="header-brand-chips">
                            <span class="filter-chip active" data-value="all">Tất cả</span>
                            <span class="filter-chip" data-value="apple">Apple</span>
                            <span class="filter-chip" data-value="samsung">Samsung</span>
                            <span class="filter-chip" data-value="dell">Dell</span>
                            <span class="filter-chip" data-value="asus">Asus</span>
                            <span class="filter-chip" data-value="sony">Sony</span>
                            <span class="filter-chip" data-value="xiaomi">Xiaomi</span>
                        </div>
                    </div>
                    
                    <div class="row g-2">
                        <!-- Price Range Select -->
                        <div class="col-6 mb-3">
                            <div class="filter-group">
                                <label class="filter-label" for="header-price-range">Khoảng giá</label>
                                <select id="header-price-range" class="filter-select">
                                    <option value="all">Tất cả các giá</option>
                                    <option value="under10">Dưới 10 triệu</option>
                                    <option value="10to25">Từ 10tr - 25 triệu</option>
                                    <option value="25to45">Từ 25tr - 45 triệu</option>
                                    <option value="above45">Trên 45 triệu</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Price Sort Select -->
                        <div class="col-6 mb-3">
                            <div class="filter-group">
                                <label class="filter-label" for="header-price-sort">Sắp xếp giá</label>
                                <select id="header-price-sort" class="filter-select">
                                    <option value="none">Mặc định</option>
                                    <option value="asc">Từ thấp đến cao</option>
                                    <option value="desc">Từ cao đến thấp</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="dropdown-footer">
                    <button type="button" class="btn-search-go w-100" id="header-search-submit-btn">
                        <i class="fas fa-search"></i> ÁP DỤNG BỘ LỌC
                    </button>
                </div>
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