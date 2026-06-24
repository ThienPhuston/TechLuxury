<?php
$path_prefix = "../";
include("../includes/header.php");
?>

<section style="background:#090c13;min-height:82vh;padding:60px 0;color:white;">
    <div class="container">

        <!-- Header -->
        <div class="d-flex align-items-center gap-3 mb-5">
            <a href="../index.php" class="btn btn-sm d-flex align-items-center gap-2"
               style="border-radius:8px;padding:8px 16px;border:1px solid rgba(255,255,255,0.08);color:#ccc;background:rgba(255,255,255,0.02);">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <h1 class="m-0" style="font-weight:800;font-size:28px;background:linear-gradient(135deg,#fff 0%,#aaa 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                SẢN PHẨM YÊU THÍCH
            </h1>
            <span id="wishlist-count-badge" class="badge ms-1" style="background:rgba(255,71,87,0.12);color:#ff4757;border:1px solid rgba(255,71,87,0.2);padding:5px 12px;border-radius:20px;font-size:12px;font-weight:700;"></span>
        </div>

        <!-- Empty State -->
        <div id="wishlist-empty" style="display:none;" class="text-center py-5">
            <div style="width:80px;height:80px;border-radius:50%;background:rgba(255,71,87,0.05);border:1px solid rgba(255,71,87,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;color:#ff4757;font-size:32px;">
                <i class="far fa-heart"></i>
            </div>
            <h3 class="text-white mb-2" style="font-weight:700;">Chưa có sản phẩm yêu thích</h3>
            <p class="text-secondary mb-4" style="font-size:14px;max-width:380px;margin:0 auto 20px;">
                Nhấn biểu tượng ❤️ trên thẻ sản phẩm để lưu vào danh sách yêu thích của bạn.
            </p>
            <a href="../page/product.php" class="btn px-4 py-3 fw-bold"
               style="background:linear-gradient(135deg,#ff4757,#c0392b);color:white;border:none;border-radius:10px;font-size:13px;">
                <i class="fas fa-shopping-bag me-2"></i>Khám phá sản phẩm
            </a>
        </div>

        <!-- Wishlist Grid -->
        <div id="wishlist-grid" class="row g-4"></div>

        <!-- Clear All Button -->
        <div id="wishlist-actions" class="text-center mt-5" style="display:none;">
            <button onclick="clearWishlist()" class="btn px-4 py-2"
               style="background:rgba(255,71,87,0.08);color:#ff4757;border:1px solid rgba(255,71,87,0.2);border-radius:10px;font-size:13px;transition:all 0.3s;"
               onmouseover="this.style.background='rgba(255,71,87,0.15)'" onmouseout="this.style.background='rgba(255,71,87,0.08)'">
                <i class="fas fa-trash me-2"></i>Xóa tất cả yêu thích
            </button>
        </div>
    </div>
</section>

<script>
const WISHLIST_KEY = 'techluxury_wishlist';

function getWishlist() {
    try { return JSON.parse(localStorage.getItem(WISHLIST_KEY)) || []; } catch(e) { return []; }
}

function saveWishlist(list) {
    localStorage.setItem(WISHLIST_KEY, JSON.stringify(list));
}

function removeFromWishlist(title) {
    let wl = getWishlist().filter(p => p.title !== title);
    saveWishlist(wl);
    renderWishlist();
    if (window.showToast) showToast('Đã xóa khỏi yêu thích!', 'info', 2500);
}

function clearWishlist() {
    if (!confirm('Bạn có chắc muốn xóa tất cả sản phẩm yêu thích?')) return;
    localStorage.removeItem(WISHLIST_KEY);
    renderWishlist();
}

function addToCartFromWishlist(title, price, img, stock) {
    if (typeof window.addToCart === 'function') {
        window.addToCart(title, price + 'đ', img, stock, 1);
    } else {
        if (window.showToast) showToast('Vui lòng quay lại trang chủ để thêm vào giỏ!', 'warning');
    }
}

function renderWishlist() {
    const wl = getWishlist();
    const grid = document.getElementById('wishlist-grid');
    const empty = document.getElementById('wishlist-empty');
    const actions = document.getElementById('wishlist-actions');
    const badge = document.getElementById('wishlist-count-badge');

    badge.textContent = wl.length + ' sản phẩm';
    if (wl.length === 0) {
        grid.innerHTML = '';
        empty.style.display = 'block';
        actions.style.display = 'none';
        return;
    }
    empty.style.display = 'none';
    actions.style.display = 'block';

    grid.innerHTML = wl.map(p => {
        const price = typeof p.price === 'number' ? p.price : parseInt((p.price+'').replace(/[^0-9]/g,''));
        const formattedPrice = price.toLocaleString('vi-VN') + 'đ';
        const imgSrc = p.img ? ('../' + p.img.replace(/^(\.\.\/|\.\/)/,'')) : '../images/ip16pm.webp';
        return `
        <div class="col-6 col-md-4 col-lg-3">
            <div class="wishlist-card p-3 rounded-4 h-100 d-flex flex-column"
                 style="background:rgba(15,19,28,0.6);border:1px solid rgba(255,255,255,0.05);backdrop-filter:blur(12px);transition:all 0.3s;">
                <!-- Remove btn -->
                <button onclick="removeFromWishlist('${p.title.replace(/'/g,"\'")}')"
                    style="position:absolute;top:12px;right:12px;width:30px;height:30px;border-radius:50%;background:rgba(255,71,87,0.12);border:1px solid rgba(255,71,87,0.2);color:#ff4757;font-size:12px;cursor:pointer;transition:all 0.2s;z-index:2;"
                    onmouseover="this.style.background='rgba(255,71,87,0.25)'" onmouseout="this.style.background='rgba(255,71,87,0.12)'"
                    title="Xóa khỏi yêu thích"><i class="fas fa-times"></i></button>

                <!-- Image -->
                <div style="background:white;border-radius:10px;padding:12px;margin-bottom:12px;aspect-ratio:1;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <img src="${imgSrc}" alt="${p.title}" style="max-width:100%;max-height:120px;object-fit:contain;">
                </div>

                <!-- Info -->
                <div class="flex-grow-1">
                    <h6 class="text-white mb-1" style="font-size:13px;font-weight:600;line-height:1.4;">${p.title}</h6>
                    <div style="color:#d4af37;font-weight:800;font-size:15px;margin-bottom:12px;">${formattedPrice}</div>
                </div>

                <!-- Action -->
                <button onclick="addToCartFromWishlist('${p.title.replace(/'/g,"\\'")}', ${price}, '${p.img}', ${p.stock||99})"
                    class="btn w-100" style="background:linear-gradient(135deg,rgba(212,175,55,0.12),rgba(212,175,55,0.04));border:1px solid rgba(212,175,55,0.25);color:#d4af37;border-radius:8px;font-size:12px;font-weight:700;padding:9px;transition:all 0.3s;"
                    onmouseover="this.style.background='linear-gradient(135deg,rgba(212,175,55,0.2),rgba(212,175,55,0.08))'"
                    onmouseout="this.style.background='linear-gradient(135deg,rgba(212,175,55,0.12),rgba(212,175,55,0.04))'">
                    <i class="fas fa-cart-plus me-1"></i>Thêm vào giỏ
                </button>
            </div>
        </div>`;
    }).join('');

    // Fix relative positioning for remove buttons
    document.querySelectorAll('.wishlist-card').forEach(c => c.style.position = 'relative');
}

document.addEventListener('DOMContentLoaded', renderWishlist);
</script>

<style>
.wishlist-card:hover {
    transform: translateY(-4px);
    border-color: rgba(255,71,87,0.2) !important;
    box-shadow: 0 12px 30px rgba(0,0,0,0.3);
}
</style>

<?php include("../includes/footer.php"); ?>
