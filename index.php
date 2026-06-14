<?php include("includes/header.php"); ?>


<section class="hero">
    <div class="hero-content">
        <h1>CÔNG NGHỆ ĐẲNG CẤP</h1>
        <p>Trải nghiệm sản phẩm công nghệ cao cấp chính hãng</p>
        <a href="page/product.php" class="btn btn-primary">
            <i class="fas fa-shopping-cart"></i> KHÁM PHÁ NGAY
        </a>
    </div>
</section>

<section class="categories">
    <div class="container">
        <h2>DANH MỤC SẢN PHẨM</h2>
        <div class="categories-grid">
            <div class="category-card">
                <i class="fas fa-laptop"></i>
                <h3>LAPTOP</h3>
                <p>Các dòng Laptop cao cấp từ các hãng hàng đầu</p>
                <a href="page/product.php" class="link-btn">Xem thêm</a>
            </div>
            <div class="category-card">
                <i class="fas fa-mobile-alt"></i>
                <h3>ĐIỆN THOẠI</h3>
                <p>Điện thoại thông minh mới nhất 2024-2025</p>
                <a href="page/product.php" class="link-btn">Xem thêm</a>
            </div>
            <div class="category-card">
                <i class="fas fa-headphones"></i>
                <h3>PHỤ KIỆN</h3>
                <p>Phụ kiện công nghệ cao cấp và chính hãng</p>
                <a href="page/product.php" class="link-btn">Xem thêm</a>
            </div>
        </div>
    </div>
</section>


<section class="sale-section">
    <div class="container">
        <h2>🔥 SẢN PHẨM KHUYẾN MÃI</h2>
        <div class="products-grid">
            <div class="card sale-card">
                <div class="sale-badge">-15%</div>
                <img src="images/macbook.jpg" alt="Macbook Pro M4">
                <h3>Macbook Pro M4</h3>
                <p class="original-price"><del>70.990.000đ</del></p>
                <p class="sale-price">59.990.000đ</p>
                <button class="btn-buy">Thêm vào giỏ</button>
            </div>

            <div class="card sale-card">
                <div class="sale-badge">-20%</div>
                <img src="images/iphone16.jpg" alt="iPhone 16 Pro Max">
                <h3>iPhone 16 Pro Max</h3>
                <p class="original-price"><del>44.990.000đ</del></p>
                <p class="sale-price">35.990.000đ</p>
                <button class="btn-buy">Thêm vào giỏ</button>
            </div>

            <div class="card sale-card">
                <div class="sale-badge">-25%</div>
                <img src="images/s24.jpg" alt="Galaxy S24 Ultra">
                <h3>Galaxy S24 Ultra</h3>
                <p class="original-price"><del>42.990.000đ</del></p>
                <p class="sale-price">31.990.000đ</p>
                <button class="btn-buy">Thêm vào giỏ</button>
            </div>
        </div>
    </div>
</section>


<section class="featured py-5">
    <div class="container">
        <h2 class="featured-title text-center mb-4">SẢN PHẨM NỔI BẬT</h2>
        
        <div class="featured-tabs d-flex justify-content-center gap-2 mb-4">
            <button class="tab-btn active" onclick="filterProducts('all', this)">Tất cả</button>
            <button class="tab-btn" onclick="filterProducts('laptop', this)">Laptop</button>
            <button class="tab-btn" onclick="filterProducts('phone', this)">Điện thoại</button>
            <button class="tab-btn" onclick="filterProducts('accessory', this)">Phụ kiện</button>
        </div>

        <div class="products row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-center" id="featured-products-container">
            
            <div class="col product-col" data-category="laptop">
                <div class="card product-square-card">
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

            <div class="col product-col" data-category="phone">
                <div class="card product-square-card">
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

            <div class="col product-col" data-category="phone">
                <div class="card product-square-card">
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

            <div class="col product-col" data-category="laptop">
                <div class="card product-square-card">
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

            <div class="col product-col" data-category="accessory">
                <div class="card product-square-card">
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

            <div class="col product-col" data-category="accessory">
                <div class="card product-square-card">
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

            <div class="col product-col" data-category="phone">
                <div class="card product-square-card">
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

            <div class="col product-col" data-category="laptop">
                <div class="card product-square-card">
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

            <div class="col product-col" data-category="phone">
                <div class="card product-square-card">
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

            <div class="col product-col" data-category="accessory">
                <div class="card product-square-card">
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
        renderPagination();
    }
});
</script>