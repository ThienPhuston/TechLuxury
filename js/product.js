const PRODUCTS_PER_PAGE = 8;
let currentProductPage = 1;

function renderProductPagination() {
  const items = Array.from(
    document.querySelectorAll("#products-container .product-col"),
  );
  const totalItems = items.length;
  const totalPages = Math.ceil(totalItems / PRODUCTS_PER_PAGE);

  // Ẩn tất cả, sau đó hiện đúng các sản phẩm thuộc trang hiện tại
  const start = (currentProductPage - 1) * PRODUCTS_PER_PAGE;
  const end = start + PRODUCTS_PER_PAGE;

  items.forEach((item, index) => {
    if (index >= start && index < end) {
      item.classList.remove("d-none");
    } else {
      item.classList.add("d-none");
    }
  });

  // Vẽ lại các nút phân trang
  const pagination = document.getElementById("products-pagination");
  if (!pagination) return;

  pagination.innerHTML = "";

  if (totalPages <= 1) {
    document.querySelector(".pagination-container").style.display = "none";
    return;
  }
  document.querySelector(".pagination-container").style.display = "flex";

  // Nút "Trước"
  const prevLi = document.createElement("li");
  prevLi.className =
    "page-item" + (currentProductPage === 1 ? " disabled" : "");
  prevLi.innerHTML = `<a class="page-link" href="javascript:void(0)"><i class="fas fa-chevron-left"></i></a>`;
  prevLi.addEventListener("click", () =>
    goToProductPage(currentProductPage - 1),
  );
  pagination.appendChild(prevLi);

  // Các nút số trang
  for (let page = 1; page <= totalPages; page++) {
    const li = document.createElement("li");
    li.className = "page-item" + (page === currentProductPage ? " active" : "");
    li.innerHTML = `<a class="page-link" href="javascript:void(0)">${page}</a>`;
    li.addEventListener("click", () => goToProductPage(page));
    pagination.appendChild(li);
  }

  // Nút "Sau"
  const nextLi = document.createElement("li");
  nextLi.className =
    "page-item" + (currentProductPage === totalPages ? " disabled" : "");
  nextLi.innerHTML = `<a class="page-link" href="javascript:void(0)"><i class="fas fa-chevron-right"></i></a>`;
  nextLi.addEventListener("click", () =>
    goToProductPage(currentProductPage + 1),
  );
  pagination.appendChild(nextLi);
}

function goToProductPage(page) {
  const items = Array.from(
    document.querySelectorAll("#products-container .product-col"),
  );
  const totalPages = Math.ceil(items.length / PRODUCTS_PER_PAGE);

  if (page < 1 || page > totalPages) return;

  currentProductPage = page;
  renderProductPagination();

  // Cuộn lên đầu danh sách sản phẩm cho dễ nhìn
  document
    .querySelector(".products-page")
    .scrollIntoView({ behavior: "smooth" });
}

document.addEventListener("DOMContentLoaded", renderProductPagination);
