<?php
$path_prefix = "";
include("includes/header.php");
?>

<!-- Premium Split Hero Section -->
<section class="hero">
    <div class="container d-flex flex-column-reverse flex-lg-row align-items-center justify-content-between gap-5 w-100">
        <div class="hero-content text-start col-lg-6 p-0">
            <h1>THẾ GIỚI CÔNG NGHỆ<br><span>ĐẲNG CẤP & SANG TRỌNG</span></h1>
            <p>Trải nghiệm sản phẩm công nghệ cao cấp chính hãng từ các thương hiệu hàng đầu thế giới với chế độ bảo hành đặc quyền Smember.</p>
            <a href="page/product.php" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i> KHÁM PHÁ NGAY
            </a>
        </div>
        <div class="hero-image-container d-flex justify-content-center align-items-center col-lg-5 p-0 position-relative">
            <div class="hero-glow"></div>
            <img src="./images/ip16pm.webp" alt="iPhone 16 Pro Max Premium" class="hero-img-floating">
        </div>
    </div>
</section>

<!-- Premium Categories Section -->
<section class="categories">
    <div class="container">
        <h2>DANH MỤC SẢN PHẨM</h2>
        <div class="categories-grid">
            <div class="category-card" onclick="window.location.href='page/product.php'">
                <i class="fas fa-laptop"></i>
                <h3>LAPTOP</h3>
                <p>Các dòng Laptop cao cấp, cấu hình vượt trội cho doanh nhân & creators.</p>
                <a href="page/product.php" class="link-btn">Xem thêm</a>
            </div>
            <div class="category-card" onclick="window.location.href='page/product.php'">
                <i class="fas fa-mobile-alt"></i>
                <h3>ĐIỆN THOẠI</h3>
                <p>Smartphone flagship mới nhất 2024-2025 với công nghệ AI tiên phong.</p>
                <a href="page/product.php" class="link-btn">Xem thêm</a>
            </div>
            <div class="category-card" onclick="window.location.href='page/product.php'">
                <i class="fas fa-headphones"></i>
                <h3>PHỤ KIỆN</h3>
                <p>Hệ sinh thái phụ kiện âm thanh, sạc nhanh cao cấp chính hãng.</p>
                <a href="page/product.php" class="link-btn">Xem thêm</a>
            </div>
        </div>
    </div>
</section>

<!-- Luxury Sale Section (Promotional Products with Fixed Image Paths) -->
<?php
require_once 'includes/db.php';
try {
    $sale_stmt = $conn->query("SELECT * FROM products WHERE is_sale = 1 LIMIT 3");
    $sale_products = $sale_stmt->fetchAll();
} catch (PDOException $e) {
    $sale_products = [];
}
?>
<section class="sale-section">
    <div class="container">
        <h2>🔥 SẢN PHẨM KHUYẾN MÃI ĐẶC BIỆT</h2>
        <div class="products-grid">
            <?php foreach ($sale_products as $p) {
                $disc_pct = 20; // Default discount percentage display
                $original_price = $p['price'] / (1 - $disc_pct / 100);
            ?>
                <div class="sale-card"
                    data-title="<?php echo htmlspecialchars($p['name']); ?>"
                    data-price="<?php echo number_format($p['price'], 0, '', '.'); ?>đ"
                    data-img="./images/<?php echo htmlspecialchars($p['img']); ?>"
                    data-specs="<?php echo htmlspecialchars($p['specs'] ?? ''); ?>"
                    data-category="<?php echo htmlspecialchars($p['category']); ?>"
                    data-stock="<?php echo $p['stock']; ?>">
                    <div class="sale-badge">-<?php echo $disc_pct; ?>%</div>
                    <img src="./images/<?php echo htmlspecialchars($p['img']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
                    <div>
                        <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                        <p class="original-price"><del><?php echo number_format($original_price, 0, '', '.'); ?>đ</del></p>
                        <p class="sale-price"><?php echo number_format($p['price'], 0, '', '.'); ?>đ</p>
                        <p class="product-stock small text-secondary m-0 mb-2" style="font-size: 11px;">
                            <?php if ($p['stock'] > 0) { ?>
                                Còn lại: <strong class="text-success"><?php echo $p['stock']; ?></strong> sản phẩm
                            <?php } else { ?>
                                <strong class="text-danger"><i class="fas fa-exclamation-triangle"></i> Hết hàng</strong>
                            <?php } ?>
                        </p>
                    </div>
                    <?php if ($p['stock'] > 0) { ?>
                        <button class="btn-buy">Thêm vào giỏ</button>
                    <?php } else { ?>
                        <button class="btn-buy disabled" disabled style="background: rgba(255,255,255,0.05); color: #555; border: 1px solid rgba(255,255,255,0.05); cursor: not-allowed;">Hết hàng</button>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Premium Featured Section -->
<section class="featured py-5">
    <div class="container">
        <h2 class="featured-title text-center mb-4">SẢN PHẨM NỔI BẬT</h2>

        <!-- Elegant Collapsible Filter Panel -->
        <div class="advanced-filter-panel mb-5">
            <div class="filter-panel-header d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">
                <!-- Search Name (Always visible) -->
                <div class="search-main-wrapper flex-grow-1">
                    <label class="filter-label">Tìm kiếm theo tên</label>
                    <div class="search-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="filter-search-text" class="form-control" placeholder="Nhập tên sản phẩm cần tìm...">
                    </div>
                </div>

                <!-- Action Buttons (Always visible) -->
                <div class="filter-actions-wrapper d-flex align-items-end gap-2 pt-2 pt-md-0">
                    <button type="button" class="btn-toggle-filters" id="btn-toggle-advanced" title="Mở bộ lọc nâng cao">
                        <i class="fas fa-sliders-h"></i> Bộ lọc nâng cao
                    </button>
                    <button type="button" class="btn-clear-filters-page" id="page-clear-btn" title="Đặt lại bộ lọc">
                        <i class="fas fa-undo"></i> Đặt lại
                    </button>
                </div>
            </div>

            <!-- Collapsible Filters Content -->
            <div class="filter-panel-collapse" id="advanced-filter-collapse">
                <div class="row g-4">
                    <!-- Category Chips -->
                    <div class="col-12 col-lg-6">
                        <div class="filter-group">
                            <label class="filter-label">Danh mục sản phẩm</label>
                            <div class="filter-chips" id="page-category-chips">
                                <span class="filter-chip active" data-value="all">Tất cả</span>
                                <?php
                                try {
                                    $cat_query = $conn->query("SELECT * FROM categories ORDER BY id ASC");
                                    $db_cats = $cat_query->fetchAll();
                                } catch (PDOException $ex) {
                                    $db_cats = [
                                        ['name' => 'laptop', 'display_name' => 'Laptop'],
                                        ['name' => 'phone', 'display_name' => 'Điện thoại'],
                                        ['name' => 'accessory', 'display_name' => 'Phụ kiện']
                                    ];
                                }
                                foreach ($db_cats as $cat) {
                                ?>
                                    <span class="filter-chip" data-value="<?php echo htmlspecialchars($cat['name']); ?>"><?php echo htmlspecialchars($cat['display_name']); ?></span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Brand Chips -->
                    <div class="col-12 col-lg-6">
                        <div class="filter-group">
                            <label class="filter-label">Thương hiệu</label>
                            <div class="filter-chips" id="page-brand-chips">
                                <span class="filter-chip active" data-value="all">Tất cả thương hiệu</span>
                                <span class="filter-chip" data-value="apple">Apple</span>
                                <span class="filter-chip" data-value="samsung">Samsung</span>
                                <span class="filter-chip" data-value="dell">Dell</span>
                                <span class="filter-chip" data-value="asus">Asus</span>
                                <span class="filter-chip" data-value="sony">Sony</span>
                                <span class="filter-chip" data-value="xiaomi">Xiaomi</span>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdowns Row -->
                    <div class="col-12">
                        <div class="row g-3">
                            <!-- Price Range -->
                            <div class="col-12 col-md-6">
                                <div class="filter-group">
                                    <label class="filter-label" for="filter-price-range">Khoảng giá</label>
                                    <select id="filter-price-range" class="form-select">
                                        <option value="all">Tất cả các giá</option>
                                        <option value="under10">Dưới 10 triệu</option>
                                        <option value="10to25">Từ 10tr - 25 triệu</option>
                                        <option value="25to45">Từ 25tr - 45 triệu</option>
                                        <option value="above45">Trên 45 triệu</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Price Sort -->
                            <div class="col-12 col-md-6">
                                <div class="filter-group">
                                    <label class="filter-label" for="filter-price-sort">Sắp xếp giá</label>
                                    <select id="filter-price-sort" class="form-select">
                                        <option value="none">Mặc định</option>
                                        <option value="asc">Giá thấp đến cao</option>
                                        <option value="desc">Giá cao đến thấp</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="products row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-center" id="featured-products-container">

            <?php
            try {
                $stmt = $conn->query("SELECT * FROM products ORDER BY id ASC");
                $db_products = $stmt->fetchAll();
            } catch (PDOException $e) {
                $db_products = [];
            }
            foreach ($db_products as $i => $p) {
            ?>
                <div class="col product-col" data-category="<?php echo htmlspecialchars($p['category']); ?>">
                    <div class="card product-square-card"
                        data-title="<?php echo htmlspecialchars($p['name']); ?>"
                        data-price="<?php echo number_format($p['price'], 0, '', '.'); ?>đ"
                        data-img="./images/<?php echo htmlspecialchars($p['img']); ?>"
                        data-specs="<?php echo htmlspecialchars($p['specs'] ?? ''); ?>"
                        data-category="<?php echo htmlspecialchars($p['category']); ?>"
                        data-stock="<?php echo $p['stock']; ?>"
                        data-brand="<?php
                                    $title_lower = strtolower($p['name']);
                                    if (strpos($title_lower, 'macbook') !== false || strpos($title_lower, 'iphone') !== false || strpos($title_lower, 'airpod') !== false) echo 'apple';
                                    elseif (strpos($title_lower, 'samsung') !== false || strpos($title_lower, 'galaxy') !== false || strpos($title_lower, 'buds') !== false) echo 'samsung';
                                    elseif (strpos($title_lower, 'dell') !== false) echo 'dell';
                                    elseif (strpos($title_lower, 'asus') !== false || strpos($title_lower, 'rog') !== false) echo 'asus';
                                    elseif (strpos($title_lower, 'sony') !== false) echo 'sony';
                                    elseif (strpos($title_lower, 'xiaomi') !== false) echo 'xiaomi';
                                    else echo 'other';
                                    ?>">
                        <div class="img-square-box">
                            <img src="./images/<?php echo htmlspecialchars($p['img']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
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
                            <div class="mini-chips">
                                <?php
                                if (!empty($p['specs'])) {
                                    $specs = explode(",", $p['specs']);
                                    for ($j = 0; $j < min(2, count($specs)); $j++) {
                                        echo '<span class="m-chip">' . trim(htmlspecialchars($specs[$j])) . '</span>';
                                    }
                                }
                                ?>
                            </div>
                            <div class="square-rating mt-2">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="square-action">
                            <?php if ($p['stock'] > 0) { ?>
                                <button class="btn-square-buy">Thêm vào giỏ</button>
                            <?php } else { ?>
                                <button class="btn-square-buy disabled" disabled style="background: rgba(255,255,255,0.05); color: #555; border: 1px solid rgba(255,255,255,0.05); cursor: not-allowed;">Hết hàng</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="pagination-container d-flex justify-content-center mt-5 w-100">
            <nav aria-label="Page navigation">
                <ul class="pagination custom-pagination d-flex justify-content-center align-items-center gap-2 m-0 p-0" id="featured-pagination">
                </ul>
            </nav>
        </div>
    </div>
</section>

<!-- Luxury Benefits Section -->
<section class="why-choose-us">
    <div class="container">
        <h2>ĐẶC QUYỀN KHI CHỌN TECHLUXURY</h2>
        <div class="benefits-grid">
            <div class="benefit-item">
                <i class="fas fa-shipping-fast"></i>
                <h3>Giao Hàng Siêu Tốc</h3>
                <p>Miễn phí giao hàng nội thành trong vòng 2 giờ cho tất cả đơn hàng Smember.</p>
            </div>
            <div class="benefit-item">
                <i class="fas fa-shield-alt"></i>
                <h3>Bảo Hành Đặc Quyền</h3>
                <p>Bảo hành VIP 1 đổi 1 trong vòng 30 ngày nếu phát sinh lỗi phần cứng từ nhà sản xuất.</p>
            </div>
            <div class="benefit-item">
                <i class="fas fa-sync-alt"></i>
                <h3>Đổi Trả Trọn Đời</h3>
                <p>Hỗ trợ thu cũ đổi mới lên đời sản phẩm công nghệ với trợ giá tối đa đến 95% giá trị.</p>
            </div>
            <div class="benefit-item">
                <i class="fas fa-headset"></i>
                <h3>Hỗ Trợ 24/7</h3>
                <p>Đội ngũ chuyên viên tư vấn kỹ thuật cao cấp hỗ trợ riêng biệt cho khách hàng VIP.</p>
            </div>
        </div>
    </div>
</section>

<?php include("includes/footer.php"); ?>

<script>
    function filterProducts(category, button) {
        const cols = document.querySelectorAll('.product-col');
        const buttons = document.querySelectorAll('.tab-btn');

        // Update active button state
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // Filter and show/hide the column wrappers using Bootstrap's d-none
        cols.forEach(col => {
            const colCategory = col.getAttribute('data-category');
            if (category === 'all' || colCategory === category) {
                col.classList.remove('d-none');
            } else {
                col.classList.add('d-none');
            }
        });
    }
    let currentPage = 1;
    const productsPerPage = 8; // Quy định cứng: hiển thị tối đa 8 sản phẩm trên 1 trang

    function renderPagination() {
        const activeChip = document.querySelector('#page-category-chips .filter-chip.active');
        const activeCategory = activeChip ? activeChip.getAttribute('data-value') : 'all';
        const allCols = Array.from(document.querySelectorAll('.product-col'));

        const filteredCols = allCols.filter(col => {
            const cat = col.getAttribute('data-category');
            return activeCategory === 'all' || cat === activeCategory;
        });

        const totalProducts = filteredCols.length;
        const totalPages = Math.ceil(totalProducts / productsPerPage);

        const paginationWrapper = document.querySelector('.pagination-container');
        const paginationUl = document.getElementById('featured-pagination');
        if (!paginationUl) return;

        paginationUl.innerHTML = "";

        if (totalPages <= 1) {
            paginationWrapper.style.setProperty('display', 'none', 'important');
        } else {
            paginationWrapper.style.setProperty('display', 'flex', 'important');
        }

        allCols.forEach(col => col.style.setProperty('display', 'none', 'important'));

        // Ensure currentPage is within bounds
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        filteredCols.forEach((col, index) => {
            const startIndex = (currentPage - 1) * productsPerPage;
            const endIndex = startIndex + productsPerPage;

            if (index >= startIndex && index < endIndex) {
                col.style.setProperty('display', 'block', 'important');
            }
        });

        if (totalPages > 1) {
            // Nút "Trước"
            const prevLi = document.createElement("li");
            prevLi.className = "page-item" + (currentPage === 1 ? " disabled" : "");
            prevLi.innerHTML = `<a class="page-link" href="javascript:void(0)" onclick="changePage(-1)"><i class="fas fa-chevron-left"></i></a>`;
            paginationUl.appendChild(prevLi);

            // Các nút số trang
            for (let page = 1; page <= totalPages; page++) {
                const li = document.createElement("li");
                li.className = "page-item" + (page === currentPage ? " active" : "");
                li.innerHTML = `<a class="page-link" href="javascript:void(0)" onclick="goToPage(${page})">${page}</a>`;
                paginationUl.appendChild(li);
            }

            // Nút "Sau"
            const nextLi = document.createElement("li");
            nextLi.className = "page-item" + (currentPage === totalPages ? " disabled" : "");
            nextLi.innerHTML = `<a class="page-link" href="javascript:void(0)" onclick="changePage(1)"><i class="fas fa-chevron-right"></i></a>`;
            paginationUl.appendChild(nextLi);
        }
    }

    function goToPage(page) {
        currentPage = page;
        renderPagination();
        document.querySelector('.featured').scrollIntoView({
            behavior: 'smooth'
        });
    }

    function changePage(direction) {
        const activeChip = document.querySelector('#page-category-chips .filter-chip.active');
        const activeCategory = activeChip ? activeChip.getAttribute('data-value') : 'all';
        const allCols = Array.from(document.querySelectorAll('.product-col'));
        const filteredCols = allCols.filter(col => {
            const cat = col.getAttribute('data-category');
            return activeCategory === 'all' || cat === activeCategory;
        });
        const totalPages = Math.ceil(filteredCols.length / productsPerPage);

        currentPage += direction;
        if (currentPage < 1) currentPage = 1;
        if (currentPage > totalPages) currentPage = totalPages;
        goToPage(currentPage);
    }

    document.addEventListener("DOMContentLoaded", function() {
        renderPagination();

        window.filterProducts = function(category, button) {
            currentPage = 1;
            if (typeof applyAdvancedFilters === "function") {
                applyAdvancedFilters();
            } else {
                renderPagination();
            }
        }
    });
</script>