<?php 
$path_prefix = "../"; 
include("../includes/header.php"); 
?>

<section class="login d-flex align-items-center justify-content-center" style="min-height: 80vh; padding: 40px 20px;">
    <div class="w-100" style="max-width: 460px;">
        <form id="register-form" action="javascript:void(0)" class="w-100 shadow-lg" style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 45px 35px; border-radius: 20px;">
            <div class="text-center mb-4">
                <span class="d-inline-block p-3 rounded-circle mb-3" style="background: rgba(212,175,55,0.1); color: var(--accent-gold); width: 60px; height: 60px;">
                    <i class="fas fa-user-plus" style="font-size: 24px;"></i>
                </span>
                <h2 class="text-white m-0" style="font-size: 24px; font-weight: 800;">ĐĂNG KÝ</h2>
                <p class="text-secondary mt-2 mb-0" style="font-size: 13px;">Trở thành thành viên VIP Smember của TechLuxury</p>
            </div>
            
            <div class="mb-3">
                <input type="text" id="register-fullname" placeholder="Họ và tên" required class="form-control w-100" style="padding: 12px 18px; font-size: 13px;">
            </div>

            <div class="mb-3">
                <input type="text" id="register-username" placeholder="Tên đăng nhập" required class="form-control w-100" style="padding: 12px 18px; font-size: 13px;">
            </div>

            <div class="mb-3">
                <input type="email" id="register-email" placeholder="Địa chỉ Email" required class="form-control w-100" style="padding: 12px 18px; font-size: 13px;">
            </div>
            
            <div class="mb-3">
                <input type="password" id="register-password" placeholder="Mật khẩu" required class="form-control w-100" style="padding: 12px 18px; font-size: 13px;">
            </div>

            <div class="mb-3">
                <input type="password" id="register-confirm" placeholder="Nhập lại mật khẩu" required class="form-control w-100" style="padding: 12px 18px; font-size: 13px;">
            </div>

            <div id="register-error-msg" class="text-danger small mb-3 text-center" style="display: none; font-weight: 600;"></div>

            <div class="mb-4 d-flex align-items-center gap-2" style="font-size: 12px; color: var(--text-secondary);">
                <input type="checkbox" id="terms" required style="width: auto; cursor: pointer;">
                <label for="terms" style="cursor: pointer;">Tôi đồng ý với các điều khoản dịch vụ.</label>
            </div>
            
            <button type="submit" class="w-100 btn-checkout mb-3" style="border: none; padding: 12px 0;">ĐĂNG KÝ TÀI KHOẢN</button>
            
            <div class="text-center" style="font-size: 12px;">
                <span class="text-secondary">Đã có tài khoản? <a href="login.php" class="text-decoration-none" style="color: var(--accent-gold); font-weight: 700;">Đăng nhập ngay</a></span>
            </div>
        </form>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("register-form");
    const errorMsg = document.getElementById("register-error-msg");

    form.addEventListener("submit", function(e) {
        e.preventDefault();
        
        const fullname = document.getElementById("register-fullname").value.trim();
        const username = document.getElementById("register-username").value.trim();
        const email = document.getElementById("register-email").value.trim();
        const password = document.getElementById("register-password").value;
        const confirmPass = document.getElementById("register-confirm").value;

        // Validation
        if (password !== confirmPass) {
            errorMsg.textContent = "Mật khẩu nhập lại không khớp!";
            errorMsg.style.display = "block";
            return;
        }

        if (username.length < 3) {
            errorMsg.textContent = "Tên đăng nhập phải chứa ít nhất 3 ký tự!";
            errorMsg.style.display = "block";
            return;
        }

        errorMsg.style.display = "none";

        // Gửi thông tin đăng ký lên server
        fetch("register_process.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                fullname: fullname,
                username: username,
                email: email,
                password: password
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = "login.php";
            } else {
                errorMsg.textContent = data.message;
                errorMsg.style.display = "block";
            }
        })
        .catch(error => {
            console.error("Error:", error);
            errorMsg.textContent = "Không thể kết nối đến máy chủ!";
            errorMsg.style.display = "block";
        });
    });
});
</script>

<?php include("../includes/footer.php"); ?>
