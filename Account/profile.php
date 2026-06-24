<?php
$path_prefix = "../";
include("../includes/header.php");

// Block if not logged in
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Vui lòng đăng nhập để xem hồ sơ!'); window.location.href='login.php';</script>";
    exit();
}

require_once '../includes/db.php';
$user_id = $_SESSION['user']['id'];

// Fetch fresh user data from DB
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    $user = $_SESSION['user'];
}

$success_msg = '';
$error_msg   = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_info') {
        $fullname = trim($_POST['fullname'] ?? '');
        $email    = trim($_POST['email']    ?? '');
        $phone    = trim($_POST['phone']    ?? '');

        if (empty($fullname) || empty($email)) {
            $error_msg = 'Họ tên và email không được để trống!';
        } else {
            try {
                // Check email conflict
                $chk = $conn->prepare("SELECT id FROM users WHERE email = :email AND id != :id LIMIT 1");
                $chk->execute(['email' => $email, 'id' => $user_id]);
                if ($chk->fetch()) {
                    $error_msg = 'Email đã được sử dụng bởi tài khoản khác!';
                } else {
                    $upd = $conn->prepare("UPDATE users SET fullname=:fullname, email=:email, phone=:phone WHERE id=:id");
                    $upd->execute(['fullname' => $fullname, 'email' => $email, 'phone' => $phone, 'id' => $user_id]);
                    // Update session
                    $_SESSION['user']['fullname'] = $fullname;
                    $_SESSION['user']['email']    = $email;
                    // Re-fetch
                    $stmt2 = $conn->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
                    $stmt2->execute(['id' => $user_id]);
                    $user = $stmt2->fetch();
                    $success_msg = 'Cập nhật thông tin thành công!';
                }
            } catch (PDOException $e) {
                $error_msg = 'Lỗi cập nhật: ' . $e->getMessage();
            }
        }
    } elseif ($action === 'change_password') {
        $old_pw  = $_POST['old_password']  ?? '';
        $new_pw  = $_POST['new_password']  ?? '';
        $conf_pw = $_POST['confirm_password'] ?? '';

        if (empty($old_pw) || empty($new_pw) || empty($conf_pw)) {
            $error_msg = 'Vui lòng điền đầy đủ các trường mật khẩu!';
        } elseif ($new_pw !== $conf_pw) {
            $error_msg = 'Mật khẩu xác nhận không khớp!';
        } elseif (strlen($new_pw) < 6) {
            $error_msg = 'Mật khẩu mới phải có ít nhất 6 ký tự!';
        } elseif (!password_verify($old_pw, $user['password'])) {
            $error_msg = 'Mật khẩu hiện tại không đúng!';
        } else {
            try {
                $hashed = password_hash($new_pw, PASSWORD_DEFAULT);
                $conn->prepare("UPDATE users SET password=:pw WHERE id=:id")->execute(['pw' => $hashed, 'id' => $user_id]);
                $success_msg = 'Đổi mật khẩu thành công!';
            } catch (PDOException $e) {
                $error_msg = 'Lỗi đổi mật khẩu: ' . $e->getMessage();
            }
        }
    }
}

// Auto-add phone column if missing
try { $conn->exec("ALTER TABLE users ADD COLUMN phone VARCHAR(20) DEFAULT NULL"); } catch(Exception $e) {}

// Count orders
try {
    $order_count = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_id = :id");
    $order_count->execute(['id' => $user_id]);
    $total_orders = $order_count->fetchColumn();

    $spent_stmt = $conn->prepare("SELECT SUM(total_amount) FROM orders WHERE user_id = :id AND status != 'Đã hủy'");
    $spent_stmt->execute(['id' => $user_id]);
    $total_spent = $spent_stmt->fetchColumn() ?: 0;
} catch (PDOException $e) {
    $total_orders = 0;
    $total_spent  = 0;
}
?>

<section class="profile-section" style="background: #090c13; min-height: 85vh; padding: 60px 0; color: white;">
    <div class="container" style="max-width: 1000px;">

        <!-- Page Title -->
        <div class="d-flex align-items-center gap-3 mb-5">
            <a href="../index.php" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2"
               style="border-radius: 8px; padding: 8px 16px; border-color: rgba(255,255,255,0.08); color: #ccc; background: rgba(255,255,255,0.02);">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <h1 class="m-0" style="font-weight: 800; font-size: 28px; background: linear-gradient(135deg,#fff 0%,#aaa 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
                HỒ SƠ TÀI KHOẢN
            </h1>
        </div>

        <!-- Alert Messages -->
        <?php if ($success_msg): ?>
        <div class="alert d-flex align-items-center gap-3 mb-4" style="background:rgba(46,204,113,0.08);border:1px solid rgba(46,204,113,0.25);border-radius:12px;color:#2ecc71;padding:16px 20px;">
            <i class="fas fa-check-circle"></i> <span><?php echo htmlspecialchars($success_msg); ?></span>
        </div>
        <?php elseif ($error_msg): ?>
        <div class="alert d-flex align-items-center gap-3 mb-4" style="background:rgba(255,71,87,0.08);border:1px solid rgba(255,71,87,0.25);border-radius:12px;color:#ff4757;padding:16px 20px;">
            <i class="fas fa-exclamation-triangle"></i> <span><?php echo htmlspecialchars($error_msg); ?></span>
        </div>
        <?php endif; ?>

        <div class="row g-4">

            <!-- LEFT: Avatar + Stats Card -->
            <div class="col-lg-4">
                <!-- Avatar Card -->
                <div class="p-4 rounded-4 mb-4 text-center" style="background:rgba(15,19,28,0.6);border:1px solid rgba(255,255,255,0.05);backdrop-filter:blur(12px);">
                    <div class="avatar-circle mx-auto mb-3" style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,rgba(212,175,55,0.2),rgba(212,175,55,0.05));border:2px solid rgba(212,175,55,0.3);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:var(--accent-gold,#d4af37);">
                        <?php echo mb_strtoupper(mb_substr($user['fullname'], 0, 1)); ?>
                    </div>
                    <h3 style="font-size:18px;font-weight:700;margin-bottom:4px;"><?php echo htmlspecialchars($user['fullname']); ?></h3>
                    <p class="text-secondary mb-1" style="font-size:13px;">@<?php echo htmlspecialchars($user['username']); ?></p>
                    <span class="badge" style="background:rgba(212,175,55,0.1);color:#d4af37;border:1px solid rgba(212,175,55,0.2);padding:5px 12px;border-radius:20px;font-size:11px;font-weight:600;">
                        <?php echo $user['role'] === 'admin' ? '⚡ ADMIN' : '✦ SMEMBER'; ?>
                    </span>
                    <div class="mt-3 text-secondary" style="font-size:12px;">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Thành viên từ <?php echo date('m/Y', strtotime($user['created_at'] ?? 'now')); ?>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="d-flex gap-3">
                    <div class="flex-fill p-3 rounded-4 text-center" style="background:rgba(15,19,28,0.6);border:1px solid rgba(255,255,255,0.05);">
                        <div style="font-size:22px;font-weight:800;color:#d4af37;"><?php echo $total_orders; ?></div>
                        <div class="text-secondary" style="font-size:11px;">Đơn hàng</div>
                    </div>
                    <div class="flex-fill p-3 rounded-4 text-center" style="background:rgba(15,19,28,0.6);border:1px solid rgba(255,255,255,0.05);">
                        <div style="font-size:14px;font-weight:800;color:#2ecc71;"><?php echo number_format($total_spent/1000000, 1); ?>M</div>
                        <div class="text-secondary" style="font-size:11px;">Đã chi tiêu</div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="mt-4 p-4 rounded-4" style="background:rgba(15,19,28,0.6);border:1px solid rgba(255,255,255,0.05);">
                    <h6 style="font-size:12px;font-weight:700;letter-spacing:1px;color:#888;text-transform:uppercase;margin-bottom:14px;">Liên kết nhanh</h6>
                    <a href="../page/order_history.php" class="d-flex align-items-center gap-3 py-2 text-decoration-none" style="color:#ccc;border-bottom:1px solid rgba(255,255,255,0.04);font-size:14px;transition:color 0.2s;"
                       onmouseover="this.style.color='#d4af37'" onmouseout="this.style.color='#ccc'">
                        <i class="fas fa-receipt" style="color:#d4af37;width:18px;text-align:center;"></i> Lịch sử đơn hàng
                        <i class="fas fa-chevron-right ms-auto" style="font-size:10px;opacity:0.4;"></i>
                    </a>
                    <a href="../page/wishlist.php" class="d-flex align-items-center gap-3 py-2 text-decoration-none" style="color:#ccc;border-bottom:1px solid rgba(255,255,255,0.04);font-size:14px;transition:color 0.2s;"
                       onmouseover="this.style.color='#d4af37'" onmouseout="this.style.color='#ccc'">
                        <i class="fas fa-heart" style="color:#ff4757;width:18px;text-align:center;"></i> Sản phẩm yêu thích
                        <i class="fas fa-chevron-right ms-auto" style="font-size:10px;opacity:0.4;"></i>
                    </a>
                    <a href="../page/product.php" class="d-flex align-items-center gap-3 py-2 text-decoration-none" style="color:#ccc;font-size:14px;transition:color 0.2s;"
                       onmouseover="this.style.color='#d4af37'" onmouseout="this.style.color='#ccc'">
                        <i class="fas fa-shopping-bag" style="color:#667eea;width:18px;text-align:center;"></i> Tiếp tục mua sắm
                        <i class="fas fa-chevron-right ms-auto" style="font-size:10px;opacity:0.4;"></i>
                    </a>
                </div>
            </div>

            <!-- RIGHT: Forms -->
            <div class="col-lg-8">

                <!-- Tab Nav -->
                <div class="d-flex gap-2 mb-4" id="profile-tabs">
                    <button class="profile-tab-btn active" data-tab="info" onclick="switchTab('info', this)"
                        style="padding:10px 22px;border-radius:10px;border:1px solid rgba(212,175,55,0.3);background:rgba(212,175,55,0.08);color:#d4af37;font-weight:700;font-size:13px;cursor:pointer;transition:all 0.2s;">
                        <i class="fas fa-user me-2"></i>Thông tin
                    </button>
                    <button class="profile-tab-btn" data-tab="password" onclick="switchTab('password', this)"
                        style="padding:10px 22px;border-radius:10px;border:1px solid rgba(255,255,255,0.06);background:transparent;color:#888;font-weight:700;font-size:13px;cursor:pointer;transition:all 0.2s;">
                        <i class="fas fa-lock me-2"></i>Bảo mật
                    </button>
                </div>

                <!-- Info Tab -->
                <div id="tab-info" class="profile-tab-content">
                    <div class="p-4 p-md-5 rounded-4" style="background:rgba(15,19,28,0.6);border:1px solid rgba(255,255,255,0.05);backdrop-filter:blur(12px);">
                        <h4 style="font-size:16px;font-weight:700;margin-bottom:24px;">Thông tin cá nhân</h4>
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="update_info">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label text-secondary" style="font-size:12px;font-weight:600;letter-spacing:0.5px;">HỌ VÀ TÊN *</label>
                                    <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>"
                                        class="form-control" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:white;border-radius:10px;padding:12px 16px;font-size:14px;" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-secondary" style="font-size:12px;font-weight:600;letter-spacing:0.5px;">TÊN ĐĂNG NHẬP</label>
                                    <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>"
                                        class="form-control" style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.04);color:#666;border-radius:10px;padding:12px 16px;font-size:14px;" readonly disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-secondary" style="font-size:12px;font-weight:600;letter-spacing:0.5px;">EMAIL *</label>
                                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                                        class="form-control" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:white;border-radius:10px;padding:12px 16px;font-size:14px;" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-secondary" style="font-size:12px;font-weight:600;letter-spacing:0.5px;">SỐ ĐIỆN THOẠI</label>
                                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
                                        class="form-control" placeholder="0912 345 678"
                                        style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:white;border-radius:10px;padding:12px 16px;font-size:14px;">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn px-5 py-3 fw-bold" 
                                        style="background:linear-gradient(135deg,#d4af37,#b8962e);color:#000;border:none;border-radius:10px;font-size:13px;letter-spacing:0.5px;transition:all 0.3s;"
                                        onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(212,175,55,0.3)'"
                                        onmouseout="this.style.transform='';this.style.boxShadow=''">
                                        <i class="fas fa-save me-2"></i>LƯU THAY ĐỔI
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Tab -->
                <div id="tab-password" class="profile-tab-content" style="display:none;">
                    <div class="p-4 p-md-5 rounded-4" style="background:rgba(15,19,28,0.6);border:1px solid rgba(255,255,255,0.05);backdrop-filter:blur(12px);">
                        <h4 style="font-size:16px;font-weight:700;margin-bottom:8px;">Đổi mật khẩu</h4>
                        <p class="text-secondary mb-4" style="font-size:13px;">Mật khẩu mới phải có ít nhất 6 ký tự. Sau khi đổi, bạn cần đăng nhập lại.</p>
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="change_password">
                            <div class="d-flex flex-column gap-4">
                                <div>
                                    <label class="form-label text-secondary" style="font-size:12px;font-weight:600;letter-spacing:0.5px;">MẬT KHẨU HIỆN TẠI *</label>
                                    <input type="password" name="old_password"
                                        class="form-control" placeholder="••••••••"
                                        style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:white;border-radius:10px;padding:12px 16px;font-size:14px;" required>
                                </div>
                                <div>
                                    <label class="form-label text-secondary" style="font-size:12px;font-weight:600;letter-spacing:0.5px;">MẬT KHẨU MỚI *</label>
                                    <input type="password" name="new_password" id="new_pw"
                                        class="form-control" placeholder="••••••••"
                                        style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:white;border-radius:10px;padding:12px 16px;font-size:14px;" required>
                                </div>
                                <div>
                                    <label class="form-label text-secondary" style="font-size:12px;font-weight:600;letter-spacing:0.5px;">XÁC NHẬN MẬT KHẨU MỚI *</label>
                                    <input type="password" name="confirm_password" id="conf_pw"
                                        class="form-control" placeholder="••••••••"
                                        style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:white;border-radius:10px;padding:12px 16px;font-size:14px;" required>
                                </div>
                                <!-- Password strength indicator -->
                                <div id="pw-strength-bar" style="height:4px;border-radius:4px;background:rgba(255,255,255,0.05);overflow:hidden;display:none;">
                                    <div id="pw-strength-fill" style="height:100%;width:0%;transition:width 0.3s,background 0.3s;border-radius:4px;"></div>
                                </div>
                                <div>
                                    <button type="submit" class="btn px-5 py-3 fw-bold"
                                        style="background:linear-gradient(135deg,#667eea,#764ba2);color:white;border:none;border-radius:10px;font-size:13px;letter-spacing:0.5px;transition:all 0.3s;"
                                        onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(102,126,234,0.3)'"
                                        onmouseout="this.style.transform='';this.style.boxShadow=''">
                                        <i class="fas fa-lock me-2"></i>ĐỔI MẬT KHẨU
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
.form-control:focus {
    background: rgba(255,255,255,0.06) !important;
    border-color: rgba(212,175,55,0.4) !important;
    box-shadow: 0 0 0 3px rgba(212,175,55,0.1) !important;
    color: white !important;
}
.profile-tab-btn.active {
    border-color: rgba(212,175,55,0.3) !important;
    background: rgba(212,175,55,0.08) !important;
    color: #d4af37 !important;
}
</style>

<script>
function switchTab(tab, btn) {
    document.querySelectorAll('.profile-tab-content').forEach(el => el.style.display = 'none');
    document.getElementById('tab-' + tab).style.display = 'block';
    document.querySelectorAll('.profile-tab-btn').forEach(b => {
        b.classList.remove('active');
        b.style.borderColor = 'rgba(255,255,255,0.06)';
        b.style.background  = 'transparent';
        b.style.color       = '#888';
    });
    btn.classList.add('active');
    btn.style.borderColor = 'rgba(212,175,55,0.3)';
    btn.style.background  = 'rgba(212,175,55,0.08)';
    btn.style.color       = '#d4af37';
}

// Show password strength bar
const newPw = document.getElementById('new_pw');
if (newPw) {
    newPw.addEventListener('input', function() {
        const bar = document.getElementById('pw-strength-bar');
        const fill = document.getElementById('pw-strength-fill');
        const val = this.value;
        bar.style.display = 'block';
        let strength = 0;
        if (val.length >= 6) strength++;
        if (val.length >= 10) strength++;
        if (/[A-Z]/.test(val)) strength++;
        if (/[0-9]/.test(val)) strength++;
        if (/[^A-Za-z0-9]/.test(val)) strength++;
        const colors = ['#ff4757','#ff6b35','#ffa502','#2ecc71','#1abc9c'];
        fill.style.width  = (strength * 20) + '%';
        fill.style.background = colors[strength - 1] || '#ff4757';
    });
}

// Open password tab if error came from password action
<?php if (!empty($error_msg) && isset($_POST['action']) && $_POST['action'] === 'change_password'): ?>
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('password', document.querySelector('[data-tab="password"]'));
    });
<?php endif; ?>
</script>

<?php include("../includes/footer.php"); ?>
