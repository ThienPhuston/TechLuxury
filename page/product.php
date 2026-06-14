<?php include("../includes/header.php"); ?>

<section class="products-page">

<div class="container">
	<h1 class="mb-4">TẤT CẢ SẢN PHẨM</h1>

	<div class="products row g-3" id="products-container">

	<?php

	$products = [
		["Macbook Pro M4","59990000","laptop",true, "macbook-pro-14-inch-m4-pro-24gb-1tb-20gpu-bac-1-639104240462766154-750x500.jpg"],
		["Dell XPS 15","45990000","laptop",false, "DELL.webp"],
		["iPhone 16 Pro Max","35990000","phone",true, "iphone"],
		["Samsung S24 Ultra","31990000","phone",false, "samsung"],
		["AirPods Pro 3","6190000","accessory",true, "airpods"],
		["Apple Watch Ultra","18990000","accessory",false, "applewatch"],
		["DJI Osmo","10920000","accessory",false, "dji"],
		["Gaming Router AX300","789000","accessory",true, "gaming"],
		["EarPods Lightning","500000","accessory",false, "earpods"],
		["Galaxy Buds 3","599000","accessory",false, "galaxy"],
		["ThinkPad X1","42990000","laptop",false, "thinkpad"],
		["iPad Pro","17990000","tablet",true, "ipad"]
	];

	foreach($products as $i => $p) {
	?>

		<div class="col-6 col-md-3 product-col" data-category="<?php echo $p[2]; ?>" data-index="<?php echo $i; ?>">
			<div class="card h-100 position-relative">
				<?php if($p[3]) { ?>
					<div class="sale-badge">Giảm 19%</div>
				<?php } ?>
				<img src="../images/macbook.jpg" alt="<?php echo htmlspecialchars($p[0]); ?>">
				<div>
					<h3 class="mt-2 mb-1"><?php echo $p[0]; ?></h3>
					<div class="price-row mb-2">
						<span class="price"><?php echo number_format($p[1]); ?>đ</span>
						<span class="original-price ms-2"><?php echo number_format(intval($p[1]*1.2)); ?>đ</span>
					</div>
					<div class="chips mb-2">
						<span class="chip">Smember giảm đến 60.000đ</span>
						<span class="chip">Trả góp 0%</span>
					</div>
				</div>

				<div class="card-footer d-flex justify-content-between align-items-center pt-2 border-0 bg-transparent">
					<div class="rating small"><i class="fas fa-star"></i> 4.9</div>
					<div class="fav"><i class="far fa-heart"></i></div>
				</div>
			</div>
		</div>

	<?php } ?>

	</div>

	<div class="pagination-container d-flex justify-content-center mt-4 w-100">
		<nav aria-label="Page navigation">
			<ul class="pagination custom-pagination d-flex justify-content-center align-items-center gap-2 m-0 p-0" id="products-pagination">
		
			</ul>
		</nav>
	</div>

</div>

</section>

<script src="../js/product.js"></script>

<?php include("../includes/footer.php"); ?>