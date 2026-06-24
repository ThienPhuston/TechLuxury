<?php
$path_prefix = "../";
include("../includes/header.php");
require_once '../includes/db.php';

// Get product ID from GET request
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
try {
    $stmt = $conn->prepare("SELECT p.*, b.display_name AS brand_name FROM products p LEFT JOIN brands b ON p.brand_id = b.id WHERE p.id = :id LIMIT 1");
    $stmt->execute(['id' => $product_id]);
    $product = $stmt->fetch();
} catch (PDOException $e) {
    $product = null;
}

if (!$product) {
    echo "<div class='container my-5 text-center py-5'>
        <h2 class='text-danger mb-4'><i class='fas fa-exclamation-triangle'></i> Không tìm thấy sản phẩm!</h2>
        <a href='../index.php' class='btn-checkout d-inline-block px-4 py-2' style='max-width: 250px;'>Quay về trang chủ</a>
    </div>";
    include("../includes/footer.php");
    exit();
}

// Handle new review submission
$review_success = false;
$review_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 5;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $user_fullname = isset($_POST['user_fullname']) ? trim($_POST['user_fullname']) : '';

    if (empty($user_fullname)) {
        if (isset($_SESSION['user']['fullname'])) {
            $user_fullname = $_SESSION['user']['fullname'];
        } else {
            $user_fullname = 'Khách hàng ẩn danh';
        }
    }

    if ($rating < 1 || $rating > 5) {
        $review_error = 'Đánh giá phải từ 1 đến 5 sao!';
    } elseif (empty($comment)) {
        $review_error = 'Vui lòng nhập nội dung nhận xét!';
    } else {
        try {
            $ins_review = $conn->prepare("INSERT INTO product_reviews (product_id, user_fullname, rating, comment) VALUES (:product_id, :user_fullname, :rating, :comment)");
            $ins_review->execute([
                'product_id' => $product_id,
                'user_fullname' => $user_fullname,
                'rating' => $rating,
                'comment' => $comment
            ]);
            $review_success = true;
        } catch (PDOException $e) {
            $review_error = 'Lỗi gửi đánh giá: ' . $e->getMessage();
        }
    }
}

// Fetch existing reviews for the product
try {
    $rev_stmt = $conn->prepare("SELECT * FROM product_reviews WHERE product_id = :product_id ORDER BY id DESC");
    $rev_stmt->execute(['product_id' => $product_id]);
    $reviews = $rev_stmt->fetchAll();
} catch (PDOException $e) {
    $reviews = [];
}

// Calculate average rating
$total_stars = 0;
$average_rating = 5;
if (count($reviews) > 0) {
    foreach ($reviews as $r) {
        $total_stars += intval($r['rating']);
    }
    $average_rating = round($total_stars / count($reviews), 1);
}

// Fetch related products (same category, excluding current product)
try {
    $rel_stmt = $conn->prepare("SELECT * FROM products WHERE category = :category AND id != :id LIMIT 4");
    $rel_stmt->execute(['category' => $product['category'], 'id' => $product_id]);
    $related_products = $rel_stmt->fetchAll();
} catch (PDOException $e) {
    $related_products = [];
}
?>

<div class="product-detail-page py-5">
    <div class="container">
        <!-- Back Navigation link -->
        <a href="product.php" class="back-link mb-4 d-inline-block text-secondary text-decoration-none">
            <i class="fas fa-arrow-left me-2"></i> Quay lại trang sản phẩm
        </a>

        <!-- Main Product Card Info -->
        <div class="product-detail-card mb-5 p-4 p-md-5">
            <div class="row g-5">
                <!-- Left: Image Box -->
                <div class="col-lg-6">
                    <div class="detail-img-wrapper position-relative">
                        <?php if ($product['is_sale']) { ?>
                            <div class="sale-badge">-20%</div>
                        <?php } ?>
                        <div class="detail-img-box">
                            <img src="../images/<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
                    </div>
                </div>

                <!-- Right: Details Info -->
                <div class="col-lg-6">
                    <div class="product-detail-info">
                        <span class="detail-category text-uppercase text-secondary small tracking-widest d-block mb-2">
                            <?php echo htmlspecialchars($product['category']); ?>
                        </span>
                        <h1 class="text-white mb-3" style="font-weight: 800; font-size: 32px;"><?php echo htmlspecialchars($product['name']); ?></h1>

                        <!-- Ratings Overview -->
                        <div class="detail-rating-summary d-flex align-items-center gap-3 mb-4">
                            <div class="stars text-warning" style="font-size: 14px;">
                                <?php 
                                $full_stars = floor($average_rating);
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $full_stars) {
                                        echo '<i class="fas fa-star"></i>';
                                    } elseif ($i - 0.5 <= $average_rating) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <span class="text-light fw-bold small" style="font-size: 13px;"><?php echo $average_rating; ?> / 5.0</span>
                            <span class="text-secondary small">|</span>
                            <span class="text-secondary small"><?php echo count($reviews); ?> đánh giá</span>
                        </div>

                        <!-- Price & Stock -->
                        <div class="d-flex align-items-baseline gap-3 mb-4">
                            <span class="detail-price" style="color: var(--accent-gold); font-size: 28px; font-weight: 800;">
                                <?php echo number_format($product['price'], 0, '', '.'); ?>đ
                            </span>
                            <?php if ($product['is_sale']) { 
                                $original_price = $product['price'] / 0.8;
                            ?>
                                <span class="text-secondary text-decoration-line-through small" style="font-size: 14px;">
                                    <?php echo number_format($original_price, 0, '', '.'); ?>đ
                                </span>
                            <?php } ?>
                        </div>

                        <div class="mb-4">
                            <span class="text-secondary small fw-bold">TÌNH TRẠNG KHO: </span>
                            <?php if ($product['stock'] > 0) { ?>
                                <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Còn hàng (<?php echo $product['stock']; ?> sản phẩm)</span>
                            <?php } else { ?>
                                <span class="text-danger fw-bold"><i class="fas fa-exclamation-triangle me-1"></i> Hết hàng</span>
                            <?php } ?>
                        </div>

                        <!-- Specs list -->
                        <div class="detail-specs-box p-4 mb-4" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); border-radius: 12px;">
                            <h5 class="text-white mb-3" style="font-size: 14px; font-weight: 700; letter-spacing: 0.5px;">THÔNG SỐ KỸ THUẬT</h5>
                            <div class="row g-2">
                                <?php 
                                if (!empty($product['specs'])) {
                                    $specs = explode(",", $product['specs']);
                                    foreach ($specs as $s) {
                                        $parts = explode(":", $s, 2);
                                        if (count($parts) === 2) {
                                            echo '<div class="col-6 text-secondary small">' . htmlspecialchars(trim($parts[0])) . ':</div>';
                                            echo '<div class="col-6 text-white small fw-bold">' . htmlspecialchars(trim($parts[1])) . '</div>';
                                        } else {
                                            echo '<div class="col-12 text-white small d-flex align-items-center gap-2"><i class="fas fa-circle text-warning" style="font-size: 5px;"></i> ' . htmlspecialchars(trim($s)) . '</div>';
                                        }
                                    }
                                } else {
                                    echo '<div class="col-12 text-secondary small">Chưa cập nhật thông số kỹ thuật chi tiết.</div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Quantity Selector + Action Button -->
                        <div class="detail-action">
                            <?php if ($product['stock'] > 0) { ?>
                                <!-- Qty Selector -->
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <span class="text-secondary" style="font-size:13px;font-weight:600;letter-spacing:0.5px;">SỐ LƯỢNG:</span>
                                    <div class="qty-selector d-flex align-items-center" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.1);border-radius:10px;overflow:hidden;">
                                        <button type="button" id="qty-minus" onclick="changeDetailQty(-1)"
                                            style="width:38px;height:38px;background:none;border:none;color:#aaa;font-size:16px;cursor:pointer;transition:color 0.2s;"
                                            onmouseover="this.style.color='#d4af37'" onmouseout="this.style.color='#aaa'">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" id="detail-qty-input" value="1" min="1" max="<?php echo $product['stock']; ?>"
                                            style="width:50px;text-align:center;background:none;border:none;color:white;font-weight:700;font-size:15px;padding:0;">
                                        <button type="button" id="qty-plus" onclick="changeDetailQty(1)"
                                            style="width:38px;height:38px;background:none;border:none;color:#aaa;font-size:16px;cursor:pointer;transition:color 0.2s;"
                                            onmouseover="this.style.color='#d4af37'" onmouseout="this.style.color='#aaa'">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <span class="text-secondary" style="font-size:12px;">(≤ <?php echo $product['stock']; ?>)</span>
                                </div>
                                <!-- Add to cart button -->
                                <button class="btn-checkout w-100 py-3" style="font-size: 14px;"
                                    onclick="addDetailToCart('<?php echo htmlspecialchars($product['name'], ENT_QUOTES); ?>', '<?php echo number_format($product['price'], 0, '', '.'); ?>đ', './images/<?php echo htmlspecialchars($product['img']); ?>', <?php echo $product['stock']; ?>)">
                                    <i class="fas fa-shopping-cart me-2"></i> THÊM VÀO GIỏ HÀNG
                                </button>
                            <?php } else { ?>
                                <button class="btn-checkout w-100 py-3 disabled" disabled style="background: rgba(255,255,255,0.05); color: #555; border: 1px solid rgba(255,255,255,0.05); cursor: not-allowed; font-size: 14px;">
                                    TẠM THỜI HẾT HÀNG
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Tabs Section (Reviews) -->
        <div class="row g-5">
            <!-- Left: Reviews List -->
            <div class="col-lg-7">
                <div class="product-detail-card p-4">
                    <h3 class="text-white mb-4" style="font-size: 18px; font-weight: 800; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
                        ĐÁNH GIÁ TỪ KHÁCH HÀNG (<?php echo count($reviews); ?>)
                    </h3>

                    <div class="reviews-list">
                        <?php if (count($reviews) === 0) { ?>
                            <div class="text-center py-4 text-secondary">
                                <i class="far fa-comments mb-2" style="font-size: 24px;"></i>
                                <p class="small m-0">Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên chia sẻ cảm nhận!</p>
                            </div>
                        <?php } else { 
                            foreach ($reviews as $rev) {
                        ?>
                            <div class="review-item mb-4 pb-4" style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="text-white m-0" style="font-size: 13px; font-weight: 700;"><?php echo htmlspecialchars($rev['user_fullname']); ?></h5>
                                    <span class="text-secondary small" style="font-size: 11px;"><?php echo date("d/m/Y", strtotime($rev['created_at'])); ?></span>
                                </div>
                                <div class="review-stars text-warning mb-2" style="font-size: 11px;">
                                    <?php 
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $rev['rating'] ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                                    }
                                    ?>
                                </div>
                                <p class="text-secondary small m-0" style="line-height: 1.6;"><?php echo htmlspecialchars($rev['comment']); ?></p>
                            </div>
                        <?php } } ?>
                    </div>
                </div>
            </div>

            <!-- Right: Submit Review Form -->
            <div class="col-lg-5">
                <div class="product-detail-card p-4">
                    <h3 class="text-white mb-4" style="font-size: 18px; font-weight: 800; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
                        VIẾT ĐÁNH GIÁ CỦA BẠN
                    </h3>

                    <?php if ($review_success) { ?>
                        <div class="alert alert-success small p-3 rounded-3 mb-0">
                            <i class="fas fa-check-circle me-1"></i> Gửi đánh giá của bạn thành công! Cảm ơn bạn đã đóng góp ý kiến.
                        </div>
                    <?php } else { ?>
                        <?php if ($review_error) { ?>
                            <div class="alert alert-danger small p-3 rounded-3 mb-3">
                                <i class="fas fa-exclamation-circle me-1"></i> <?php echo $review_error; ?>
                            </div>
                        <?php } ?>

                        <form action="" method="POST" id="review-form">
                            <div class="mb-3">
                                <label class="text-secondary small fw-bold mb-2">HỌ VÀ TÊN</label>
                                <input type="text" name="user_fullname" class="form-control text-white" 
                                       placeholder="Nhập tên của bạn..." 
                                       value="<?php echo isset($_SESSION['user']['fullname']) ? htmlspecialchars($_SESSION['user']['fullname']) : ''; ?>"
                                       style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: white; padding: 10px 14px; border-radius: 8px; font-size: 13px;">
                            </div>

                            <div class="mb-3">
                                <label class="text-secondary small fw-bold mb-2">SỐ SAO ĐÁNH GIÁ</label>
                                <div class="rating-selector d-flex gap-2 align-items-center">
                                    <div class="stars-select text-secondary" style="font-size: 20px; cursor: pointer;">
                                        <i class="far fa-star rating-star" data-value="1"></i>
                                        <i class="far fa-star rating-star" data-value="2"></i>
                                        <i class="far fa-star rating-star" data-value="3"></i>
                                        <i class="far fa-star rating-star" data-value="4"></i>
                                        <i class="far fa-star rating-star" data-value="5"></i>
                                    </div>
                                    <input type="hidden" name="rating" id="review-rating-input" value="5">
                                    <span class="text-warning fw-bold small ms-2" id="rating-text">5 sao (Xuất sắc)</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="text-secondary small fw-bold mb-2">NỘI DUNG NHẬN XÉT</label>
                                <textarea name="comment" rows="4" class="form-control text-white" 
                                          placeholder="Nhận xét của bạn về chất lượng sản phẩm..." required
                                          style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: white; padding: 10px 14px; border-radius: 8px; font-size: 13px; resize: none;"></textarea>
                            </div>

                            <button type="submit" name="submit_review" class="btn-checkout w-100 py-3" style="font-size: 13px;">
                                GỬI ĐÁNH GIÁ NGAY
                            </button>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        <?php if (count($related_products) > 0) { ?>
            <div class="mt-5 pt-4">
                <h3 class="text-white mb-4" style="font-size: 22px; font-weight: 800;">
                    🔥 SẢN PHẨM CÙNG DANH MỤC
                </h3>
                
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-start">
                    <?php foreach ($related_products as $p) { ?>
                        <div class="col product-col">
                            <div class="card product-square-card"
                                 onclick="window.location.href='product-detail.php?id=<?php echo $p['id']; ?>'"
                                 data-title="<?php echo htmlspecialchars($p['name']); ?>"
                                 data-price="<?php echo number_format($p['price'], 0, '', '.'); ?>đ"
                                 data-img="../images/<?php echo htmlspecialchars($p['img']); ?>"
                                 data-specs="<?php echo htmlspecialchars($p['specs'] ?? ''); ?>"
                                 data-category="<?php echo htmlspecialchars($p['category']); ?>"
                                 data-stock="<?php echo $p['stock']; ?>"
                                 style="cursor: pointer;">
                                <?php if ($p['is_sale']) { ?>
                                    <div class="sale-badge">-20%</div>
                                <?php } ?>
                                <div class="img-square-box">
                                    <img src="../images/<?php echo htmlspecialchars($p['img']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
                                </div>
                                <div class="card-square-body">
                                    <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                                    <p class="product-price mb-1"><?php echo number_format($p['price'], 0, '', '.'); ?>đ</p>
                                    <p class="product-stock small text-secondary m-0 mb-2" style="font-size: 11px;">
                                        <?php if ($p['stock'] > 0) { ?>
                                            Còn lại: <strong class="text-success"><?php echo $p['stock']; ?></strong> sản phẩm
                                        <?php } else { ?>
                                            <strong class="text-danger"><i class="fas fa-exclamation-triangle"></i> Hết hàng</strong>
                                        <?php } ?>
                                    </p>
                                </div>
                                <div class="square-action">
                                    <?php if ($p['stock'] > 0) { ?>
                                        <button class="btn-square-buy" onclick="event.stopPropagation(); addDetailToCart('<?php echo htmlspecialchars($p['name']); ?>', '<?php echo number_format($p['price'], 0, '', '.'); ?>đ', '../images/<?php echo htmlspecialchars($p['img']); ?>', <?php echo $p['stock']; ?>)">Thêm vào giỏ</button>
                                    <?php } else { ?>
                                        <button class="btn-square-buy disabled" disabled style="background: rgba(255,255,255,0.05); color: #555; border: 1px solid rgba(255,255,255,0.05); cursor: not-allowed;">Hết hàng</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Extra styling for details page -->
<style>
.product-detail-page {
    background: linear-gradient(180deg, var(--bg-obsidian) 0%, #0d111b 50%, var(--bg-obsidian) 100%);
    min-height: 100vh;
}
.product-detail-card {
    background: rgba(15, 19, 28, 0.7) !important;
    backdrop-filter: blur(16px) !important;
    -webkit-backdrop-filter: blur(16px) !important;
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
}
.detail-img-wrapper {
    background: radial-gradient(circle, #ffffff 40%, #e2e8f0 100%) !important;
    border-radius: 16px;
    padding: 30px;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: inset 0 0 20px rgba(0,0,0,0.05);
}
.detail-img-box img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    transition: transform 0.5s ease;
}
.detail-img-wrapper:hover img {
    transform: scale(1.06);
}
.back-link {
    font-size: 13px;
    font-weight: 600;
    transition: color 0.25s ease;
}
.back-link:hover {
    color: var(--accent-gold) !important;
}
.detail-category {
    letter-spacing: 2px;
}
</style>

<script>
// Star Rating interactiveness inside review form
document.addEventListener("DOMContentLoaded", function() {
    const stars = document.querySelectorAll(".rating-star");
    const ratingInput = document.getElementById("review-rating-input");
    const ratingText = document.getElementById("rating-text");

    const texts = {
        1: "1 sao (Rất tệ)",
        2: "2 sao (Tệ)",
        3: "3 sao (Bình thường)",
        4: "4 sao (Tốt)",
        5: "5 sao (Xuất sắc)"
    };

    // Initialize with 5 stars selected
    updateStars(5);

    stars.forEach(star => {
        star.addEventListener("click", function() {
            const val = parseInt(this.getAttribute("data-value"));
            ratingInput.value = val;
            updateStars(val);
        });

        star.addEventListener("mouseenter", function() {
            const val = parseInt(this.getAttribute("data-value"));
            highlightStars(val);
        });
    });

    const starsContainer = document.querySelector(".stars-select");
    if (starsContainer) {
        starsContainer.addEventListener("mouseleave", function() {
            updateStars(parseInt(ratingInput.value));
        });
    }

    function highlightStars(val) {
        stars.forEach(star => {
            const starVal = parseInt(star.getAttribute("data-value"));
            if (starVal <= val) {
                star.className = "fas fa-star rating-star text-warning";
            } else {
                star.className = "far fa-star rating-star";
            }
        });
        if (ratingText) ratingText.textContent = texts[val];
    }

    function updateStars(val) {
        stars.forEach(star => {
            const starVal = parseInt(star.getAttribute("data-value"));
            if (starVal <= val) {
                star.className = "fas fa-star rating-star text-warning";
            } else {
                star.className = "far fa-star rating-star";
            }
        });
        if (ratingText) ratingText.textContent = texts[val];
    }
});

// Quantity control for detail page
function changeDetailQty(delta) {
    const input = document.getElementById('detail-qty-input');
    if (!input) return;
    const max = parseInt(input.max) || 9999;
    let val = parseInt(input.value) || 1;
    val = Math.max(1, Math.min(max, val + delta));
    input.value = val;
}

// Add to cart helper function on detail page — reads qty from input
function addDetailToCart(title, price, img, stock) {
    const qtyInput = document.getElementById('detail-qty-input');
    const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;
    if (typeof window.addToCart === "function") {
        window.addToCart(title, price, img, stock, qty);
    } else {
        if (window.showToast) showToast('Có lỗi xảy ra! Vui lòng tải lại trang.', 'error');
        else alert("Có lỗi xảy ra: Giỏ hàng chưa được tải!");
    }
}

</script>

<?php include("../includes/footer.php"); ?>
