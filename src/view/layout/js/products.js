// VISIBILITY - BEGIN DEFINE /////////////////////////////////////////////////////

function toggleSidebarDropdown(elementId) {
  let x = document.getElementById(elementId);
  x.classList.toggle("hidden");
}

function toggleModal(elementId) {
  let x = document.getElementById(elementId);

  x.classList.toggle("open");

  Array.from(document.getElementsByClassName("modal")).forEach((modal) => {
      if (modal.id !== elementId)
          modal.classList.remove("open");
  });


}

function togglePage(elementId) {
  let selectedPage = document.getElementById(elementId);
  let catalougePage = document.getElementById("catalogue");
  let allPages = document.querySelectorAll(".toggle-page");


  selectedPage.classList.toggle("hidden");

  allPages.forEach((page) => {
      if (page.id !== elementId) {
          page.classList.add("hidden");
      }
  });

  // Now check if any page is active
  let anyActivePage = Array.from(allPages).some(page => !page.classList.contains("hidden"));


  // If no page is active, show catalougePage; otherwise, hide it
  if (!anyActivePage)
      catalougePage.classList.remove("hidden");
  else
      catalougePage.classList.add("hidden");


  window.scrollTo({ top: 0 });
}
// VISIBILITY - END DEFINE /////////////////////////////////////////////////////

// USER - BEGIN DEFINE /////////////////////////////////////////////////////
// Change UI based on whether user has logged in or not
function updateMenuVisibility() {
  let isLoggedIn = !!localStorage.getItem("currentuser");
  let currentuser = JSON.parse(localStorage.getItem("currentuser"));

  // Show checkout-btn if user is logged in
  let checkoutBtn = document.getElementById("cart-checkout-btn");
  if (isLoggedIn) {
      checkoutBtn.classList.add("active");
      checkoutBtn.disabled = false;
  } else {
      checkoutBtn.classList.remove("active");
      checkoutBtn.disabled = true;
  }

  // Show cart, order-history if user is logged in
  if (isLoggedIn) {
      showCart();
      updateCartTotalAmount();
      updateCartTotalPrice();
      showOrderHistory();
  }

  // Show logged-in items, hide logged-out items if user is logged in
  document.querySelectorAll(".logged-in").forEach(item => {
      item.style.display = isLoggedIn ? "block" : "none";
  });
  document.querySelectorAll(".logged-out").forEach(item => {
      item.style.display = isLoggedIn ? "none" : "block";
  });

  // Show admin features if account is admin
  document.querySelectorAll(".isAdmin").forEach(item => {
      item.style.display = isLoggedIn && currentuser.isAdmin ? "block" : "none";
  });

  // Show username in specific places if user is logged in
  document.querySelectorAll(".display-username").forEach(item => {
      item.textContent = isLoggedIn ? currentuser.username : "";
  });

  // Show address in specific places if user is logged in
  document.querySelectorAll(".display-address").forEach(item => {
      item.value = isLoggedIn ? currentuser.address : "";
  });
}

// For signup form
function handleSignupForm() {
  event.preventDefault();

  let username = document.getElementById("username-signup").value.trim();
  let fullname = document.getElementById("fullname-signup").value.trim();
  let phone = document.getElementById("phone-signup").value.trim();
  let address = document.getElementById("address-signup").value.trim();
  let password = document.getElementById("password-signup").value.trim();
  let confirmPassword = document.getElementById("confirm-password-signup").value.trim();

  let hasError = false;

  // Reset form-msg-error classes
  document.querySelectorAll(".signup-user .form-msg-error").forEach(msg => {
      msg.textContent = "";
  });



  // Validate username
  if (!username || username.length < 5 || /\W|\s/.test(username)) {
      document.querySelector("#username-signup + .form-msg-error").innerText =
          "Username must be at least 5 characters long, no spaces or special characters.";
      hasError = true;
  }

  // Validate fullname
  if (!fullname) {
      document.querySelector("#fullname-signup + .form-msg-error").innerText =
          "Full name cannot be empty.";
      hasError = true;
  }

  // Validate phone
  if (!phone || !/^\d{10}$/.test(phone)) {
      document.querySelector("#phone-signup + .form-msg-error").innerText =
          "Phone number must be exactly 10 digits.";
      hasError = true;
  }

  // Validate address
  if (!address) {
      document.querySelector("#address-signup + .form-msg-error").innerText =
          "Address cannot be empty.";
      hasError = true;
  }

  // Validate password
  if (!password || password.length < 5 || /\s/.test(password)) {
      document.querySelector("#password-signup + .form-msg-error").innerText =
          "Password must be at least 5 characters long and cannot contain spaces.";
      hasError = true;
  }

  // Validate confirm password
  if (password !== confirmPassword) {
      document.querySelector("#confirm-password-signup + .form-msg-error").innerText =
          "Passwords do not match.";
      hasError = true;
  }

  if (hasError) {
      toastMsg({ title: "ERROR", message: "Please fill in the form correctly.", type: "error" });
      return;
  }


  // If no error messages, proceed with saving to local storage
  let accounts = JSON.parse(localStorage.getItem("accounts")) || [];
  let user = {
      id: ID_TYPE[0] + (accounts.length + 1),
      username: username,
      fullname: fullname,
      phone: phone,
      address: address,
      password: password,
      join: new Date(),
      cart: [],
      isAdmin: 0,
      status: 1
  };

  // Check for duplicate / trung username/phone
  let containsDuplicate = accounts.some(account => {
      return account.phone === user.phone || account.username === user.username;
  });


  if (!containsDuplicate) {
      accounts.push(user);
      localStorage.setItem("accounts", JSON.stringify(accounts));
      localStorage.setItem("currentuser", JSON.stringify(user));
      console.log("handleSignupForm(): Signed up");
      updateMenuVisibility();
      toggleModal("signup-user");
      document.getElementById("signup-form").reset();
      toastMsg({ title: "SUCCESS", message: "Account created successfully!", type: "success" });
  } else {
      toastMsg({ title: "ERROR", message: "Account with username and/or phone number already existed!", type: "error" });
  }
};

// For login form
function handleLoginForm() {
  event.preventDefault();

  let usernameOrPhone = document.getElementById("username-login").value.trim();
  let password = document.getElementById("password-login").value.trim();
  let userMsgError = document.querySelector("#username-login + .form-msg-error");
  let passMsgError = document.querySelector("#password-login + .form-msg-error");

  // Ensure accounts exist in local storage
  let accounts = JSON.parse(localStorage.getItem("accounts")) || [];

  // Reset form-msg-error classes
  document.querySelectorAll(".login-user .form-msg-error").forEach(msg => {
      msg.textContent = "";
  });

  if (!usernameOrPhone || !password) {
      userMsgError.innerText = "Both fields are required";
      passMsgError.innerText = "Both fields are required";
      toastMsg({ title: "ERROR", message: "Please fill in the form correctly.", type: "error" });
      return;
  }

  let userIdx = accounts.findIndex(account => (account.phone === usernameOrPhone || account.username === usernameOrPhone));

  if (userIdx === -1) {
      userMsgError.innerText = "Account with this username or phone number does not exist.";
  } else if (accounts[userIdx].password === password) {
      if (accounts[userIdx].status === 0) {
          userMsgError.innerText = "This account has been locked.";
      } else {
          localStorage.setItem("currentuser", JSON.stringify(accounts[userIdx]));
          toastMsg({ title: "SUCCESS", message: "Login successful!", type: "success" });
          console.log("handleLoginForm(): Signed up");
          updateMenuVisibility();
          toggleModal("login-user");
          document.getElementById("login-form").reset();
      }
  } else {
      passMsgError.innerText = "Password is incorrect.";
  }
}

// To sign out
function signOut() {
  let accounts = JSON.parse(localStorage.getItem("accounts"));
  let user = JSON.parse(localStorage.getItem("currentuser"));
  let idx = accounts.findIndex(item => item.phone == user.phone);

  //Save cart when logged in again
  accounts[idx].cart.length = 0;
  for (let i = 0; i < user.cart.length; i++) {
      accounts[idx].cart[i] = user.cart[i];
  }

  localStorage.setItem("accounts", JSON.stringify(accounts));
  localStorage.removeItem("currentuser");
  console.log("signOut(): Signed out.");
  updateMenuVisibility();
  location.reload();
}

// Load user info to My Account after user has logged in
function loadUserInfo() {
  event.preventDefault();

  const currentuser = JSON.parse(localStorage.getItem("currentuser"));

  if (currentuser) {
      document.getElementById("infoname").value = currentuser.username || "";
      document.getElementById("fullname").value = currentuser.fullname || "";
      document.getElementById("infophone").value = currentuser.phone || "";
      document.getElementById("infoemail").value = currentuser.email || "";
      document.getElementById("infoaddress").value = currentuser.address || "";
  }
}

// Apply changes to current account in My Acocunt
function changeAccInfo() {
  event.preventDefault();

  // Collect updated values from the form
  // let username = document.getElementById("infoname").value.trim();
  let fullname = document.getElementById("fullname").value.trim();
  let phone = document.getElementById("infophone").value.trim();
  let email = document.getElementById("infoemail").value.trim();
  let address = document.getElementById("infoaddress").value.trim();

  let hasError = false;

  // Reset form-msg-error classes
  document.querySelectorAll(".account-user .form-msg-error").forEach(msg => {
      msg.textContent = "";
  });

  // Validation checks
  // if (!username || username.length < 5 || /\W|\s/.test(username)) {
  //     errorMsg.innerHTML += "<p>Username must be at least 5 characters long, no spaces or special characters.</p>";
  // }


  if (!fullname) {
      document.querySelector("#fullname + .form-msg-error").innerText = "Full name cannot be empty.";
      hasError = true;
  }

  if (!phone || !/^\d{10}$/.test(phone)) {
      document.querySelector("#infophone + .form-msg-error").innerText = "Phone number must be exactly 10 digits.";
      hasError = true;
  }

  if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      document.querySelector("#infoemail + .form-msg-error").innerText = "Please enter a valid email address.";
      hasError = true;
  }

  if (!address) {
      document.querySelector("#infoaddress + .form-msg-error").innerText = "Address cannot be empty.";
      hasError = true;
  }

  if (hasError) {
      toastMsg({ title: "ERROR", message: "Please fill in the form correctly.", type: "error" });
      return;
  }

  let updatedUser = {
      // username: username,
      fullname: fullname,
      phone: phone,
      email: email,
      address: address
  };


  const accounts = JSON.parse(localStorage.getItem("accounts"));
  const currentuser = JSON.parse(localStorage.getItem("currentuser"));

  const isPhoneTaken = accounts.some(account => account.phone === phone && account.id !== currentuser.id);

  if (isPhoneTaken) {
      document.querySelector("#infophone + .form-msg-error").innerText = "Phone number is already taken.";
      toastMsg({ title: "ERROR", message: "Phone number already taken! Please try again.", type: "error" });
      return;
  }

  let userIdx = accounts.findIndex(account => account.id === currentuser.id);

  if (userIdx !== -1) {
      accounts[userIdx] = { ...accounts[userIdx], ...updatedUser };
      localStorage.setItem("accounts", JSON.stringify(accounts));
      localStorage.setItem("currentuser", JSON.stringify(accounts[userIdx]));
      toastMsg({ title: "SUCCESS", message: "Account info updated successfully!", type: "success" });
  } else {
      toastMsg({ title: "ERROR", message: "User not found!", type: "error" });
  }
}

function toggleChangePass() {
  let changepass = document.getElementById("user-info-changepass");
  let changeacc = document.getElementById("user-info-changeacc");
  if (changepass.classList.contains("hidden")) {
      changepass.classList.remove("hidden");
      changeacc.classList.add("hidden");
  } else {
      changepass.classList.add("hidden");
      changeacc.classList.remove("hidden");
  }
  window.scrollTo({ top: 0 });
}

// Change current user"s password
function changePassword() {
  event.preventDefault();

  let currentPassword = document.getElementById("password-cur-info").value.trim();
  let newPassword = document.getElementById("password-after-info").value.trim();
  let confirmNewPassword = document.getElementById("password-confirm-info").value.trim();

  let hasError = false;

  // Reset form-msg-error classes
  document.querySelectorAll(".change-password .form-msg-error").forEach(msg => {
      msg.textContent = "";
  });

  const currentuser = JSON.parse(localStorage.getItem("currentuser"));
  const accounts = JSON.parse(localStorage.getItem("accounts"));

  if (!currentPassword) {
      document.querySelector("#password-cur-info + .form-msg-error").innerText = "Please enter current password";
      hasError = true;
  }

  if (currentPassword !== currentuser.password) {
      document.querySelector("#password-cur-info + .form-msg-error").innerText = "Current password is incorrect.";
      hasError = true;
  }

  if (!newPassword || newPassword.length < 5 || /\s/.test(newPassword)) {
      document.querySelector("#password-after-info + .form-msg-error").innerText = "New password must be at least 5 characters long and cannot contain spaces";
      hasError = true;
  }

  if (newPassword === currentPassword) {
      document.querySelector("#password-after-info + .form-msg-error").innerText = "New password must be different from current password.";
      hasError = true;
  }

  if (newPassword !== confirmNewPassword) {
      document.querySelector("#password-confirm-info + .form-msg-error").innerText = "New password and confirmation do not match.";
      hasError = true;
  }

  if (hasError) {
      toastMsg({ title: "ERROR", message: "Please fill in the form correctly.", type: "error" });
      return;
  }

  currentuser.password = newPassword;
  // let userIdx = accounts.findIndex(account => account.phone === currentuser.phone || account.username === currentuser.username);

  accounts[userIdx].password = newPassword;
  localStorage.setItem("accounts", JSON.stringify(accounts));
  localStorage.setItem("currentuser", JSON.stringify(currentuser));
  document.getElementById("changepass-form").reset();
  toastMsg({ title: "SUCCESS", message: "Password changed successfully.", type: "success" });

}

// USER - END DEFINE /////////////////////////////////////////////////////

// CATALOGUE - BEGIN DEFINE /////////////////////////////////////////////////////
// Function to toggle visibility of the dropdown menu
function toggleDropdown(menuId) {
  let menu = document.getElementById(menuId);

  // Close other dropdowns
  document.querySelectorAll(".dropdown-menu").forEach(dropdown => {
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
      document.querySelectorAll(".dropdown-menu").forEach(dropdown => {
          dropdown.style.display = "none";
      });
  }
});

// Initialize: Hide all dropdowns on page load
window.addEventListener("load", function () {
  document.querySelectorAll(".dropdown-menu").forEach(dropdown => {
      dropdown.style.display = "none";
  });
});

// CATALOGUE - FILTER - BEGIN DEFINE /////////////////////////////////////////////////////
// Toggle filter options
const filterOptions = document.querySelectorAll(".filter-option");
const sortbyDisplay = document.getElementById("sortby-mode-display");
const displayCatalogueName = document.getElementById("display-catalogue-name");

filterOptions.forEach(option => {
  option.addEventListener("click", (event) => {
      let clickedElement = event.target;
      if (!clickedElement.classList.contains("active")) {
          clickedElement.classList.add("active");
      } else {
          clickedElement.classList.remove("active");
      }
  });
});

// Toggle sortby
document.querySelector(".sortby .float-dropdown .menu-list").addEventListener("click", (event) => {
  if (event.target.tagName === "A") {
      sortbyDisplay.innerText = event.target.innerText.trim();
      window.scrollTo({ top: 700, behavior: 'smooth' });
      showHomeProduct(JSON.parse(localStorage.getItem("products")))
  }
});

// Toggle & display products by category
document.querySelectorAll(".filter-category").forEach(category => {
  category.addEventListener("click", (event) => {

      // If header-sidebar is open, toggle it off
      let headerSideabar = document.getElementById("header-sidebar");
      if (parseFloat(window.getComputedStyle(headerSideabar).getPropertyValue("width"))) {
          toggleModal("header-sidebar");
      }

      // If toggle-page is open, toggle it off
      let isTogglePage = document.querySelector(".toggle-page:not(.hidden)");
      if (isTogglePage) {
          if (isTogglePage.classList.contains("account-user")) togglePage("account-user");
          if (isTogglePage.classList.contains("order-history")) togglePage("order-history");
      }

      document.querySelectorAll(".category-menu .filter-category.active").forEach(ele => ele.classList.remove("active"));
      event.target.classList.add("active");
      displayCatalogueName.innerText = event.target.innerText.trim();
      resetFilter();
      showHomeProduct(JSON.parse(localStorage.getItem("products")));
  });
});

// Toggle search by name
document.getElementById("search-bar").addEventListener("keyup", () => {
  window.scrollTo({ top: 700, behavior: 'smooth' });
  showHomeProduct(JSON.parse(localStorage.getItem("products")));

})

// Reset all filter & sortby options
function resetFilter() {
  const filterOptions = document.querySelectorAll(".filter-option");
  filterOptions.forEach(option => {
      option.classList.remove("active");
      option.value = "";
  });
  window.scrollTo({ top: 700 });
  sortbyDisplay.textContent = "None";
  showHomeProduct(JSON.parse(localStorage.getItem("products")));
  scrollTo(top);
}

function getFilterOption() {
  const brandOption = Array.from(document.querySelectorAll(".filter-brand.active")).map(option => option.getAttribute("data-filter"));
  const sizeOption = Array.from(document.querySelectorAll(".filter-size.active")).map(option => option.getAttribute("data-filter"));
  const genderOption = Array.from(document.querySelectorAll(".filter-gender.active")).map(option => option.getAttribute("data-filter"));

  // Check if user is on mobile based on the display style if the details-search-bar
  const isMobile = window.getComputedStyle(document.querySelector(".details-search-bar.show-on-mobile.hide-on-pc")).display !== "none";
  console.log("Is mobile device: ", isMobile);

  let categoryOption = document.querySelector(".filter-category.active").getAttribute("data-filter");
  if (categoryOption == "Home")
      categoryOption = ["Sneaker", "Sandal", "Kid"];
  else
      categoryOption = [document.querySelector(".filter-category.active").getAttribute("data-filter")];

  const nameOption = document.getElementById("search-bar").value.trim();
  const sortbyOption = document.getElementById("sortby-mode-display").innerText.trim();

  // Read from field based on isMobile
  let minprice = isMobile ? parseInt(document.getElementById("price-lowerbound-sidebar").value.trim()) || 0 : parseInt(document.getElementById("price-lowerbound").value.trim()) || 0;
  let maxprice = isMobile ? parseInt(document.getElementById("price-upperbound-sidebar").value.trim()) || Infinity : parseInt(document.getElementById("price-upperbound").value.trim()) || Infinity;

  console.log("Filter options:", brandOption, sizeOption, genderOption, sortbyOption, nameOption, categoryOption, minprice, maxprice);

  return { brandOption, sizeOption, genderOption, sortbyOption, nameOption, categoryOption, minprice, maxprice };
}

function filterProducts(products, filters) {
  return products.filter(product => {
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
      if (filters.brandOption.length > 0 && !filters.brandOption.includes(product.brand)) {
          return false;
      }

      // Check gender
      if (filters.genderOption.length > 0 && !filters.genderOption.includes(product.sex)) {
          return false;
      }

      // Check size (at least one matching size is required)
      if (
          filters.sizeOption.length > 0 &&
          !filters.sizeOption.every(size => product.size.includes(Number(size)))
      ) {
          return false;
      }

      console.log(product.id, product.name);
      return true;
  });
}

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

// Start filter if clicked the Apply Filter button
document.querySelectorAll(".apply-filter-btn").forEach(btn => {
  btn.addEventListener("click", () => {
      window.scrollTo({ top: 700 });
      showHomeProduct(JSON.parse(localStorage.getItem("products")));
  });
});

// CATALOGUE - FILTER - END DEFINE /////////////////////////////////////////////////////

// CATALOGUE - CART - BEGIN DEFINE /////////////////////////////////////////////////////

//Get product from the the "products" array

function getCartTotalAmount() {
  let currentuser = JSON.parse(localStorage.getItem("currentuser"));
  let amount = 0;
  currentuser.cart.forEach(element => {
      amount += parseInt(element.quantity);
  });
  return amount;
}

function updateCartTotalAmount() {
  if (!localStorage.getItem("currentuser")) {
      console.log("updateCartTotalAmount(): Not logged in.");
      return;
  }

  let amount = getCartTotalAmount();
  document.querySelectorAll(".display-cart-total-amount").forEach(ele => ele.innerText = amount);
  console.log("updateCartTotalAmount(): ", amount);
}

// Display/update the totalprice of the cart
function updateCartTotalPrice() {
  const total = vnd(getCartTotalPrice());
  document.querySelectorAll(".display-totalprice").forEach(ele => {
      ele.innerText = total;
  });
  document.querySelectorAll(".display-totalorder").forEach(ele => {
      ele.innerText = vnd(getCartTotalPrice() + DELIVERY_FEE);
  })
}

// Get the totalprice of the cart
function getCartTotalPrice() {
  let currentuser = JSON.parse(localStorage.getItem("currentuser"));
  let totalprice = 0;
  if (currentuser != null || currentuser.cart.length) {
      currentuser.cart.forEach(item => {
          totalprice += (parseInt(item.quantity) * parseInt(item.originalPrice));
      });
  }
  return totalprice;
}

// Update total cart amount when changing cartItem quantity
function updateCartAll(id, size, ele) {
  let currentuser = JSON.parse(localStorage.getItem("currentuser"));
  let parent = ele.parentNode;
  console.log("updateCartAll(): ", parent);
  let quantity = parseInt(parent.querySelector(".input-qty").value.trim());
  console.log("updateCartAll(): ", quantity);
  let idx = currentuser.cart.findIndex(item => item.id == id && item.size == size);
  if (idx == -1) {
      console.log("updateCartAll(): Error findIndex()");
      return;
  }
  currentuser.cart[idx].quantity = quantity;
  localStorage.setItem("currentuser", JSON.stringify(currentuser));
  updateCartTotalAmount();
  updateCartTotalPrice();
  // saveCartInfo();
}

//Reset the cart
function resetCart() {
  let accounts = JSON.parse(localStorage.getItem("accounts"));
  let currentuser = JSON.parse(localStorage.getItem("currentuser"));
  currentuser.cart = [];
  localStorage.setItem("currentuser", JSON.stringify(currentuser));

  let userIdx = accounts.findIndex(user => user.phone === currentuser.phone);
  if (userIdx != -1) {
      accounts[userIdx] = currentuser;
      localStorage.setItem("accounts", JSON.stringify(accounts));
  }
  updateCartTotalAmount();
  updateCartTotalPrice();
  updateMenuVisibility();
}

//Add cart item to cart[]
function addCart(id, size, quantity, price) {
  if (!localStorage.getItem("currentuser")) {
      console.log(-1);
      return;
  }

  let currentuser = JSON.parse(localStorage.getItem("currentuser"));

  let cartItem = {
      id: id,
      quantity: quantity,
      size: parseInt(size),
      originalPrice: parseInt(price)
  }

  console.log("Cart item:", cartItem);

  let idx = currentuser.cart.findIndex(item => item.id == cartItem.id && item.size == cartItem.size);
  if (idx === -1) {
      currentuser.cart.push(cartItem);
  } else {
      currentuser.cart[idx].quantity += cartItem.quantity;
  }

  localStorage.setItem("currentuser", JSON.stringify(currentuser));
  updateCartTotalAmount();
  updateCartTotalPrice();
  showCart();
  closeModal();
}

//Delete the cart item
function deleteCartItem(id, size, ele) {
  const checkoutBtn = document.getElementById("cart-checkout-btn");
  let cartParent = ele.parentNode.parentNode;
  cartParent.remove();
  let currentuser = JSON.parse(localStorage.getItem("currentuser"));
  let idx = currentuser.cart.findIndex(item => item.id == id && item.size == size)
  currentuser.cart.splice(idx, 1);

  if (currentuser.cart.length == 0) {
      displayWhenEmpty(".cart .cart-body", displayEmptyHTML_cart);
      checkoutBtn.classList.remove(".active");
      checkoutBtn.disabled = true;
  }
  localStorage.setItem("currentuser", JSON.stringify(currentuser));
  updateCartTotalPrice();
  updateCartTotalAmount();
  console.log("Deleted item cart ID = ", id, ", size = ", size);
  console.log("Updated cart:", currentuser.cart);
}

function showCart() {
  if (!localStorage.getItem("currentuser")) {
      displayWhenEmpty(".cart .cart-body", displayEmptyHTML_cart);
      return;
  }
  let currentuser = JSON.parse(localStorage.getItem("currentuser"));
  const cartBody = document.querySelector(".cart .cart-body");
  const checkoutBtn = document.getElementById("cart-checkout-btn");

  cartBody.innerHTML = "";

  if (currentuser.cart.length !== 0) {
      // Show the checkout button and generate cart items HTML
      checkoutBtn.classList.add("active");
      checkoutBtn.disabled = false;

      let cartItemhtml = "";
      currentuser.cart.forEach(item => {
          let product = getProduct(item);
          cartItemhtml += `
                  <div class="modal-container cart-item" data-productID="${product.id}">
                      <div class="img-container">
                          <img src="${product.image}" onerror="this.src='./asset/img/catalogue/coming-soon.jpg'">
                      </div>
                      <div class="cart-item-info">
                          <p class="display-product-name">${product.name}</p>
                          <p>Brand: <span class="display-product-brand">${product.brand}</span></p>
                          <p>Size: <span class="display-product-size">${product.size}</span></p>
                          <p class="display-product-price">${vnd(item.originalPrice)}</p>
                      </div>
                      <div class="cart-item-control">
                          <a onclick="deleteCartItem('${product.id}', ${product.size}, this)">
                              <i class="fa-regular fa-circle-xmark"></i>
                          </a>
                          <div class="cart-item-amount">
                              <button class="minus is-form" onclick="decreasingNumber(this); updateCartAll('${product.id}',${product.size}, this)">
                                  <i class="fa-solid fa-minus"></i>
                              </button>
                              <input class="input-qty" max="100" min="1" name="" type="number" value="${product.quantity}" onkeyup="updateCartAll('${product.id}',${product.size}, this)">
                              <button class="plus is-form" onclick="increasingNumber(this); updateCartAll('${product.id}',${product.size}, this)">
                                  <i class="fa-solid fa-plus"></i>
                              </button>
                          </div>
                      </div>
                  </div>
              `;
      });
      // Inject cart items into cart body
      cartBody.innerHTML = cartItemhtml;
  } else {
      // If the cart is empty, show the empty message and hide checkout button
      checkoutBtn.classList.remove("active");
      checkoutBtn.disabled = true;
      displayWhenEmpty(".cart .cart-body", displayEmptyHTML_cart);
  }

}

// CATALOGUE - CART - END DEFINE /////////////////////////////////////////////////////

// CATALOGUE - ORDER HISTORY - BEGIN DEFINE /////////////////////////////////////////////////////

function showOrderDetail(orderID) {
  const orders = JSON.parse(localStorage.getItem("orders")) || [];
  const order = orders[orders.findIndex(order => order.id == orderID)];
  const orderDetail = document.getElementById("order-detail");
  orderDetail.innerHTML = `
                  <div class="modal-container mdl-cnt">
                  <h3 class="modal-container-title">ORDER DETAIL</h3>
                  <a onclick="closeModal()" style="position: absolute; right: 16px"><i class="fa-regular fa-circle-xmark"></i></a>
                  <div class="order-detail-row">
                      <span><i class="fa-solid fa-hashtag"></i>Order ID: </span>
                      <span>${order.id}</span>
                  </div>
                  <div class="order-detail-row">
                      <span><i class="fa-regular fa-calendar"></i>Purchase date: </span>
                      <span>${formatDate(order.orderDate)}</span>
                  </div>
                  <div class="order-detail-row">
                      <span><i class="fa-solid fa-location-dot"></i>Delivery address: </span>
                      <span>${order.address.fullAddress}</span>
                  </div>
                  <div class="order-detail-row">
                      <span><i class="fa-solid fa-map-location-dot"></i>Region: </span>
                      <p>${order.address.region.ward}, ${order.address.region.district}, ${order.address.region.province}</p>
                  </div>
                  <div class="order-detail-row">
                      <span><i class="fa-solid fa-cash-register"></i>Payment method: </span>
                      <span>${order.payment.method}</span>
                  </div>
                  <div class="order-detail-row card-payment">
                      <span><i class="fa-solid fa-user"></i>Card owner: </span>
                      <span>${order.payment.cardOwner}</span>
                  </div>
                  <div class="order-detail-row card-payment">
                      <span><i class="fa-regular fa-credit-card"></i>Card number: </span>
                      <span>${order.payment.cardNumber}</span>
                  </div>
              </div>
  `;

  if (order.payment.method.toLowerCase() != "card") {
      orderDetail.querySelectorAll(".card-payment").forEach(item => item.style.display = "none");
  }

  orderDetail.classList.toggle("open");
}

function getOrderHistoryCart(orderCart) {
  let OHCarthtml = ``;

  orderCart.forEach(item => {
      let product = getProduct(item);
      OHCarthtml += `
              <div class="modal-container cart-item" data-productID="${product.id}">
                  <div class="img-container">
                      <img src="${product.image}" onerror="this.src='./asset/img/catalogue/coming-soon.jpg'">
                  </div>
                  <div class="cart-item-info">
                      <p class="display-product-name">${product.name}</p>
                      <p>Brand: <span class="display-product-brand">${product.brand}</span></p>
                      <p>Size: <span class="display-product-size">${product.size}</span></p>
                      <p class="display-product-price">${vnd(product.originalPrice)}</p>
                  </div>
                  <div class="cart-item-amount">
                      <p>x<span class="display-product-quantity">${item.quantity}</span></p>
                  </div>
              </div>
          `;
  });

  return OHCarthtml;
}

function showOrderHistory() {
  let currentuser = JSON.parse(localStorage.getItem("currentuser"));
  let orders = JSON.parse(localStorage.getItem("orders")) || [];

  if (!currentuser) {
      console.log("showOrderHistory(): User not logged in.")
      return;
  }

  let OHbody = document.querySelector(".order-history .main-account-body-col");
  OHbody.innerHTML = "";
  if (orders.length !== 0) {
      let orderhtml = ``;
      orders.forEach((order, idx) => {
          if (order.customerId != currentuser.id) return;
          orderhtml += `
                  <div class="modal-container order-history" datda-orderID="${order.id}">
                      <div class="cart-main">
                          <div class="cart-body" style="max-height: 520px; overflow-y: auto">
                              ${getOrderHistoryCart(order.cart)}
                          </div>
                          <div class="cart-footer">
                              <div class="cart-totalprice">
                                  <p>GRAND TOTAL</p>
                                  <p class="display-totalprice">${vnd(order.total)}</p>
                              </div>
                              <div class="cart-item-status">
                                  <div style="background-color: var(${order_statusColor[order.status]})">
                                      <p class="display-order-status">Status: <span>${order_statusTitle[order.status]}</span>
                                      <span><i class="${order_statusIcon[order.status]}"></i></span></p>
                                  </div>
                                  <button onclick="showOrderDetail('${order.id}')">Details</button>
                              </div>
                          </div>
                      </div>
                  </div>
          `;
      });

      // Inject generated order history HTML into OHbody
      OHbody.innerHTML = orderhtml;
      console.log(OHbody);
  } else {
      displayWhenEmpty(".order-history .main-account-body-col", displayEmptyHTML_orderhistory);
  }
}

// CATALOGUE - ORDER HISTORY - END DEFINE /////////////////////////////////////////////////////

// CATALOGUE - PRODUCTS - BEGIN DEFINE /////////////////////////////////////////////////////
function increasingNumber(e) {
  let qty = e.parentNode.querySelector('.input-qty');
  if (parseInt(qty.value) < qty.max) {
      qty.value = parseInt(qty.value) + 1;
  } else {
      qty.value = qty.max;
  }
}

function decreasingNumber(e) {
  let qty = e.parentNode.querySelector('.input-qty');
  if (qty.value > qty.min) {
      qty.value = parseInt(qty.value) - 1;
  } else {
      qty.value = qty.min;
  }
}

function detailProduct(id) {
  let modal = document.querySelector('.modal.product-detail');
  let products = JSON.parse(localStorage.getItem('products'));
  event.preventDefault();
  let infoProduct = products.find(sp => {
      return sp.id === id;
  })
  const sizeButtonsHTML = infoProduct.size.map(size => `
      <button class="size-button">${size}</button>
  `).join("");
  let modalHtml = `
  <div class="img-container">
      <img src="${infoProduct.image}" alt="" onerror="this.src='./asset/img/catalogue/coming-soon.jpg'">
  </div>
  <div class="modal-body">
      <h2 class="product-title">${infoProduct.name}</h2>
      <div class="product-control">
          <div class="priceBox">
              <span class="current-price">${vnd(infoProduct.price)}</span>
          </div>
           <div class="buttons_added">
              <button class="minus is-form" type="button" value="-" onclick="decreasingNumber(this)">
                  <i class="fa-solid fa-minus"></i>
              </button>
              <input class="input-qty" max="100" min="1" name="" type="number" value="1">
              <button class="plus is-form" type="button" value="+" onclick="increasingNumber(this)">
                  <i class="fa-solid fa-plus"></i>
              </button>
          </div>
      </div>
  </div>
  <div class="size-container">${sizeButtonsHTML}</div>
  <div class="modal-footer">
      <div class="price-total">
          <span class="thanhtien">Total</span>
          <span class="price">${vnd(infoProduct.price)}</span>
      </div>
      <div class="modal-footer-control">
          <button class="checkout-btn" data-product="${infoProduct.id}">Buy now</button>
          <button class="button-dat" id="add-cart"><i class="fa-solid fa-cart-shopping "></i></button>
      </div>
  </div>`;
  document.querySelector('#product-detail-content').innerHTML = modalHtml;
  modal.classList.add('open');
  body.style.overflow = "hidden";

  //Cap nhat gia tien khi tang so luong san pham
  let tgbtn = document.querySelectorAll('.is-form');
  let qty = document.querySelector('.product-control .input-qty');
  let priceText = document.querySelector('.price');
  tgbtn.forEach(element => {
      element.addEventListener('click', () => {
          let price = infoProduct.price * parseInt(qty.value.trim());
          priceText.innerHTML = vnd(price);
      });
  });

  // Select a shoes size
  let selectedSize;
  document.querySelector(".size-container").addEventListener("click", (event) => {
      if (event.target.tagName === "BUTTON") {
          document.querySelectorAll(".size-container button").forEach(button => {
              button.classList.remove("active");
          });

          event.target.classList.add("active");
          selectedSize = event.target.textContent.trim();
          console.log("Selected size: " + selectedSize);
      }
  });

  modal.querySelector('.button-dat').addEventListener('click', () => {
      if (!selectedSize) {
          toastMsg({ title: "REMINDER", message: "Please chose a shoe size first!", type: "warning" });
          return;
      }

      if (localStorage.getItem('currentuser')) {
          addCart(infoProduct.id, selectedSize, parseInt(qty.value), infoProduct.price);
      } else {
          toastMsg({ title: "REMINDER", message: "Please login first!", type: "warning" });
          closeModal();
      }
  });

  modal.querySelector(".checkout-btn").addEventListener("click", () => {
      if (!selectedSize) {
          toastMsg({ title: "REMINDER", message: "Please chose a shoe size first!", type: "warning" });
          return;
      }

      if (localStorage.getItem('currentuser')) {
          addCart(infoProduct.id, selectedSize, parseInt(qty.value), infoProduct.price);
          showCartCheckout();
          toggleModal("checkout-page");
      } else {
          toastMsg({ title: "REMINDER", message: "Please login first!", type: "warning" });
          closeModal();
      }
  });

}

function displayProducts(productShow) {
  const productContainer = document.getElementById("home-product");
  productContainer.innerHTML = ""; // Clear current content

  let productHTML = ""; // Create HTML string
  if (productShow.length !== 0) {
      productShow.forEach(product => {
          if (product.isDeleted) return;

          productHTML += `
          <div class="product-box" onclick="detailProduct('${product.id}')">
              <div class="img-container">
                  <img src="${product.image}" alt="${product.name}" onerror="this.src='./asset/img/catalogue/coming-soon.jpg'" />
              </div>
              <div class="shoes-name">${product.name}</div>
              <div class="shoes-price">${vnd(product.price)}</div>
          </div>
      `;
      });

      productContainer.innerHTML = productHTML;
  } else {
      // No products to show
      productContainer.style.display = "flex"; // Ensure the container is visible
      displayWhenEmpty("#home-product", displayEmptyHTML_catalogue);
  }
}


// Phân trang 

let currentPage = 1;
function displayList(productAll, perPage, currentPage) {
  let start = (currentPage - 1) * perPage;
  let end = (currentPage - 1) * perPage + perPage;
  let productShow = productAll.slice(start, end);
  displayProducts(productShow);
}

function showHomeProduct(products) {
  const filters = getFilterOption();

  console.group("Filtered products");
  let filteredProducts = filterProducts(products, filters);
  console.groupEnd();

  filteredProducts = sortProducts(filteredProducts, filters.sortbyOption);
  let displayCatalogueAmount = document.getElementById("display-catalogue-amount");
  displayCatalogueAmount.textContent = filteredProducts.length + " ";

  displayList(filteredProducts, perPage, currentPage);
  setupPagination(filteredProducts, perPage);
  window.scrollTo({ top: 700 });
}

function setupPagination(productAll, perPage) {
  const pageNav = document.querySelector('.page-nav'); // Get the pagination container
  const pageNavList = document.querySelector('.page-nav-list'); // Get the list inside pagination

  // Clear previous pagination content
  pageNavList.innerHTML = '';

  // Handle case where no products are available
  if (productAll.length === 0 || productAll.length <= perPage) {
      pageNav.style.display = 'none'; // Hide pagination
      return; // Exit the function early
  }

  // Show pagination if there are products
  pageNav.style.display = 'flex'; // Ensure pagination is visible

  // Calculate the number of pages
  let page_count = Math.ceil(productAll.length / perPage);

  // Generate pagination items
  for (let i = 1; i <= page_count; i++) {
      let li = paginationChange(i, productAll, currentPage);
      pageNavList.appendChild(li);
  }
}

function paginationChange(page, productAll, currentPage) {
  let node = document.createElement(`li`);
  node.classList.add('page-nav-item');
  node.innerHTML = `<a href="javascript:;">${page}</a>`;
  if (currentPage == page) node.classList.add('active');
  node.addEventListener('click', function () {
      currentPage = page;
      displayList(productAll, perPage, currentPage);
      let t = document.querySelectorAll('.page-nav-item.active');
      for (let i = 0; i < t.length; i++) {
          t[i].classList.remove('active');
      }
      node.classList.add('active');
      window.scrollTo({ top: 700, behavior: 'smooth' });
  })
  return node;
}

window.onload = () => {
  window.scrollTo({ top: 0 });
  createProduct(); // Ensure products are created in localStorage
  createBetaAccount();
  createBetaOrder();

  let products = JSON.parse(localStorage.getItem('products')); // Fetch the products from localStorage
  showHomeProduct(products); // Display products after initialization

  initializeProvinces();

  updateMenuVisibility();
}

// CATALOGUE - PRODUCTS - END DEFINE /////////////////////////////////////////////////////
// CATALOGUE - END DEFINE /////////////////////////////////////////////////////