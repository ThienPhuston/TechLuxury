<?php 
$path_prefix = "../"; 
include("../includes/header.php"); 
?>

<section class="contact-page py-5">
    <div class="container py-4">
        <!-- Section Title -->
        <div class="text-center mb-5 reveal-element">
            <span class="text-uppercase fw-bold text-secondary" style="font-size: 11px; letter-spacing: 2px; color: var(--accent-gold) !important;">HỖ TRỢ ĐẶC QUYỀN</span>
            <h1 class="text-white mt-2 mb-3" style="font-size: 42px; font-weight: 800; letter-spacing: -0.5px;">LIÊN HỆ VỚI CHÚNG TÔI</h1>
            <p class="text-secondary mx-auto" style="max-width: 600px; font-size: 14px; line-height: 1.7;">
                Chúng tôi luôn sẵn sàng lắng nghe và giải đáp mọi yêu cầu của khách hàng về sản phẩm, chính sách bảo hành, hoặc góp ý chất lượng dịch vụ.
            </p>
        </div>

        <!-- Glass Support Cards -->
        <div class="row g-4 mb-5 justify-content-center reveal-element">
            <div class="col-md-4">
                <div class="stat-counter-card h-100 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 55px; height: 55px; background: rgba(212,175,55,0.05); border: 1px solid rgba(212,175,55,0.1); color: var(--accent-gold); font-size: 18px;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h4 class="text-white fw-bold mb-1" style="font-size: 14px; text-transform: uppercase;">Đường dây nóng</h4>
                    <span class="text-gold fw-bold" style="font-size: 16px; color: var(--accent-gold);">0794923325</span>
                    <p class="text-muted m-0 mt-1" style="font-size: 11px;">Hỗ trợ tư vấn VIP 24/7</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="stat-counter-card h-100 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 55px; height: 55px; background: rgba(212,175,55,0.05); border: 1px solid rgba(212,175,55,0.1); color: var(--accent-gold); font-size: 18px;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h4 class="text-white fw-bold mb-1" style="font-size: 14px; text-transform: uppercase;">Email hỗ trợ</h4>
                    <span class="text-white fw-bold" style="font-size: 14px;">Thienphutontran@gmail.com</span>
                    <p class="text-muted m-0 mt-1" style="font-size: 11px;">Phản hồi trong vòng 2 giờ</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-counter-card h-100 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 55px; height: 55px; background: rgba(212,175,55,0.05); border: 1px solid rgba(212,175,55,0.1); color: var(--accent-gold); font-size: 18px;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4 class="text-white fw-bold mb-1" style="font-size: 14px; text-transform: uppercase;">Trụ sở chính</h4>
                    <span class="text-white fw-bold text-center" style="font-size: 14px; padding: 0 10px;">Quận 1, TP. Hồ Chí Minh</span>
                    <p class="text-muted m-0 mt-1" style="font-size: 11px;">Việt Nam</p>
                </div>
            </div>
        </div>

        <!-- Form and Map Columns -->
        <div class="row g-5 justify-content-center align-items-stretch reveal-element">
            <!-- Form -->
            <div class="col-lg-6">
                <div class="stat-counter-card text-start h-100 p-4" style="background: rgba(15, 19, 28, 0.4);">
                    <h3 class="text-white mb-4" style="font-size: 18px; font-weight: 700; border-bottom: 2px solid var(--accent-gold); padding-bottom: 8px; display: inline-block;">GỬI LỜI NHẮN CHO CHÚNG TÔI</h3>
                    
                    <form action="javascript:void(0)" class="m-0">
                        <div class="mb-3">
                            <label class="text-secondary small mb-1" style="font-size: 11px; font-weight: 600;">HỌ VÀ TÊN</label>
                            <input type="text" placeholder="Nhập họ và tên..." required class="form-control glass-input">
                        </div>
                        <div class="mb-3">
                            <label class="text-secondary small mb-1" style="font-size: 11px; font-weight: 600;">ĐỊA CHỈ EMAIL</label>
                            <input type="email" placeholder="email@vi-du.com..." required class="form-control glass-input">
                        </div>
                        <div class="mb-4">
                            <label class="text-secondary small mb-1" style="font-size: 11px; font-weight: 600;">NỘI DUNG LIÊN HỆ</label>
                            <textarea placeholder="Nhập lời nhắn của bạn ở đây..." rows="4" required class="form-control glass-input"></textarea>
                        </div>
                        <button type="submit" class="btn w-100 fw-bold py-3" style="border-radius: 10px; font-size: 13px;">GỬI LIÊN HỆ NGAY</button>
                    </form>
                </div>
            </div>

            <!-- Map Mockup -->
            <div class="col-lg-6 d-flex flex-column justify-content-between">
                <div class="stat-counter-card p-4 text-start h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h3 class="text-white mb-3" style="font-size: 18px; font-weight: 700; border-bottom: 2px solid var(--accent-gold); padding-bottom: 8px; display: inline-block;">HỆ THỐNG LOUNGE TRẢI NGHIỆM</h3>
                        <p class="text-secondary m-0" style="font-size: 13px; line-height: 1.7;">
                            Lounge trải nghiệm cao cấp của TechLuxury nằm ngay tại trung tâm Quận 1. Không gian sang trọng, trưng bày đầy đủ các flagship mới nhất, sẵn sàng tiếp đón và phục vụ quý khách theo phong cách hoàng gia.
                        </p>
                    </div>

                    <!-- Obsidian styled mock map -->
                    <div class="dark-map-mockup">
                        <div class="map-grid-lines"></div>
                        <div class="map-location-pulse"></div>
                        <div class="map-label">VIP Lounge - TechLuxury</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section reveal-element">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-uppercase fw-bold text-secondary" style="font-size: 11px; letter-spacing: 2px; color: var(--accent-gold) !important;">GIẢI ĐÁP THẮC MẮC</span>
            <h2 class="text-white mt-2 mb-3" style="font-size: 32px; font-weight: 800; letter-spacing: -0.5px;">CÂU HỎI THƯỜNG GẶP</h2>
        </div>

        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-header">
                    <h3>Quy trình đổi trả sản phẩm tại TechLuxury như thế nào?</h3>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-content">
                    <div class="faq-content-inner">
                        Đối với khách hàng VIP Smember, chúng tôi hỗ trợ chính sách 1 đổi 1 trong vòng 30 ngày đối với lỗi phần cứng từ nhà sản xuất. Sản phẩm thu hồi sẽ được kiểm tra và xử lý đổi mới chỉ trong vòng 24-48 giờ làm việc với chuyên viên hỗ trợ riêng tại cửa hàng.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-header">
                    <h3>Có hỗ trợ mua hàng trả góp trực tuyến không?</h3>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-content">
                    <div class="faq-content-inner">
                        Có, TechLuxury hợp tác với các ngân hàng lớn để hỗ trợ trả góp lãi suất 0% qua thẻ tín dụng Visa/Mastercard. Bạn có thể thanh toán trực tuyến nhanh chóng mà không cần thủ tục giấy tờ phức tạp, kỳ hạn thanh toán linh hoạt lên đến 12 tháng.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-header">
                    <h3>Làm thế nào để đăng ký làm thành viên VIP Lounge?</h3>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </div>
                <div class="faq-content">
                    <div class="faq-content-inner">
                        Tài khoản của bạn sẽ tự động được nâng cấp lên VIP Lounge khi tổng chi tiêu tích lũy tại TechLuxury đạt từ 50.000.000đ trở lên. Khi đạt mức này, bạn sẽ nhận được một thẻ VIP đặc quyền, được giảm giá 5% cho tất cả đơn hàng phụ kiện và có chuyên viên tư vấn riêng hỗ trợ 24/7.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Accordion JS Logic -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const faqHeaders = document.querySelectorAll(".faq-header");
    faqHeaders.forEach(header => {
        header.addEventListener("click", function() {
            const faqItem = this.parentElement;
            const content = this.nextElementSibling;
            
            // Check if item is already active
            const isActive = faqItem.classList.contains("active");
            
            // Close all items
            document.querySelectorAll(".faq-item").forEach(item => {
                item.classList.remove("active");
                item.querySelector(".faq-content").style.maxHeight = null;
            });
            
            // Toggle active item
            if (!isActive) {
                faqItem.classList.add("active");
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    });
});
</script>

<?php include("../includes/footer.php"); ?>