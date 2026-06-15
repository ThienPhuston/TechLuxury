// Global Cart and UI Logic for TECHLUXURY

document.addEventListener("DOMContentLoaded", function () {
    // Helper to determine if we are in a subfolder (case-insensitive)
    const checkIsSubpage = () => {
        const path = window.location.pathname.toLowerCase();
        return path.includes("/page/") || path.includes("/account/") || path.includes("/admin/");
    };

    // ----------------------------------------------------------------
    // 1. DỊCH VỤ GIỎ HÀNG (LocalStorage)
    // ----------------------------------------------------------------
    
    let cart = JSON.parse(localStorage.getItem("techluxury_cart")) || [];

    function saveCart() {
        localStorage.setItem("techluxury_cart", JSON.stringify(cart));
        updateCartUI();
    }

    function addToCart(title, price, img) {
        // Đưa giá về dạng số nguyên để tính toán
        let numPrice = parseInt(price.replace(/[^0-9]/g, ""));
        
        // Chuẩn hóa đường dẫn ảnh: loại bỏ các tiền tố ./ hoặc ../ để lưu dạng tương đối sạch
        let normalizedImg = img.replace(/^(\.\.\/|\.\/)/, "");
        
        let existingItem = cart.find(item => item.title === title);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                title: title,
                price: numPrice,
                img: normalizedImg,
                quantity: 1
            });
        }
        saveCart();
        openCartDrawer();
    }

    function removeFromCart(title) {
        cart = cart.filter(item => item.title !== title);
        saveCart();
    }

    function updateQuantity(title, change) {
        let item = cart.find(item => item.title === title);
        if (item) {
            item.quantity += change;
            if (item.quantity <= 0) {
                removeFromCart(title);
            } else {
                saveCart();
            }
        }
    }

    function formatVND(amount) {
        return amount.toLocaleString("vi-VN") + "đ";
    }

    function updateCartUI() {
        // Cập nhật huy hiệu số lượng trên Header
        const badge = document.querySelector(".cart-badge");
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        if (badge) {
            badge.textContent = totalItems;
            badge.style.display = totalItems > 0 ? "flex" : "none";
        }

        // Cập nhật giao diện trong Drawer
        const itemsContainer = document.getElementById("cart-drawer-items");
        const totalAmountText = document.getElementById("cart-total-amount");
        const footerSec = document.getElementById("cart-drawer-footer-sec");

        if (!itemsContainer) return;

        itemsContainer.innerHTML = "";

        if (cart.length === 0) {
            // Hiển thị thông báo giỏ trống
            itemsContainer.innerHTML = `
                <div class="empty-cart-message">
                    <i class="fas fa-shopping-bag"></i>
                    <p>Giỏ hàng đang trống</p>
                    <a href="javascript:void(0)" class="btn-shop-now" id="empty-shop-btn">MUA SẮM NGAY</a>
                </div>
            `;
            if (totalAmountText) totalAmountText.textContent = "0đ";
            if (footerSec) footerSec.style.display = "none";
            
            const emptyBtn = document.getElementById("empty-shop-btn");
            if (emptyBtn) {
                emptyBtn.addEventListener("click", function() {
                    closeCartDrawer();
                    // Cuộn đến phần sản phẩm hoặc chuyển hướng sang trang sản phẩm
                    const featuredSec = document.querySelector(".featured");
                    if (featuredSec) {
                        featuredSec.scrollIntoView({ behavior: "smooth" });
                    } else {
                        // Lấy đường dẫn động sang trang sản phẩm
                        const isSubpage = checkIsSubpage();
                        window.location.href = isSubpage ? "product.php" : "page/product.php";
                    }
                });
            }
            return;
        }

        if (footerSec) footerSec.style.display = "block";

        let totalAmount = 0;

        cart.forEach(item => {
            totalAmount += item.price * item.quantity;
            
            // Tính toán tiền tố đường dẫn dựa trên thư mục hiện tại để hiển thị đúng ảnh
            const isSubpage = checkIsSubpage();
            const pathPrefix = isSubpage ? "../" : "./";
            const displayImg = pathPrefix + item.img;
            
            const itemHTML = `
                <div class="cart-item">
                    <img src="${displayImg}" alt="${item.title}">
                    <div class="cart-item-info">
                        <h4>${item.title}</h4>
                        <p class="cart-item-price">${formatVND(item.price)}</p>
                        <div class="cart-item-qty">
                            <button class="qty-btn minus" data-title="${item.title}">-</button>
                            <span>${item.quantity}</span>
                            <button class="qty-btn plus" data-title="${item.title}">+</button>
                        </div>
                    </div>
                    <button class="cart-item-remove" data-title="${item.title}">&times;</button>
                </div>
            `;
            itemsContainer.insertAdjacentHTML("beforeend", itemHTML);
        });

        if (totalAmountText) {
            totalAmountText.textContent = formatVND(totalAmount);
        }

        // Lắng nghe sự kiện click cho các nút cộng/trừ/xóa
        itemsContainer.querySelectorAll(".qty-btn.plus").forEach(btn => {
            btn.addEventListener("click", () => updateQuantity(btn.getAttribute("data-title"), 1));
        });

        itemsContainer.querySelectorAll(".qty-btn.minus").forEach(btn => {
            btn.addEventListener("click", () => updateQuantity(btn.getAttribute("data-title"), -1));
        });

        itemsContainer.querySelectorAll(".cart-item-remove").forEach(btn => {
            btn.addEventListener("click", () => removeFromCart(btn.getAttribute("data-title")));
        });
    }

    // ----------------------------------------------------------------
    // 2. BẬT TẮT CART DRAWER
    // ----------------------------------------------------------------
    const cartDrawer = document.getElementById("cart-drawer");
    const cartOverlay = document.getElementById("cart-overlay");
    const cartTrigger = document.getElementById("cart-trigger");
    const cartCloseBtn = document.getElementById("cart-close-btn");

    function openCartDrawer() {
        if (cartDrawer && cartOverlay) {
            cartDrawer.classList.add("active");
            cartOverlay.classList.add("active");
            document.body.style.overflow = "hidden"; // chặn cuộn trang chính
        }
    }

    function closeCartDrawer() {
        if (cartDrawer && cartOverlay) {
            cartDrawer.classList.remove("active");
            cartOverlay.classList.remove("active");
            document.body.style.overflow = "";
        }
    }

    if (cartTrigger) cartTrigger.addEventListener("click", openCartDrawer);
    if (cartCloseBtn) cartCloseBtn.addEventListener("click", closeCartDrawer);
    if (cartOverlay) cartOverlay.addEventListener("click", closeCartDrawer);

    // ----------------------------------------------------------------
    // 3. MODAL XEM CHI TIẾT SẢN PHẨM (Quick Specs View)
    // ----------------------------------------------------------------
    const specsModal = document.getElementById("specs-modal");
    const specsOverlay = document.getElementById("specs-overlay");
    const specsCloseBtn = document.getElementById("specs-close-btn");
    let currentModalProduct = null;

    function openSpecsModal(productData) {
        if (!specsModal || !specsOverlay) return;

        currentModalProduct = productData;

        // Điền dữ liệu vào modal
        document.getElementById("modal-product-img").src = productData.img;
        document.getElementById("modal-product-title").textContent = productData.title;
        
        let priceStr = productData.price;
        if (priceStr && !priceStr.endsWith("đ")) {
            priceStr += "đ";
        }
        document.getElementById("modal-product-price").textContent = priceStr;

        // Huy hiệu danh mục hoặc trạng thái nổi bật
        const badge = document.getElementById("modal-product-badge");
        if (badge) {
            badge.textContent = productData.category ? productData.category.toUpperCase() : "NỔI BẬT";
        }

        // Tạo chip thông số kỹ thuật
        const specsContainer = document.getElementById("modal-product-specs");
        if (specsContainer) {
            specsContainer.innerHTML = "";
            if (productData.specs) {
                const specsList = productData.specs.split(",");
                specsList.forEach(spec => {
                    const chip = document.createElement("span");
                    chip.className = "m-chip";
                    chip.textContent = spec.trim();
                    specsContainer.appendChild(chip);
                });
            } else {
                specsContainer.innerHTML = `<span class="m-chip">Chính hãng 100%</span><span class="m-chip">Bảo hành 12 tháng</span>`;
            }
        }

        // Hiện modal
        specsModal.classList.add("active");
        specsOverlay.classList.add("active");
        document.body.style.overflow = "hidden";
    }

    function closeSpecsModal() {
        if (specsModal && specsOverlay) {
            specsModal.classList.remove("active");
            specsOverlay.classList.remove("active");
            document.body.style.overflow = "";
        }
    }

    if (specsCloseBtn) specsCloseBtn.addEventListener("click", closeSpecsModal);
    if (specsOverlay) specsOverlay.addEventListener("click", closeSpecsModal);

    // Gắn sự kiện click vào nút Add to Cart trong modal
    const modalAddBtn = document.getElementById("modal-add-to-cart-btn");
    if (modalAddBtn) {
        modalAddBtn.addEventListener("click", function () {
            if (currentModalProduct) {
                addToCart(currentModalProduct.title, currentModalProduct.price, currentModalProduct.img);
                closeSpecsModal();
            }
        });
    }

    // Gắn sự kiện cho các mẫu màu swatch để chọn màu sắc
    const swatches = document.querySelectorAll(".color-swatches .swatch");
    swatches.forEach(swatch => {
        swatch.addEventListener("click", function() {
            swatches.forEach(s => s.classList.remove("active"));
            this.classList.add("active");
        });
    });

    // ----------------------------------------------------------------
    // 4. LẮNG NGHE CLICK VÀO CARD SẢN PHẨM TRÊN TOÀN TRANG
    // ----------------------------------------------------------------
    function initProductCardEvents() {
        // Chọn tất cả thẻ sản phẩm
        const cards = document.querySelectorAll(".product-square-card, .card.h-100, .sale-card");
        
        cards.forEach(card => {
            // Ràng buộc sự kiện xem chi tiết khi click vào thẻ sản phẩm
            // Tránh kích hoạt khi click nút mua hàng hoặc rating
            card.addEventListener("click", function (e) {
                if (e.target.closest("button") || e.target.closest(".fav") || e.target.closest("a") || e.target.classList.contains("btn-buy")) {
                    return; // không làm gì nếu click nút
                }

                // Lấy thông tin từ các thuộc tính data-*
                let title = card.getAttribute("data-title");
                let price = card.getAttribute("data-price");
                let img = card.getAttribute("data-img");
                let specs = card.getAttribute("data-specs");
                let category = card.getAttribute("data-category");

                // Nếu không có data-attribute trực tiếp trên card, thử tìm trong thẻ con
                if (!title) {
                    const h3 = card.querySelector("h3");
                    title = h3 ? h3.textContent.trim() : "Sản phẩm công nghệ";
                }
                if (!price) {
                    const priceEl = card.querySelector(".product-price, .sale-price, .price");
                    price = priceEl ? priceEl.textContent.trim() : "Liên hệ";
                }
                if (!img) {
                    const imgEl = card.querySelector("img");
                    img = imgEl ? imgEl.getAttribute("src") : "";
                }

                openSpecsModal({
                    title: title,
                    price: price,
                    img: img,
                    specs: specs,
                    category: category
                });
            });

            // Gắn sự kiện mua hàng cho nút mua hàng trên card
            const buyBtn = card.querySelector(".btn-square-buy, .btn-buy, .btn-buy-modal");
            if (buyBtn) {
                buyBtn.addEventListener("click", function (e) {
                    e.stopPropagation(); // chặn sự kiện nổi bọt xem chi tiết
                    
                    let title = card.getAttribute("data-title");
                    let price = card.getAttribute("data-price");
                    let img = card.getAttribute("data-img");

                    if (!title) {
                        const h3 = card.querySelector("h3");
                        title = h3 ? h3.textContent.trim() : "Sản phẩm công nghệ";
                    }
                    if (!price) {
                        const priceEl = card.querySelector(".product-price, .sale-price, .price");
                        price = priceEl ? priceEl.textContent.trim() : "Liên hệ";
                    }
                    if (!img) {
                        const imgEl = card.querySelector("img");
                        img = imgEl ? imgEl.getAttribute("src") : "";
                    }

                    addToCart(title, price, img);
                });
            }
        });
    }

    // ----------------------------------------------------------------
    // 5. BỘ LỌC TÌM KIẾM NÂNG CAO (Advanced Filters) & LIVE SEARCH
    // ----------------------------------------------------------------
    const searchInput = document.getElementById("header-search-input");
    const headerSearchContainer = document.getElementById("header-search-container");
    const headerFilterToggle = document.getElementById("header-filter-toggle");
    const headerSearchDropdown = document.getElementById("header-search-dropdown");
    const headerClearBtn = document.getElementById("header-clear-btn");
    const headerSearchSubmitBtn = document.getElementById("header-search-submit-btn");

    const filterSearchText = document.getElementById("filter-search-text");
    const filterCategory = document.getElementById("filter-category");
    const filterBrand = document.getElementById("filter-brand");
    const filterPriceRange = document.getElementById("filter-price-range");
    const filterPriceSort = document.getElementById("filter-price-sort");

    const headerPriceRange = document.getElementById("header-price-range");
    const headerPriceSort = document.getElementById("header-price-sort");

    // Global filter state object
    const filterState = {
        query: "",
        category: "all",
        brand: "all",
        priceRange: "all",
        priceSort: "none"
    };



    // Helper to check if search page or home page grid is active on the current DOM
    function isProductContainerPresent() {
        return !!(document.getElementById("featured-products-container") || document.getElementById("products-container"));
    }

    // Helper to determine brand from product title string
    function getBrandFromTitle(title) {
        title = title.toLowerCase();
        if (title.includes("apple") || title.includes("macbook") || title.includes("iphone") || title.includes("airpod")) return "apple";
        if (title.includes("samsung") || title.includes("galaxy") || title.includes("bud")) return "samsung";
        if (title.includes("dell")) return "dell";
        if (title.includes("asus") || title.includes("rog")) return "asus";
        if (title.includes("sony")) return "sony";
        if (title.includes("xiaomi")) return "xiaomi";
        return "other";
    }

    // Populate data-brand dynamically if missing in HTML
    document.querySelectorAll(".product-square-card, .card, .sale-card").forEach(card => {
        if (!card.getAttribute("data-brand")) {
            const title = card.getAttribute("data-title") || card.querySelector("h3")?.textContent || "";
            card.setAttribute("data-brand", getBrandFromTitle(title));
        }
    });

    // Synchronize UI components with filterState values
    function syncFilterStateToInPage() {
        // 1. Keyword search text
        if (searchInput) searchInput.value = filterState.query;
        if (filterSearchText) filterSearchText.value = filterState.query;

        // 2. Category selection
        // In header dropdown chips
        const catChips = document.querySelectorAll("#header-category-chips .filter-chip");
        catChips.forEach(c => {
            if (c.getAttribute("data-value") === filterState.category) {
                c.classList.add("active");
            } else {
                c.classList.remove("active");
            }
        });
        // In home page category tabs
        const tabBtns = document.querySelectorAll(".tab-btn");
        tabBtns.forEach(btn => {
            const onclickAttr = btn.getAttribute("onclick") || "";
            if (onclickAttr.includes(`'${filterState.category}'`)) {
                btn.classList.add("active");
            } else {
                btn.classList.remove("active");
            }
        });
        // In page category select dropdown
        if (filterCategory) filterCategory.value = filterState.category;

        // 3. Brand selection
        // In header dropdown chips
        const brandChips = document.querySelectorAll("#header-brand-chips .filter-chip");
        brandChips.forEach(c => {
            if (c.getAttribute("data-value") === filterState.brand) {
                c.classList.add("active");
            } else {
                c.classList.remove("active");
            }
        });
        // In page brand select dropdown
        if (filterBrand) filterBrand.value = filterState.brand;

        // 4. Price range
        if (headerPriceRange) headerPriceRange.value = filterState.priceRange;
        if (filterPriceRange) filterPriceRange.value = filterState.priceRange;

        // 5. Price Sort
        if (headerPriceSort) headerPriceSort.value = filterState.priceSort;
        if (filterPriceSort) filterPriceSort.value = filterState.priceSort;
    }

    // Toggle advanced filter dropdown panel
    if (headerFilterToggle && headerSearchDropdown) {
        headerFilterToggle.addEventListener("click", function (e) {
            e.stopPropagation();
            headerFilterToggle.classList.toggle("active");
            headerSearchDropdown.classList.toggle("show");
        });

        document.addEventListener("click", function (e) {
            if (headerSearchContainer && !headerSearchContainer.contains(e.target)) {
                headerFilterToggle.classList.remove("active");
                headerSearchDropdown.classList.remove("show");
            }
        });

        headerSearchDropdown.addEventListener("click", function (e) {
            e.stopPropagation();
        });
    }

    // Initialize chips behavior in the dropdown panel
    function setupChips(containerId, stateKey) {
        const container = document.getElementById(containerId);
        if (!container) return;
        const chips = container.querySelectorAll(".filter-chip");
        chips.forEach(chip => {
            chip.addEventListener("click", function () {
                chips.forEach(c => c.classList.remove("active"));
                this.classList.add("active");
                filterState[stateKey] = this.getAttribute("data-value");
                syncFilterStateToInPage();
                if (isProductContainerPresent()) {
                    applyAdvancedFilters();
                }
            });
        });
    }

    setupChips("header-category-chips", "category");
    setupChips("header-brand-chips", "brand");

    // Clear filters logic
    if (headerClearBtn) {
        headerClearBtn.addEventListener("click", function () {
            filterState.query = "";
            filterState.category = "all";
            filterState.brand = "all";
            filterState.priceRange = "all";
            filterState.priceSort = "none";
            syncFilterStateToInPage();
            if (isProductContainerPresent()) {
                applyAdvancedFilters();
            }
        });
    }

    // Form submit redirection logic (for pages other than catalog)
    function handleGlobalSearchSubmit() {
        if (isProductContainerPresent()) {
            if (headerFilterToggle && headerSearchDropdown) {
                headerFilterToggle.classList.remove("active");
                headerSearchDropdown.classList.remove("show");
            }
            applyAdvancedFilters();
        } else {
            const isSub = checkIsSubpage();
            const prefix = isSub ? "" : "page/";
            const urlParams = new URLSearchParams({
                query: filterState.query,
                category: filterState.category,
                brand: filterState.brand,
                priceRange: filterState.priceRange,
                priceSort: filterState.priceSort
            });
            window.location.href = prefix + "product.php?" + urlParams.toString();
        }
    }

    if (headerSearchSubmitBtn) {
        headerSearchSubmitBtn.addEventListener("click", handleGlobalSearchSubmit);
    }

    if (searchInput) {
        searchInput.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                handleGlobalSearchSubmit();
            }
        });
    }

    // Apply Advanced Filtering on DOM cards
    function applyAdvancedFilters() {
        const query = filterState.query.toLowerCase().trim();
        const category = filterState.category;
        const brand = filterState.brand;
        const priceRange = filterState.priceRange;
        const priceSort = filterState.priceSort;

        const container = document.getElementById("featured-products-container") || document.getElementById("products-container");
        if (!container) return;

        const cols = Array.from(container.querySelectorAll(".product-col"));
        const paginationContainer = document.querySelector(".pagination-container");

        // Step 1: Filter
        let visibleCols = cols.filter(col => {
            let card = col.querySelector(".product-square-card, .card");
            if (!card) return false;

            // 1.1 Filter by query (title search)
            let title = card.getAttribute("data-title") || card.querySelector("h3")?.textContent || "";
            title = title.toLowerCase();
            const matchesSearch = title.includes(query);

            // 1.2 Filter by Category
            let itemCategory = col.getAttribute("data-category") || card.getAttribute("data-category") || "";
            const matchesCategory = (category === "all" || itemCategory === category);

            // 1.3 Filter by Brand
            let itemBrand = card.getAttribute("data-brand") || col.getAttribute("data-brand") || "";
            if (!itemBrand) {
                itemBrand = getBrandFromTitle(title);
            }
            const matchesBrand = (brand === "all" || itemBrand === brand);

            // 1.4 Filter by Price Range
            let priceRaw = card.getAttribute("data-price") || card.querySelector(".product-price, .sale-price, .price")?.textContent || "0";
            let price = parseInt(priceRaw.replace(/[^0-9]/g, ""));
            
            let matchesPrice = true;
            if (priceRange === "under10") {
                matchesPrice = (price < 10000000);
            } else if (priceRange === "10to25") {
                matchesPrice = (price >= 10000000 && price <= 25000000);
            } else if (priceRange === "25to45") {
                matchesPrice = (price > 25000000 && price <= 45000000);
            } else if (priceRange === "above45") {
                matchesPrice = (price > 45000000);
            }

            return matchesSearch && matchesCategory && matchesBrand && matchesPrice;
        });

        const isFiltering = (query !== "" || category !== "all" || brand !== "all" || priceRange !== "all" || priceSort !== "none");

        if (!isFiltering) {
            // Restore default pagination status
            cols.forEach(col => {
                col.style.removeProperty("display");
                col.classList.remove("d-none");
            });

            if (paginationContainer) {
                paginationContainer.style.setProperty("display", "flex", "important");
            }
            if (typeof renderPagination === "function") {
                renderPagination();
            } else if (typeof renderProductPagination === "function") {
                renderProductPagination();
            }
            return;
        }

        // Hide all initially
        cols.forEach(col => {
            col.style.setProperty("display", "none", "important");
            col.classList.add("d-none");
        });

        // Step 2: Sort
        if (priceSort !== "none" && visibleCols.length > 0) {
            visibleCols.sort((colA, colB) => {
                let cardA = colA.querySelector(".product-square-card, .card");
                let cardB = colB.querySelector(".product-square-card, .card");
                
                let priceA = parseInt((cardA.getAttribute("data-price") || "0").replace(/[^0-9]/g, ""));
                let priceB = parseInt((cardB.getAttribute("data-price") || "0").replace(/[^0-9]/g, ""));
                
                if (priceSort === "asc") {
                    return priceA - priceB;
                } else {
                    return priceB - priceA;
                }
            });

            // Re-order DOM elements inside container
            visibleCols.forEach(col => container.appendChild(col));
        }

        // Step 3: Show results
        if (paginationContainer) {
            paginationContainer.style.setProperty("display", "none", "important");
        }
        visibleCols.forEach(col => {
            col.style.setProperty("display", "block", "important");
            col.classList.remove("d-none");
        });
    }

    // Sync input events for in-page controls
    if (searchInput) {
        searchInput.addEventListener("input", function() {
            filterState.query = this.value;
            syncFilterStateToInPage();
            if (isProductContainerPresent()) {
                applyAdvancedFilters();
            }
        });
    }
    if (headerPriceRange) {
        headerPriceRange.addEventListener("change", function() {
            filterState.priceRange = this.value;
            syncFilterStateToInPage();
            if (isProductContainerPresent()) {
                applyAdvancedFilters();
            }
        });
    }
    if (headerPriceSort) {
        headerPriceSort.addEventListener("change", function() {
            filterState.priceSort = this.value;
            syncFilterStateToInPage();
            if (isProductContainerPresent()) {
                applyAdvancedFilters();
            }
        });
    }

    if (filterSearchText) {
        filterSearchText.addEventListener("input", function() {
            filterState.query = this.value;
            syncFilterStateToInPage();
            applyAdvancedFilters();
        });
    }
    if (filterCategory) {
        filterCategory.addEventListener("change", function() {
            filterState.category = this.value;
            syncFilterStateToInPage();
            applyAdvancedFilters();
        });
    }
    if (filterBrand) {
        filterBrand.addEventListener("change", function() {
            filterState.brand = this.value;
            syncFilterStateToInPage();
            applyAdvancedFilters();
        });
    }
    if (filterPriceRange) {
        filterPriceRange.addEventListener("change", function() {
            filterState.priceRange = this.value;
            syncFilterStateToInPage();
            applyAdvancedFilters();
        });
    }
    if (filterPriceSort) {
        filterPriceSort.addEventListener("change", function() {
            filterState.priceSort = this.value;
            syncFilterStateToInPage();
            applyAdvancedFilters();
        });
    }

    // Expose applyAdvancedFilters to global window
    window.applyAdvancedFilters = applyAdvancedFilters;

    // Load filters from URL query parameters on catalog page
    function loadUrlFilters() {
        const urlParams = new URLSearchParams(window.location.search);
        let hasFilters = false;

        if (urlParams.has("query")) {
            filterState.query = urlParams.get("query");
            hasFilters = true;
        }
        if (urlParams.has("category")) {
            filterState.category = urlParams.get("category");
            hasFilters = true;
        }
        if (urlParams.has("brand")) {
            filterState.brand = urlParams.get("brand");
            hasFilters = true;
        }
        if (urlParams.has("priceRange")) {
            filterState.priceRange = urlParams.get("priceRange");
            hasFilters = true;
        }
        if (urlParams.has("priceSort")) {
            filterState.priceSort = urlParams.get("priceSort");
            hasFilters = true;
        }

        if (hasFilters) {
            syncFilterStateToInPage();
            if (isProductContainerPresent()) {
                applyAdvancedFilters();
            }
        }
    }

    // Run URL filter parsing on initial page load
    loadUrlFilters();

    // Khởi tạo giỏ hàng ban đầu
    updateCartUI();
    
    // Khởi tạo các sự kiện click cho thẻ sản phẩm
    initProductCardEvents();

    // Hỗ trợ tái khởi tạo sự kiện khi chuyển tab hoặc phân trang (được gọi từ file khác nếu cần)
    window.reinitProductCards = initProductCardEvents;

    // Lắng nghe sự kiện nút thanh toán trong giỏ hàng
    const checkoutBtn = document.getElementById("checkout-btn");
    if (checkoutBtn) {
        checkoutBtn.addEventListener("click", function() {
            if (cart.length === 0) {
                alert("Giỏ hàng của bạn đang trống!");
                return;
            }
            const isSubpage = checkIsSubpage();
            const pathPrefix = isSubpage ? "" : "page/";
            window.location.href = pathPrefix + "checkout.php";
        });
    }
});
