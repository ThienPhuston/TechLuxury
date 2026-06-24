<?php
$path_prefix = "";
include("includes/header.php");
?>

<section style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background: #090c13; padding: 60px 0;">
    <div class="container text-center">

        <!-- Animated 404 graphic -->
        <div class="not-found-graphic mb-5">
            <div class="nf-number" style="font-size:clamp(80px,15vw,160px);font-weight:900;line-height:1;letter-spacing:-4px;background:linear-gradient(135deg,rgba(212,175,55,0.8) 0%,rgba(212,175,55,0.15) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation: pulse404 3s ease-in-out infinite;">
                404
            </div>
            <div class="nf-icon" style="font-size:48px;margin-top:-20px;color:rgba(212,175,55,0.3);animation:float404 3s ease-in-out infinite;">
                <i class="fas fa-satellite-dish"></i>
            </div>
        </div>

        <!-- Message -->
        <h1 class="text-white mb-3" style="font-size:clamp(22px,4vw,36px);font-weight:800;">
            Trang không tồn tại
        </h1>
        <p class="text-secondary mx-auto mb-5" style="max-width:480px;font-size:15px;line-height:1.8;">
            Trang bạn đang tìm kiếm đã bị xóa, chưa từng tồn tại, hoặc đường dẫn không chính xác.
            Hãy quay lại và khám phá thế giới công nghệ đẳng cấp của chúng tôi.
        </p>

        <!-- CTA Buttons -->
        <div class="d-flex flex-wrap gap-3 justify-content-center mb-5">
            <a href="index.php" class="btn px-5 py-3 fw-bold"
               style="background:linear-gradient(135deg,#d4af37,#b8962e);color:#000;border:none;border-radius:12px;font-size:13px;letter-spacing:0.5px;transition:all 0.3s;"
               onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 30px rgba(212,175,55,0.35)'"
               onmouseout="this.style.transform='';this.style.boxShadow=''">
                <i class="fas fa-home me-2"></i>VỀ TRANG CHỦ
            </a>
            <a href="page/product.php" class="btn px-5 py-3 fw-bold"
               style="background:rgba(255,255,255,0.04);color:white;border:1px solid rgba(255,255,255,0.1);border-radius:12px;font-size:13px;letter-spacing:0.5px;transition:all 0.3s;"
               onmouseover="this.style.background='rgba(255,255,255,0.08)';this.style.borderColor='rgba(212,175,55,0.3)'"
               onmouseout="this.style.background='rgba(255,255,255,0.04)';this.style.borderColor='rgba(255,255,255,0.1)'">
                <i class="fas fa-shopping-bag me-2"></i>XEM SẢN PHẨM
            </a>
        </div>

        <!-- Suggestion links -->
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <span class="text-secondary small me-2" style="font-size:12px;">Có thể bạn muốn:</span>
            <a href="page/about.php" class="badge text-decoration-none" style="background:rgba(255,255,255,0.04);color:#aaa;border:1px solid rgba(255,255,255,0.07);padding:6px 14px;border-radius:20px;font-size:12px;">Giới thiệu</a>
            <a href="page/contact.php" class="badge text-decoration-none" style="background:rgba(255,255,255,0.04);color:#aaa;border:1px solid rgba(255,255,255,0.07);padding:6px 14px;border-radius:20px;font-size:12px;">Liên hệ</a>
            <a href="Account/login.php" class="badge text-decoration-none" style="background:rgba(255,255,255,0.04);color:#aaa;border:1px solid rgba(255,255,255,0.07);padding:6px 14px;border-radius:20px;font-size:12px;">Đăng nhập</a>
        </div>

    </div>
</section>

<style>
@keyframes pulse404 {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.6; }
}
@keyframes float404 {
    0%, 100% { transform: translateY(0px); }
    50%       { transform: translateY(-12px); }
}
</style>

<?php include("includes/footer.php"); ?>
