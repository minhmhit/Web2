<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRO SHOES</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Audiowide&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap');
    </style>
    <link rel="icon" href="asset\img\logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="asset\css\main.css">
    <link rel="stylesheet" href="asset\css\main-responsive.css">
    <link rel="stylesheet" href="asset\css\toast-msg.css">
    <script src="https://kit.fontawesome.com/e8d4a112b7.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="wrapper">
        <!-- BODY - HEADER -->
        <header>
            <div class="container" id="header">
                <div class="header-container-left">
                    <a onclick="location.reload()" class="header-logo">BRO SHOES</a>
                </div>
                <div class="header-container-mid hide-on-mobile">
                    <ul class="menu-list category-menu">
                        <li><a class="filter-category active" data-filter="Home">HOME</a></li>
                        <li><a class="filter-category" data-filter="Sneaker">SNEAKERS</a></li>
                        <li><a class="filter-category" data-filter="Sandal">SANDALS</a></li>
                        <li><a class="filter-category" data-filter="Kid">KIDS</a></li>
                    </ul>
                </div>
                <div class="header-container-right">
                    <ul class="menu-list">
                        <li><label for="search-bar"><a><i class="fa-solid fa-magnifying-glass"></i></label></a>
                        </li>
                        <li class="hide-on-mobile">
                            <!-- ACCOUNT FLOAT DROPDOWN -->
                            <a><i class="fa-regular fa-user"></i><span class="display-username"></span></a>
                            <div class="container float-dropdown" id="account-drop-list">
                                <ul class="menu-list" id="login-dropdown">
                                    <li class="logged-out"><a onclick="toggleModal('login-user')"><i
                                                class="fa-solid fa-right-to-bracket"></i><span>Log in</span></a></li>
                                    <li class="logged-out"><a onclick="toggleModal('signup-user')"><i
                                                class="fa-solid fa-user-plus"></i><span>Sign up</span></a></li>
                                    <li class="logged-in isAdmin"><a href="admin.html"><i
                                                class="fa-solid fa-screwdriver-wrench"></i><span>Manage*</span></a></li>
                                    <li class="logged-in"><a onclick="togglePage('account-user'); loadUserInfo()"><i
                                                class="fa-solid fa-circle-user"></i><span>My Account</span></a></li>
                                    <li class="logged-in"><a onclick="togglePage('order-history')"><i
                                                class="fa-solid fa-basket-shopping"></i><span>My
                                                Order</span></a></li>
                                    <li class="logged-in"><a onclick="signOut()"><i
                                                class="fa-solid fa-right-from-bracket"></i><span>Sign Out</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="hide-on-mobile"><a onclick="toggleModal('cart')"><i
                                    class="fa-solid fa-cart-shopping "></i>(<span
                                    class="display-cart-total-amount">0</span>)</a></li>
                    </ul>
                </div>
                <div class="container hamburger-menu-button hide-on-pc show-on-mobile">
                    <a class="toggler" id="toggle-sidebar" onclick="toggleModal('header-sidebar')"><i
                            class="fa-solid fa-bars"></i></a>
                </div>
                <!-- SIDEBAR -->
                <div class="modal sidebar header-sidebar" id="header-sidebar">
                    <div class="sidebar-main mdl-cnt">
                        <ul class="menu-list category-menu">
                            <li>Hi there <span class="display-username"></span>!</li>
                            <li><a class="filter-category active" data-filter="Home">HOME</a></li>
                            <li><a class="filter-category" data-filter="Sneaker">SNEAKERS</a></li>
                            <li><a class="filter-category" data-filter="Sandal">SANDALS</a></li>
                            <li><a class="filter-category" data-filter="Kid">KIDS</a></li>
                            <li>
                                <!-- SIDEBAR ACCOUNT DROPDOWN -->
                                <a onclick="toggleSidebarDropdown('account-drop-list-sidebar')"><span>ACCOUNT</span> <i
                                        class="fa-solid fa-chevron-down"></i></a>
                                <div class="container account-dropdown hidden" id="account-drop-list-sidebar">
                                    <ul class="menu-list" id="login-dropdown">
                                        <li class="logged-out"><a onclick="toggleModal('login-user')"><span>Log
                                                    in</span></a></li>
                                        <li class="logged-out"><a onclick="toggleModal('signup-user')"><span>Sign
                                                    up</span></a></li>
                                        <li class="logged-in isAdmin"><a href="admin.html"><span>Manage*</span></a></li>
                                        <li class="logged-in"><a
                                                onclick="loadUserInfo(); togglePage('account-user'); toggleModal('header-sidebar')"><span>My
                                                    Account</span></a></li>
                                        <li class="logged-in"><a
                                                onclick="togglePage('order-history'); toggleModal('header-sidebar')"><span>My
                                                    Order</span></a></li>
                                        <li class="logged-in"><a
                                                onclick="signOut(); toggleModal('header-sidebar')"><span>Sign
                                                    Out</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li><a onclick="toggleModal('cart');">CART (<span
                                        class="display-cart-total-amount">0</span>)</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>