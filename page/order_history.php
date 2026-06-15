<?php 
$path_prefix = "../"; 
include("../includes/header.php"); 

// Chặn truy cập nếu chưa đăng nhập
if (!isset($_SESSION['user'])) {
    echo "<script>
        alert('Vui lòng đăng nhập để xem lịch sử đơn hàng!');
        window.location.href = '../Account/login.php';
    </script>";
    exit();
}

require_once '../includes/db.php';
$user_id = $_SESSION['user']['id'];

try {
    // Truy vấn các đơn hàng của user
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC");
    $stmt->execute(['user_id' => $user_id]);
    $orders = $stmt->fetchAll();

    // Truy vấn chi tiết sản phẩm cho từng đơn hàng
    foreach ($orders as &$order) {
        $item_stmt = $conn->prepare("
            SELECT oi.*, p.img 
            FROM order_items oi 
            LEFT JOIN products p ON p.name = oi.product_name 
            WHERE oi.order_id = :order_id
        ");
        $item_stmt->execute(['order_id' => $order['id']]);
        $order['items'] = $item_stmt->fetchAll();
    }
} catch (PDOException $e) {
    $orders = [];
}
?>

<section class="order-history-section" style="background: #090c13; min-height: 85vh; padding: 60px 0; color: white;">
    <div class="container">
        <!-- Breadcrumb & Title -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-5">
            <div class="d-flex align-items-center gap-3">
                <a href="../index.php" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2" style="border-radius: 8px; padding: 8px 16px; border-color: rgba(255,255,255,0.08); color: #ccc; background: rgba(255,255,255,0.02); transition: all 0.3s;">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <h1 class="m-0" style="font-weight: 800; letter-spacing: 0.5px; font-size: 28px; background: linear-gradient(135deg, #fff 0%, #aaa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">LỊCH SỬ GIAO DỊCH</h1>
            </div>
            <span class="text-secondary small fw-medium" style="background: rgba(255, 255, 255, 0.03); padding: 8px 16px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.05);">
                Tài khoản: <strong class="text-white"><?php echo htmlspecialchars($_SESSION['user']['fullname']); ?></strong>
            </span>
        </div>

        <?php if (empty($orders)): ?>
            <!-- Trạng thái giỏ hàng trống / Chưa có đơn hàng -->
            <div class="text-center py-5 rounded-4" style="background: rgba(255, 255, 255, 0.01); border: 1px solid rgba(255,255,255,0.05); backdrop-filter: blur(10px);">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background: rgba(212, 175, 55, 0.05); color: var(--accent-gold); border: 1px solid rgba(212,175,55,0.1);">
                    <i class="fas fa-receipt" style="font-size: 32px;"></i>
                </div>
                <h3 class="text-white mb-2" style="font-weight: 700;">Bạn chưa có giao dịch nào</h3>
                <p class="text-secondary mb-4 mx-auto" style="font-size: 14px; max-width: 400px; line-height: 1.6;">
                    Lịch sử mua sắm của bạn đang trống. Hãy lựa chọn những sản phẩm công nghệ cao cấp nhất của chúng tôi ngay hôm nay.
                </p>
                <a href="product.php" class="btn btn-warning px-4 py-3 fw-bold" style="border-radius: 8px; font-size: 13px; letter-spacing: 0.5px;">MUA SẮM NGAY</a>
            </div>
        <?php else: ?>
            <!-- Danh sách đơn hàng -->
            <div class="order-history-list d-flex flex-column gap-4">
                <?php foreach ($orders as $order): ?>
                    <div class="order-card p-4 rounded-4" style="background: rgba(15, 19, 28, 0.5); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.04); box-shadow: 0 10px 30px rgba(0,0,0,0.2); transition: all 0.3s ease; position: relative; overflow: hidden;">
                        
                        <!-- Glow effect on hover -->
                        <div class="order-card-hover-border"></div>

                        <!-- Card Header -->
                        <div class="order-card-header d-flex flex-wrap justify-content-between align-items-center gap-3 pb-3 mb-4" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <div>
                                <span class="order-code fs-5 fw-bold text-gold" style="color: var(--accent-gold); font-family: monospace; letter-spacing: 0.5px;">#<?php echo htmlspecialchars($order['order_code']); ?></span>
                                <span class="text-secondary small ms-3 d-inline-block" style="font-size: 12px;">
                                    <i class="far fa-clock me-1"></i> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?>
                                </span>
                            </div>
                            <div>
                                <?php 
                                $status = $order['status'];
                                $badge_style = 'background: rgba(212,175,55,0.1); color: var(--accent-gold); border: 1px solid rgba(212,175,55,0.2);';
                                if ($status === 'Đã thanh toán' || $status === 'Hoàn thành' || $status === 'Đang giao hàng') {
                                    $badge_style = 'background: rgba(46,204,113,0.1); color: #2ecc71; border: 1px solid rgba(46,204,113,0.2);';
                                } elseif ($status === 'Đã hủy') {
                                    $badge_style = 'background: rgba(255,71,87,0.1); color: #ff4757; border: 1px solid rgba(255,71,87,0.2);';
                                }
                                ?>
                                <span class="badge px-3 py-2 text-uppercase fw-bold" style="<?php echo $badge_style; ?> border-radius: 6px; font-size: 10px; letter-spacing: 0.8px;">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </div>
                        </div>

                        <!-- Card Body (Products purchased) -->
                        <div class="order-card-body d-flex flex-column gap-3 mb-4">
                            <?php foreach ($order['items'] as $item): ?>
                                <div class="order-item-row d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid rgba(255,255,255,0.02);">
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- Product Image -->
                                        <div class="product-img-box rounded-3 overflow-hidden d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: white; padding: 4px; border: 1px solid rgba(255,255,255,0.06);">
                                            <img src="<?php echo !empty($item['img']) ? '../images/' . htmlspecialchars($item['img']) : '../images/ip16pm.webp'; ?>" 
                                                 alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                                                 style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        </div>
                                        <div>
                                            <h5 class="text-white m-0 fs-6 fw-semibold"><?php echo htmlspecialchars($item['product_name']); ?></h5>
                                            <span class="text-secondary small">Số lượng: <strong class="text-white"><?php echo $item['quantity']; ?></strong></span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-white fw-bold" style="font-size: 14px;"><?php echo number_format($item['price'] * $item['quantity'], 0, '', '.'); ?>đ</span>
                                        <br>
                                        <small class="text-secondary" style="font-size: 11px;"><?php echo number_format($item['price'], 0, '', '.'); ?>đ / chiếc</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Order Notes -->
                            <?php if (!empty($order['notes'])): ?>
                                <div class="order-notes mt-2 p-3 rounded-3" style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.03); font-size: 12px; color: #bbb;">
                                    <strong class="text-secondary"><i class="far fa-comment-dots me-1"></i> Ghi chú đặt hàng:</strong> 
                                    <span><?php echo htmlspecialchars($order['notes']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Card Footer -->
                        <div class="order-card-footer d-flex flex-wrap justify-content-between align-items-center gap-3 pt-3" style="border-top: 1px solid rgba(255,255,255,0.05);">
                            <div class="text-secondary small">
                                <i class="fas fa-wallet me-1"></i> Phương thức thanh toán: 
                                <strong class="text-white">
                                    <?php 
                                    $method = $order['payment_method'];
                                    if ($method === 'cod') echo 'Thanh toán khi nhận hàng (COD)';
                                    elseif ($method === 'bank') echo 'Chuyển khoản VietQR (MB Bank)';
                                    elseif ($method === 'card') echo 'Cổng thẻ Visa/Mastercard';
                                    else echo htmlspecialchars($method);
                                    ?>
                                </strong>
                            </div>
                            <div class="fs-6 text-secondary fw-semibold">
                                Tổng số tiền: <span style="color: var(--accent-gold); font-size: 20px; font-weight: 800;"><?php echo number_format($order['total_amount'], 0, '', '.'); ?>đ</span>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.order-card {
    position: relative;
    z-index: 1;
}
.order-card:hover {
    transform: translateY(-2px);
    border-color: rgba(212, 175, 55, 0.2) !important;
    box-shadow: 0 15px 35px rgba(0,0,0,0.3) !important;
}
.order-item-row:last-child {
    border-bottom: none !important;
}
</style>

<?php include("../includes/footer.php"); ?>
