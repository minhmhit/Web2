let productlist = [];
fetch("controller/db_controller/api.php?action=get_products")
  .then((response) => response.json())
  .then((data) => {
    productlist = data;
  });

function vnd(price) {
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(price);
}

// filter category
document.querySelectorAll(".filter-category").forEach((category) => {
  category.addEventListener("click", (event) => {
    // If header-sidebar is open, toggle it off
    if(event.target.dataset.filter == "Home"){
      document.querySelector(".main-container-home").classList.add("Active");
      document.querySelector(".product-page").classList.remove("Active");
    }else{
        document.querySelector(".main-container-home").classList.remove("Active");
        document.querySelector(".product-page").classList.add("Active");
    }

    document.querySelector(".search-bar").style.display = "flex";
    document.querySelector(".catalogue-info").style.display = "flex";

    //  main_container
    html_mainc();

    // them nut nhan cho filter option
    addListener_filterOption();
    let headerSideabar = document.getElementById("header-sidebar");
    if (
      parseFloat(
        window.getComputedStyle(headerSideabar).getPropertyValue("width")
      )
    ) {
      toggleModal("header-sidebar");
    }

    // If toggle-page is open, toggle it off
    let isTogglePage = document.querySelector(".toggle-page:not(.hidden)");
    if (isTogglePage) {
      if (isTogglePage.classList.contains("account-user"))
        togglePage("account-user");
      if (isTogglePage.classList.contains("order-history"))
        togglePage("order-history");
    }

    document
      .querySelectorAll(".category-menu .filter-category.active")
      .forEach((ele) => ele.classList.remove("active"));
    event.target.classList.add("active");
    let displayCatalogueName = document.getElementById(
      "display-catalogue-name"
    );
    displayCatalogueName.innerText = event.target.innerText.trim();
    resetFilter();
  });
});
function detailProduct(id) {
  let modal = document.querySelector('.modal.product-detail');
  let body = document.body;

  // Gọi API để lấy chi tiết sản phẩm từ `productdetail.php`
  fetch(`view/productdetail.php?id=${id}`)
      .then(response => response.text()) // Lấy HTML từ productdetail.php
      .then(html => {
          document.querySelector('#product-detail-content').innerHTML = html;
          modal.classList.add('open'); // Hiện modal
          body.style.overflow = "hidden"; // Ẩn scroll của body

          // Đăng ký sự kiện chọn size và xử lý add-to-cart sau khi modal được mở
          setupEventListeners();
      })
      .catch(error => console.error("Lỗi khi tải sản phẩm:", error));
}
// PHAN TRANG
let per_Page = 8;

function displayProducts(productList) {
  let div = document.querySelector(".product-box-container");
  div.innerHTML = "";

  let html = "";
  productList.forEach((product) => {
    // Kiểm tra trạng thái "hết hàng" và áp dụng class "disabled"
    const isOutOfStock = product.stockStatus?.toLowerCase() === 'out of stock'; // Sửa "hết hàng" thành 'out of stock' nếu cần
    const stockStatusClass = product.stockStatus?.toLowerCase().replace(/\s+/g, '-');

    // Tạo chuỗi HTML giống PHP của bạn
    html += `
      <div class="product-box ${isOutOfStock ? 'disabled' : ''}" 
           ${isOutOfStock ? '' : `onclick="detailProduct('${product.id}')"`}>
        <div class="img-container">
          <div class="stock-status ${stockStatusClass}">
            ${product.stockStatus}
          </div>
          <img src="${product.image}" alt="${product.name}"
               onerror="this.src='view/layout/asset/img/catalogue/coming-soon.jpg'" />
        </div>
        <div class="shoes-name">${product.name}</div>
        <div class="shoes-price">${vnd(product.price)}</div>
      </div>
    `;
  });

  div.innerHTML = html;
  displayWhenEmpty(".product-box-container", displayEmptyHTML_catalogue);
}


///

document.getElementById("search-bar").addEventListener("keyup", () => {
  window.scrollTo({ top: 700, behavior: "smooth" });
  showHomeProduct(productlist);
});
// fill san pham
function displayList(productList, per_Page, currentPage) {
  let start = (currentPage - 1) * per_Page;
  let end = (currentPage - 1) * per_Page + per_Page;
  let productShow = productList.slice(start, end);
  displayProducts(productShow);
}
// setup button pagination
function setupPagination(productList, per_Page) {
  if (productList.length > per_Page) {
    let NoPage =
      productList.length % per_Page == 0
        ? productList.length / per_Page
        : productList.length / per_Page + 1;

    let html = "";
    let pageNav = document.querySelector(".page-nav-list");
    pageNav.innerHTML = "";
    for (let i = 1; i <= NoPage; i++) {
      active = i == 1 ? "active" : "";
      html +=
        '<li class="page-nav-item ' +
        active +
        '"><a href="javascript:;">' +
        i +
        "</a></li>";
    }
    pageNav.innerHTML = html;
    document.querySelector(".page-nav").style.display = "flex";
    addclick(productList);
  } else {
    document.querySelector(".page-nav").style.display = "none";
  }
}

// listener click button pagination

function addclick(products) {
  let list = document.querySelectorAll(".page-nav-list .page-nav-item");
  list.forEach((element, index) => {
    element.addEventListener("click", function () {
      let currentPagenum = document.querySelector(".page-nav-list .active");
      currentPagenum.classList.remove("active");
      list[index].classList.add("active");
      window.scrollTo({ top: 700, behavior: "smooth" });
      products = products ? products : productlist;
      displayList(products, per_Page, index + 1);
    });
  });
}

function showHomeProduct(products) {
  const filters = getFilterOption();

  let filteredProducts = filterProducts(products, filters);

  filteredProducts = sortProducts(filteredProducts, filters.sortbyOption);

  let displayCatalogueAmount = document.getElementById(
    "display-catalogue-amount"
  );

  displayCatalogueAmount.textContent = filteredProducts.length + " ";

  displayList(filteredProducts, per_Page, 1);
  setupPagination(filteredProducts, per_Page);
  window.scrollTo({ top: 700 });
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//  SORT BY
document.querySelectorAll(".menu-list .sortby-option a").forEach((option) => {
  option.addEventListener("click", (event) => {
    document.querySelector("#sortby-mode-display").innerText =
      option.textContent;
    showHomeProduct(productlist);
    window.scrollTo({ top: 700, behavior: "smooth" });
  });
});
function sortProducts(products, sortbyOption) {
  if (sortbyOption === "Alphabetically, A-Z") {
    return products.sort((a, b) => a.name.localeCompare(b.name));
  } else if (sortbyOption === "Alphabetically, Z-A") {
    return products.sort((a, b) => b.name.localeCompare(a.name));
  } else if (sortbyOption === "Price, low to high") {
    return products.sort((a, b) => a.price - b.price);
  } else if (sortbyOption === "Price, high to low") {
    return products.sort((a, b) => b.price - a.price);
  }
  return products;
}

function getFilterOption() {
  const brandOption = Array.from(
    document.querySelectorAll(".filter-brand.active")
  ).map((option) => option.getAttribute("data-filter"));

  const sizeOption = Array.from(
    document.querySelectorAll(".filter-size.active")
  ).map((option) => option.getAttribute("data-filter"));
  const genderOption = Array.from(
    document.querySelectorAll(".filter-gender.active")
  ).map((option) => option.getAttribute("data-filter"));

  // Check if user is on mobile based on the display style if the details-search-bar
  const isMobile =
    window.getComputedStyle(
      document.querySelector(".details-search-bar.show-on-mobile.hide-on-pc")
    ).display !== "none";
  console.log("Is mobile device: ", isMobile);

  let categoryOption = document
    .querySelector(".filter-category.active")
    .getAttribute("data-filter");
  if (categoryOption == "Product")
    categoryOption = ["Sneaker", "Sandal", "Kid"];
  else
    categoryOption = [
      document
        .querySelector(".filter-category.active")
        .getAttribute("data-filter"),
    ];

  const nameOption = document.getElementById("search-bar").value.trim();
  const sortbyOption = document
    .getElementById("sortby-mode-display")
    .innerText.trim();

  // Read from field based on isMobile
  let minprice = isMobile
    ? parseInt(
        document.getElementById("price-lowerbound-sidebar").value.trim()
      ) || 0
    : parseInt(document.getElementById("price-lowerbound").value.trim()) || 0;
  let maxprice = isMobile
    ? parseInt(
        document.getElementById("price-upperbound-sidebar").value.trim()
      ) || Infinity
    : parseInt(document.getElementById("price-upperbound").value.trim()) ||
      Infinity;

  console.log(
    "Filter options:",
    brandOption,
    sizeOption,
    genderOption,
    sortbyOption,
    nameOption,
    categoryOption,
    minprice,
    maxprice
  );

  return {
    brandOption,
    sizeOption,
    genderOption,
    sortbyOption,
    nameOption,
    categoryOption,
    minprice,
    maxprice,
  };
}

function filterProducts(products, filters) {
  return products.filter((product) => {
    // If the product is marked "deleted" with attribute isDeleted = true
    if (product.isDeleted) return false;

    // Check matching name
    if (
      filters.nameOption &&
      !product.name.toLowerCase().includes(filters.nameOption.toLowerCase())
    ) {
      return false;
    }

    // Check price range
    if (product.price < filters.minprice || product.price > filters.maxprice) {
      return false;
    }

    // Check category
    if (!filters.categoryOption.includes(product.category)) {
      return false;
    }

    // Check brand
    if (
      filters.brandOption.length > 0 &&
      !filters.brandOption.includes(product.brand)
    ) {
      return false;
    }

    // Check gender
    if (
      filters.genderOption.length > 0 &&
      !filters.genderOption.includes(product.sex)
    ) {
      return false;
    }

    // Check size (at least one matching size is required)
    if (
      filters.sizeOption.length > 0 &&
      !filters.sizeOption.every((size) => product.size.includes(size))
    ) {
      return false;
    }

    return true;
  });
}

function resetFilter() {
  let filterOptions = document.querySelectorAll(".filter-option");
  filterOptions.forEach((option) => {
    option.classList.remove("active");
    option.value = "";
  });
  window.scrollTo({ top: 700 });
  showHomeProduct(productlist);
}


// left menu
function toggleDropdown(menuId) {
  let menu = document.getElementById(menuId);

  // Close other dropdowns
  document.querySelectorAll(".dropdown-menu").forEach((dropdown) => {
    if (dropdown.id !== menuId) {
      dropdown.style.display = "none";
    }
  });

  // Toggle the clicked dropdown
  menu.style.display = menu.style.display === "block" ? "none" : "block";
}

// Event listener to close dropdowns when clicking outside
document.addEventListener("click", function (event) {
  let isClickInside = event.target.closest(".dropdown");

  if (!isClickInside) {
    document.querySelectorAll(".dropdown-menu").forEach((dropdown) => {
      dropdown.style.display = "none";
    });
  }
});

$(document).ready(function () {
  document.querySelectorAll(".dropdown-menu").forEach((dropdown) => {
    dropdown.style.display = "none";
  });
  addclick();
});

// CATALOGUE - FILTER - BEGIN DEFINE /////////////////////////////////////////////////////
// Toggle filter options
function addListener_filterOption() {
  const filterOptions = document.querySelectorAll(".filter-option");

  filterOptions.forEach((option) => {
    option.addEventListener("click", (event) => {
      let clickedElement = event.target;
      if (!clickedElement.classList.contains("active")) {
        clickedElement.classList.add("active");
      } else {
        clickedElement.classList.remove("active");
      }
    });
  });

  document.querySelector(".apply-filter-btn").addEventListener("click", () => {
    window.scrollTo({ top: 700, behavior: "smooth" });
    showHomeProduct(productlist);
  });
}

// product detail
//

function html_mainc() {
  let container = document.querySelector(".main-container");
  container.innerHTML = ""; // Clear the container
  let html = ""; // Initialize HTML string
  html += `<div class="details-search hide-on-mobile">
                              <div class="dropdown">
                                  <ul class="dropdown-header">
                                      <li onclick="toggleDropdown('brand-menu')">BRAND</li>
                                  </ul>
                                  <ul class="dropdown-menu" id="brand-menu">
                                      <li class="filter-option filter-brand" data-filter="Adidas">ADIDAS</li>
                                      <li class="filter-option filter-brand" data-filter="Converse">CONVERSE</li>
                                      <li class="filter-option filter-brand" data-filter="Nike">NIKE</li>
                                      <li class="filter-option filter-brand" data-filter="BirkenStock">BIRKENSTOCK</li>
                                      <li class="filter-option filter-brand" data-filter="Teva">TEVA</li>
                                      <li class="filter-option filter-brand" data-filter="Fila">FILA</li>
                                  </ul>
                              </div>
                              <!-- SIZE Dropdown -->
                              <div class="dropdown">
                                  <ul class="dropdown-header">
                                      <li onclick="toggleDropdown('size-menu')">SIZE</li>
                                  </ul>
                                  <ul class="dropdown-menu" id="size-menu">
                                      <li class="filter-option filter-size" data-filter="20">20</li>
                                      <li class="filter-option filter-size" data-filter="21">21</li>
                                      <li class="filter-option filter-size" data-filter="22">22</li>
                                      <li class="filter-option filter-size" data-filter="23">23</li>
                                      <li class="filter-option filter-size" data-filter="24">24</li>
                                      <li class="filter-option filter-size" data-filter="35">35</li>
                                      <li class="filter-option filter-size" data-filter="36">36</li>
                                      <li class="filter-option filter-size" data-filter="37">37</li>
                                      <li class="filter-option filter-size" data-filter="38">38</li>
                                      <li class="filter-option filter-size" data-filter="39">39</li>
                                      <li class="filter-option filter-size" data-filter="41">41</li>
                                      <li class="filter-option filter-size" data-filter="42">42</li>
                                      <li class="filter-option filter-size" data-filter="43">43</li>
                                  </ul>
                              </div>
      
                              <!-- GENDER Dropdown -->
                              <div class="dropdown">
                                  <ul class="dropdown-header">
                                      <li onclick="toggleDropdown('gender-menu')">GENDER</li>
                                  </ul>
                                  <ul class="dropdown-menu" id="gender-menu">
                                      <li class="filter-option filter-gender" data-filter="M">Male</li>
                                      <li class="filter-option filter-gender" data-filter="F">Female</li>
                                      <li class="filter-option filter-gender" data-filter="U">Unisex</li>
                                  </ul>
                              </div>
      
                              <!-- PRICE Dropdown -->
                              <div class="dropdown">
                                  <ul class="dropdown-header">
                                      <li onclick="toggleDropdown('price-menu')">PRICE</li>
                                  </ul>
                                  <ul class="dropdown-menu" id="price-menu">
                                      <label for="price-lowerbound">Between</label>
                                      <input class="form-input-bar filter-option" type="number" name="price-lowerbound"
                                          id="price-lowerbound" placeholder="Minimun price" inputmode="numeric">
                                      <label for="price-upperbound">and</label>
                                      <input class="form-input-bar filter-option" type="number" name="price-upperbound"
                                          id="price-upperbound" placeholder="Maximum price" inputmode="numeric">
                                  </ul>
                              </div>                              
                              <div class="details-search-control">
                                  <button class="apply-filter-btn">APPLY FILTER</button>
                                  <a id="reset" onclick="resetFilter()">RESET FILTER</a>
                              </div>
                          </div>
                          <div class="shoes-box-container show-on-mobile">
      <div class="product-box-container" id="home-product">
         
      </div>
      <div class="page-nav" style="display: flex;">
          <ul class="page-nav-list">
              
          </ul>
      </div>
      </div>
       
      </div>`;
  container.innerHTML = html; // Set the new HTML
  document.querySelectorAll(".dropdown-menu").forEach((dropdown) => {
    dropdown.style.display = "none";
  });
}
