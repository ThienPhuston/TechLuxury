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
<section class="sale-section">
    <div class="container">
        <h2>🔥 SẢN PHẨM KHUYẾN MÃI ĐẶC BIỆT</h2>
        <div class="products-grid">
            <!-- Card 1: Macbook Pro M4 -->
            <div class="sale-card" 
                 data-title="Macbook Pro M4" 
                 data-price="59.990.000đ" 
                 data-img="./images/macbook-pro-14-inch-m4-pro-24gb-1tb-20gpu-bac-1-639104240462766154-750x500.jpg" 
                 data-specs="Chip Apple M4, RAM 16GB, SSD 512GB, Màn hình Liquid Retina XDR 14 inch" 
                 data-category="laptop">
                <div class="sale-badge">-15%</div>
                <img src="./images/macbook-pro-14-inch-m4-pro-24gb-1tb-20gpu-bac-1-639104240462766154-750x500.jpg" alt="Macbook Pro M4">
                <div>
                    <h3>Macbook Pro M4</h3>
                    <p class="original-price"><del>70.990.000đ</del></p>
                    <p class="sale-price">59.990.000đ</p>
                </div>
                <button class="btn-buy">Thêm vào giỏ</button>
            </div>

            <!-- Card 2: iPhone 16 Pro Max -->
            <div class="sale-card" 
                 data-title="iPhone 16 Pro Max" 
                 data-price="35.990.000đ" 
                 data-img="./images/ip16pm.webp" 
                 data-specs="Chip A18 Pro AI, RAM 8GB, Bộ nhớ 256GB, Camera 48MP Zoom 5x" 
                 data-category="phone">
                <div class="sale-badge">-20%</div>
                <img src="./images/ip16pm.webp" alt="iPhone 16 Pro Max">
                <div>
                    <h3>iPhone 16 Pro Max</h3>
                    <p class="original-price"><del>44.990.000đ</del></p>
                    <p class="sale-price">35.990.000đ</p>
                </div>
                <button class="btn-buy">Thêm vào giỏ</button>
            </div>

            <!-- Card 3: Galaxy S24 Ultra -->
            <div class="sale-card" 
                 data-title="Galaxy S24 Ultra" 
                 data-price="31.990.000đ" 
                 data-img="./images/Galaxy s24ultra.webp" 
                 data-specs="Chip Snapdragon 8 Gen 3, Camera 200MP AI, Bút S-Pen tích hợp, Titanium Frame" 
                 data-category="phone">
                <div class="sale-badge">-25%</div>
                <img src="./images/Galaxy s24ultra.webp" alt="Galaxy S24 Ultra">
                <div>
                    <h3>Galaxy S24 Ultra</h3>
                    <p class="original-price"><del>42.990.000đ</del></p>
                    <p class="sale-price">31.990.000đ</p>
                </div>
                <button class="btn-buy">Thêm vào giỏ</button>
            </div>
        </div>
    </div>
</section>

<!-- Premium Featured Section -->
<section class="featured py-5">
    <div class="container">
        <h2 class="featured-title text-center mb-4">SẢN PHẨM NỔI BẬT</h2>

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

        <div class="featured-tabs d-flex justify-content-center gap-2 mb-4">
            <button class="tab-btn active" onclick="filterProducts('all', this)">Tất cả</button>
            <button class="tab-btn" onclick="filterProducts('laptop', this)">Laptop</button>
            <button class="tab-btn" onclick="filterProducts('phone', this)">Điện thoại</button>
            <button class="tab-btn" onclick="filterProducts('accessory', this)">Phụ kiện</button>
        </div>

        <div class="products row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-center" id="featured-products-container">
            
            <!-- Product 1 -->
            <div class="col product-col" data-category="laptop">
                <div class="card product-square-card"
                     data-title="Macbook Pro M4" 
                     data-price="59.990.000đ" 
                     data-img="./images/macbook-pro-14-inch-m4-pro-24gb-1tb-20gpu-bac-1-639104240462766154-750x500.jpg" 
                     data-specs="Chip Apple M4, RAM 16G, SSD 512G, Màn hình Liquid Retina XDR" 
                     data-category="laptop">
                    <div class="img-square-box">
                        <img src="./images/macbook-pro-14-inch-m4-pro-24gb-1tb-20gpu-bac-1-639104240462766154-750x500.jpg" alt="Macbook Pro M4">
                    </div>
                    <div class="card-square-body">
                        <h3>Macbook Pro M4</h3>
                        <p class="product-price">59.990.000đ</p>
                        <div class="mini-chips">
                            <span class="m-chip">RAM 16G</span>
                            <span class="m-chip">SSD 512G</span>
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

            <!-- Product 2 -->
            <div class="col product-col" data-category="phone">
                <div class="card product-square-card"
                     data-title="iPhone 16 Pro Max" 
                     data-price="35.990.000đ" 
                     data-img="./images/ip16pm.webp" 
                     data-specs="Chip A18 Pro, Camera 48MP Zoom 5x, Titanium Thiết kế, Apple Intelligence" 
                     data-category="phone">
                    <div class="img-square-box">
                        <img src="./images/ip16pm.webp" alt="iPhone 16 Pro Max">
                    </div>
                    <div class="card-square-body">
                        <h3>iPhone 16 Pro Max</h3>
                        <p class="product-price">35.990.000đ</p>
                        <div class="mini-chips">
                            <span class="m-chip">48MP</span>
                            <span class="m-chip">A18 Pro</span>
                        </div>
                        <div class="square-rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <div class="square-action">
                        <button class="btn-square-buy">Thêm vào giỏ</button>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="col product-col" data-category="phone">
                <div class="card product-square-card"
                     data-title="Galaxy S24 Ultra" 
                     data-price="31.990.000đ" 
                     data-img="./images/Galaxy s24ultra.webp" 
                     data-specs="Chip Snapdragon 8 Gen 3, Camera 200MP, Bút S-Pen, Galaxy AI dịch thuật" 
                     data-category="phone">
                    <div class="img-square-box">
                        <img src="./images/Galaxy s24ultra.webp" alt="Galaxy S24 Ultra">
                    </div>
                    <div class="card-square-body">
                        <h3>Galaxy S24 Ultra</h3>
                        <p class="product-price">31.990.000đ</p>
                        <div class="mini-chips">
                            <span class="m-chip">200MP</span>
                            <span class="m-chip">Snap 8G3</span>
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

            <!-- Product 4 -->
            <div class="col product-col" data-category="laptop">
                <div class="card product-square-card"
                     data-title="Dell XPS 15" 
                     data-price="49.990.000đ" 
                     data-img="./images/DELL.webp" 
                     data-specs="Core i7 Thế hệ 13, RAM 32GB, SSD 1TB, Màn hình OLED Cảm ứng" 
                     data-category="laptop">
                    <div class="img-square-box">
                        <img src="./images/DELL.webp" alt="Dell XPS 15">
                    </div>
                    <div class="card-square-body">
                        <h3>Dell XPS 15</h3>
                        <p class="product-price">49.990.000đ</p>
                        <div class="mini-chips">
                            <span class="m-chip">RAM 32G</span>
                            <span class="m-chip">OLED Touch</span>
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

            <!-- Product 5 -->
            <div class="col product-col" data-category="accessory">
                <div class="card product-square-card"
                     data-title="AirPods Pro Max" 
                     data-price="12.990.000đ" 
                     data-img="./images/AIRPOD.webp" 
                     data-specs="Chống ồn ANC vượt trội, Âm thanh vòm Spatial, Pin dùng 20 giờ" 
                     data-category="accessory">
                    <div class="img-square-box">
                        <img src="./images/AIRPOD.webp" alt="AirPods Pro Max">
                    </div>
                    <div class="card-square-body">
                        <h3>AirPods Pro Max</h3>
                        <p class="product-price">12.990.000đ</p>
                        <div class="mini-chips">
                            <span class="m-chip">ANC Đỉnh</span>
                            <span class="m-chip">Spatial</span>
                        </div>
                        <div class="square-rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <div class="square-action">
                        <button class="btn-square-buy">Thêm vào giỏ</button>
                    </div>
                </div>
            </div>

            <!-- Product 6 -->
            <div class="col product-col" data-category="accessory">
                <div class="card product-square-card"
                     data-title="Galaxy Buds 3" 
                     data-price="5.990.000đ" 
                     data-img="./images/Galaxy bud3.webp" 
                     data-specs="Thiết kế hạt đậu thời trang, Chống nước IPX7, Âm bass sâu ấm áp" 
                     data-category="accessory">
                    <div class="img-square-box">
                        <img src="./images/Galaxy bud3.webp" alt="Galaxy Buds 3">
                    </div>
                    <div class="card-square-body">
                        <h3>Galaxy Buds 3</h3>
                        <p class="product-price">5.990.000đ</p>
                        <div class="mini-chips">
                            <span class="m-chip">Bass Ấm</span>
                            <span class="m-chip">IPX7</span>
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

            <!-- Product 7 -->
            <div class="col product-col" data-category="phone">
                <div class="card product-square-card"
                     data-title="iPhone 16 Standard" 
                     data-price="22.990.000đ" 
                     data-img="./images/ip16standard.webp" 
                     data-specs="Chip A18 Bionic, Bộ nhớ 128GB, Camera góc siêu rộng, Nút Camera Control" 
                     data-category="phone">
                    <div class="img-square-box">
                        <img src="./images/ip16standard.webp" alt="iPhone 16">
                    </div>
                    <div class="card-square-body">
                        <h3>iPhone 16 Standard</h3>
                        <p class="product-price">22.990.000đ</p>
                        <div class="mini-chips">
                            <span class="m-chip">128GB</span>
                            <span class="m-chip">A18 Bionic</span>
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

            <!-- Product 8 -->
            <div class="col product-col" data-category="laptop">
                <div class="card product-square-card"
                     data-title="ASUS ROG Strix G16" 
                     data-price="38.490.000đ" 
                     data-img="./images/ASUS ROG.webp" 
                     data-specs="Card đồ họa RTX 4060, Chip Intel i7-13650HX, Màn hình 165Hz chuyên game" 
                     data-category="laptop">
                    <div class="img-square-box">
                        <img src="./images/ASUS ROG.webp" alt="ASUS ROG Strix">
                    </div>
                    <div class="card-square-body">
                        <h3>ASUS ROG Strix G16</h3>
                        <p class="product-price">38.490.000đ</p>
                        <div class="mini-chips">
                            <span class="m-chip">RTX 4060</span>
                            <span class="m-chip">i7-13650HX</span>
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

            <!-- Product 9 -->
            <div class="col product-col" data-category="phone">
                <div class="card product-square-card"
                     data-title="Xiaomi 14 Ultra Leica" 
                     data-price="26.990.000đ" 
                     data-img="./images/XIAOMI.webp" 
                     data-specs="Ống kính chuyên nghiệp Leica, Snapdragon 8 Gen 3, Sạc siêu tốc 90W" 
                     data-category="phone">
                    <div class="img-square-box">
                        <img src="./images/XIAOMI.webp" alt="Xiaomi 14 Ultra">
                    </div>
                    <div class="card-square-body">
                        <h3>Xiaomi 14 Ultra Leica</h3>
                        <p class="product-price">26.990.000đ</p>
                        <div class="mini-chips">
                            <span class="m-chip">Leica Cam</span>
                            <span class="m-chip">Snap 8G3</span>
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

            <!-- Product 10 -->
            <div class="col product-col" data-category="accessory">
                <div class="card product-square-card"
                     data-title="Sony WH-1000XM5" 
                     data-price="6.850.000đ" 
                     data-img="./images/sony.webp" 
                     data-specs="Bộ xử lý chống ồn kép V1, Pin bền bỉ 30 giờ, Cuộc gọi siêu nét" 
                     data-category="accessory">
                    <div class="img-square-box">
                        <img src="./images/sony.webp" alt="Sony WH-1000XM5">
                    </div>
                    <div class="card-square-body">
                        <h3>Sony WH-1000XM5</h3>
                        <p class="product-price">6.850.000đ</p>
                        <div class="mini-chips">
                            <span class="m-chip">ANC Best</span>
                            <span class="m-chip">30H Pin</span>
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

        </div>

        <div class="pagination-container d-flex justify-content-center mt-5 w-100">
            <nav aria-label="Page navigation">
                <ul class="pagination custom-pagination d-flex justify-content-center align-items-center gap-2 m-0 p-0">
                    <li class="page-item disabled" id="prev-page-btn">
                        <a class="page-link" href="javascript:void(0)" onclick="changePage(-1)"><i class="fas fa-chevron-left"></i></a>
                    </li>
                    <li class="page-item active" id="page-1-btn">
                        <a class="page-link" href="javascript:void(0)" onclick="goToPage(1)">1</a>
                    </li>
                    <li class="page-item" id="page-2-btn">
                        <a class="page-link" href="javascript:void(0)" onclick="goToPage(2)">2</a>
                    </li>
                    <li class="page-item" id="next-page-btn">
                        <a class="page-link" href="javascript:void(0)" onclick="changePage(1)"><i class="fas fa-chevron-right"></i></a>
                    </li>
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
    const activeTab = document.querySelector('.tab-btn.active');
    const activeCategory = activeTab.getAttribute('onclick').match(/'([^']+)'/)[1];
    const allCols = Array.from(document.querySelectorAll('.product-col'));
    
    const filteredCols = allCols.filter(col => {
        const cat = col.getAttribute('data-category');
        return activeCategory === 'all' || cat === activeCategory;
    });

    const totalProducts = filteredCols.length;
    const totalPages = Math.ceil(totalProducts / productsPerPage);

    const paginationWrapper = document.querySelector('.pagination-container');
    if (totalPages <= 1) {
        paginationWrapper.style.setProperty('display', 'none', 'important');
    } else {
        paginationWrapper.style.setProperty('display', 'flex', 'important');
    }

    allCols.forEach(col => col.style.setProperty('display', 'none', 'important'));
    
    filteredCols.forEach((col, index) => {
        const startIndex = (currentPage - 1) * productsPerPage;
        const endIndex = startIndex + productsPerPage;

        if (index >= startIndex && index < endIndex) {
            col.style.setProperty('display', 'block', 'important');
        }
    });

    const p1Btn = document.getElementById('page-1-btn');
    const p2Btn = document.getElementById('page-2-btn');
    const prevBtn = document.getElementById('prev-page-btn');
    const nextBtn = document.getElementById('next-page-btn');
    
    if (p1Btn && p2Btn && prevBtn && nextBtn) {
        if (currentPage === 1) {
            p1Btn.classList.add('active');
            p2Btn.classList.remove('active');
            prevBtn.classList.add('disabled');
            if (totalPages > 1) nextBtn.classList.remove('disabled');
        } else {
            p1Btn.classList.remove('active');
            p2Btn.classList.add('active');
            prevBtn.classList.remove('disabled');
            nextBtn.classList.add('disabled');
        }
    }
}

function goToPage(page) {
    currentPage = page;
    renderPagination();
    document.querySelector('.featured').scrollIntoView({ behavior: 'smooth' });
}

function changePage(direction) {
    currentPage += direction;
    if (currentPage < 1) currentPage = 1;
    if (currentPage > 2) currentPage = 2;
    goToPage(currentPage);
}

document.addEventListener("DOMContentLoaded", function() {
    renderPagination();
    
    window.filterProducts = function(category, button) {
        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        
        currentPage = 1; 
        if (typeof applyAdvancedFilters === "function") {
            applyAdvancedFilters();
        } else {
            renderPagination();
        }
    }
});
</script>