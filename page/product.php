<?php 
$path_prefix = "../"; 
require_once '../includes/db.php';
include("../includes/header.php"); 
?>

<section class="products-page">

<div class="container">
	<h1 class="mb-4">TẤT CẢ SẢN PHẨM</h1>

    <!-- Elegant Collapsible Filter Panel -->
    <div class="advanced-filter-panel mb-5 reveal-element">
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

	<div class="products row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-center reveal-element" id="products-container">

	<?php
	
	try {
	    $stmt = $conn->query("SELECT * FROM products ORDER BY id ASC");
	    $products = $stmt->fetchAll();
	} catch (PDOException $e) {
	    $products = [];
	}

	foreach($products as $i => $p) {
	?>

		<div class="col product-col" data-category="<?php echo htmlspecialchars($p['category']); ?>" data-index="<?php echo $i; ?>">
			<div class="card product-square-card"
                 data-title="<?php echo htmlspecialchars($p['name']); ?>"
                 data-price="<?php echo number_format($p['price'], 0, '', '.'); ?>đ"
                 data-img="../images/<?php echo htmlspecialchars($p['img']); ?>"
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
				<?php if($p['is_sale']) { ?>
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
					<div class="mini-chips">
						<?php 
						if (!empty($p['specs'])) {
							$specs = explode(",", $p['specs']);
							for($j = 0; $j < min(2, count($specs)); $j++) {
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
			<ul class="pagination custom-pagination d-flex justify-content-center align-items-center gap-2 m-0 p-0" id="products-pagination">
		
			</ul>
		</nav>
	</div>

</div>

</section>

<script src="../js/product.js"></script>

<?php include("../includes/footer.php"); ?>