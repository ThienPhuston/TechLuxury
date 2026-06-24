<?php 
$path_prefix = "../"; 
include("../includes/header.php"); 

if (!isset($_SESSION['user'])) {
    echo "<script>
        alert('Vui lòng đăng nhập hoặc đăng ký tài khoản để tiến hành thanh toán mua hàng!');
        window.location.href = '../Account/login.php';
    </script>";
    exit();
}
?>

<section class="checkout-page">
    <div class="container">
        <h1 class="text-white mb-5 text-center">THANH TOÁN ĐƠN HÀNG</h1>
        
        <div class="row g-5">
            <!-- Cột trái: Thông tin nhận hàng & Thanh toán -->
            <div class="col-lg-7">
                <!-- Split Shipping Toggle Checkbox -->
                <div class="checkout-box mb-4">
                    <div class="form-check form-switch m-0 d-flex align-items-center">
                        <input class="form-check-input" type="checkbox" id="split-shipping-toggle" style="cursor: pointer; width: 40px; height: 20px; accent-color: var(--accent-gold);">
                        <label class="form-check-label text-warning fw-bold ms-3" for="split-shipping-toggle" style="cursor: pointer; font-size: 14px;">
                            <i class="fas fa-exchange-alt me-1"></i> Giao hàng đến 2 địa điểm khác nhau (Tách đơn hàng)
                        </label>
                    </div>
                    <p class="text-secondary m-0 mt-2" style="font-size: 11px; line-height: 1.5;">Bật tính năng này nếu bạn muốn giao một số sản phẩm trong giỏ hàng đến địa chỉ thứ 2. Hệ thống sẽ tách thành 2 đơn hàng tương ứng.</p>
                </div>

                <div id="address-1-panel">
                    <div class="checkout-box mb-4">
                        <h3 class="text-white mb-4" id="address-1-title" style="font-size: 16px; font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                            <i class="fas fa-shipping-fast text-warning me-2"></i> THÔNG TIN NHẬN HÀNG
                        </h3>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-secondary small fw-bold mb-2">HỌ VÀ TÊN</label>
                                <input type="text" id="checkout-name" placeholder="Nguyễn Văn A" required class="form-control" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: white; padding: 12px 18px; border-radius: 10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="text-secondary small fw-bold mb-2">SỐ ĐIỆN THOẠI</label>
                                <input type="tel" id="checkout-phone" placeholder="0901234567" required class="form-control" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: white; padding: 12px 18px; border-radius: 10px;">
                            </div>
                            <div class="col-12">
                                <label class="text-secondary small fw-bold mb-2">ĐỊA CHỈ NHẬN HÀNG</label>
                                <input type="text" id="checkout-address" placeholder="Số nhà, tên đường, phường/xã..." required class="form-control" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: white; padding: 12px 18px; border-radius: 10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="text-secondary small fw-bold mb-2">TỈNH / THÀNH PHỐ</label>
                                <input type="text" id="checkout-city" placeholder="TP. Hồ Chí Minh" required class="form-control" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: white; padding: 12px 18px; border-radius: 10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="text-secondary small fw-bold mb-2">GHI CHÚ (NẾU CÓ)</label>
                                <input type="text" id="checkout-notes" placeholder="Giao hàng giờ hành chính..." class="form-control" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: white; padding: 12px 18px; border-radius: 10px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="address-2-panel" style="display: none;">
                    <div class="checkout-box mb-4">
                        <h3 class="text-white mb-4" style="font-size: 16px; font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                            <i class="fas fa-shipping-fast text-warning me-2"></i> THÔNG TIN NHẬN HÀNG (ĐỊA CHỈ 2)
                        </h3>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-secondary small fw-bold mb-2">HỌ VÀ TÊN (ĐỊA CHỈ 2)</label>
                                <input type="text" id="checkout-name-2" placeholder="Nguyễn Văn B" class="form-control" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: white; padding: 12px 18px; border-radius: 10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="text-secondary small fw-bold mb-2">SỐ ĐIỆN THOẠI (ĐỊA CHỈ 2)</label>
                                <input type="tel" id="checkout-phone-2" placeholder="0909876543" class="form-control" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: white; padding: 12px 18px; border-radius: 10px;">
                            </div>
                            <div class="col-12">
                                <label class="text-secondary small fw-bold mb-2">ĐỊA CHỈ NHẬN HÀNG (ĐỊA CHỈ 2)</label>
                                <input type="text" id="checkout-address-2" placeholder="Số nhà, tên đường, phường/xã..." class="form-control" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: white; padding: 12px 18px; border-radius: 10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="text-secondary small fw-bold mb-2">TỈNH / THÀNH PHỐ (ĐỊA CHỈ 2)</label>
                                <input type="text" id="checkout-city-2" placeholder="Hà Nội" class="form-control" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: white; padding: 12px 18px; border-radius: 10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="text-secondary small fw-bold mb-2">GHI CHÚ (ĐỊA CHỈ 2)</label>
                                <input type="text" id="checkout-notes-2" placeholder="Giao hàng buổi tối..." class="form-control" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); color: white; padding: 12px 18px; border-radius: 10px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="checkout-box">
                    <h3 class="text-white mb-4" style="font-size: 18px; font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                        <i class="fas fa-credit-card text-warning me-2"></i> PHƯƠNG THỨC THANH TOÁN
                    </h3>
                    
                    <div class="payment-selector">
                        <div class="payment-option active" onclick="selectPayment(this, 'cod')">
                            <input type="radio" name="payment_method" id="pay-cod" value="cod" checked>
                            <i class="fas fa-money-bill-wave"></i>
                            <div>
                                <h5 class="text-white m-0" style="font-size: 14px; font-weight: 700;">Thanh toán khi nhận hàng (COD)</h5>
                                <p class="text-secondary m-0" style="font-size: 11px;">Thanh toán bằng tiền mặt khi shipper giao hàng tận nơi.</p>
                            </div>
                        </div>

                        <div class="payment-option" onclick="selectPayment(this, 'bank')">
                            <input type="radio" name="payment_method" id="pay-bank" value="bank">
                            <i class="fas fa-university"></i>
                            <div>
                                <h5 class="text-white m-0" style="font-size: 14px; font-weight: 700;">Chuyển khoản ngân hàng qua mã QR</h5>
                                <p class="text-secondary m-0" style="font-size: 11px;">Quét mã QR chuyển khoản tức thì qua dịch vụ VietQR.</p>
                            </div>
                        </div>

                        <div class="payment-option" onclick="selectPayment(this, 'card')">
                            <input type="radio" name="payment_method" id="pay-card" value="card">
                            <i class="fab fa-cc-visa"></i>
                            <div>
                                <h5 class="text-white m-0" style="font-size: 14px; font-weight: 700;">Cổng thanh toán thẻ Visa/Mastercard</h5>
                                <p class="text-secondary m-0" style="font-size: 11px;">Hỗ trợ thẻ quốc tế và nội địa an toàn bảo mật cao.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cột phải: Tóm tắt đơn hàng -->
            <div class="col-lg-5">
                <div class="checkout-box h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h3 class="text-white mb-4" style="font-size: 18px; font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                            <i class="fas fa-shopping-bag text-warning me-2"></i> TÓM TẮT ĐƠN HÀNG
                        </h3>
                        
                        <!-- List of order items -->
                        <div id="checkout-order-items" style="max-height: 350px; overflow-y: auto; padding-right: 5px;">
                            <!-- Dynamically loaded via js -->
                        </div>

                        <!-- Coupon input field -->
                        <div class="checkout-coupon-box mt-4 pt-3" style="border-top: 1px dashed var(--border-color);">
                            <label class="text-secondary small fw-bold mb-2"><i class="fas fa-ticket-alt text-warning me-1"></i> MÃ GIẢM GIÁ (COUPON)</label>
                            <div class="input-group">
                                <input type="text" id="coupon-code-input" placeholder="Ví dụ: TECHLUXURY500..." class="form-control text-white" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); padding: 10px 14px; border-radius: 8px 0 0 8px; font-size: 13px; font-weight: 700; text-transform: uppercase;">
                                <button class="btn btn-outline-warning" type="button" id="btn-apply-coupon" style="border-radius: 0 8px 8px 0; font-size: 12px; font-weight: 700; padding: 0 16px; border-color: var(--border-color);">ÁP DỤNG</button>
                            </div>
                            <div id="coupon-message" class="small mt-2" style="display: none;"></div>
                        </div>
                    </div>
                    
                    <div class="checkout-total-sec">
                        <div class="checkout-total-row">
                            <span>Tạm tính</span>
                            <span id="checkout-subtotal">0đ</span>
                        </div>
                        <div class="checkout-total-row" id="discount-row" style="display: none;">
                            <span>Chiết khấu (Giảm giá)</span>
                            <span id="checkout-discount" class="text-danger fw-bold">-0đ</span>
                        </div>
                        <div class="checkout-total-row">
                            <span>Phí vận chuyển</span>
                            <span class="text-success fw-bold">Miễn phí (VIP)</span>
                        </div>
                        <div class="checkout-total-row grand-total">
                            <span>TỔNG TIỀN CẦN THANH TOÁN</span>
                            <span id="checkout-grand-total" style="color: var(--accent-gold); font-size: 20px;">0đ</span>
                        </div>
                        
                        <button class="btn-checkout w-100 py-3 mt-4" id="btn-place-order">
                            <i class="fas fa-check-circle"></i> XÁC NHẬN ĐẶT HÀNG
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Confetti Modal -->
<div class="specs-modal" id="order-success-modal" style="max-width: 450px;">
    <div class="specs-modal-content text-center p-5">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
            <i class="fas fa-check-circle" style="font-size: 48px;"></i>
        </div>
        <h2 class="text-white mb-3" style="font-weight: 800;">ĐẶT HÀNG THÀNH CÔNG!</h2>
        <p class="text-secondary mb-4" style="font-size: 13px; line-height: 1.6;">
            Cảm ơn bạn đã lựa chọn TechLuxury. Mã đơn hàng của bạn là <strong class="text-white" id="order-id-display">#TL-8942</strong>. Chúng tôi sẽ liên hệ xác nhận trong thời gian sớm nhất.
        </p>
        <button class="btn-checkout w-100" id="btn-success-close">QUAY VỀ TRANG CHỦ</button>
    </div>
</div>
<div class="specs-modal-overlay" id="order-success-overlay"></div>

<script src="../js/checkout.js"></script>

<script>
// Select payment options helper
function selectPayment(element, method) {
    document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
    element.classList.add('active');
    
    const radioBtn = element.querySelector('input[type="radio"]');
    if (radioBtn) {
        radioBtn.checked = true;
    }
}
</script>

<?php include("../includes/footer.php"); ?>
