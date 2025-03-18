<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- icon -->
    <link rel="icon" href="asset\img\logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://kit.fontawesome.com/e8d4a112b7.js" crossorigin="anonymous"></script>
    <!-- embed font -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Audiowide&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap');
    </style>
    <!-- css -->
    <link rel="stylesheet" href="view/layout/asset/css/admin.css" />
    <link rel="stylesheet" href="view/layout/asset/css/admin-responsive.css" />
    <link rel="stylesheet" href="view/layout/asset/css/toast-msg.css" />
    <title>Store Manager</title>
</head>

<body>
    <section class="admin wrapper">
        <!-- TOAST -->
        <div class="container toast" id="toast"></div>
        <div class="modal" id="modal">
            <div class="modal-container mdl-cnt" id="modal-container">
            </div>
        </div>
        <div class="admin-sidebar" id="admin-sidebar">
            <div class="admin-sidebar__top">
                <a class="img-container" href=""><img class="header-logo" src="view/layout/asset/img/logo.jpg" alt="Bro Shoes"></a>
            </div>
            <aside class="admin-sidebar__content">
                <ul>
                    <li>
                        <a onclick="togglePage('homepage')"><i class="fa-solid fa-house"></i>
                            <span>HOMEPAGE</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="togglePage('bill')"><i class="fa-solid fa-file-invoice"></i>
                            <span>ORDERS</span></a>
                    </li>
                    <li>
                        <a onclick="togglePage('showProducts')"><i class="fa-solid fa-box-archive"></i>
                            <span>PRODUCTS</span></a>
                    </li>
                    <li>
                        <a onclick="togglePage('customer')"><i class="fa-solid fa-users"></i>
                            <span>ACCOUNTS</span></a>
                    </li>
                    <li><a onclick="togglePage('statistical')"><i
                                class="fa-solid fa-chart-pie"></i><span>STATISTIC</span></a>
                    </li>
                </ul>
                <ul>
                    <li><a><i class="fa-solid fa-user-tie"></i><span class="display-username"></span></a></li>
                    <li><a href="index.php"><i class="fa-regular fa-circle-left"></i><span>RETURN</span></a></li>
                    <li><a onclick="logOut()"><i class="fa-solid fa-arrow-right-from-bracket"></i><span>LOG OUT</span></a></li>
                </ul>
            </aside>
        </div>
        <main class="admin-content">
            <section class="admin-content-top show-on-mobile hide-on-pc">
                <button onclick="toggleSideBar()"><i class="fa-solid fa-bars"></i></button>
                <h1 class="logo">BRO SHOES</h1>
            </section>
            <section>
                <div id="customAlert"></div>
                <!-- TRANG CHỦ -->
                <div class="admin-content-main toggle-page show" id="homepage">
                    <div class="admin-content-main__title">
                        <h1>HOMEPAGE</h1>
                    </div>
                    <div class="admin-content-main__center">
                        <!-- Nội dung -->
                        <div class="cards">
                            <div class="card-single">
                                <div class="box">
                                    <h2 class="display-user-count">0</h2>
                                    <div class="on-box">
                                        <img src="view/layout/asset/img/admin-homepage/users.png" alt="" style=" width: 200px;">
                                        <h3>ACTIVE USERS</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-single">
                                <div class="box">
                                    <div class="on-box">
                                        <img src="view/layout/asset/img/admin-homepage/shopping.png" alt="" style=" width: 200px;">
                                        <h2 class="display-product-count">0</h2>
                                        <h3>PRODUCTS ON SALE</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-single">
                                <div class="box">
                                    <h2 class="display-total-income">0</h2>
                                    <div class="on-box">
                                        <img src="view/layout/asset/img/admin-homepage/income.png" alt="" style=" width: 200px;">
                                        <h3>TOTAL INCOME</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- DANH SÁCH SẢN PHẨM -->
                <div id="showProducts" class="admin-content-main toggle-page none">
                    <div class="admin-content-main__title">
                        <h1>PRODUCTS</h1>
                    </div>
                    <div class="admin-content-main__control">
                        <div class="top">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input class="form-input-bar" type="text" id="form-search-product"
                                placeholder="Search products...">
                        </div>
                        <div class="bottom">
                            <div class="left">
                                <label>
                                    <span>Status: </span>
                                    <select name="status-product" id="status-product">
                                        <option value="1" selected>On sale</option>
                                        <option value="0">Deleted</option>
                                    </select>
                                </label>
                                <label>
                                    <span>Category: </span>
                                    <select name="category-product" id="category-product">
                                        <option value="0" selected>All</option>
                                        <option value="Sneaker">Sneaker</option>
                                        <option value="Sandal">Sandal</option>
                                        <option value="Kid">Kid</option>
                                    </select>
                                </label>
                                <label>
                                    <span>Brand: </span>
                                    <select name="brand-product" id="brand-product">
                                        <option value="0" selected>All</option>
                                        <option value="Nike">Nike</option>
                                        <option value="Converse">Converse</option>
                                        <option value="Fila">Fila</option>
                                        <option value="BirkenStock">BirkenStock</option>
                                        <option value="Teva">Teva</option>
                                    </select>
                                </label>
                                <label>
                                    <span>Gender: </span>
                                    <select name="gender-product" id="gender-product">
                                        <option value="0">All</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                        <option value="U">Unisex</option>
                                    </select>
                                </label>
                            </div>
                            <div class="middle">
                                <label>
                                    <span>Between: </span>
                                    <input class="form-input-bar" type="number" placeholder="Minimum price"
                                        id="minprice-product">
                                </label>
                                <label>
                                    <span> and </span>
                                    <input class="form-input-bar" type="number" placeholder="Maximum price"
                                        id="maxprice-product">
                                </label>
                            </div>
                            <div class="right">
                                <button class="add-btn filter-btn" onclick="resetFilterProducts()"><i
                                        class="fa-solid fa-filter-circle-xmark"></i></button>
                                <button class="add-btn" onclick="resetForm()">ADD PRODUCT</button>
                            </div>
                        </div>
                    </div>
                    <div class="admin-content-main__center">
                        <!-- Nội dung -->
                        <div class="product-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>INDEX</th>
                                        <th>ID</th>
                                        <th>IMAGE</th>
                                        <th>NAME</th>
                                        <th>PRICE</th>
                                        <th>CATEGORY</th>
                                        <th>BRAND</th>
                                        <th>GENDER</th>
                                        <th>SIZEs</th>
                                        <th>OPTIONS</th>
                                    </tr>
                                </thead>
                                <tbody id="products">
                                    <!-- hiển thị sản phẩm bằng js -->
                                </tbody>
                            </table>
                            <div class="display-when-empty"></div>
                        </div>
                    </div>
                    <div>
                        <ul class="listPage">
                        </ul>
                    </div>
                    <!-- Thêm sản phẩm -->
                    <div class="addProducts" id="edit">
                        <div class="add">
                            <h2>ADD NEW PRODUCT</h2>
                            <form>
                                <div class="content">
                                    <div class="form-group">
                                        <label for="productName">Name</label>
                                        <input type="text" id="productName" name="productName"
                                            placeholder="Enter product name" class="form-input-bar">
                                    </div>

                                    <div class="form-group">
                                        <label for="productPrice">Price</label>
                                        <input type="text" id="productPrice" name="productPrice"
                                            placeholder="Enter product price" class="form-input-bar">
                                    </div>
                                    <div class="form-groups">
                                        <label for="productCategory">Category</label>
                                        <select id="productCategory" name="productCategory">
                                            <option value="Sneaker">Sneaker</option>
                                            <option value="Sandal">Sandal</option>
                                            <option value="Kid">Kid</option>
                                        </select>
                                    </div>
                                    <div class="form-groups">
                                        <label for="productBrand">Brand</label>
                                        <select id="productBrand" name="productBrand">
                                            <option value="Nike">Nike</option>
                                            <option value="Adidas">Adidas</option>
                                            <option value="BirkenStock">BirkenStock</option>
                                            <option value="Converse">Converse</option>
                                            <option value="Teva">Teva</option>
                                            <option value="Fila">Fila</option>
                                        </select>
                                    </div>
                                    <div class="form-groups">
                                        <label for="sex">Gender</label>
                                        <select id="sex" name="sex">
                                            <option value="M">M</option>
                                            <option value="U">U</option>
                                            <option value="F">F</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="size" class="tittle">Sizes</label>
                                        <div class="size-options visible" id="normal">
                                            <label><input type="checkbox" name="size" value="36">36</label>
                                            <label><input type="checkbox" name="size" value="37">37</label>
                                            <label><input type="checkbox" name="size" value="38">38</label>
                                            <label><input type="checkbox" name="size" value="39">39</label>
                                            <label><input type="checkbox" name="size" value="40">40</label>
                                            <label><input type="checkbox" name="size" value="41">41</label>
                                            <label><input type="checkbox" name="size" value="42">42</label>
                                            <label><input type="checkbox" name="size" value="43">43</label>
                                        </div>
                                        <div class="size-options hidden" id="option-Kid">
                                            <label><input type="checkbox" name="size" value="20">20</label>
                                            <label><input type="checkbox" name="size" value="21">21</label>
                                            <label><input type="checkbox" name="size" value="22">22</label>
                                            <label><input type="checkbox" name="size" value="23">23</label>
                                            <label><input type="checkbox" name="size" value="24">24</label>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="productImage">Image</label>
                                        <img src="./asset/img/temp.jpg" alt="" width="200px" id="imagePreview">
                                        <input type="file" id="productImage" name="productImage">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="form" onclick="addProduct()">ADD PRODUCT</button>
                        </div>
                    </div>
                </div>
                <!-- DANH SÁCH ĐƠN HÀNG -->
                <div class="admin-content-main toggle-page none" id="bill">
                    <div class="admin-content-main__title">
                        <h1>ORDERS</h1>
                    </div>
                    <div class="admin-content-main__control">
                        <div class="top">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input class="form-input-bar" type="text" id="form-search-order"
                                placeholder="Search orders...">
                        </div>
                        <div class="bottom">
                            <div class="lef">
                                <label>
                                    <span>Status: </span>
                                    <select name="status-order" id="status-order">
                                        <option value="4" selected>All</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Processed</option>
                                        <option value="2">Received</option>
                                        <option value="3">Cancelled</option>
                                    </select>
                                </label>
                                <label>
                                    <span>Payment method: </span>
                                    <select name="payment-method" id="payment-method">
                                        <option value="0">All</option>
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                    </select>
                                </label>
                                <label>
                                    <span>From: </span>
                                    <input type="date" name="timestart-order" id="timestart-order">
                                </label>
                                <label>
                                    <span>To: </span>
                                    <input type="date" name="timeend-order" id="timeend-order">
                                </label>
                            </div>
                            <div class="middle">
                                <div class="region-selector">
                                    <select id="province" class="region-select" onchange="updateDistricts()">
                                        <option value="">Province/City</option>
                                    </select>
                                    <select id="district" class="region-select" onchange="updateWards()">
                                        <option value="">District</option>
                                    </select>
                                    <select id="ward" class="region-select">
                                        <option value="">Ward/Commune</option>
                                    </select>
                                </div>
                            </div>
                            <div class="right">
                                <label>
                                    <span>Between: </span>
                                    <input class="form-input-bar" type="number" placeholder="Minimum price"
                                        id="minprice-order">
                                </label>
                                <label>
                                    <span> and </span>
                                    <input class="form-input-bar" type="number" placeholder="Maximum price"
                                        id="maxprice-order">
                                </label>
                                <button class="add-btn filter-btn" onclick="resetFilterOrders()"><i
                                        class="fa-solid fa-filter-circle-xmark"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="admin-content-main__center">
                        <!-- Nội dung -->
                        <div class="product-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>INDEX</th>
                                        <th>ID</th>
                                        <th>CUSTOMER</th>
                                        <th>PHONE</th>
                                        <th>DATE</th>
                                        <th>TOTAL</th>
                                        <th>STATUS</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="show-orders">
                                </tbody>
                            </table>
                            <div class="display-when-empty"></div>
                        </div>
                    </div>
                </div>
                <!-- DANH SÁCH KHÁCH HÀNG -->
                <div class="admin-content-main toggle-page none" id="customer">
                    <div class="admin-content-main__title">
                        <h1>ACCOUNTS</h1>
                    </div>
                    <div class="admin-content-main__control">
                        <div class="top">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input class="form-input-bar" id="form-search-user" type="text"
                                placeholder="Search account...">
                        </div>
                        <div class="bottom">
                            <div class="left">
                                <label for="status-user">
                                    <span>Account status: </span>
                                    <select name="status-user" id="status-user">
                                        <option value="2" selected>All</option>
                                        <option value="1">Active</option>
                                        <option value="0">Locked</option>
                                    </select>
                                </label>
                                <label>
                                    <span>From: </span>
                                    <input type="date" name="timestart-user" id="timestart-user">
                                </label>
                                <label>
                                    <span>To: </span>
                                    <input type="date" name="timeend-user" id="timeend-user">
                                </label>
                            </div>
                            <div class="right">
                                <button class="add-btn filter-btn" onclick="resetFilterAccounts()"><i
                                        class="fa-solid fa-filter-circle-xmark"></i></button>
                                <button class="add-btn" onclick="showModalAccount()">ADD ACCOUNT</button>
                            </div>
                        </div>
                    </div>
                    <div class="admin-content-main__center">
                        <!-- Nội dung -->
                        <div class="product-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>INDEX</th>
                                        <th>ID</th>
                                        <th>FULL NAME</th>
                                        <th>USERNAME</th>
                                        <th>PHONE</th>
                                        <th>JOIN DATE</th>
                                        <th>STATUS</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="accounts">
                                </tbody>
                            </table>
                            <div class="display-when-empty"></div>
                        </div>
                    </div>
                </div>
                <!-- STATISTIC -->
                <div class="admin-content-main toggle-page none" id="statistical">
                    <div class="admin-content-main__title">
                        <h1>STATISTIC</h1>
                    </div>
                    <div class="admin-content-main__control">
                        <div class="top">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input class="form-input-bar" type="text" id="form-search-stat" placeholder="Search...">
                        </div>
                        <div class="bottom">
                            <div class="left">
                                <label>
                                    <span>Brand: </span>
                                    <select name="brand-product-stat" id="brand-product-stat">
                                        <option value="0" selected>All</option>
                                        <option value="Nike">Nike</option>
                                        <option value="Converse">Converse</option>
                                        <option value="Fila">Fila</option>
                                        <option value="BirkenStock">BirkenStock</option>
                                        <option value="Teva">Teva</option>
                                    </select>
                                </label>
                                <label>
                                    <span>From: </span>
                                    <input type="date" name="timestart-stat" id="timestart-stat">
                                </label>
                                <label>
                                    <span>To: </span>
                                    <input type="date" name="timeend-stat" id="timeend-stat">
                                </label>
                            </div>
                            <div class="right">
                                <button class="add-btn filter-btn" onclick="filterStat('asc')"><i
                                        class="fa-solid fa-sort-up"></i></button>
                                <button class="add-btn filter-btn" onclick="filterStat('desc')"><i
                                        class="fa-solid fa-sort-down"></i></button>
                                <button class="add-btn filter-btn" onclick="resetFilterStat()"><i
                                        class="fa-solid fa-filter-circle-xmark"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="admin-content-main__center">
                        <!-- Nội dung -->
                        <div class="order-statistical" id="order-statistical">
                            <div class="order-statistical-item">
                                <div class="order-statistical-item-content">
                                    <p class="order-statistical-item-content-desc">SOLD PRODUCTS</p>
                                    <h4 class="order-statistical-item-content-h" id="quantity-product">0</h4>
                                    <i class="fa-solid fa-box-open order-statistical-item-icon"></i>
                                </div>

                            </div>
                            <div class="order-statistical-item">
                                <div class="order-statistical-item-content">
                                    <p class="order-statistical-item-content-desc">SOLD QUANTITY</p>
                                    <h4 class="order-statistical-item-content-h" id="quantity-order">0</h4>
                                    <i class="fa-solid fa-hashtag order-statistical-item-icon"></i>
                                </div>

                            </div>
                            <div class="order-statistical-item">
                                <div class="order-statistical-item-content">
                                    <p class="order-statistical-item-content-desc">TOTAL INCOME</p>
                                    <h4 class="order-statistical-item-content-h" id="quantity-sale">0₫</h4>
                                    <i class="fa-solid fa-dollar-sign order-statistical-item-icon"></i>
                                </div>

                            </div>
                        </div>
                        <h3>PRODUCTS' REVENUE</h3>
                        <div class="product-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>INDEX</th>
                                        <th>ID</th>
                                        <th>PRODUCT</th>
                                        <th>SOLD QUANTITY</th>
                                        <th>REVENUE</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="statistic-products">
                                </tbody>
                            </table>
                            <div class="display-when-empty"></div>
                        </div>
                        <h3 style="margin-top: 24px">CUSTOMERS' REVENUE</h3>
                        <div class="product-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>INDEX</th>
                                        <th>ID</th>
                                        <th>FULL NAME</th>
                                        <th>PHONE</th>
                                        <th>REVENUE</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="statistic-accounts"></tbody>
                            </table>
                            <div class="display-when-empty"></div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </section>
    <script src="view/layout/js/initialization.js"></script>
    <script src="view/layout/js/toast-msg.js"></script>
    <script src="view/layout/js/admin.js"></script>
</body>

</html>