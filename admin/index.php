<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== 'admin' || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHLUXURY - Admin Dashboard</title>

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

    <!-- Inline Security Check -->
    <script>
        (function() {
            const loggedInUser = JSON.parse(localStorage.getItem("logged_in_user"));
            if (!loggedInUser || loggedInUser.username !== "admin" || loggedInUser.role !== "admin") {
                alert("Quyền truy cập bị từ chối! Trang này chỉ dành cho quản trị viên.");
                window.location.href = "login.php";
            }
        })();
    </script>
</head>

<body>

<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <a href="../index.php" class="admin-logo-text">TECHLUXURY</a>
        
        <ul class="admin-menu">
            <li class="active" data-tab="overview">
                <a href="javascript:void(0)"><i class="fas fa-chart-line"></i> <span>Tổng quan</span></a>
            </li>
            <li data-tab="products">
                <a href="javascript:void(0)"><i class="fas fa-box"></i> <span>Sản phẩm</span></a>
            </li>
            <li data-tab="categories">
                <a href="javascript:void(0)"><i class="fas fa-tags"></i> <span>Danh mục</span></a>
            </li>
            <li data-tab="vouchers">
                <a href="javascript:void(0)"><i class="fas fa-file-invoice"></i> <span>Phiếu nhập</span></a>
            </li>
            <li data-tab="orders">
                <a href="javascript:void(0)"><i class="fas fa-shopping-cart"></i> <span>Đơn hàng</span></a>
            </li>
            <li data-tab="customers">
                <a href="javascript:void(0)"><i class="fas fa-users"></i> <span>Khách hàng</span></a>
            </li>
            <li data-tab="settings">
                <a href="javascript:void(0)"><i class="fas fa-sliders-h"></i> <span>Cấu hình</span></a>
            </li>
            <li style="margin-top: auto;">
                <a href="javascript:void(0)" id="admin-logout-btn" style="color: var(--accent-red); background: rgba(255, 71, 87, 0.05);"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Bar Header -->
        <header class="admin-header">
            <div>
                <h1 id="admin-title" class="text-white m-0" style="font-size: 24px; font-weight: 800;">TỔNG QUAN HỆ THỐNG</h1>
                <p id="admin-subtitle" class="text-secondary m-0" style="font-size: 13px;">Báo cáo số liệu kinh doanh hôm nay</p>
            </div>
            
            <div class="admin-profile">
                <div class="text-end d-none d-sm-block">
                    <h5 id="admin-fullname" class="text-white m-0" style="font-size: 14px; font-weight: 700;">Admin Premium</h5>
                    <p class="text-secondary m-0" style="font-size: 11px;">Chủ sở hữu cửa hàng</p>
                </div>
                <div class="admin-avatar">AP</div>
            </div>
        </header>

        <!-- ---------------------------------------------------- -->
        <!-- TAB 1: TỔNG QUAN -->
        <!-- ---------------------------------------------------- -->
        <div id="tab-overview" class="tab-pane-content">
            <!-- Stats Grid -->
            <div class="admin-stats-grid">
                <!-- Stat 1 -->
                <div class="admin-stat-card">
                    <div class="admin-stat-info">
                        <p>DOANH THU THỰC TẾ</p>
                        <h3 id="stat-revenue">0đ</h3>
                    </div>
                    <div class="admin-stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="admin-stat-card">
                    <div class="admin-stat-info">
                        <p>TỔNG ĐƠN HÀNG</p>
                        <h3 id="stat-orders">0 Đơn</h3>
                    </div>
                    <div class="admin-stat-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="admin-stat-card">
                    <div class="admin-stat-info">
                        <p>SẢN PHẨM HIỆN CÓ</p>
                        <h3 id="stat-products">0 Loại</h3>
                    </div>
                    <div class="admin-stat-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                </div>

                <!-- Stat 4 -->
                <div class="admin-stat-card">
                    <div class="admin-stat-info">
                        <p>THÀNH VIÊN VIP</p>
                        <h3 id="stat-customers">0 Thành viên</h3>
                    </div>
                    <div class="admin-stat-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                </div>
            </div>

            <!-- SVG Revenue Chart Widget -->
            <div class="admin-table-box mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="m-0">BIỂU ĐỒ TĂNG TRƯỞNG DOANH THU (1 NĂM QUA)</h3>
                    <span class="badge" style="background: rgba(212, 175, 55, 0.1); color: var(--accent-gold); border: 1px solid var(--border-hover); padding: 6px 12px; font-size: 11px;">MỤC TIÊU ĐẠT 92%</span>
                </div>
                
                <div class="w-100" style="height: 180px; position: relative;">
                    <svg viewBox="0 0 1000 150" class="w-100 h-100" style="overflow: visible;">
                        <defs>
                            <linearGradient id="chart-glow" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="rgba(212, 175, 55, 0.2)" />
                                <stop offset="100%" stop-color="rgba(212, 175, 55, 0)" />
                            </linearGradient>
                        </defs>
                        <path d="M0,130 Q150,90 300,110 T600,40 T900,20 L1000,10 L1000,150 L0,150 Z" fill="url(#chart-glow)"></path>
                        <path d="M0,130 Q150,90 300,110 T600,40 T900,20 L1000,10" fill="none" stroke="var(--accent-gold)" stroke-width="4" stroke-linecap="round"></path>
                        <circle cx="300" cy="110" r="6" fill="#090c13" stroke="var(--accent-gold)" stroke-width="3"></circle>
                        <circle cx="600" cy="40" r="6" fill="#090c13" stroke="var(--accent-gold)" stroke-width="3"></circle>
                        <circle cx="900" cy="20" r="6" fill="#090c13" stroke="var(--accent-gold)" stroke-width="3"></circle>
                    </svg>
                </div>
                <div class="d-flex justify-content-between text-secondary mt-3" style="font-size: 11px;">
                    <span>Q1 / 2025</span>
                    <span>Q2 / 2025</span>
                    <span>Q3 / 2025</span>
                    <span>Q4 / 2025</span>
                    <span>Hiện tại (2026)</span>
                </div>
            </div>

            <!-- Low Stock Warning Box -->
            <div id="low-stock-warning-box" class="admin-table-box mb-4" style="border: 1px solid rgba(255, 71, 87, 0.3); background: rgba(255, 71, 87, 0.02); display: none;">
                <div class="d-flex align-items-center gap-2 mb-3 text-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h3 class="m-0 text-danger" style="font-size: 16px; font-weight: 700;">CẢNH BÁO SẢN PHẨM SẮP HẾT HÀNG (SỐ LƯỢNG KHO <= 5)</h3>
                </div>
                <div class="table-responsive">
                    <table class="custom-table table-sm" id="low-stock-table">
                        <thead>
                            <tr>
                                <th>ẢNH</th>
                                <th>TÊN SẢN PHẨM</th>
                                <th>TỒN KHO HỒ SƠ</th>
                                <th>TRẠNG THÁI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Generated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Orders Box -->
            <div class="admin-table-box">
                <h3 class="m-0 mb-4">DANH SÁCH ĐƠN HÀNG MỚI ĐẶT</h3>
                <div class="table-responsive">
                    <table class="custom-table" id="recent-orders-table">
                        <thead>
                            <tr>
                                <th>MÃ ĐƠN</th>
                                <th>KHÁCH HÀNG</th>
                                <th>TỔNG TIỀN</th>
                                <th>PHƯƠNG THỨC</th>
                                <th>TRẠNG THÁI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Generated dynamically via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ---------------------------------------------------- -->
        <!-- TAB 2: SẢN PHẨM -->
        <!-- ---------------------------------------------------- -->
        <div id="tab-products" class="tab-pane-content" style="display: none;">
            <div class="admin-table-box">
                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">
                        <h3 class="m-0">DANH SÁCH SẢN PHẨM</h3>
                        
                        <div class="d-flex flex-wrap gap-2">
                            <input type="text" id="product-search-input" placeholder="Tìm kiếm sản phẩm..." class="form-control text-white" style="width: auto; min-width: 200px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); font-size: 12px; border-radius: 8px; padding: 8px 12px;">
                            
                            <select id="product-category-filter" class="form-select text-white" style="width: auto; background: #0f131c; border: 1px solid var(--border-color); font-size: 12px; border-radius: 8px;">
                                <option value="all">Tất cả danh mục</option>
                            </select>

                            <select id="product-stock-filter" class="form-select text-white" style="width: auto; background: #0f131c; border: 1px solid var(--border-color); font-size: 12px; border-radius: 8px;">
                                <option value="all">Tất cả hàng tồn</option>
                                <option value="low">Sắp hết hàng (<=5)</option>
                                <option value="out">Đã hết hàng (0)</option>
                            </select>

                            <button class="btn btn-outline-warning d-flex align-items-center gap-2" id="btn-add-product-modal" style="font-size: 12px; font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                                <i class="fas fa-plus"></i> THÊM SẢN PHẨM
                            </button>
                        </div>
                    </div>

                    <!-- Advanced lookup fields for Price, Cost and Profit rate -->
                    <div class="row g-2 p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color);">
                        <div class="col-md-4">
                            <label class="text-secondary small fw-bold mb-1" style="font-size: 10px;">LỌC THEO GIÁ BÁN (VNĐ)</label>
                            <div class="d-flex gap-2">
                                <input type="number" id="product-price-min" placeholder="Từ" class="form-control text-white form-control-sm" style="background: rgba(255,255,255,0.03); border-color: var(--border-color); font-size: 11px; color: white;">
                                <input type="number" id="product-price-max" placeholder="Đến" class="form-control text-white form-control-sm" style="background: rgba(255,255,255,0.03); border-color: var(--border-color); font-size: 11px; color: white;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-secondary small fw-bold mb-1" style="font-size: 10px;">LỌC THEO GIÁ NHẬP / GIÁ VỐN (VNĐ)</label>
                            <div class="d-flex gap-2">
                                <input type="number" id="product-cost-min" placeholder="Từ" class="form-control text-white form-control-sm" style="background: rgba(255,255,255,0.03); border-color: var(--border-color); font-size: 11px; color: white;">
                                <input type="number" id="product-cost-max" placeholder="Đến" class="form-control text-white form-control-sm" style="background: rgba(255,255,255,0.03); border-color: var(--border-color); font-size: 11px; color: white;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-secondary small fw-bold mb-1" style="font-size: 10px;">LỌC THEO TỶ SUẤT LỢI NHUẬN (%)</label>
                            <div class="d-flex gap-2">
                                <input type="number" id="product-profit-min" placeholder="Từ" class="form-control text-white form-control-sm" style="background: rgba(255,255,255,0.03); border-color: var(--border-color); font-size: 11px; color: white;">
                                <input type="number" id="product-profit-max" placeholder="Đến" class="form-control text-white form-control-sm" style="background: rgba(255,255,255,0.03); border-color: var(--border-color); font-size: 11px; color: white;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="custom-table" id="products-table">
                        <thead>
                            <tr>
                                <th>ẢNH</th>
                                <th>TÊN SẢN PHẨM</th>
                                <th>GIÁ BÁN</th>
                                <th>GIÁ NHẬP</th>
                                <th>LÃI (TỶ SUẤT)</th>
                                <th>NHẬP - XUẤT</th>
                                <th>TỒN KHO</th>
                                <th>DANH MỤC</th>
                                <th>HÀNH ĐỘNG</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Generated dynamically via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ---------------------------------------------------- -->
        <!-- TAB 3: ĐƠN HÀNG -->
        <!-- ---------------------------------------------------- -->
        <div id="tab-orders" class="tab-pane-content" style="display: none;">
            <div class="admin-table-box">
                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">
                        <h3 class="m-0">QUẢN LÝ ĐƠN HÀNG</h3>
                        
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <input type="text" id="order-search-input" placeholder="Tìm mã đơn, tên khách..." class="form-control text-white" style="width: auto; min-width: 180px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); font-size: 12px; border-radius: 8px; padding: 6px 12px;">

                            <select id="order-status-filter" class="form-select text-white" style="width: auto; background: #0f131c; border: 1px solid var(--border-color); font-size: 12px; border-radius: 8px;">
                                <option value="all">Tất cả trạng thái</option>
                                <option value="Chờ thanh toán">Chờ thanh toán</option>
                                <option value="Đang xử lý">Đang xử lý</option>
                                <option value="Đã thanh toán">Đã thanh toán</option>
                                <option value="Đang giao hàng">Đang giao hàng</option>
                                <option value="Hoàn thành">Hoàn thành</option>
                                <option value="Đã hủy">Đã hủy</option>
                            </select>

                            <button class="btn btn-outline-warning d-flex align-items-center gap-2" id="btn-sort-order-address" style="font-size: 12px; font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                                <i class="fas fa-sort-alpha-down"></i> XẾP THEO ĐỊA CHỈ (A-Z)
                            </button>
                        </div>
                    </div>

                    <!-- Date range filters -->
                    <div class="row g-2 p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color);">
                        <div class="col-md-6 d-flex align-items-center gap-2">
                            <label class="text-secondary small fw-bold mb-0 text-nowrap" style="font-size: 11px; min-width: 60px;">TỪ NGÀY:</label>
                            <input type="date" id="order-date-min" class="form-control text-white form-control-sm" style="background: rgba(255,255,255,0.03); border-color: var(--border-color); font-size: 11px; color: white;">
                        </div>
                        <div class="col-md-6 d-flex align-items-center gap-2">
                            <label class="text-secondary small fw-bold mb-0 text-nowrap" style="font-size: 11px; min-width: 60px;">ĐẾN NGÀY:</label>
                            <input type="date" id="order-date-max" class="form-control text-white form-control-sm" style="background: rgba(255,255,255,0.03); border-color: var(--border-color); font-size: 11px; color: white;">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="custom-table" id="orders-table">
                        <thead>
                            <tr>
                                <th>MÃ ĐƠN</th>
                                <th>KHÁCH HÀNG</th>
                                <th>CHI TIẾT SẢN PHẨM</th>
                                <th>TỔNG TIỀN</th>
                                <th>PHƯƠNG THỨC</th>
                                <th>NGÀY ĐẶT</th>
                                <th>TRẠNG THÁI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Generated dynamically via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ---------------------------------------------------- -->
        <!-- TAB 4: KHÁCH HÀNG -->
        <!-- ---------------------------------------------------- -->
        <div id="tab-customers" class="tab-pane-content" style="display: none;">
            <div class="admin-table-box">
                <h3 class="m-0 mb-4">QUẢN LÝ TÀI KHOẢN KHÁCH HÀNG</h3>
                <div class="table-responsive">
                    <table class="custom-table" id="customers-table">
                        <thead>
                            <tr>
                                <th>HỌ VÀ TÊN</th>
                                <th>TÊN ĐĂNG NHẬP</th>
                                <th>EMAIL</th>
                                <th>VAI TRÒ</th>
                                <th>TRẠNG THÁI</th>
                                <th>HÀNH ĐỘNG</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Generated dynamically via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ---------------------------------------------------- -->
        <!-- TAB 5: CẤU HÌNH -->
        <!-- ---------------------------------------------------- -->
        <div id="tab-settings" class="tab-pane-content" style="display: none;">
            <div class="admin-table-box" style="max-width: 700px; margin: 0 auto;">
                <h3 class="m-0 mb-4">CẤU HÌNH HỆ THỐNG CỬA HÀNG</h3>
                
                <form id="shop-settings-form" action="javascript:void(0)" class="w-100 p-0 m-0 bg-transparent border-0 d-flex flex-column gap-3" style="max-width: 100%;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-secondary small fw-bold mb-2">TÊN CỬA HÀNG</label>
                            <input type="text" id="set-shop-name" class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; padding: 10px 14px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-secondary small fw-bold mb-2">HOTLINE LIÊN HỆ</label>
                            <input type="text" id="set-hotline" class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; padding: 10px 14px; border-radius: 8px;">
                        </div>
                        <div class="col-12">
                            <label class="text-secondary small fw-bold mb-2">EMAIL HỖ TRỢ</label>
                            <input type="email" id="set-email" class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; padding: 10px 14px; border-radius: 8px;">
                        </div>
                        <div class="col-12">
                            <label class="text-secondary small fw-bold mb-2">ĐỊA CHỈ TRỤ SỞ CHÍNH</label>
                            <input type="text" id="set-address" class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; padding: 10px 14px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-secondary small fw-bold mb-2">CHIẾT KHẤU VIP SMEMBER (%)</label>
                            <input type="number" id="set-discount" class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; padding: 10px 14px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-secondary small fw-bold mb-2">TRẠNG THÁI CỬA HÀNG</label>
                            <select id="set-maintenance" class="form-select text-white" style="background: #0f131c; border: 1px solid var(--border-color); padding: 10px 14px; border-radius: 8px;">
                                <option value="active">Hoạt động bình thường</option>
                                <option value="maintenance">Bảo trì hệ thống</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-warning py-3 mt-4" style="font-weight: 700; border-radius: 8px; font-size: 13px;">LƯU THIẾT LẬP HỆ THỐNG</button>
                </form>
            </div>
        </div>

        <!-- TAB 6: DANH MỤC SẢN PHẨM -->
        <div id="tab-categories" class="tab-pane-content" style="display: none;">
            <div class="admin-table-box">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="m-0">QUẢN LÝ DANH MỤC</h3>
                    <button class="btn btn-outline-warning btn-sm d-flex align-items-center gap-2" id="btn-add-category" style="font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                        <i class="fas fa-plus"></i> THÊM DANH MỤC
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="custom-table" id="categories-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>MÃ DANH MỤC</th>
                                <th>TÊN HIỂN THỊ</th>
                                <th>HÀNH ĐỘNG</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Generated dynamically via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 7: PHIẾU NHẬP HÀNG -->
        <div id="tab-vouchers" class="tab-pane-content" style="display: none;">
            <div class="admin-table-box">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="m-0">QUẢN LÝ PHIẾU NHẬP HÀNG</h3>
                    <button class="btn btn-outline-warning btn-sm d-flex align-items-center gap-2" id="btn-add-voucher" style="font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                        <i class="fas fa-plus"></i> TẠO PHIẾU NHẬP
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="custom-table" id="vouchers-table">
                        <thead>
                            <tr>
                                <th>MÃ PHIẾU</th>
                                <th>NHÀ CUNG CẤP</th>
                                <th>SẢN PHẨM NHẬP</th>
                                <th>TỔNG TIỀN</th>
                                <th>NGÀY NHẬP</th>
                                <th>HÀNH ĐỘNG</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Generated dynamically via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Add/Edit Product Modal (Glassmorphism layout) -->
<div class="specs-modal" id="admin-product-modal" style="max-width: 500px;">
    <div class="specs-modal-content p-4" style="position: relative;">
        <span class="specs-modal-close" id="modal-close-btn" style="position: absolute; right: 18px; top: 18px; font-size: 20px; cursor: pointer; color: white;">&times;</span>
        <h3 class="text-white mb-4" id="modal-product-title" style="font-weight: 800; font-size: 18px;">THÊM SẢN PHẨM MỚI</h3>
        
        <form id="product-form" action="javascript:void(0)" class="w-100 p-0 m-0 bg-transparent border-0 d-flex flex-column gap-3" style="max-width: 100%;">
            <input type="hidden" id="form-product-index" value="">
            
            <div class="mb-2">
                <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">TÊN SẢN PHẨM</label>
                <input type="text" id="form-product-name" required class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;">
            </div>
            
            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">GIÁ BÁN (VNĐ)</label>
                    <input type="text" id="form-product-price" required class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;">
                </div>
                <div class="col-6">
                    <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">TỶ SUẤT LỢI NHUẬN (%)</label>
                    <input type="number" id="form-product-profit-rate" class="form-control" placeholder="Lãi / Giá vốn" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;">
                </div>
            </div>

            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">GIÁ NHẬP (VNĐ)</label>
                    <input type="text" id="form-product-cost-price" required class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;">
                </div>
                <div class="col-6">
                    <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">TỒN KHO</label>
                    <input type="number" id="form-product-stock" required min="0" class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;">
                </div>
            </div>

            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">DANH MỤC</label>
                    <select id="form-product-category" required class="form-select text-white" style="background: #0f131c; border: 1px solid var(--border-color); font-size: 13px; padding: 10px 14px;">
                        <option value="laptop">Laptop</option>
                        <option value="phone">Điện thoại</option>
                        <option value="accessory">Phụ kiện</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">KHUYẾN MÃI (-20%)</label>
                    <select id="form-product-sale" required class="form-select text-white" style="background: #0f131c; border: 1px solid var(--border-color); font-size: 13px; padding: 10px 14px;">
                        <option value="false">Không</option>
                        <option value="true">Có</option>
                    </select>
                </div>
            </div>

            <div class="mb-2">
                <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">HÌNH ẢNH SẢN PHẨM</label>
                <div class="d-flex gap-2">
                    <input type="text" id="form-product-image" readonly placeholder="Chọn ảnh từ máy tính..." required class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;">
                    <input type="file" id="form-product-image-file" accept="image/*" style="display: none;">
                    <button type="button" class="btn btn-outline-warning" id="btn-browse-image" style="font-size: 12px; white-space: nowrap; padding: 10px 16px;">Chọn file</button>
                </div>
                <div id="image-upload-status" class="small mt-1" style="display: none; font-weight: 500;"></div>
            </div>

            <div class="mb-3">
                <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">THÔNG SỐ KỸ THUẬT (Phân tách bằng dấu phẩy)</label>
                <textarea id="form-product-specs" required class="form-control" rows="2" placeholder="RAM 16G, SSD 512G, Chip M4" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;"></textarea>
            </div>

            <button type="submit" class="w-100 btn btn-warning py-3" style="font-weight: 700; border-radius: 8px; font-size: 13px;">LƯU SẢN PHẨM</button>
        </form>
    </div>
</div>
<div class="specs-modal-overlay" id="admin-product-overlay"></div>

<!-- Category Modal -->
<div class="specs-modal" id="admin-category-modal" style="max-width: 400px;">
    <div class="specs-modal-content p-4" style="position: relative;">
        <span class="specs-modal-close" id="modal-category-close" style="position: absolute; right: 18px; top: 18px; font-size: 20px; cursor: pointer; color: white;">&times;</span>
        <h3 class="text-white mb-4" id="modal-category-title" style="font-weight: 800; font-size: 16px;">THÊM DANH MỤC MỚI</h3>
        
        <form id="category-form" action="javascript:void(0)" class="w-100 p-0 m-0 bg-transparent border-0 d-flex flex-column gap-3">
            <input type="hidden" id="form-category-id" value="">
            
            <div class="mb-2">
                <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">MÃ DANH MỤC (slug)</label>
                <input type="text" id="form-category-name" required class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;">
            </div>
            
            <div class="mb-3">
                <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">TÊN DANH MỤC HIỂN THỊ</label>
                <input type="text" id="form-category-display" required class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;">
            </div>
            
            <button type="submit" class="w-100 btn btn-warning py-3" style="font-weight: 700; border-radius: 8px; font-size: 13px;">LƯU DANH MỤC</button>
        </form>
    </div>
</div>
<div class="specs-modal-overlay" id="admin-category-overlay"></div>

<!-- Voucher Modal -->
<div class="specs-modal" id="admin-voucher-modal" style="max-width: 650px;">
    <div class="specs-modal-content p-4" style="position: relative;">
        <span class="specs-modal-close" id="modal-voucher-close" style="position: absolute; right: 18px; top: 18px; font-size: 20px; cursor: pointer; color: white;">&times;</span>
        <h3 class="text-white mb-4" id="modal-voucher-title" style="font-weight: 800; font-size: 16px;">TẠO PHIẾU NHẬP HÀNG</h3>
        
        <form id="voucher-form" action="javascript:void(0)" class="w-100 p-0 m-0 bg-transparent border-0 d-flex flex-column gap-3" style="max-width: 100%;">
            <input type="hidden" id="form-voucher-id" value="">
            
            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">MÃ PHIẾU NHẬP</label>
                    <input type="text" id="form-voucher-code" required placeholder="PN-XXXX" class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;">
                </div>
                <div class="col-6">
                    <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">NHÀ CUNG CẤP</label>
                    <input type="text" id="form-voucher-provider" required placeholder="Nhà cung cấp..." class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;">
                </div>
            </div>

            <!-- Items list inside voucher -->
            <div class="mb-3">
                <label class="text-secondary small fw-bold mb-2 d-flex justify-content-between align-items-center" style="font-size: 11px;">
                    <span>DANH SÁCH SẢN PHẨM NHẬP HÀNG</span>
                    <button type="button" class="btn btn-outline-info btn-sm" id="btn-add-voucher-item" style="font-size: 10px; padding: 2px 8px; border-radius: 4px;"><i class="fas fa-plus"></i> Thêm sản phẩm</button>
                </label>
                
                <div id="voucher-items-container" class="d-flex flex-column gap-2" style="max-height: 200px; overflow-y: auto; padding-right: 5px;">
                    <!-- Added dynamically -->
                </div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color);">
                <span class="text-secondary small fw-bold">TỔNG GIÁ TRỊ NHẬP HÀNG:</span>
                <span id="voucher-total-display" class="text-gold fw-bold fs-5">0đ</span>
            </div>

            <button type="submit" class="w-100 btn btn-warning py-3" style="font-weight: 700; border-radius: 8px; font-size: 13px;">LƯU PHIẾU NHẬP</button>
        </form>
    </div>
</div>
<div class="specs-modal-overlay" id="admin-voucher-overlay"></div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let products = [];
    let orders = [];
    let users = [];
    let settings = {};

    function formatVND(amount) {
        return amount.toLocaleString("vi-VN") + "đ";
    }

    function formatNumberWithDots(val) {
        let clean = val.toString().replace(/\D/g, "");
        if (clean === "") return "";
        return clean.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function setupPriceFormatting(inputEl) {
        if (!inputEl) return;
        inputEl.addEventListener("input", function(e) {
            let cursorPosition = this.selectionStart;
            let originalLen = this.value.length;

            let formatted = formatNumberWithDots(this.value);
            this.value = formatted;

            let newLen = this.value.length;
            cursorPosition = cursorPosition + (newLen - originalLen);
            this.setSelectionRange(cursorPosition, cursorPosition);
        });
    }

    const priceInput = document.getElementById("form-product-price");
    const costInput = document.getElementById("form-product-cost-price");
    const profitRateInput = document.getElementById("form-product-profit-rate");

    setupPriceFormatting(priceInput);
    setupPriceFormatting(costInput);

    function getCleanNumber(val) {
        return parseInt(val.toString().replace(/\./g, "")) || 0;
    }

    function updateProfitRate() {
        const price = getCleanNumber(priceInput.value);
        const cost = getCleanNumber(costInput.value);
        if (cost > 0) {
            const rate = Math.round((price - cost) / cost * 100);
            profitRateInput.value = rate;
        } else {
            profitRateInput.value = 0;
        }
    }

    function updatePriceFromRate() {
        const cost = getCleanNumber(costInput.value);
        const rate = parseFloat(profitRateInput.value) || 0;
        const price = Math.round(cost * (1 + rate / 100));
        priceInput.value = formatNumberWithDots(price.toString());
    }

    if (priceInput && costInput && profitRateInput) {
        priceInput.addEventListener("input", function() {
            setTimeout(updateProfitRate, 10);
        });
        costInput.addEventListener("input", function() {
            setTimeout(updateProfitRate, 10);
        });
        profitRateInput.addEventListener("input", function() {
            updatePriceFromRate();
        });
    }

    // 2. Chuyển đổi tab SPA mượt mà
    const menuItems = document.querySelectorAll(".admin-menu li[data-tab]");
    const tabPanes = document.querySelectorAll(".tab-pane-content");
    const adminTitle = document.getElementById("admin-title");
    const adminSubtitle = document.getElementById("admin-subtitle");

    const tabHeaders = {
        overview: { title: "TỔNG QUAN HỆ THỐNG", subtitle: "Báo cáo số liệu kinh doanh hôm nay" },
        products: { title: "QUẢN LÝ SẢN PHẨM", subtitle: "Danh sách sản phẩm đang mở bán trên website" },
        categories: { title: "QUẢN LÝ DANH MỤC", subtitle: "Quản lý phân loại sản phẩm trên cửa hàng" },
        vouchers: { title: "QUẢN LÝ PHIẾU NHẬP HÀNG", subtitle: "Nhập thêm tồn kho sản phẩm từ nhà cung cấp" },
        orders: { title: "QUẢN LÝ ĐƠN HÀNG", subtitle: "Danh sách và trạng thái các giao dịch mua sắm" },
        customers: { title: "QUẢN LÝ TÀI KHOẢN", subtitle: "Xem thông tin thành viên đăng ký và quản lý vai trò" },
        settings: { title: "CẤU HÌNH HỆ THỐNG", subtitle: "Thiết lập thông tin hiển thị cơ bản của cửa hàng" }
    };

    menuItems.forEach(item => {
        item.addEventListener("click", function() {
            const targetTab = this.getAttribute("data-tab");
            
            // Cập nhật hoạt động sidebar
            menuItems.forEach(mi => mi.classList.remove("active"));
            this.classList.add("active");

            // Hiển thị khung nội dung tab tương ứng
            tabPanes.forEach(pane => pane.style.display = "none");
            const activePane = document.getElementById("tab-" + targetTab);
            if (activePane) {
                activePane.style.display = "block";
            }

            // Đổi tiêu đề header
            if (tabHeaders[targetTab]) {
                adminTitle.textContent = tabHeaders[targetTab].title;
                adminSubtitle.textContent = tabHeaders[targetTab].subtitle;
            }

            // Tải lại dữ liệu tab
            loadTabData(targetTab);
        });
    });

    // 3. Tải dữ liệu động cho từng Tab từ API
    function loadTabData(tab) {
        if (tab === "overview") {
            fetch("api.php?action=overview")
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        orders = data.recent_orders;
                        document.getElementById("stat-revenue").textContent = formatVND(data.revenue);
                        document.getElementById("stat-orders").textContent = data.orders_count + " Đơn";
                        document.getElementById("stat-products").textContent = data.products_count + " Loại";
                        document.getElementById("stat-customers").textContent = data.customers_count + " Thành viên";
                        
                        const recentOrdersContainer = document.querySelector("#recent-orders-table tbody");
                        if (recentOrdersContainer) {
                            recentOrdersContainer.innerHTML = "";
                            if (data.recent_orders.length === 0) {
                                recentOrdersContainer.innerHTML = `<tr><td colspan="5" class="text-center text-secondary py-4">Chưa có đơn hàng nào được đặt.</td></tr>`;
                            } else {
                                data.recent_orders.forEach(o => {
                                    let statusClass = "warning";
                                    if (o.status === "Đã thanh toán" || o.status === "Hoàn thành") statusClass = "success";
                                    else if (o.status === "Đang giao hàng") statusClass = "success";
                                    else if (o.status === "Đã hủy") statusClass = "danger";

                                    const tr = document.createElement("tr");
                                    tr.innerHTML = `
                                        <td><strong>#${o.order_code}</strong></td>
                                        <td>${o.customer_name}</td>
                                        <td><span class="text-gold font-weight-bold">${formatVND(parseFloat(o.total_amount))}</span></td>
                                        <td>${o.payment_method === 'cod' ? 'COD' : (o.payment_method === 'bank' ? 'Chuyển khoản' : 'Thẻ Visa')}</td>
                                        <td><span class="status-pill ${statusClass}">${o.status}</span></td>
                                    `;
                                    recentOrdersContainer.appendChild(tr);
                                });
                            }
                        }
                    }
                });

            // Also fetch products to list low-stock items for visual warning
            fetch("api.php?action=products_list")
                .then(r => r.json())
                .then(pData => {
                    if (pData.success) {
                        const lowStockBox = document.getElementById("low-stock-warning-box");
                        const lowStockBody = document.querySelector("#low-stock-table tbody");
                        if (lowStockBox && lowStockBody) {
                            const lowStockItems = pData.products.filter(p => parseInt(p.stock) <= 5);
                            if (lowStockItems.length > 0) {
                                lowStockBox.style.display = "block";
                                lowStockBody.innerHTML = "";
                                lowStockItems.forEach(p => {
                                    const stockVal = parseInt(p.stock);
                                    const tr = document.createElement("tr");
                                    tr.innerHTML = `
                                        <td><img src="../images/${p.img}" alt="${p.name}" style="width: 32px; height: 32px; object-fit: contain; background: white; border-radius: 4px;" onerror="this.src='../images/ip16pm.webp'"></td>
                                        <td><strong>${p.name}</strong></td>
                                        <td><span class="text-danger fw-bold">${stockVal} chiếc</span></td>
                                        <td><span class="badge ${stockVal === 0 ? 'bg-danger' : 'bg-warning text-dark'}">${stockVal === 0 ? 'Hết hàng' : 'Cực thấp'}</span></td>
                                    `;
                                    lowStockBody.appendChild(tr);
                                });
                            } else {
                                lowStockBox.style.display = "none";
                            }
                        }
                    }
                });
        } else if (tab === "products") {
            fetch("api.php?action=products_list")
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        products = data.products;
                        renderProducts();
                    }
                });
        } else if (tab === "orders") {
            fetch("api.php?action=orders_list")
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        orders = data.orders;
                        renderOrders();
                    }
                });
        } else if (tab === "customers") {
            fetch("api.php?action=customers_list")
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        users = data.users;
                        renderCustomers();
                    }
                });
        } else if (tab === "settings") {
            fetch("api.php?action=get_settings")
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        settings = data.settings;
                        renderSettings();
                    }
                });
        } else if (tab === "categories") {
            fetch("api.php?action=categories_list")
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        renderCategories(data.categories);
                    }
                });
        } else if (tab === "vouchers") {
            // Load products first so we can select them in vouchers
            fetch("api.php?action=products_list")
                .then(r => r.json())
                .then(pData => {
                    if (pData.success) {
                        products = pData.products;
                        fetch("api.php?action=vouchers_list")
                            .then(r => r.json())
                            .then(vData => {
                                if (vData.success) {
                                    renderVouchers(vData.vouchers);
                                }
                            });
                    }
                });
        }
    }

    // TAB 2: RENDER PRODUCTS (CRUD)
    function renderProducts() {
        const productsBody = document.querySelector("#products-table tbody");
        if (!productsBody) return;

        productsBody.innerHTML = "";
        const searchVal = document.getElementById("product-search-input").value.trim().toLowerCase();
        const catVal = document.getElementById("product-category-filter").value;
        const stockFilterVal = document.getElementById("product-stock-filter").value;

        const priceMin = parseFloat(document.getElementById("product-price-min").value) || 0;
        const priceMax = parseFloat(document.getElementById("product-price-max").value) || Infinity;
        const costMin = parseFloat(document.getElementById("product-cost-min").value) || 0;
        const costMax = parseFloat(document.getElementById("product-cost-max").value) || Infinity;
        const profitMin = parseFloat(document.getElementById("product-profit-min").value) || -Infinity;
        const profitMax = parseFloat(document.getElementById("product-profit-max").value) || Infinity;

        const filtered = products.filter(p => {
            const price = parseFloat(p.price);
            const cost = parseFloat(p.cost_price || 0);
            const profitVal = price - cost;
            const profitPct = cost > 0 ? (profitVal / cost * 100) : 0;
            const stockVal = parseInt(p.stock || 0);

            const matchesSearch = p.name.toLowerCase().includes(searchVal);
            const matchesCat = (catVal === "all" || p.category === catVal);
            
            const matchesPrice = price >= priceMin && price <= priceMax;
            const matchesCost = cost >= costMin && cost <= costMax;
            const matchesProfit = profitPct >= profitMin && profitPct <= profitMax;

            let matchesStock = true;
            if (stockFilterVal === "low") {
                matchesStock = stockVal <= 5;
            } else if (stockFilterVal === "out") {
                matchesStock = stockVal === 0;
            }

            return matchesSearch && matchesCat && matchesPrice && matchesCost && matchesProfit && matchesStock;
        });

        if (filtered.length === 0) {
            productsBody.innerHTML = `<tr><td colspan="9" class="text-center text-secondary py-4">Không tìm thấy sản phẩm nào phù hợp.</td></tr>`;
            return;
        }

        filtered.forEach((p, idx) => {
            const isSaleVal = (p.is_sale == 1 || p.isSale);
            const price = parseInt(p.price);
            const costPrice = parseInt(p.cost_price || 0);
            const profit = price - costPrice;
            const profitRate = costPrice > 0 ? Math.round(profit / costPrice * 100) : 0;
            
            // Stock styling
            const stockVal = parseInt(p.stock || 0);
            let stockHTML = `<span class="badge bg-success">${stockVal} chiếc</span>`;
            if (stockVal === 0) {
                stockHTML = `<span class="badge bg-danger">Hết hàng</span>`;
            } else if (stockVal <= 5) {
                stockHTML = `<span class="badge bg-warning text-dark">${stockVal} chiếc (Ít)</span>`;
            }

            const tr = document.createElement("tr");

            // Low-stock row highlighting
            if (stockVal <= 5) {
                tr.style.background = "rgba(255, 193, 7, 0.04)";
                tr.style.borderLeft = "3px solid var(--accent-gold)";
            }

            tr.innerHTML = `
                <td><img src="../images/${p.img}" alt="${p.name}" style="width: 42px; height: 42px; object-fit: contain; background: white; border-radius: 6px; padding: 2px;" onerror="this.src='../images/ip16pm.webp'"></td>
                <td><strong>${p.name}</strong> ${isSaleVal ? '<span class="badge bg-danger small ms-1">-20%</span>' : ''}</td>
                <td><span class="text-gold font-weight-bold">${formatVND(price)}</span></td>
                <td><span class="text-secondary">${formatVND(costPrice)}</span></td>
                <td>
                    <span class="text-success fw-bold">${formatVND(profit)}</span><br>
                    <small class="text-muted">(${profitRate}%)</small>
                </td>
                <td>
                    <span class="text-info small fw-bold">N: ${p.total_imported || 0}</span> | 
                    <span class="text-warning small fw-bold">X: ${p.total_exported || 0}</span>
                </td>
                <td>${stockHTML}</td>
                <td><span class="text-uppercase small" style="letter-spacing: 0.5px;">${p.category}</span></td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn-admin-action edit edit-product-btn" data-index="${idx}" title="Sửa"><i class="fas fa-edit"></i></button>
                        <button class="btn-admin-action delete delete-product-btn" data-index="${idx}" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </td>
            `;
            productsBody.appendChild(tr);
        });

        // Bắt sự kiện Xóa sản phẩm
        productsBody.querySelectorAll(".delete-product-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const idx = parseInt(this.getAttribute("data-index"));
                const prod = filtered[idx];
                if (confirm(`Bạn có chắc chắn muốn xóa sản phẩm "${prod.name}"?`)) {
                    fetch("api.php?action=delete_product", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: prod.id })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            loadTabData("products");
                        } else {
                            alert(data.message);
                        }
                    });
                }
            });
        });

        // Bắt sự kiện Sửa sản phẩm
        productsBody.querySelectorAll(".edit-product-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const idx = parseInt(this.getAttribute("data-index"));
                const prod = filtered[idx];
                const realIdx = products.findIndex(p => p.id === prod.id);
                if (realIdx !== -1) {
                    openProductModal(realIdx);
                }
            });
        });
    }

    // Modal Add/Edit
    const modal = document.getElementById("admin-product-modal");
    const overlay = document.getElementById("admin-product-overlay");
    const closeBtn = document.getElementById("modal-close-btn");
    const form = document.getElementById("product-form");
    const addProductBtn = document.getElementById("btn-add-product-modal");

    if (addProductBtn) addProductBtn.addEventListener("click", () => openProductModal());
    if (closeBtn) closeBtn.addEventListener("click", closeProductModal);
    if (overlay) overlay.addEventListener("click", closeProductModal);

    function openProductModal(index = null) {
        modal.classList.add("active");
        overlay.classList.add("active");
        document.body.style.overflow = "hidden";

        const title = document.getElementById("modal-product-title");
        const idxField = document.getElementById("form-product-index");
        
        if (index !== null) {
            title.textContent = "CẬP NHẬT SẢN PHẨM";
            idxField.value = index;
            document.getElementById("form-product-name").value = products[index].name;
            document.getElementById("form-product-price").value = formatNumberWithDots(products[index].price.toString());
            document.getElementById("form-product-cost-price").value = formatNumberWithDots((products[index].cost_price || 0).toString());
            
            // Calculate and set profit rate
            const cost = parseInt(products[index].cost_price || 0);
            const price = parseInt(products[index].price);
            const rate = cost > 0 ? Math.round((price - cost) / cost * 100) : 0;
            document.getElementById("form-product-profit-rate").value = rate;

            document.getElementById("form-product-stock").value = products[index].stock || 0;
            document.getElementById("form-product-category").value = products[index].category;
            const isSaleVal = (products[index].is_sale == 1 || products[index].isSale) ? "true" : "false";
            document.getElementById("form-product-sale").value = isSaleVal;
            document.getElementById("form-product-image").value = products[index].img;
            document.getElementById("form-product-specs").value = products[index].specs;
        } else {
            title.textContent = "THÊM SẢN PHẨM MỚI";
            idxField.value = "";
            form.reset();
            document.getElementById("form-product-price").value = "";
            document.getElementById("form-product-cost-price").value = "";
            document.getElementById("form-product-profit-rate").value = "";
            document.getElementById("form-product-stock").value = "";
        }
        const uploadStatus = document.getElementById("image-upload-status");
        if (uploadStatus) {
            uploadStatus.style.display = "none";
            uploadStatus.innerHTML = "";
        }
    }

    function closeProductModal() {
        modal.classList.remove("active");
        overlay.classList.remove("active");
        document.body.style.overflow = "";
    }

    if (form) {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            const idx = document.getElementById("form-product-index").value;
            const name = document.getElementById("form-product-name").value.trim();
            const price = parseInt(document.getElementById("form-product-price").value.replace(/\./g, "")) || 0;
            const costPrice = parseInt((document.getElementById("form-product-cost-price").value || "0").replace(/\./g, "")) || 0;
            const stock = parseInt(document.getElementById("form-product-stock").value || 0);
            const category = document.getElementById("form-product-category").value;
            const isSale = document.getElementById("form-product-sale").value === "true" ? 1 : 0;
            const img = document.getElementById("form-product-image").value.trim();
            const specs = document.getElementById("form-product-specs").value.trim();

            if (price <= 0) {
                alert("Lỗi: Giá bán phải lớn hơn 0!");
                return;
            }
            if (costPrice < 0) {
                alert("Lỗi: Giá nhập không được âm!");
                return;
            }
            if (stock < 0) {
                alert("Lỗi: Số lượng tồn kho không được âm!");
                return;
            }
            if (price < costPrice) {
                alert("Lỗi: Giá bán phải lớn hơn hoặc bằng giá nhập (không thể bán lỗ)!");
                return;
            }

            const pData = { name, price, costPrice, stock, category, isSale, img, specs };

            if (idx !== "") {
                pData.id = products[parseInt(idx)].id;
            }

            fetch("api.php?action=save_product", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(pData)
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeProductModal();
                    loadTabData("products");
                } else {
                    alert(data.message);
                }
            });
        });
    }

    const searchInput = document.getElementById("product-search-input");
    const filterCat = document.getElementById("product-category-filter");
    if (searchInput) searchInput.addEventListener("input", renderProducts);
    if (filterCat) filterCat.addEventListener("change", renderProducts);

    const filterStock = document.getElementById("product-stock-filter");
    const priceMinInput = document.getElementById("product-price-min");
    const priceMaxInput = document.getElementById("product-price-max");
    const costMinInput = document.getElementById("product-cost-min");
    const costMaxInput = document.getElementById("product-cost-max");
    const profitMinInput = document.getElementById("product-profit-min");
    const profitMaxInput = document.getElementById("product-profit-max");

    if (filterStock) filterStock.addEventListener("change", renderProducts);
    if (priceMinInput) priceMinInput.addEventListener("input", renderProducts);
    if (priceMaxInput) priceMaxInput.addEventListener("input", renderProducts);
    if (costMinInput) costMinInput.addEventListener("input", renderProducts);
    if (costMaxInput) costMaxInput.addEventListener("input", renderProducts);
    if (profitMinInput) profitMinInput.addEventListener("input", renderProducts);
    if (profitMaxInput) profitMaxInput.addEventListener("input", renderProducts);

    // Image selection and AJAX upload logic
    const btnBrowse = document.getElementById("btn-browse-image");
    const fileInput = document.getElementById("form-product-image-file");
    const imgTextInput = document.getElementById("form-product-image");
    const uploadStatusLabel = document.getElementById("image-upload-status");
    const submitBtn = form ? form.querySelector("button[type='submit']") : null;

    if (btnBrowse && fileInput) {
        btnBrowse.addEventListener("click", function() {
            fileInput.click();
        });

        fileInput.addEventListener("change", function() {
            if (fileInput.files.length === 0) return;
            
            const file = fileInput.files[0];
            const formData = new FormData();
            formData.append("image", file);

            // Display loading status
            uploadStatusLabel.style.display = "block";
            uploadStatusLabel.className = "small mt-1 text-warning";
            uploadStatusLabel.textContent = "Đang tải ảnh lên...";
            btnBrowse.disabled = true;
            if (submitBtn) submitBtn.disabled = true;

            fetch("api.php?action=upload_image", {
                method: "POST",
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                btnBrowse.disabled = false;
                if (submitBtn) submitBtn.disabled = false;
                if (data.success) {
                    imgTextInput.value = data.filename;
                    uploadStatusLabel.className = "small mt-1 text-success";
                    uploadStatusLabel.innerHTML = `<i class="fas fa-check-circle"></i> Tải ảnh lên thành công!`;
                } else {
                    uploadStatusLabel.className = "small mt-1 text-danger";
                    uploadStatusLabel.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${data.message}`;
                }
            })
            .catch(err => {
                console.error(err);
                btnBrowse.disabled = false;
                if (submitBtn) submitBtn.disabled = false;
                uploadStatusLabel.className = "small mt-1 text-danger";
                uploadStatusLabel.innerHTML = `<i class="fas fa-exclamation-circle"></i> Lỗi kết nối máy chủ!`;
            });
        });
    }

    // TAB 3: RENDER ORDERS
    let orderSortAddressAsc = false;

    function renderOrders() {
        const ordersBody = document.querySelector("#orders-table tbody");
        if (!ordersBody) return;

        ordersBody.innerHTML = "";

        const searchVal = document.getElementById("order-search-input").value.trim().toLowerCase();
        const statusVal = document.getElementById("order-status-filter").value;
        const dateMinVal = document.getElementById("order-date-min").value;
        const dateMaxVal = document.getElementById("order-date-max").value;

        let filtered = orders.filter(o => {
            const matchesSearch = o.orderId.toLowerCase().includes(searchVal) || o.customerName.toLowerCase().includes(searchVal);
            const matchesStatus = (statusVal === "all" || o.status === statusVal);
            
            let matchesDate = true;
            if (dateMinVal) {
                matchesDate = matchesDate && (o.date >= dateMinVal);
            }
            if (dateMaxVal) {
                matchesDate = matchesDate && (o.date <= dateMaxVal);
            }

            return matchesSearch && matchesStatus && matchesDate;
        });

        // Apply sorting alphabetically by address (A-Z) if active
        if (orderSortAddressAsc) {
            filtered.sort((a, b) => {
                const addrA = (a.address || "").toLowerCase();
                const addrB = (b.address || "").toLowerCase();
                return addrA.localeCompare(addrB, "vi");
            });
        }

        if (filtered.length === 0) {
            ordersBody.innerHTML = `<tr><td colspan="7" class="text-center text-secondary py-4">Không tìm thấy đơn hàng nào phù hợp.</td></tr>`;
            return;
        }

        filtered.forEach((o) => {
            const itemsHTML = o.items.map(item => `
                <div class="small d-flex justify-content-between mb-1" style="font-size: 11px;">
                    <span class="text-white">${item.title}</span>
                    <span class="text-secondary">x${item.quantity}</span>
                </div>
            `).join("");

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td><strong>#${o.orderId}</strong></td>
                <td>
                    <div style="font-weight: 700; font-size: 13px;">${o.customerName}</div>
                    <div class="text-secondary" style="font-size: 11px;">SĐT: ${o.phone}</div>
                    <div class="text-secondary text-wrap" style="font-size: 10px; max-width: 200px;" title="${o.address}">${o.address}</div>
                </td>
                <td style="min-width: 200px;">${itemsHTML}</td>
                <td><span class="text-gold font-weight-bold">${formatVND(parseInt(o.grandTotal))}</span></td>
                <td><span class="small">${o.paymentMethod === 'cod' ? 'COD' : (o.paymentMethod === 'bank' ? 'QR Ngân hàng' : 'Thẻ Visa')}</span></td>
                <td><span class="small text-secondary">${o.date}</span></td>
                <td>
                    <select class="form-select form-select-sm select-order-status" data-order-id="${o.orderId}" style="width: auto; background: #0f131c; border-color: rgba(255,255,255,0.08); color: white; font-size: 12px; font-weight: 700;">
                        <option value="Chờ thanh toán" ${o.status === 'Chờ thanh toán' ? 'selected' : ''}>Chờ thanh toán</option>
                        <option value="Đang xử lý" ${o.status === 'Đang xử lý' ? 'selected' : ''}>Đang xử lý</option>
                        <option value="Đã thanh toán" ${o.status === 'Đã thanh toán' ? 'selected' : ''}>Đã thanh toán</option>
                        <option value="Đang giao hàng" ${o.status === 'Đang giao hàng' ? 'selected' : ''}>Đang giao hàng</option>
                        <option value="Hoàn thành" ${o.status === 'Hoàn thành' ? 'selected' : ''}>Hoàn thành</option>
                        <option value="Đã hủy" ${o.status === 'Đã hủy' ? 'selected' : ''}>Đã hủy</option>
                    </select>
                </td>
            `;
            ordersBody.appendChild(tr);
        });

        // Bắt sự kiện đổi trạng thái đơn hàng
        ordersBody.querySelectorAll(".select-order-status").forEach(select => {
            select.addEventListener("change", function() {
                const orderId = this.getAttribute("data-order-id");
                const newStatus = this.value;

                fetch("api.php?action=update_order_status", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ orderId: orderId, status: newStatus })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        alert(`Đã cập nhật trạng thái đơn hàng #${orderId} thành "${newStatus}"!`);
                    } else {
                        alert(data.message);
                    }
                });
            });
        });
    }

    const orderSearch = document.getElementById("order-search-input");
    const orderStatusFilter = document.getElementById("order-status-filter");
    const orderDateMin = document.getElementById("order-date-min");
    const orderDateMax = document.getElementById("order-date-max");
    const btnSortAddress = document.getElementById("btn-sort-order-address");

    if (orderSearch) orderSearch.addEventListener("input", renderOrders);
    if (orderStatusFilter) orderStatusFilter.addEventListener("change", renderOrders);
    if (orderDateMin) orderDateMin.addEventListener("input", renderOrders);
    if (orderDateMax) orderDateMax.addEventListener("input", renderOrders);

    if (btnSortAddress) {
        btnSortAddress.addEventListener("click", function() {
            orderSortAddressAsc = !orderSortAddressAsc;
            if (orderSortAddressAsc) {
                btnSortAddress.innerHTML = `<i class="fas fa-sort-alpha-up"></i> ĐÃ XẾP ĐỊA CHỈ (A-Z)`;
                btnSortAddress.classList.remove("btn-outline-warning");
                btnSortAddress.classList.add("btn-warning");
            } else {
                btnSortAddress.innerHTML = `<i class="fas fa-sort-alpha-down"></i> XẾP THEO ĐỊA CHỈ (A-Z)`;
                btnSortAddress.classList.remove("btn-warning");
                btnSortAddress.classList.add("btn-outline-warning");
            }
            renderOrders();
        });
    }

    // TAB 4: RENDER CUSTOMERS
    function renderCustomers() {
        const customersBody = document.querySelector("#customers-table tbody");
        if (!customersBody) return;

        customersBody.innerHTML = "";

        if (users.length === 0) {
            customersBody.innerHTML = `<tr><td colspan="6" class="text-center text-secondary py-4">Chưa có tài khoản đăng ký nào.</td></tr>`;
            return;
        }

        users.forEach((u, index) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td><strong>${u.fullname}</strong></td>
                <td><code>${u.username}</code></td>
                <td>${u.email}</td>
                <td><span class="badge ${u.role === 'admin' ? 'bg-danger' : 'bg-primary'}">${u.role === 'admin' ? 'ADMIN' : 'MEMBER'}</span></td>
                <td><span class="status-pill ${u.status === 'active' ? 'success' : 'danger'}">${u.status === 'active' ? 'Hoạt động' : 'Đã khóa'}</span></td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn-admin-action edit toggle-role-btn" data-index="${index}" title="Chuyển quyền"><i class="fas fa-user-shield"></i></button>
                        <button class="btn-admin-action ${u.status === 'active' ? 'delete' : 'success'} toggle-status-btn" data-index="${index}" title="${u.status === 'active' ? 'Khóa' : 'Mở khóa'}">
                            <i class="fas ${u.status === 'active' ? 'fa-lock' : 'fa-unlock'}"></i>
                        </button>
                    </div>
                </td>
            `;
            customersBody.appendChild(tr);
        });

        // Bắt sự kiện Chuyển quyền Admin / Member
        customersBody.querySelectorAll(".toggle-role-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const idx = parseInt(this.getAttribute("data-index"));
                const user = users[idx];
                const newRole = user.role === "admin" ? "user" : "admin";
                
                if (confirm(`Bạn muốn đổi vai trò của "${user.fullname}" sang "${newRole.toUpperCase()}"?`)) {
                    fetch("api.php?action=toggle_customer_role", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: user.id, role: newRole })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            loadTabData("customers");
                        } else {
                            alert(data.message);
                        }
                    });
                }
            });
        });

        // Bắt sự kiện Khóa / Mở khóa tài khoản
        customersBody.querySelectorAll(".toggle-status-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const idx = parseInt(this.getAttribute("data-index"));
                const user = users[idx];
                const newStatus = user.status === "active" ? "blocked" : "active";

                if (confirm(`Bạn muốn ${newStatus === 'active' ? 'mở khóa' : 'khóa'} tài khoản của "${user.fullname}"?`)) {
                    fetch("api.php?action=toggle_customer_status", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: user.id, status: newStatus })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            loadTabData("customers");
                        } else {
                            alert(data.message);
                        }
                    });
                }
            });
        });
    }

    // TAB 5: RENDER SETTINGS
    function renderSettings() {
        document.getElementById("set-shop-name").value = settings.shopName || "TECHLUXURY";
        document.getElementById("set-hotline").value = settings.hotline || "1900.8989";
        document.getElementById("set-email").value = settings.email || "support@techluxury.vn";
        document.getElementById("set-address").value = settings.address || "";
        document.getElementById("set-discount").value = settings.discount || 10;
        document.getElementById("set-maintenance").value = settings.maintenance || "active";
    }

    // Submit form settings
    const settingsForm = document.getElementById("shop-settings-form");
    if (settingsForm) {
        settingsForm.addEventListener("submit", function(e) {
            e.preventDefault();
            
            const newSettings = {
                shopName: document.getElementById("set-shop-name").value.trim(),
                hotline: document.getElementById("set-hotline").value.trim(),
                email: document.getElementById("set-email").value.trim(),
                address: document.getElementById("set-address").value.trim(),
                discount: parseInt(document.getElementById("set-discount").value) || 0,
                maintenance: document.getElementById("set-maintenance").value
            };

            fetch("api.php?action=save_settings", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(newSettings)
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    loadTabData("settings");
                } else {
                    alert(data.message);
                }
            });
        });
    }

    // =========================================================================
    // TAB 6: RENDER CATEGORIES & MODAL EVENTS
    // =========================================================================
    let localCategories = [];

    function renderCategories(cats) {
        localCategories = cats;
        const body = document.querySelector("#categories-table tbody");
        if (!body) return;
        body.innerHTML = "";

        if (cats.length === 0) {
            body.innerHTML = `<tr><td colspan="4" class="text-center text-secondary py-4">Chưa có danh mục nào.</td></tr>`;
            return;
        }

        cats.forEach((cat, idx) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td><code>${cat.id}</code></td>
                <td><strong>${cat.name}</strong></td>
                <td>${cat.display_name}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn-admin-action edit edit-cat-btn" data-id="${cat.id}" data-index="${idx}" title="Sửa"><i class="fas fa-edit"></i></button>
                        <button class="btn-admin-action delete delete-cat-btn" data-id="${cat.id}" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </td>
            `;
            body.appendChild(tr);
        });

        // Edit category trigger
        body.querySelectorAll(".edit-cat-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const idx = parseInt(this.getAttribute("data-index"));
                openCategoryModal(localCategories[idx]);
            });
        });

        // Delete category trigger
        body.querySelectorAll(".delete-cat-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const id = this.getAttribute("data-id");
                if (confirm("Bạn có chắc chắn muốn xóa danh mục này? Các sản phẩm thuộc danh mục này sẽ mất phân loại.")) {
                    fetch("api.php?action=delete_category", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: id })
                    })
                    .then(r => r.json())
                    .then(data => {
                        alert(data.message);
                        loadCategoryDropdowns();
                        loadTabData("categories");
                    });
                }
            });
        });
    }

    const catModal = document.getElementById("admin-category-modal");
    const catOverlay = document.getElementById("admin-category-overlay");
    const catClose = document.getElementById("modal-category-close");
    const btnAddCat = document.getElementById("btn-add-category");
    const catForm = document.getElementById("category-form");

    if (btnAddCat) btnAddCat.addEventListener("click", () => openCategoryModal());
    if (catClose) catClose.addEventListener("click", closeCategoryModal);
    if (catOverlay) catOverlay.addEventListener("click", closeCategoryModal);

    function openCategoryModal(cat = null) {
        if (!catModal || !catOverlay) return;
        catModal.classList.add("active");
        catOverlay.classList.add("active");
        
        const title = document.getElementById("modal-category-title");
        const idField = document.getElementById("form-category-id");
        const nameField = document.getElementById("form-category-name");
        const displayField = document.getElementById("form-category-display");

        if (cat) {
            title.textContent = "CẬP NHẬT DANH MỤC";
            idField.value = cat.id;
            nameField.value = cat.name;
            displayField.value = cat.display_name;
        } else {
            title.textContent = "THÊM DANH MỤC MỚI";
            idField.value = "";
            nameField.value = "";
            displayField.value = "";
        }
    }

    function closeCategoryModal() {
        if (catModal && catOverlay) {
            catModal.classList.remove("active");
            catOverlay.classList.remove("active");
        }
    }

    if (catForm) {
        catForm.addEventListener("submit", function(e) {
            e.preventDefault();
            const id = document.getElementById("form-category-id").value;
            const name = document.getElementById("form-category-name").value.trim();
            const display_name = document.getElementById("form-category-display").value.trim();

            fetch("api.php?action=save_category", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id, name, display_name })
            })
            .then(r => r.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    closeCategoryModal();
                    loadCategoryDropdowns();
                    loadTabData("categories");
                }
            });
        });
    }

    // Dynamic populate Category dropdowns in product tab
    function loadCategoryDropdowns() {
        fetch("api.php?action=categories_list")
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const filterDropdown = document.getElementById("product-category-filter");
                    const formDropdown = document.getElementById("form-product-category");
                    
                    if (filterDropdown) {
                        const currentVal = filterDropdown.value;
                        filterDropdown.innerHTML = `<option value="all">Tất cả danh mục</option>`;
                        data.categories.forEach(cat => {
                            filterDropdown.innerHTML += `<option value="${cat.name}">${cat.display_name}</option>`;
                        });
                        filterDropdown.value = currentVal || "all";
                    }
                    if (formDropdown) {
                        formDropdown.innerHTML = "";
                        data.categories.forEach(cat => {
                            formDropdown.innerHTML += `<option value="${cat.name}">${cat.display_name}</option>`;
                        });
                    }
                }
            });
    }

    // =========================================================================
    // TAB 7: RENDER IMPORT VOUCHERS & MODAL EVENTS
    // =========================================================================
    let localVouchers = [];

    function renderVouchers(vouchers) {
        localVouchers = vouchers;
        const body = document.querySelector("#vouchers-table tbody");
        if (!body) return;
        body.innerHTML = "";

        if (vouchers.length === 0) {
            body.innerHTML = `<tr><td colspan="6" class="text-center text-secondary py-4">Chưa có phiếu nhập hàng nào được tạo.</td></tr>`;
            return;
        }

        vouchers.forEach((v, idx) => {
            const itemsHTML = v.items.map(item => `
                <div class="small d-flex justify-content-between mb-1" style="font-size: 11px;">
                    <span class="text-white">${item.product_name}</span>
                    <span class="text-secondary">SL: ${item.quantity} | Giá: ${formatVND(parseFloat(item.import_price))}</span>
                </div>
            `).join("");

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td><strong>#${v.voucher_code}</strong></td>
                <td>${v.provider}</td>
                <td>${itemsHTML}</td>
                <td><span class="text-gold fw-bold">${formatVND(parseFloat(v.total_amount))}</span></td>
                <td><span class="small text-secondary">${v.created_at}</span></td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn-admin-action edit edit-voucher-btn" data-index="${idx}" title="Sửa"><i class="fas fa-edit"></i></button>
                        <button class="btn-admin-action delete delete-voucher-btn" data-id="${v.id}" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </td>
            `;
            body.appendChild(tr);
        });

        // Edit voucher trigger
        body.querySelectorAll(".edit-voucher-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const idx = parseInt(this.getAttribute("data-index"));
                openVoucherModal(localVouchers[idx]);
            });
        });

        // Delete voucher trigger
        body.querySelectorAll(".delete-voucher-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const id = this.getAttribute("data-id");
                if (confirm("Bạn có chắc chắn muốn xóa phiếu nhập này? Tồn kho các sản phẩm trong phiếu nhập sẽ được giảm tương ứng.")) {
                    fetch("api.php?action=delete_voucher", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: id })
                    })
                    .then(r => r.json())
                    .then(data => {
                        alert(data.message);
                        loadTabData("vouchers");
                    });
                }
            });
        });
    }

    const voucherModal = document.getElementById("admin-voucher-modal");
    const voucherOverlay = document.getElementById("admin-voucher-overlay");
    const voucherClose = document.getElementById("modal-voucher-close");
    const btnAddVoucher = document.getElementById("btn-add-voucher");
    const btnAddVoucherItem = document.getElementById("btn-add-voucher-item");
    const voucherForm = document.getElementById("voucher-form");
    const voucherItemsContainer = document.getElementById("voucher-items-container");

    if (btnAddVoucher) btnAddVoucher.addEventListener("click", () => openVoucherModal());
    if (voucherClose) voucherClose.addEventListener("click", closeVoucherModal);
    if (voucherOverlay) voucherOverlay.addEventListener("click", closeVoucherModal);

    function createVoucherItemRow(item = null) {
        const row = document.createElement("div");
        row.className = "row g-2 align-items-center voucher-item-row mb-2";
        
        let productOptions = products.map(p => `
            <option value="${p.id}" ${item && parseInt(item.product_id) === p.id ? "selected" : ""}>${p.name}</option>
        `).join("");

        row.innerHTML = `
            <div class="col-6">
                <select class="form-select text-white select-voucher-item-product" required style="background: #0f131c; border: 1px solid var(--border-color); font-size: 12px; padding: 8px 12px;">
                    ${productOptions}
                </select>
            </div>
            <div class="col-3">
                <input type="number" class="form-control text-white input-voucher-item-qty" required min="1" placeholder="SL" value="${item ? item.quantity : 1}" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); font-size: 12px; padding: 8px 12px;">
            </div>
            <div class="col-2">
                <input type="text" class="form-control text-white input-voucher-item-price" required placeholder="Giá" value="${item ? formatNumberWithDots(item.import_price.toString()) : ""}" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); font-size: 12px; padding: 8px 12px;">
            </div>
            <div class="col-1 text-center">
                <button type="button" class="btn btn-link text-danger btn-remove-voucher-item p-0 m-0" style="font-size: 16px;"><i class="fas fa-trash-alt"></i></button>
            </div>
        `;

        // Format import price on the fly
        setupPriceFormatting(row.querySelector(".input-voucher-item-price"));

        // Add event listeners to update total
        row.querySelector(".input-voucher-item-qty").addEventListener("input", calculateVoucherTotal);
        row.querySelector(".input-voucher-item-price").addEventListener("input", calculateVoucherTotal);

        row.querySelector(".btn-remove-voucher-item").addEventListener("click", function() {
            row.remove();
            calculateVoucherTotal();
        });

        voucherItemsContainer.appendChild(row);
        calculateVoucherTotal();
    }

    if (btnAddVoucherItem) {
        btnAddVoucherItem.addEventListener("click", () => createVoucherItemRow());
    }

    function calculateVoucherTotal() {
        let total = 0;
        document.querySelectorAll(".voucher-item-row").forEach(row => {
            const qty = parseInt(row.querySelector(".input-voucher-item-qty").value) || 0;
            const price = parseInt(row.querySelector(".input-voucher-item-price").value.replace(/\./g, "")) || 0;
            total += qty * price;
        });
        document.getElementById("voucher-total-display").textContent = formatVND(total);
    }

    function openVoucherModal(v = null) {
        if (!voucherModal || !voucherOverlay) return;
        voucherModal.classList.add("active");
        voucherOverlay.classList.add("active");

        const title = document.getElementById("modal-voucher-title");
        const idField = document.getElementById("form-voucher-id");
        const codeField = document.getElementById("form-voucher-code");
        const providerField = document.getElementById("form-voucher-provider");

        voucherItemsContainer.innerHTML = "";

        if (v) {
            title.textContent = "CẬP NHẬT PHIẾU NHẬP HÀNG";
            idField.value = v.id;
            codeField.value = v.voucher_code;
            providerField.value = v.provider;
            
            v.items.forEach(item => {
                createVoucherItemRow(item);
            });
        } else {
            title.textContent = "TẠO PHIẾU NHẬP HÀNG MỚI";
            idField.value = "";
            codeField.value = "PN-" + Math.floor(1000 + Math.random() * 9000);
            providerField.value = "";
            
            // Add a default item row
            createVoucherItemRow();
        }
    }

    function closeVoucherModal() {
        if (voucherModal && voucherOverlay) {
            voucherModal.classList.remove("active");
            voucherOverlay.classList.remove("active");
        }
    }

    if (voucherForm) {
        voucherForm.addEventListener("submit", function(e) {
            e.preventDefault();
            const id = document.getElementById("form-voucher-id").value;
            const voucher_code = document.getElementById("form-voucher-code").value.trim();
            const provider = document.getElementById("form-voucher-provider").value.trim();
            const items = [];

            let hasErrors = false;
            document.querySelectorAll(".voucher-item-row").forEach(row => {
                const product_id = row.querySelector(".select-voucher-item-product").value;
                const quantity = parseInt(row.querySelector(".input-voucher-item-qty").value) || 0;
                const import_price = parseInt(row.querySelector(".input-voucher-item-price").value.replace(/\./g, "")) || 0;

                if (quantity <= 0 || import_price <= 0) {
                    hasErrors = true;
                }
                items.push({ product_id, quantity, import_price });
            });

            if (hasErrors || items.length === 0) {
                alert("Lỗi: Tất cả sản phẩm nhập phải có số lượng và giá nhập hợp lệ (>0)!");
                return;
            }

            fetch("api.php?action=save_voucher", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id, voucher_code, provider, items })
            })
            .then(r => r.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    closeVoucherModal();
                    loadTabData("vouchers");
                }
            });
        });
    }

    // 4. Logout Handler
    const logoutBtn = document.getElementById("admin-logout-btn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function() {
            localStorage.removeItem("logged_in_user");
            alert("Đã đăng xuất tài khoản admin!");
            window.location.href = "../Account/logout.php";
        });
    }

    // Khởi động load trang ban đầu với tab Overview
    loadCategoryDropdowns();
    loadTabData("overview");

    // Set tên admin trên header
    const loggedInUser = JSON.parse(localStorage.getItem("logged_in_user"));
    if (loggedInUser) {
        const fullnameEl = document.getElementById("admin-fullname");
        if (fullnameEl) fullnameEl.textContent = loggedInUser.fullname;
        
        const avatarEl = document.querySelector(".admin-avatar");
        if (avatarEl) {
            const initials = loggedInUser.fullname.split(" ").map(n => n[0]).join("").substring(0, 2).toUpperCase();
            avatarEl.textContent = initials;
        }
    }
});
</script>
</body>

</html>
