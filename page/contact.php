<?php 
$path_prefix = "../"; 
include("../includes/header.php"); 
?>

<section class="contact">
    <div class="container py-5">
        <h1 class="text-center mb-5">LIÊN HỆ VỚI CHÚNG TÔI</h1>
        
        <div class="row g-5 justify-content-center">
            <!-- Cột thông tin liên hệ -->
            <div class="col-lg-5 text-start d-flex flex-column justify-content-between">
                <div>
                    <h2 class="text-white mb-4" style="font-weight: 700;">Hỗ Trợ Khách Hàng VIP</h2>
                    <p class="text-secondary mb-4" style="font-size: 14px; line-height: 1.7;">
                        Chúng tôi luôn sẵn sàng lắng nghe và giải đáp mọi thắc mắc của bạn về sản phẩm, dịch vụ bảo hành hoặc ý kiến đóng góp. Hãy liên hệ với chúng tôi qua các kênh dưới đây hoặc để lại lời nhắn.
                    </p>
                    
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: rgba(212,175,55,0.1); color: var(--accent-gold);">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h5 class="text-white m-0" style="font-size: 13px; font-weight: 700;">ĐƯỜNG DÂY NÓNG</h5>
                                <p class="text-secondary m-0" style="font-size: 14px;">0794923325</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: rgba(212,175,55,0.1); color: var(--accent-gold);">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h5 class="text-white m-0" style="font-size: 13px; font-weight: 700;">EMAIL HỖ TRỢ</h5>
                                <p class="text-secondary m-0" style="font-size: 14px;">Thienphutontran@gmail.com</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: var(--bg-card); border: 1px solid var(--border-color);">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background: rgba(212,175,55,0.1); color: var(--accent-gold);">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h5 class="text-white m-0" style="font-size: 13px; font-weight: 700;">ĐỊA CHỈ TRỤ SỞ</h5>
                                <p class="text-secondary m-0" style="font-size: 14px;">Quận 1, TP. Hồ Chí Minh, Việt Nam</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột Form liên hệ -->
            <div class="col-lg-5">
                <form action="javascript:void(0)" class="m-0 w-100" style="max-width: 100%;">
                    <h3 class="text-white mb-4 text-center" style="font-size: 18px; font-weight: 700;">GỬI LỜI NHẮN CHO CHÚNG TÔI</h3>
                    <input type="text" placeholder="Họ và tên của bạn" required class="form-control mb-3">
                    <input type="email" placeholder="Địa chỉ Email" required class="form-control mb-3">
                    <textarea placeholder="Nội dung cần liên hệ" rows="4" required class="form-control mb-4"></textarea>
                    <button type="submit" class="w-100 btn-buy" style="border: none; padding: 12px 0;">GỬI LIÊN HỆ</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include("../includes/footer.php"); ?>