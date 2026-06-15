<?php 
$path_prefix = "../"; 
include("../includes/header.php"); 
?>

<section class="products-page">

<div class="container">
	<h1 class="mb-4">TẤT CẢ SẢN PHẨM</h1>

    <!-- Advanced Filter Panel -->
    <div class="advanced-filter-panel">
        <div class="row g-3 align-items-center">
            <!-- Search Filter -->
            <div class="col-12 col-md-3">
                <div class="filter-box-sub">
                    <label for="filter-search-text" class="form-label text-secondary small m-0 fw-bold">TÌM KIẾM THEO TÊN</label>
                    <div class="search-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="filter-search-text" class="form-control" placeholder="Tên sản phẩm...">
                    </div>
                </div>
            </div>
            <!-- Category Filter -->
            <div class="col-6 col-md-2">
                <div class="filter-box-sub">
                    <label for="filter-category" class="form-label text-secondary small m-0 fw-bold">DANH MỤC</label>
                    <select id="filter-category" class="form-select">
                        <option value="all">Tất cả danh mục</option>
                        <option value="laptop">Laptop</option>
                        <option value="phone">Điện thoại</option>
                        <option value="accessory">Phụ kiện</option>
                    </select>
                </div>
            </div>
            <!-- Brand Filter -->
            <div class="col-6 col-md-2">
                <div class="filter-box-sub">
                    <label for="filter-brand" class="form-label text-secondary small m-0 fw-bold">THƯƠNG HIỆU</label>
                    <select id="filter-brand" class="form-select">
                        <option value="all">Tất cả thương hiệu</option>
                        <option value="apple">Apple</option>
                        <option value="samsung">Samsung</option>
                        <option value="dell">Dell</option>
                        <option value="asus">Asus</option>
                        <option value="sony">Sony</option>
                        <option value="xiaomi">Xiaomi</option>
                    </select>
                </div>
            </div>
            <!-- Price Range Filter -->
            <div class="col-6 col-md-3">
                <div class="filter-box-sub">
                    <label for="filter-price-range" class="form-label text-secondary small m-0 fw-bold">KHOẢNG GIÁ</label>
                    <select id="filter-price-range" class="form-select">
                        <option value="all">Tất cả các giá</option>
                        <option value="under10">Dưới 10 triệu</option>
                        <option value="10to25">Từ 10tr - 25 triệu</option>
                        <option value="25to45">Từ 25tr - 45 triệu</option>
                        <option value="above45">Trên 45 triệu</option>
                    </select>
                </div>
            </div>
            <!-- Price Sort Filter -->
            <div class="col-6 col-md-2">
                <div class="filter-box-sub">
                    <label for="filter-price-sort" class="form-label text-secondary small m-0 fw-bold">SẮP XẾP GIÁ</label>
                    <select id="filter-price-sort" class="form-select">
                        <option value="none">Mặc định</option>
                        <option value="asc">Giá thấp đến cao</option>
                        <option value="desc">Giá cao đến thấp</option>
                    </select>
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