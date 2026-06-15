<?php 
$path_prefix = "../"; 
include("../includes/header.php"); 
?>

<section class="login d-flex align-items-center justify-content-center" style="min-height: 70vh; padding: 40px 20px;">
    <div class="w-100" style="max-width: 420px;">
        <form action="javascript:void(0)" class="w-100 shadow-lg" style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 45px 35px; border-radius: 20px;">
            <div class="text-center mb-4">
                <span class="d-inline-block p-3 rounded-circle mb-3" style="background: rgba(212,175,55,0.1); color: var(--accent-gold); width: 60px; height: 60px;">
                    <i class="fas fa-key" style="font-size: 24px;"></i>
                </span>
                <h2 class="text-white m-0" style="font-size: 24px; font-weight: 800;">QUÊN MẬT KHẨU</h2>
                <p class="text-secondary mt-2 mb-0" style="font-size: 13px;">Nhập email của bạn để khôi phục mật khẩu tài khoản</p>
            </div>
            
            <div class="mb-4">
                <input type="email" placeholder="Nhập địa chỉ Email của bạn" required class="form-control w-100" style="padding: 12px 18px; font-size: 13px;">
            </div>
            
            <button type="submit" class="w-100 btn-checkout mb-3" style="border: none; padding: 12px 0;">GỬI MÃ KHÔI PHỤC</button>
            
            <div class="d-flex justify-content-between align-items-center" style="font-size: 12px;">
                <a href="login.php" class="text-decoration-none" style="color: var(--accent-gold); font-weight: 700;">Quay lại Đăng nhập</a>
                <span class="text-secondary">Chưa có tài khoản? <a href="register.php" class="text-decoration-none" style="color: var(--accent-gold); font-weight: 700;">Đăng ký</a></span>
            </div>
        </form>
    </div>
</section>

<?php include("../includes/footer.php"); ?>
