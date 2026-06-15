<?php 
$path_prefix = "../"; 
include("../includes/header.php"); 
?>

<section class="checkout-page">
    <div class="container">
        <h1 class="text-white mb-5 text-center">THANH TOÁN ĐƠN HÀNG</h1>
        
        <div class="row g-5">
            <!-- Cột trái: Thông tin nhận hàng & Thanh toán -->
            <div class="col-lg-7">
                <div class="checkout-box mb-4">
                    <h3 class="text-white mb-4" style="font-size: 18px; font-weight: 700; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
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
                    </div>
                    
                    <div class="checkout-total-sec">
                        <div class="checkout-total-row">
                            <span>Tạm tính</span>
                            <span id="checkout-subtotal">0đ</span>
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
