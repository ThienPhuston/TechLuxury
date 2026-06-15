<?php 
$path_prefix = "../"; 
include("../includes/header.php"); 
?>

<section class="products-page">

<div class="container">
	<h1 class="mb-4">TẤT CẢ SẢN PHẨM</h1>

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
                            <span class="filter-chip" data-value="laptop">Laptop</span>
                            <span class="filter-chip" data-value="phone">Điện thoại</span>
                            <span class="filter-chip" data-value="accessory">Phụ kiện</span>
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

	<div class="products row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-center" id="products-container">

	<?php

	$products = [
		["Macbook Pro M4", "59990000", "laptop", true, "macbook-pro-14-inch-m4-pro-24gb-1tb-20gpu-bac-1-639104240462766154-750x500.jpg", "Chip Apple M4, RAM 16G, SSD 512G, Màn Liquid Retina"],
		["Dell XPS 15", "45990000", "laptop", false, "DELL.webp", "Intel Core i7, RAM 16G, SSD 512G, Màn OLED Touch"],
		["iPhone 16 Pro Max", "35990000", "phone", true, "ip16pm.webp", "Chip A18 Pro, Camera 48MP Zoom 5x, Khung Titanium"],
		["Samsung S24 Ultra", "31990000", "phone", false, "Galaxy s24ultra.webp", "Snapdragon 8 Gen 3, Camera 200MP, Bút S-Pen, Galaxy AI"],
		["AirPods Pro Max", "12990000", "accessory", true, "AIRPOD.webp", "ANC Đỉnh cao, Âm thanh Spatial, Pin 20H, Bao da Smart"],
		["Galaxy Buds 3", "5990000", "accessory", false, "Galaxy bud3.webp", "Chống nước IPX7, Bluetooth 5.3, Âm bass ấm, Galaxy AI"],
		["iPhone 16 Standard", "22990000", "phone", false, "ip16standard.webp", "Chip A18 Bionic, Camera 48MP, Dynamic Island, 128GB"],
		["ASUS ROG Strix G16", "38490000", "laptop", false, "ASUS ROG.webp", "Nvidia RTX 4060, Intel i7-13650HX, RAM 16G, Màn 165Hz"],
		["Xiaomi 14 Ultra Leica", "26990000", "phone", true, "XIAOMI.webp", "Ống kính Leica, Snapdragon 8 Gen 3, Sạc nhanh 90W, 50MP"],
		["Sony WH-1000XM5", "6850000", "accessory", false, "sony.webp", "Chống ồn ANC Best, Pin bền 30H, Hi-Res Audio, Bluetooth 5.2"]
	];

	foreach($products as $i => $p) {
	?>

		<div class="col product-col" data-category="<?php echo $p[2]; ?>" data-index="<?php echo $i; ?>">
			<div class="card product-square-card"
                 data-title="<?php echo htmlspecialchars($p[0]); ?>"
                 data-price="<?php echo number_format($p[1], 0, '', '.'); ?>đ"
                 data-img="../images/<?php echo $p[4]; ?>"
                 data-specs="<?php echo htmlspecialchars($p[5]); ?>"
                 data-category="<?php echo $p[2]; ?>"
                 data-brand="<?php
                      $title_lower = strtolower($p[0]);
                      if (strpos($title_lower, 'macbook') !== false || strpos($title_lower, 'iphone') !== false || strpos($title_lower, 'airpod') !== false) echo 'apple';
                      elseif (strpos($title_lower, 'samsung') !== false || strpos($title_lower, 'galaxy') !== false || strpos($title_lower, 'buds') !== false) echo 'samsung';
                      elseif (strpos($title_lower, 'dell') !== false) echo 'dell';
                      elseif (strpos($title_lower, 'asus') !== false || strpos($title_lower, 'rog') !== false) echo 'asus';
                      elseif (strpos($title_lower, 'sony') !== false) echo 'sony';
                      elseif (strpos($title_lower, 'xiaomi') !== false) echo 'xiaomi';
                      else echo 'other';
                  ?>">
				<?php if($p[3]) { ?>
					<div class="sale-badge">-20%</div>
				<?php } ?>
				<div class="img-square-box">
					<img src="../images/<?php echo $p[4]; ?>" alt="<?php echo htmlspecialchars($p[0]); ?>">
				</div>
				<div class="card-square-body">
					<h3><?php echo $p[0]; ?></h3>
					<p class="product-price"><?php echo number_format($p[1], 0, '', '.'); ?>đ</p>
					<div class="mini-chips">
						<?php 
						$specs = explode(",", $p[5]);
						for($j = 0; $j < min(2, count($specs)); $j++) {
							echo '<span class="m-chip">' . trim($specs[$j]) . '</span>';
						}
						?>
					</div>
					<div class="square-rating">
						<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
					</div>
				</div>
				<div class="square-action">
					<button class="btn-square-buy">Thêm vào giỏ</button>
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