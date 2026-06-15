// JavaScript code for TECHLUXURY Checkout Page

document.addEventListener("DOMContentLoaded", function () {
    const cart = JSON.parse(localStorage.getItem("techluxury_cart")) || [];
    
    // Nếu giỏ hàng trống, tự động quay về trang chủ
    if (cart.length === 0 && !window.location.hash.includes("success")) {
        alert("Giỏ hàng của bạn đang trống! Bạn sẽ được chuyển hướng về trang chủ.");
        window.location.href = "../index.php";
        return;
    }

    function formatVND(amount) {
        return amount.toLocaleString("vi-VN") + "đ";
    }

    // Render danh sách sản phẩm tóm tắt
    const orderItemsContainer = document.getElementById("checkout-order-items");
    const subtotalText = document.getElementById("checkout-subtotal");
    const grandTotalText = document.getElementById("checkout-grand-total");

    if (orderItemsContainer) {
        orderItemsContainer.innerHTML = "";
        let totalAmount = 0;

        cart.forEach(item => {
            totalAmount += item.price * item.quantity;
            // Prepend relative path prefix for images
            const displayImg = "../" + item.img;
            
            const itemHTML = `
                <div class="checkout-item-summary">
                    <img src="${displayImg}" alt="${item.title}">
                    <div class="checkout-item-summary-info">
                        <h5>${item.title}</h5>
                        <p>Số lượng: ${item.quantity}</p>
                    </div>
                    <div class="checkout-item-summary-price">${formatVND(item.price * item.quantity)}</div>
                </div>
            `;
            orderItemsContainer.insertAdjacentHTML("beforeend", itemHTML);
        });

        if (subtotalText) subtotalText.textContent = formatVND(totalAmount);
        if (grandTotalText) grandTotalText.textContent = formatVND(totalAmount);
    }

    // Xử lý nút đặt hàng
    const btnPlaceOrder = document.getElementById("btn-place-order");
    const orderSuccessModal = document.getElementById("order-success-modal");
    const orderSuccessOverlay = document.getElementById("order-success-overlay");

    // Lấy danh sách đơn hàng đã có hoặc khởi tạo mặc định
    let orders = JSON.parse(localStorage.getItem("techluxury_orders")) || [
        {
            orderId: "TL-8942",
            customerName: "Nguyễn Văn Hùng",
            phone: "0901234567",
            address: "123 Đường Lê Lợi, Quận 1, TP. Hồ Chí Minh",
            paymentMethod: "bank",
            items: [{ title: "iPhone 16 Pro Max (Desert Gold)", price: 35990000, quantity: 1, img: "images/ip16pm.webp" }],
            subtotal: 35990000,
            grandTotal: 35990000,
            date: "2026-06-15",
            status: "Đang xử lý"
        },
        {
            orderId: "TL-8712",
            customerName: "Trần Thị Thu Thủy",
            phone: "0987654321",
            address: "456 Đường Nguyễn Trãi, Quận 5, TP. Hồ Chí Minh",
            paymentMethod: "card",
            items: [{ title: "Macbook Pro M4 (Space Black)", price: 59990000, quantity: 1, img: "images/macbook-pro-14-inch-m4-pro-24gb-1tb-20gpu-bac-1-639104240462766154-750x500.jpg" }],
            subtotal: 59990000,
            grandTotal: 59990000,
            date: "2026-06-14",
            status: "Đã thanh toán"
        },
        {
            orderId: "TL-8629",
            customerName: "Lê Hoàng Nam",
            phone: "0912345678",
            address: "789 Đường Điện Biên Phủ, Bình Thạnh, TP. Hồ Chí Minh",
            paymentMethod: "cod",
            items: [{ title: "Galaxy Buds 3", price: 5990000, quantity: 1, img: "images/Galaxy bud3.webp" }],
            subtotal: 5990000,
            grandTotal: 5990000,
            date: "2026-06-13",
            status: "Đang giao hàng"
        }
    ];

    if (!localStorage.getItem("techluxury_orders")) {
        localStorage.setItem("techluxury_orders", JSON.stringify(orders));
    }

    if (btnPlaceOrder) {
        btnPlaceOrder.addEventListener("click", function () {
            // Kiểm tra tính hợp lệ của biểu mẫu thông tin nhận hàng
            const name = document.getElementById("checkout-name").value.trim();
            const phone = document.getElementById("checkout-phone").value.trim();
            const address = document.getElementById("checkout-address").value.trim();
            const city = document.getElementById("checkout-city").value.trim();
            const notes = document.getElementById("checkout-notes").value.trim();

            if (!name || !phone || !address || !city) {
                alert("Vui lòng điền đầy đủ các thông tin nhận hàng bắt buộc!");
                return;
            }

            const totalAmount = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value || 'cod';

            // Gửi dữ liệu đơn hàng lên backend PHP
            fetch("place_order.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    customer_name: name,
                    phone: phone,
                    address: `${address}, ${city}`,
                    notes: notes,
                    payment_method: paymentMethod,
                    cart: cart
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const newOrder = {
                        orderId: data.orderId,
                        customerName: name,
                        phone: phone,
                        address: `${address}, ${city}`,
                        notes: notes,
                        paymentMethod: paymentMethod,
                        items: [...cart],
                        subtotal: totalAmount,
                        grandTotal: totalAmount,
                        status: paymentMethod === 'cod' ? 'Đang xử lý' : 'Chờ thanh toán'
                    };
                    // Hiển thị giao diện thanh toán tương ứng
                    showPaymentInterface(newOrder, totalAmount);
                } else {
                    alert("Đặt hàng thất bại: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Không thể kết nối đến máy chủ để tạo đơn hàng!");
            });
        });
    }

    function showPaymentInterface(order, totalAmount) {
        if (!orderSuccessModal || !orderSuccessOverlay) return;

        // Kích hoạt overlay
        orderSuccessModal.classList.add("active");
        orderSuccessOverlay.classList.add("active");
        document.body.style.overflow = "hidden";

        if (order.paymentMethod === "cod") {
            // Giao diện COD thành công trực tiếp
            renderCODSuccess(order);
        } else if (order.paymentMethod === "bank") {
            // Giao diện chuyển khoản MB Bank kèm mã QR
            renderQRBankTransfer(order, totalAmount);
        } else if (order.paymentMethod === "card") {
            // Giao diện nhập thẻ Visa giả lập
            renderVisaCardPayment(order, totalAmount);
        }

        // Xóa giỏ hàng sau khi đã đặt hàng thành công
        localStorage.removeItem("techluxury_cart");
    }

    function renderCODSuccess(order) {
        orderSuccessModal.innerHTML = `
            <div class="specs-modal-content text-center p-5">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                    <i class="fas fa-check-circle" style="font-size: 48px;"></i>
                </div>
                <h2 class="text-white mb-3" style="font-weight: 800;">ĐẶT HÀNG THÀNH CÔNG!</h2>
                <p class="text-secondary mb-4" style="font-size: 13px; line-height: 1.6;">
                    Cảm ơn bạn đã lựa chọn TechLuxury. Mã đơn hàng của bạn là <strong class="text-white">#${order.orderId}</strong>.<br>
                    Phương thức thanh toán: <strong class="text-warning">COD (Nhận hàng thanh toán)</strong>.<br>
                    Chúng tôi sẽ liên hệ số điện thoại <strong class="text-white">${order.phone}</strong> để xác nhận đơn hàng và giao hàng trong thời gian sớm nhất.
                </p>
                <button class="btn-checkout w-100" id="btn-success-close">QUAY VỀ TRANG CHỦ</button>
            </div>
        `;
        bindCloseBtn();
    }

    function renderQRBankTransfer(order, totalAmount) {
        orderSuccessModal.innerHTML = `
            <div class="specs-modal-content text-center p-4" style="max-width: 500px;">
                <h3 class="text-white mb-3" style="font-weight: 800; font-size: 18px;">QUÉT MÃ QR THANH TOÁN</h3>
                <p class="text-secondary mb-3" style="font-size: 12px;">Đơn hàng: <strong class="text-white">#${order.orderId}</strong> | Số tiền: <strong class="text-warning">${formatVND(totalAmount)}</strong></p>
                
                <!-- QR Code Box -->
                <div class="qr-box p-3 mb-3" style="background: white; border-radius: 12px; display: inline-block;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=STC:TECHLUXURY:${totalAmount}:${order.orderId}" alt="VietQR" style="width: 180px; height: 180px;">
                </div>

                <div class="bank-details text-start mb-3 p-3" style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); border-radius: 10px; font-size: 12px;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Ngân hàng:</span>
                        <strong class="text-white">MB BANK (Quân Đội)</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Số tài khoản:</span>
                        <strong class="text-white">999988886666</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Chủ tài khoản:</span>
                        <strong class="text-white">CTY CỔ PHẦN TECHLUXURY</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Nội dung CK:</span>
                        <strong class="text-warning">${order.orderId}</strong>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 mb-3 text-warning justify-content-center" style="font-size: 12px;">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span>Đang chờ bạn thực hiện chuyển khoản...</span>
                </div>

                <button class="btn-checkout w-100 py-3" id="btn-confirm-bank-transfer" style="font-size: 13px;">TÔI ĐÃ CHUYỂN KHOẢN THÀNH CÔNG</button>
            </div>
        `;

        document.getElementById("btn-confirm-bank-transfer").addEventListener("click", function() {
            // Cập nhật trạng thái trong localStorage
            updateOrderStatus(order.orderId, "Đã thanh toán");

            // Hiển thị màn hình thành công
            renderSuccessState(order, "Cảm ơn quý khách đã hoàn tất chuyển khoản! Sản phẩm sẽ được chuẩn bị và bàn giao cho đơn vị vận chuyển sớm nhất.");
        });
    }

    function renderVisaCardPayment(order, totalAmount) {
        orderSuccessModal.innerHTML = `
            <div class="specs-modal-content text-start p-4" style="max-width: 450px;">
                <h3 class="text-white text-center mb-4" style="font-weight: 800; font-size: 18px;">CỔNG THANH TOÁN QUỐC TẾ</h3>
                <p class="text-secondary text-center mb-3" style="font-size: 12px;">Đơn hàng: <strong class="text-white">#${order.orderId}</strong> | Số tiền: <strong class="text-warning">${formatVND(totalAmount)}</strong></p>
                
                <form id="visa-payment-form" action="javascript:void(0)" class="w-100 p-0 m-0 bg-transparent border-0 d-flex flex-column gap-3" style="max-width: 100%;">
                    <div class="mb-2">
                        <label class="text-secondary small fw-bold mb-1" style="font-size: 10px;">TÊN CHỦ THẺ</label>
                        <input type="text" placeholder="NGUYEN VAN A" required class="form-control text-uppercase w-100" style="padding: 10px 14px; font-size: 12px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white;">
                    </div>
                    <div class="mb-2">
                        <label class="text-secondary small fw-bold mb-1" style="font-size: 10px;">SỐ THẺ (VISA/MASTER)</label>
                        <div class="position-relative">
                            <input type="text" placeholder="4111 2222 3333 4444" required maxlength="19" id="visa-card-number" class="form-control w-100" style="padding: 10px 14px; padding-right: 40px; font-size: 12px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white;">
                            <i class="fab fa-cc-visa position-absolute" style="right: 14px; top: 50%; transform: translateY(-50%); color: var(--accent-gold); font-size: 18px;"></i>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="text-secondary small fw-bold mb-1" style="font-size: 10px;">NGÀY HẾT HẠN</label>
                            <input type="text" placeholder="MM/YY" required maxlength="5" id="visa-expiry" class="form-control text-center w-100" style="padding: 10px 14px; font-size: 12px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white;">
                        </div>
                        <div class="col-6">
                            <label class="text-secondary small fw-bold mb-1" style="font-size: 10px;">MÃ CVV</label>
                            <input type="password" placeholder="***" required maxlength="3" class="form-control text-center w-100" style="padding: 10px 14px; font-size: 12px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: white;">
                        </div>
                    </div>
                    <button type="submit" class="w-100 btn-checkout py-3" style="font-size: 13px;">THANH TOÁN NGAY</button>
                </form>
            </div>
        `;

        // Định dạng thẻ Visa tự động khi nhập
        const cardInput = document.getElementById("visa-card-number");
        if (cardInput) {
            cardInput.addEventListener("input", function(e) {
                let v = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                let matches = v.match(/\d{4,16}/g);
                let match = matches && matches[0] || '';
                let parts = [];

                for (let i=0, len=match.length; i<len; i+=4) {
                    parts.push(match.substring(i, i+4));
                }

                if (parts.length > 0) {
                    e.target.value = parts.join(' ');
                } else {
                    e.target.value = v;
                }
            });
        }

        const expiryInput = document.getElementById("visa-expiry");
        if (expiryInput) {
            expiryInput.addEventListener("input", function(e) {
                let v = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                if (v.length >= 2) {
                    e.target.value = v.substring(0,2) + "/" + v.substring(2,4);
                } else {
                    e.target.value = v;
                }
            });
        }

        document.getElementById("visa-payment-form").addEventListener("submit", function(e) {
            e.preventDefault();

            // Hiển thị vòng xoay đang xử lý
            orderSuccessModal.innerHTML = `
                <div class="specs-modal-content text-center p-5">
                    <div class="spinner-border text-warning mb-4" role="status" style="width: 3rem; height: 3rem; border-width: 4px;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h4 class="text-white mb-2" style="font-weight: 700;">Đang xử lý giao dịch...</h4>
                    <p class="text-secondary mb-0" style="font-size: 12px;">Vui lòng không đóng cửa sổ này.</p>
                </div>
            `;

            setTimeout(function() {
                // Cập nhật trạng thái trong localStorage
                updateOrderStatus(order.orderId, "Đã thanh toán");

                // Hiển thị màn hình thành công
                renderSuccessState(order, "Thanh toán trực tuyến thành công! Giao dịch của bạn đã được xác nhận bảo mật. Cảm ơn quý khách!");
            }, 1800);
        });
    }

    function renderSuccessState(order, message) {
        orderSuccessModal.innerHTML = `
            <div class="specs-modal-content text-center p-5">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                    <i class="fas fa-check-circle" style="font-size: 48px;"></i>
                </div>
                <h2 class="text-white mb-3" style="font-weight: 800;">THANH TOÁN THÀNH CÔNG!</h2>
                <p class="text-secondary mb-4" style="font-size: 13px; line-height: 1.6;">
                    Mã đơn hàng của bạn là <strong class="text-white">#${order.orderId}</strong>.<br>
                    ${message}
                </p>
                <button class="btn-checkout w-100" id="btn-success-close">QUAY VỀ TRANG CHỦ</button>
            </div>
        `;
        bindCloseBtn();
    }

    function updateOrderStatus(orderId, newStatus) {
        fetch("update_order_status.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                order_code: orderId,
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error("Cập nhật trạng thái đơn hàng thất bại:", data.message);
            }
        })
        .catch(err => console.error("Error updating order status:", err));
    }

    function bindCloseBtn() {
        const btnSuccessClose = document.getElementById("btn-success-close");
        if (btnSuccessClose) {
            btnSuccessClose.addEventListener("click", function () {
                if (orderSuccessModal && orderSuccessOverlay) {
                    orderSuccessModal.classList.remove("active");
                    orderSuccessOverlay.classList.remove("active");
                    document.body.style.overflow = "";
                }
                window.location.href = "../index.php";
            });
        }
    }
});
