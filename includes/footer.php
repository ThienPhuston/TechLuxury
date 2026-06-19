<?php
// Dynamic path prefixing
if (!isset($path_prefix)) {
    $path_prefix = "";
}
?>
<footer>
    <div class="footer-container">
        <div class="footer-box info-box">
            <h3 class="footer-logo">TECHLUXURY</h3>
            <p>Trải nghiệm sản phẩm công nghệ cao cấp chính hãng từ các thương hiệu hàng đầu thế giới với chế độ hậu mãi đặc quyền.</p>
            <div class="newsletter-form">
                <input type="email" placeholder="Nhập email của bạn...">
                <button type="button"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>

        <div class="footer-box links-box">
            <h3>Danh mục dịch vụ</h3>
            <ul class="footer-links">
                <li><a href="<?php echo $path_prefix; ?>page/product.php">Sản phẩm chính hãng</a></li>
                <li><a href="<?php echo $path_prefix; ?>page/about.php">Chính sách bảo hành</a></li>
                <li><a href="<?php echo $path_prefix; ?>page/contact.php">Hệ thống cửa hàng</a></li>
                <li><a href="<?php echo $path_prefix; ?>Account/login.php">Tài khoản Smember</a></li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                    <li><a href="<?php echo $path_prefix; ?>admin/index.php">Quản trị hệ thống</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="footer-box contact-box">
            <h3>Liên hệ & Hỗ trợ</h3>
            <p><i class="fas fa-envelope"></i> Thienphutontran@gmail.com</p>
            <p><i class="fas fa-phone-alt"></i> Hotline: 0794923325</p>
            <p><i class="fas fa-map-marker-alt"></i> TP. Hồ Chí Minh, Việt Nam</p>
            <div class="social-icons">
                <a href="https://www.facebook.com/share/18pJxS62AM/?mibextid=wwXIfr" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/twh.phuss?igsh=MTVsdnJmZ2NlaThndg%3D%3D&utm_source=qr" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://www.youtube.com/techluxury" target="_blank" title="Youtube"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <p>&copy; 2026 TECHLUXURY. All rights reserved. Designed for elite tech experiences.</p>
            <div class="payment-methods">
                <i class="fab fa-cc-visa"></i>
                <i class="fab fa-cc-mastercard"></i>
                <i class="fab fa-cc-apple-pay"></i>
                <i class="fab fa-google-pay"></i>
            </div>
        </div>
    </div>
</footer>

<!-- Cart Drawer Sidebar -->
<div class="cart-drawer" id="cart-drawer">
    <div class="cart-drawer-header">
        <h3>GIỎ HÀNG CỦA BẠN</h3>
        <button class="cart-drawer-close" id="cart-close-btn">&times;</button>
    </div>
    <div class="cart-drawer-body" id="cart-drawer-items">
        <!-- Loaded dynamically via JS -->
    </div>
    <div class="cart-drawer-footer" id="cart-drawer-footer-sec">
        <div class="cart-total-row">
            <span>Tổng tiền:</span>
            <span class="cart-total-amount" id="cart-total-amount">0đ</span>
        </div>
        <button class="btn-checkout" id="checkout-btn">TIẾN HÀNH THANH TOÁN</button>
    </div>
</div>
<div class="cart-drawer-overlay" id="cart-overlay"></div>

<!-- Specs QuickView Modal -->
<div class="specs-modal" id="specs-modal">
    <div class="specs-modal-content">
        <button class="specs-modal-close" id="specs-close-btn">&times;</button>
        <div class="specs-modal-grid">
            <div class="specs-modal-gallery">
                <img id="modal-product-img" src="" alt="">
            </div>
            <div class="specs-modal-info">
                <span class="product-badge" id="modal-product-badge">NỔI BẬT</span>
                <h2 id="modal-product-title">Tên sản phẩm</h2>
                <div class="modal-product-price" id="modal-product-price">0đ</div>
                <div class="modal-product-stock text-secondary small mb-3" id="modal-product-stock" style="font-size: 13px;">
                    <!-- Stock status loaded dynamically -->
                </div>
                
                <div class="specs-section">
                    <h4>Thông số nổi bật:</h4>
                    <div class="modal-chips" id="modal-product-specs">
                        <!-- Chips loaded dynamically -->
                    </div>
                </div>

                <div class="color-options-section mt-3">
                    <h4>Màu sắc sẵn có:</h4>
                    <div class="color-swatches">
                        <span class="swatch color-titanium active" title="Titanium tự nhiên"></span>
                        <span class="swatch color-gold" title="Desert Gold"></span>
                        <span class="swatch color-black" title="Space Black"></span>
                    </div>
                </div>
                
                <div class="modal-actions mt-4 d-flex align-items-center gap-3">
                    <div class="product-qty-wrapper d-flex align-items-center gap-1">
                        <span class="small text-secondary me-1">Số lượng:</span>
                        <input type="number" id="modal-product-qty" class="form-control form-control-sm text-center text-white" value="1" min="1" style="width: 70px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); font-size: 13px; padding: 6px; border-radius: 8px;">
                    </div>
                    <button class="btn-buy-modal" id="modal-add-to-cart-btn">
                        <i class="fas fa-shopping-cart"></i> THÊM VÀO GIỎ HÀNG
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="specs-modal-overlay" id="specs-overlay"></div>

<!-- Bootstrap JS Bundle (Fixed integrity block by removing faulty hashes) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS Files -->
<script src="<?php echo $path_prefix; ?>js/main.js"></script>

</body>
</html>