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
</head>

<body>

<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <a href="../index.php" class="admin-logo-text">TECHLUXURY</a>
        
        <ul class="admin-menu">
            <li class="active">
                <a href="javascript:void(0)"><i class="fas fa-chart-line"></i> <span>Tổng quan</span></a>
            </li>
            <li>
                <a href="javascript:void(0)"><i class="fas fa-box"></i> <span>Sản phẩm</span></a>
            </li>
            <li>
                <a href="javascript:void(0)"><i class="fas fa-shopping-cart"></i> <span>Đơn hàng</span></a>
            </li>
            <li>
                <a href="javascript:void(0)"><i class="fas fa-users"></i> <span>Khách hàng</span></a>
            </li>
            <li>
                <a href="javascript:void(0)"><i class="fas fa-sliders-h"></i> <span>Cấu hình</span></a>
            </li>
            <li style="margin-top: auto;">
                <a href="../index.php" style="color: var(--accent-red); background: rgba(255, 71, 87, 0.05);"><i class="fas fa-sign-out-alt"></i> <span>Thoát Store</span></a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Bar Header -->
        <header class="admin-header">
            <div>
                <h1 class="text-white m-0" style="font-size: 24px; font-weight: 800;">TỔNG QUAN HỆ THỐNG</h1>
                <p class="text-secondary m-0" style="font-size: 13px;">Báo cáo số liệu kinh doanh hôm nay</p>
            </div>
            
            <div class="admin-profile">
                <div class="text-end d-none d-sm-block">
                    <h5 class="text-white m-0" style="font-size: 14px; font-weight: 700;">Admin Premium</h5>
                    <p class="text-secondary m-0" style="font-size: 11px;">Chủ sở hữu cửa hàng</p>
                </div>
                <div class="admin-avatar">AP</div>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="admin-stats-grid">
            <!-- Stat 1 -->
            <div class="admin-stat-card">
                <div class="admin-stat-info">
                    <p>DOANH THU THÁNG</p>
                    <h3>452.920.000đ</h3>
                </div>
                <div class="admin-stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="admin-stat-card">
                <div class="admin-stat-info">
                    <p>ĐƠN HÀNG MỚI</p>
                    <h3>128 Đơn</h3>
                </div>
                <div class="admin-stat-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="admin-stat-card">
                <div class="admin-stat-info">
                    <p>ĐÃ BÁN RA</p>
                    <h3>312 Sản phẩm</h3>
                </div>
                <div class="admin-stat-icon">
                    <i class="fas fa-box-open"></i>
                </div>
            </div>

            <!-- Stat 4 -->
            <div class="admin-stat-card">
                <div class="admin-stat-info">
                    <p>KHÁCH MỚI</p>
                    <h3>94 Thành viên</h3>
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
            
            <!-- Beautiful Ambient Glowing Line SVG Chart -->
            <div class="w-100" style="height: 180px; position: relative;">
                <svg viewBox="0 0 1000 150" class="w-100 h-100" style="overflow: visible;">
                    <defs>
                        <linearGradient id="chart-glow" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="rgba(212, 175, 55, 0.2)" />
                            <stop offset="100%" stop-color="rgba(212, 175, 55, 0)" />
                        </linearGradient>
                    </defs>
                    
                    <!-- Glow Fill Area -->
                    <path d="M0,130 Q150,90 300,110 T600,40 T900,20 L1000,10 L1000,150 L0,150 Z" fill="url(#chart-glow)"></path>
                    
                    <!-- Line -->
                    <path d="M0,130 Q150,90 300,110 T600,40 T900,20 L1000,10" fill="none" stroke="var(--accent-gold)" stroke-width="4" stroke-linecap="round"></path>
                    
                    <!-- Points -->
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

        <!-- Recent Orders Table -->
        <div class="admin-table-box">
            <h3 class="m-0 mb-4">DANH SÁCH ĐƠN HÀNG MỚI ĐẶT</h3>
            
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>MÃ ĐƠN</th>
                            <th>KHÁCH HÀNG</th>
                            <th>SẢN PHẨM</th>
                            <th>TỔNG TIỀN</th>
                            <th>PHƯƠNG THỨC</th>
                            <th>TRẠNG THÁI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#TL-8942</td>
                            <td>Nguyễn Văn Hùng</td>
                            <td>iPhone 16 Pro Max (Desert Gold)</td>
                            <td>35.990.000đ</td>
                            <td>Chuyển khoản QR</td>
                            <td><span class="status-pill warning">Đang xử lý</span></td>
                        </tr>
                        <tr>
                            <td>#TL-8712</td>
                            <td>Trần Thị Thu Thủy</td>
                            <td>Macbook Pro M4 (Space Black)</td>
                            <td>59.990.000đ</td>
                            <td>Thẻ Visa</td>
                            <td><span class="status-pill success">Đã thanh toán</span></td>
                        </tr>
                        <tr>
                            <td>#TL-8629</td>
                            <td>Lê Hoàng Nam</td>
                            <td>Galaxy Buds 3</td>
                            <td>5.990.000đ</td>
                            <td>COD</td>
                            <td><span class="status-pill success">Đang giao hàng</span></td>
                        </tr>
                        <tr>
                            <td>#TL-8510</td>
                            <td>Phạm Minh Quang</td>
                            <td>Sony WH-1000XM5</td>
                            <td>6.850.000đ</td>
                            <td>Chuyển khoản QR</td>
                            <td><span class="status-pill danger">Đã hủy</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
