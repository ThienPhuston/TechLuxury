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
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3 mb-4">
                    <h3 class="m-0">DANH SÁCH SẢN PHẨM</h3>
                    
                    <div class="d-flex flex-wrap gap-2">
                        <input type="text" id="product-search-input" placeholder="Tìm kiếm sản phẩm..." class="form-control text-white" style="width: auto; min-width: 220px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); font-size: 12px; border-radius: 8px; padding: 8px 12px;">
                        
                        <select id="product-category-filter" class="form-select text-white" style="width: auto; background: #0f131c; border: 1px solid var(--border-color); font-size: 12px; border-radius: 8px;">
                            <option value="all">Tất cả danh mục</option>
                            <option value="laptop">Laptop</option>
                            <option value="phone">Điện thoại</option>
                            <option value="accessory">Phụ kiện</option>
                        </select>

                        <button class="btn btn-outline-warning d-flex align-items-center gap-2" id="btn-add-product-modal" style="font-size: 12px; font-weight: 700; border-radius: 8px; padding: 8px 16px;">
                            <i class="fas fa-plus"></i> THÊM SẢN PHẨM
                        </button>
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
                <h3 class="m-0 mb-4">QUẢN LÝ ĐƠN HÀNG</h3>
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
            
            <div class="mb-2">
                <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">GIÁ BÁN (VNĐ)</label>
                <input type="number" id="form-product-price" required min="0" class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;">
            </div>

            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="text-secondary small fw-bold mb-1" style="font-size: 11px;">GIÁ NHẬP (VNĐ)</label>
                    <input type="number" id="form-product-cost-price" required min="0" class="form-control" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white; font-size: 13px; padding: 10px 14px;">
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

    // 2. Chuyển đổi tab SPA mượt mà
    const menuItems = document.querySelectorAll(".admin-menu li[data-tab]");
    const tabPanes = document.querySelectorAll(".tab-pane-content");
    const adminTitle = document.getElementById("admin-title");
    const adminSubtitle = document.getElementById("admin-subtitle");

    const tabHeaders = {
        overview: { title: "TỔNG QUAN HỆ THỐNG", subtitle: "Báo cáo số liệu kinh doanh hôm nay" },
        products: { title: "QUẢN LÝ SẢN PHẨM", subtitle: "Danh sách sản phẩm đang mở bán trên website" },
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
                                return;
                            }
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
        }
    }

    // TAB 2: RENDER PRODUCTS (CRUD)
    function renderProducts() {
        const productsBody = document.querySelector("#products-table tbody");
        if (!productsBody) return;

        productsBody.innerHTML = "";
        const searchVal = document.getElementById("product-search-input").value.trim().toLowerCase();
        const catVal = document.getElementById("product-category-filter").value;

        const filtered = products.filter(p => {
            const matchesSearch = p.name.toLowerCase().includes(searchVal);
            const matchesCat = (catVal === "all" || p.category === catVal);
            return matchesSearch && matchesCat;
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
            tr.innerHTML = `
                <td><img src="../images/${p.img}" alt="${p.name}" style="width: 42px; height: 42px; object-fit: contain; background: white; border-radius: 6px; padding: 2px;" onerror="this.src='../images/ip16pm.webp'"></td>
                <td><strong>${p.name}</strong> ${isSaleVal ? '<span class="badge bg-danger small ms-1">-20%</span>' : ''}</td>
                <td><span class="text-gold font-weight-bold">${formatVND(price)}</span></td>
                <td><span class="text-secondary">${formatVND(costPrice)}</span></td>
                <td>
                    <span class="text-success fw-bold">${formatVND(profit)}</span><br>
                    <small class="text-muted">(${profitRate}%)</small>
                </td>
                <td>${stockHTML}</td>
                <td><span class="text-uppercase small" style="letter-spacing: 0.5px;">${p.category}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-info edit-product-btn me-1" data-index="${idx}"><i class="fas fa-edit"></i> Sửa</button>
                    <button class="btn btn-sm btn-outline-danger delete-product-btn" data-index="${idx}"><i class="fas fa-trash-alt"></i> Xóa</button>
                </td>
            `;
            productsBody.appendChild(tr);
        });

        // Bắt sự kiện Xóa sản phẩm
        productsBody.querySelectorAll(".delete-product-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const idx = parseInt(this.getAttribute("data-index"));
                const prod = products[idx];
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
                openProductModal(idx);
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
            document.getElementById("form-product-price").value = products[index].price;
            document.getElementById("form-product-cost-price").value = products[index].cost_price || 0;
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
            document.getElementById("form-product-cost-price").value = "";
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
            const price = parseInt(document.getElementById("form-product-price").value);
            const costPrice = parseInt(document.getElementById("form-product-cost-price").value || 0);
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
    function renderOrders() {
        const ordersBody = document.querySelector("#orders-table tbody");
        if (!ordersBody) return;

        ordersBody.innerHTML = "";

        if (orders.length === 0) {
            ordersBody.innerHTML = `<tr><td colspan="7" class="text-center text-secondary py-4">Chưa có giao dịch đặt hàng nào.</td></tr>`;
            return;
        }

        orders.forEach((o, index) => {
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
                    <div class="text-secondary" style="font-size: 10px; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="${o.address}">${o.address}</div>
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
                    <button class="btn btn-sm btn-outline-warning toggle-role-btn me-1" data-index="${index}"><i class="fas fa-user-shield"></i> Chuyển quyền</button>
                    <button class="btn btn-sm ${u.status === 'active' ? 'btn-outline-danger' : 'btn-outline-success'} toggle-status-btn" data-index="${index}">
                        <i class="fas ${u.status === 'active' ? 'fa-lock' : 'fa-unlock'}"></i> ${u.status === 'active' ? 'Khóa' : 'Mở khóa'}
                    </button>
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
