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

    // Coupon states and handlers (declared here to avoid TDZ)
    let appliedCoupon = null;
    let subtotalAmount = 0;

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
                <div class="checkout-item-summary" data-item-title="${item.title}">
                    <img src="${displayImg}" alt="${item.title}">
                    <div class="checkout-item-summary-info">
                        <h5>${item.title}</h5>
                        <p>Số lượng: ${item.quantity}</p>
                        
                        <!-- Shipping Selector for each item -->
                        <div class="checkout-item-shipping-select mt-2" style="display: none;">
                            <label class="text-secondary small fw-bold" style="font-size: 10px; display: block; margin-bottom: 4px;">GIAO ĐẾN ĐỊA CHỈ:</label>
                            <select class="form-select form-select-sm select-item-dest" data-item-title="${item.title}" style="background: #0f131c; border-color: rgba(255,255,255,0.08); color: white; font-size: 11px; padding: 4px 8px; border-radius: 6px; width: 100%;">
                                <option value="1">Địa chỉ nhận hàng 1</option>
                                <option value="2">Địa chỉ nhận hàng 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="checkout-item-summary-price">${formatVND(item.price * item.quantity)}</div>
                </div>
            `;
            orderItemsContainer.insertAdjacentHTML("beforeend", itemHTML);
        });

        if (subtotalText) subtotalText.textContent = formatVND(totalAmount);
        if (grandTotalText) grandTotalText.textContent = formatVND(totalAmount);
        subtotalAmount = totalAmount;
    }

    // Coupon states and handlers

    const btnApplyCoupon = document.getElementById("btn-apply-coupon");
    const couponInput = document.getElementById("coupon-code-input");
    const couponMessage = document.getElementById("coupon-message");
    const discountRow = document.getElementById("discount-row");
    const discountText = document.getElementById("checkout-discount");

    if (btnApplyCoupon && couponInput) {
        btnApplyCoupon.addEventListener("click", function() {
            const code = couponInput.value.trim().toUpperCase();
            if (!code) {
                showCouponMessage("Vui lòng nhập mã giảm giá!", "text-danger");
                return;
            }

            fetch("validate_coupon.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    coupon_code: code,
                    subtotal: subtotalAmount
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    appliedCoupon = {
                        code: data.code,
                        discount: parseFloat(data.discount_amount)
                    };
                    
                    if (discountRow) discountRow.style.display = "flex";
                    if (discountText) discountText.textContent = "-" + formatVND(appliedCoupon.discount);
                    
                    const newGrandTotal = subtotalAmount - appliedCoupon.discount;
                    if (grandTotalText) grandTotalText.textContent = formatVND(newGrandTotal);
                    
                    showCouponMessage(data.message, "text-success");
                } else {
                    appliedCoupon = null;
                    if (discountRow) discountRow.style.display = "none";
                    if (grandTotalText) grandTotalText.textContent = formatVND(subtotalAmount);
                    showCouponMessage(data.message, "text-danger");
                }
            })
            .catch(err => {
                console.error("Coupon validation error:", err);
                showCouponMessage("Không thể kiểm tra mã giảm giá lúc này!", "text-danger");
            });
        });
    }

    function showCouponMessage(text, className) {
        if (couponMessage) {
            couponMessage.textContent = text;
            couponMessage.style.display = "block";
            couponMessage.className = "small mt-2 " + className;
        }
    }

    // Toggle split shipping UI
    const splitShippingToggle = document.getElementById("split-shipping-toggle");
    const address2Panel = document.getElementById("address-2-panel");
    const address1Title = document.getElementById("address-1-title");

    if (splitShippingToggle) {
        splitShippingToggle.addEventListener("change", function() {
            const isSplit = this.checked;
            
            // Show/hide Address 2 panel
            if (address2Panel) {
                address2Panel.style.display = isSplit ? "block" : "none";
            }
            
            // Toggle Address 1 Title
            if (address1Title) {
                address1Title.innerHTML = isSplit 
                    ? `<i class="fas fa-shipping-fast text-warning me-2"></i> THÔNG TIN NHẬN HÀNG (ĐỊA CHỈ 1)`
                    : `<i class="fas fa-shipping-fast text-warning me-2"></i> THÔNG TIN NHẬN HÀNG`;
            }
            
            // Toggle destination dropdowns in cart summary
            document.querySelectorAll(".checkout-item-shipping-select").forEach(el => {
                el.style.display = isSplit ? "block" : "none";
            });
        });
    }

    // Xử lý nút đặt hàng
    const btnPlaceOrder = document.getElementById("btn-place-order");
    const orderSuccessModal = document.getElementById("order-success-modal");
    const orderSuccessOverlay = document.getElementById("order-success-overlay");

    if (btnPlaceOrder) {
        btnPlaceOrder.addEventListener("click", function () {
            const isSplit = splitShippingToggle ? splitShippingToggle.checked : false;
            
            // Address 1 Details
            const name1 = document.getElementById("checkout-name").value.trim();
            const phone1 = document.getElementById("checkout-phone").value.trim();
            const address1 = document.getElementById("checkout-address").value.trim();
            const city1 = document.getElementById("checkout-city").value.trim();
            const notes1 = document.getElementById("checkout-notes").value.trim();

            if (!name1 || !phone1 || !address1 || !city1) {
                alert("Vui lòng điền đầy đủ các thông tin nhận hàng bắt buộc của Địa chỉ 1!");
                return;
            }

            let name2 = "", phone2 = "", address2 = "", city2 = "", notes2 = "";
            
            if (isSplit) {
                // Address 2 Details
                name2 = document.getElementById("checkout-name-2").value.trim();
                phone2 = document.getElementById("checkout-phone-2").value.trim();
                address2 = document.getElementById("checkout-address-2").value.trim();
                city2 = document.getElementById("checkout-city-2").value.trim();
                notes2 = document.getElementById("checkout-notes-2").value.trim();

                if (!name2 || !phone2 || !address2 || !city2) {
                    alert("Vui lòng điền đầy đủ các thông tin nhận hàng bắt buộc của Địa chỉ 2!");
                    return;
                }
            }

            const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value || 'cod';

            if (!isSplit) {
                // Đơn hàng bình thường (1 địa chỉ)
                const totalAmount = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
                const finalAmount = appliedCoupon ? (totalAmount - appliedCoupon.discount) : totalAmount;
                
                fetch("place_order.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        customer_name: name1,
                        phone: phone1,
                        address: `${address1}, ${city1}`,
                        notes: notes1,
                        payment_method: paymentMethod,
                        cart: cart,
                        coupon_code: appliedCoupon ? appliedCoupon.code : "",
                        discount_amount: appliedCoupon ? appliedCoupon.discount : 0
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const newOrder = {
                            orderId: data.orderId,
                            customerName: name1,
                            phone: phone1,
                            address: `${address1}, ${city1}`,
                            notes: notes1,
                            paymentMethod: paymentMethod,
                            subtotal: totalAmount,
                            grandTotal: finalAmount
                        };
                        showPaymentInterface(newOrder, finalAmount);
                    } else {
                        alert("Đặt hàng thất bại: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Không thể kết nối đến máy chủ để tạo đơn hàng!");
                });
            } else {
                // Tách thành 2 đơn hàng khác nhau
                const cart1 = [];
                const cart2 = [];
                
                document.querySelectorAll(".select-item-dest").forEach(select => {
                    const title = select.getAttribute("data-item-title");
                    const dest = select.value;
                    const item = cart.find(i => i.title === title);
                    if (item) {
                        if (dest === "1") {
                            cart1.push(item);
                        } else {
                            cart2.push(item);
                        }
                    }
                });

                if (cart1.length === 0) {
                    alert("Vui lòng gán ít nhất 1 sản phẩm cho Địa chỉ 1!");
                    return;
                }
                if (cart2.length === 0) {
                    alert("Vui lòng gán ít nhất 1 sản phẩm cho Địa chỉ 2!");
                    return;
                }

                const totalAmount1 = cart1.reduce((sum, item) => sum + item.price * item.quantity, 0);
                const totalAmount2 = cart2.reduce((sum, item) => sum + item.price * item.quantity, 0);
                const combinedTotal = totalAmount1 + totalAmount2;

                let discount1 = 0;
                let discount2 = 0;
                let code1 = "";
                let code2 = "";

                if (appliedCoupon) {
                    discount1 = appliedCoupon.discount;
                    code1 = appliedCoupon.code;
                }

                const finalCombinedTotal = combinedTotal - (discount1 + discount2);

                // Sequential order submission to prevent transaction issues
                fetch("place_order.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        customer_name: name1,
                        phone: phone1,
                        address: `${address1}, ${city1}`,
                        notes: notes1 + " (Đơn tách 1)",
                        payment_method: paymentMethod,
                        cart: cart1,
                        coupon_code: code1,
                        discount_amount: discount1
                    })
                })
                .then(r1 => r1.json())
                .then(data1 => {
                    if (!data1.success) {
                        alert("Đặt đơn hàng 1 thất bại: " + data1.message);
                        return;
                    }
                    
                    // Đơn 1 thành công, đặt tiếp đơn 2
                    fetch("place_order.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            customer_name: name2,
                            phone: phone2,
                            address: `${address2}, ${city2}`,
                            notes: notes2 + " (Đơn tách 2)",
                            payment_method: paymentMethod,
                            cart: cart2,
                            coupon_code: code2,
                            discount_amount: discount2
                        })
                    })
                    .then(r2 => r2.json())
                    .then(data2 => {
                        if (!data2.success) {
                            alert("Đặt đơn hàng 2 thất bại (Đơn 1 đã tạo #" + data1.orderId + "): " + data2.message);
                            return;
                        }
                        
                        // Cả 2 đơn thành công!
                        const combinedOrder = {
                            isSplit: true,
                            orderId: `${data1.orderId} & ${data2.orderId}`,
                            customerName: `${name1} / ${name2}`,
                            phone: `${phone1} / ${phone2}`,
                            address: `ĐC1: ${address1}, ${city1} | ĐC2: ${address2}, ${city2}`,
                            notes: `Đơn 1: ${notes1} | Đơn 2: ${notes2}`,
                            paymentMethod: paymentMethod,
                            subtotal: combinedTotal,
                            grandTotal: finalCombinedTotal
                        };
                        showPaymentInterface(combinedOrder, finalCombinedTotal);
                    })
                    .catch(err => {
                        console.error("Error order 2:", err);
                        alert("Không thể kết nối đến máy chủ để tạo đơn hàng 2!");
                    });
                })
                .catch(err => {
                    console.error("Error order 1:", err);
                    alert("Không thể kết nối đến máy chủ để tạo đơn hàng 1!");
                });
            }
        });
    }

    function showPaymentInterface(order, totalAmount) {
        if (!orderSuccessModal || !orderSuccessOverlay) return;

        // Kích hoạt overlay
        orderSuccessModal.classList.add("active");
        orderSuccessOverlay.classList.add("active");
        document.body.style.overflow = "hidden";

        if (order.paymentMethod === "cod") {
            renderCODSuccess(order);
        } else if (order.paymentMethod === "bank") {
            renderQRBankTransfer(order, totalAmount);
        } else if (order.paymentMethod === "card") {
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
                    Chúng tôi sẽ liên hệ để xác nhận đơn hàng và giao hàng trong thời gian sớm nhất.
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
            // Cập nhật trạng thái
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

        // Format credit card number and expiry inputs
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

            // Display loading processing modal
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
                // Update statuses
                updateOrderStatus(order.orderId, "Đã thanh toán");

                // Render success
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
        // Hỗ trợ cập nhật nhiều đơn cùng lúc khi tách đơn (phân cách bằng " & ")
        const orderIds = orderId.toString().split(" & ");
        orderIds.forEach(id => {
            fetch("update_order_status.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    order_code: id.trim(),
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error("Cập nhật trạng thái đơn hàng thất bại cho #" + id + ":", data.message);
                }
            })
            .catch(err => console.error("Error updating order status:", err));
        });
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
