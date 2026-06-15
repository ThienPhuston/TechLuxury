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
    const btnSuccessClose = document.getElementById("btn-success-close");

    if (btnPlaceOrder) {
        btnPlaceOrder.addEventListener("click", function () {
            // Kiểm tra tính hợp lệ của biểu mẫu thông tin nhận hàng
            const name = document.getElementById("checkout-name").value.trim();
            const phone = document.getElementById("checkout-phone").value.trim();
            const address = document.getElementById("checkout-address").value.trim();
            const city = document.getElementById("checkout-city").value.trim();

            if (!name || !phone || !address || !city) {
                alert("Vui lòng điền đầy đủ các thông tin nhận hàng bắt buộc!");
                return;
            }

            // Tạo ngẫu nhiên một mã đơn hàng sang trọng
            const randomOrderId = "TL-" + Math.floor(1000 + Math.random() * 9000);
            const orderIdDisplay = document.getElementById("order-id-display");
            if (orderIdDisplay) {
                orderIdDisplay.textContent = "#" + randomOrderId;
            }

            // Hiển thị modal đặt hàng thành công
            if (orderSuccessModal && orderSuccessOverlay) {
                orderSuccessModal.classList.add("active");
                orderSuccessOverlay.classList.add("active");
                document.body.style.overflow = "hidden";
            }

            // Làm trống giỏ hàng local
            localStorage.removeItem("techluxury_cart");
        });
    }

    // Nút đóng modal thành công để về trang chủ
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
});
