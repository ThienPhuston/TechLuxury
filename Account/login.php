<?php 
$path_prefix = "../"; 
include("../includes/header.php"); 
?>

<section class="login d-flex align-items-center justify-content-center" style="min-height: 70vh; padding: 40px 20px;">
    <div class="w-100" style="max-width: 420px;">
        <form id="login-form" action="javascript:void(0)" class="w-100 shadow-lg" style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 45px 35px; border-radius: 20px;">
            <div class="text-center mb-4">
                <span class="d-inline-block p-3 rounded-circle mb-3" style="background: rgba(212,175,55,0.1); color: var(--accent-gold); width: 60px; height: 60px;">
                    <i class="fas fa-lock" style="font-size: 24px;"></i>
                </span>
                <h2 class="text-white m-0" style="font-size: 24px; font-weight: 800;">ĐĂNG NHẬP</h2>
                <p class="text-secondary mt-2 mb-0" style="font-size: 13px;">Chào mừng bạn quay trở lại với TechLuxury</p>
            </div>
            
            <div class="mb-3">
                <input type="text" id="login-username" placeholder="Tên đăng nhập hoặc Email" required class="form-control w-100" style="padding: 12px 18px; font-size: 13px;">
            </div>
            
            <div class="mb-3">
                <input type="password" id="login-password" placeholder="Mật khẩu" required class="form-control w-100" style="padding: 12px 18px; font-size: 13px;">
            </div>

            <div id="login-error-msg" class="text-danger small mb-3 text-center" style="display: none; font-weight: 600;"></div>

            <div class="mb-3 d-flex align-items-center gap-2">
                <input type="checkbox" id="login-remember" style="width: auto; cursor: pointer;">
                <label for="login-remember" class="text-secondary small" style="cursor: pointer; font-size: 12px; user-select: none;">Ghi nhớ đăng nhập</label>
            </div>
            
            <button type="submit" class="w-100 btn-checkout mb-3" style="border: none; padding: 12px 0;">ĐĂNG NHẬP</button>
            
            <div class="d-flex justify-content-between align-items-center" style="font-size: 12px;">
                <a href="forgot-password.php" class="text-decoration-none" style="color: var(--accent-gold);">Quên mật khẩu?</a>
                <span class="text-secondary">Chưa có tài khoản? <a href="register.php" class="text-decoration-none" style="color: var(--accent-gold); font-weight: 700;">Đăng ký</a></span>
            </div>
        </form>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("login-form");
    const errorMsg = document.getElementById("login-error-msg");

    form.addEventListener("submit", function(e) {
        e.preventDefault();
        
        const usernameInput = document.getElementById("login-username").value.trim();
        const passwordInput = document.getElementById("login-password").value;

        errorMsg.style.display = "none";

        // Gửi thông tin đăng nhập lên server
        fetch("login_process.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                username: usernameInput,
                password: passwordInput
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Lưu trạng thái ghi nhớ đăng nhập
                const remember = document.getElementById("login-remember").checked;
                localStorage.setItem("remember_me", remember ? "true" : "false");
                sessionStorage.setItem("session_active", "true");

                // Lưu vào localStorage để đồng bộ với phía client
                localStorage.setItem("logged_in_user", JSON.stringify(data.user));
                alert("Đăng nhập thành công! Chào mừng " + data.user.fullname);
                
                // Chuyển hướng về trang chủ
                window.location.href = "../index.php";
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