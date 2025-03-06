//Khoi tao danh sach san pham
function createProduct() {
  if (localStorage.getItem("products") == null) {
    let products = [
      {
        id: 1,
        name: "70 COURT CANVAS HI",
        price: "2000000",
        image: "./layout/asset/img/catalogue/70-COURT-CANVAS-HI.jpg",
        category: "Sneaker",
        brand: "Converse",
        sex: "U",
        size: [36, 37, 38, 41, 42],
        isDeleted: false,
      },
      {
        id: 2,
        name: "AIR FLIGHT 89 (GS)",
        price: "2400000",
        image: "./layout/asset/img/catalogue/AIR-FLIGHT-89-(GS).jpg",
        category: "Sneaker",
        brand: "Nike",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 3,
        name: "AIR FORCE 1 LV8-3 (GS)",
        price: "3200000",
        image: "./layout/asset/img/catalogue/AIR-FORCE-1-LV8-3-(GS).jpg",
        category: "Sneaker",
        brand: "Nike",
        sex: "U",
        size: [36, 37, 38, 41, 42],
        isDeleted: false,
      },
      {
        id: 4,
        name: "AIR FORCE 1'07",
        price: "3500000",
        image: "./layout/asset/img/catalogue/AIR-FORCE-1'07.jpg",
        category: "Sneaker",
        brand: "Nike",
        sex: "U",
        size: [36, 37, 38, 41, 42],
        isDeleted: false,
      },
      {
        id: 5,
        name: "AIR MAX 90 LTR",
        price: "4600000",
        image: "./layout/asset/img/catalogue/AIR-MAX-90-LTR.jpg",
        category: "Sneaker",
        brand: "Nike",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 6,
        name: "AIR TERRRA HUMARA",
        price: "3200000",
        image: "./layout/asset/img/catalogue/AIR-TERRA-HUMARA.jpg",
        category: "Sneaker",
        brand: "Nike",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 7,
        name: "AIRIZONA VEG THYME",
        price: "3500000",
        image: "./layout/asset/img/catalogue/AIRIZONA-VEG-THYME.jpg",
        category: "Sandal",
        brand: "BirkenStock",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 8,
        name: "ARIZONA BLACKBIRKO FLOR SFB",
        price: "3200000",
        image: "./layout/asset/img/catalogue/ARIZONA-BLACKBIRKO-FLOR-SFB.jpg",
        category: "Sandal",
        brand: "BirkenStock",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 9,
        name: "ARIZONA TOBACCO BROWN OILDED LEATHER",
        price: "4000000",
        image: "./layout/asset/img/catalogue/ARIZONA-TOBACCO-BROWN-OILED-LEATHER.jpg",
        category: "Sandal",
        brand: "BirkenStock",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 10,
        name: "CHUCK 70 SEASONAL",
        price: "1650000",
        image: "./layout/asset/img/catalogue/CHUCK-70-SEASONAL.jpg",
        category: "Sneaker",
        brand: "Converse",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 11,
        name: "DUNK LOW (W)",
        price: "3500000",
        image: "./layout/asset/img/catalogue/DUNK-LOW-(W).jpg",
        category: "Sneaker",
        brand: "Nike",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 12,
        name: "FASTBREAK PRO SUEDE MID",
        price: "2800000",
        image: "./layout/asset/img/catalogue/FASTBREAK-PRO-SUEDE-MID.jpg",
        category: "Sneaker",
        brand: "Converse",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 13,
        name: "FENG CHENG WANG QS",
        price: "4200000",
        image: "./layout/asset/img/catalogue/FENG-CHENG-WANG-QS.jpg",
        category: "Sneaker",
        brand: "Converse",
        sex: "U",
        size: [36, 37, 38, 41, 42],
        isDeleted: false,
      },
      {
        id: 14,
        name: "GAZELLE (PS)",
        price: "1800000",
        image: "./layout/asset/img/catalogue/GAZELLE-(PS).jpg",
        category: "Kid",
        brand: "Adidas",
        sex: "U",
        size: [20, 21, 22, 23, 24],
        isDeleted: false,
      },
      {
        id: 15,
        name: "GAZELLE INDOOR (W)",
        price: "2800000",
        image: "./layout/asset/img/catalogue/GAZELLE-INDOOR-(W).jpg",
        category: "Sneaker",
        brand: "Adidas",
        sex: "F",
        size: [36, 37, 38, 39],
        isDeleted: false,
      },
      {
        id: 16,
        name: "HANDBALL SPEZIAL (W)",
        price: "2500000",
        image: "./layout/asset/img/catalogue/HANDBALL-SPEZIAL-(W).jpg",
        category: "Sneaker",
        brand: "Adidas",
        sex: "F",
        size: [36, 37, 38, 39],
        isDeleted: false,
      },
      {
        id: 17,
        name: "NIKE CALM BEIGE (W)",
        price: "2349000",
        image: "./layout/asset/img/catalogue/Nike_Calm_Be(w).jpg",
        category: "Sandal",
        brand: "Nike",
        sex: "F",
        size: [36, 37, 38, 39],
        isDeleted: false,
      },
      {
        id: 18,
        name: "NMD S1",
        price: "3000000",
        image: "./layout/asset/img/catalogue/NMD_S1.jpg",
        category: "Sneaker",
        brand: "Adidas",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 19,
        name: "RUN STAR HIKE HI",
        price: "3200000",
        image: "./layout/asset/img/catalogue/RUN-STAR-HIKE-HI.jpg",
        category: "Sneaker",
        brand: "Converse",
        sex: "U",
        size: [36, 37, 38, 41, 42],
        isDeleted: false,
      },
      {
        id: 20,
        name: "SAMBA OG",
        price: "2500000",
        image: "./layout/asset/img/catalogue/SAMBA-OG.jpg",
        category: "Sneaker",
        brand: "Adidas",
        sex: "U",
        size: [36, 37, 38, 41, 42],
        isDeleted: false,
      },
      {
        id: 21,
        name: "SABA XLG",
        price: "3500000",
        image: "./layout/asset/img/catalogue/SAMBA-XLG.jpg",
        category: "Sneaker",
        brand: "Adidas",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 22,
        name: "SL72 RS (PS)",
        price: "2000000",
        image: "./layout/asset/img/catalogue/SL-72-RS-(PS).jpg",
        category: "Kid",
        brand: "Adidas",
        sex: "U",
        size: [20, 21, 22, 23, 24],
        isDeleted: false,
      },
      {
        id: 23,
        name: "SL72 RS (TD)",
        price: "1800000",
        image: "./layout/asset/img/catalogue/SL72-RS-(TD).jpg",
        category: "Kid",
        brand: "Adidas",
        sex: "U",
        size: [20, 21, 22, 23, 24],
        isDeleted: false,
      },
      {
        id: 24,
        name: "SL72 RS",
        price: "2500000",
        image: "./layout/asset/img/catalogue/SL72-RS.jpg",
        category: "Sneaker",
        brand: "Adidas",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 25,
        name: "STAN SMITH (TD)",
        price: "1500000",
        image: "./layout/asset/img/catalogue/STAN-SMITH-(TD).jpg",
        category: "Kid",
        brand: "Adidas",
        sex: "U",
        size: [20, 21, 22, 23, 24],
        isDeleted: false,
      },
      {
        id: 26,
        name: "SUPERSTAR",
        price: "2500000",
        image: "./layout/asset/img/catalogue/SUPERSTAR.jpg",
        category: "Sneaker",
        brand: "Adidas",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 27,
        name: "TEVA HURRICANE DRIFT (M)",
        price: "990000",
        image: "./layout/asset/img/catalogue/Teva_Hurricane_Drift(m)-990k.jpg",
        category: "Sandal",
        brand: "Teva",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 28,
        name: "TEVA TERRA FI 5 UNIVERSAL",
        price: "2099000",
        image: "./layout/asset/img/catalogue/Teva_Terra_Fi_5_Universal-2099k.jpg",
        category: "Sandal",
        brand: "Teva",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
      {
        id: 29,
        name: "TEVA VOYA STRAPPY (W)",
        price: "845000",
        image: "./layout/asset/img/catalogue/Teva_Voya_Strappy(w)-845k.jpg",
        category: "Sandal",
        brand: "Teva",
        sex: "F",
        size: [36, 37, 38, 39],
        isDeleted: false,
      },
      {
        id: 30,
        name: "TEVA ZYMIC (W)",
        price: "1600000",
        image: "./layout/asset/img/catalogue/Teva_Zymic-1600k(w).jpg",
        category: "Sandal",
        brand: "Teva",
        sex: "F",
        size: [36, 37, 38, 39],
        isDeleted: false,
      },
      {
        id: 31,
        name: "TEVA SANDALS HURRICANE (W)",
        price: "1900000",
        image: "./layout/asset/img/catalogue/TevaSandalsHunrricane(w).jpg",
        category: "Sandal",
        brand: "Teva",
        sex: "F",
        size: [36, 37, 38, 39],
        isDeleted: false,
      },
      {
        id: 32,
        name: "UNISEX FILA PONG SD (W)",
        price: "1595000",
        image: "./layout/asset/img/catalogue/Unisex_Fila_Pong_Sd-1595k(w).jpg",
        category: "Sandal",
        brand: "Fila",
        sex: "F",
        size: [36, 37, 38, 39],
        isDeleted: false,
      },
      {
        id: 33,
        name: "UNISEX FILA TORI (M)",
        price: "1995000",
        image: "./layout/asset/img/catalogue/unisex_fila_tori-1995k(m).jpg",
        category: "Sandal",
        brand: "Fila",
        sex: "M",
        size: [41, 42, 43],
        isDeleted: false,
      },
    ];
    localStorage.setItem("products", JSON.stringify(products));
  }
}
const product = JSON.parse(localStorage.getItem("products"));
console.log(typeof product);
let productArray = Array.from(product);
while (productArray.length > 0) {
  productArray.pop(); // Hoặc arr.shift() nếu muốn xóa từ đầu
}
productArray = [
  {
    id: 1,
    name: "70 COURT CANVAS HI",
    price: "2000000",
    image: "./layout/asset/img/catalogue/70-COURT-CANVAS-HI.jpg",
    category: "Sneaker",
    brand: "Converse",
    sex: "U",
    size: [36, 37, 38, 41, 42],
    isDeleted: false,
  },
  {
    id: 2,
    name: "AIR FLIGHT 89 (GS)",
    price: "2400000",
    image: "./layout/asset/img/catalogue/AIR-FLIGHT-89-(GS).jpg",
    category: "Sneaker",
    brand: "Nike",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 3,
    name: "AIR FORCE 1 LV8-3 (GS)",
    price: "3200000",
    image: "./layout/asset/img/catalogue/AIR-FORCE-1-LV8-3-(GS).jpg",
    category: "Sneaker",
    brand: "Nike",
    sex: "U",
    size: [36, 37, 38, 41, 42],
    isDeleted: false,
  },
  {
    id: 4,
    name: "AIR FORCE 1'07",
    price: "3500000",
    image: "./layout/asset/img/catalogue/AIR-FORCE-1'07.jpg",
    category: "Sneaker",
    brand: "Nike",
    sex: "U",
    size: [36, 37, 38, 41, 42],
    isDeleted: false,
  },
  {
    id: 5,
    name: "AIR MAX 90 LTR",
    price: "4600000",
    image: "./layout/asset/img/catalogue/AIR-MAX-90-LTR.jpg",
    category: "Sneaker",
    brand: "Nike",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 6,
    name: "AIR TERRRA HUMARA",
    price: "3200000",
    image: "./layout/asset/img/catalogue/AIR-TERRA-HUMARA.jpg",
    category: "Sneaker",
    brand: "Nike",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 7,
    name: "AIRIZONA VEG THYME",
    price: "3500000",
    image: "./layout/asset/img/catalogue/AIRIZONA-VEG-THYME.jpg",
    category: "Sandal",
    brand: "BirkenStock",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 8,
    name: "ARIZONA BLACKBIRKO FLOR SFB",
    price: "3200000",
    image: "./layout/asset/img/catalogue/ARIZONA-BLACKBIRKO-FLOR-SFB.jpg",
    category: "Sandal",
    brand: "BirkenStock",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 9,
    name: "ARIZONA TOBACCO BROWN OILDED LEATHER",
    price: "4000000",
    image: "./layout/asset/img/catalogue/ARIZONA-TOBACCO-BROWN-OILED-LEATHER.jpg",
    category: "Sandal",
    brand: "BirkenStock",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 10,
    name: "CHUCK 70 SEASONAL",
    price: "1650000",
    image: "./layout/asset/img/catalogue/CHUCK-70-SEASONAL.jpg",
    category: "Sneaker",
    brand: "Converse",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 11,
    name: "DUNK LOW (W)",
    price: "3500000",
    image: "./layout/asset/img/catalogue/DUNK-LOW-(W).jpg",
    category: "Sneaker",
    brand: "Nike",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 12,
    name: "FASTBREAK PRO SUEDE MID",
    price: "2800000",
    image: "./layout/asset/img/catalogue/FASTBREAK-PRO-SUEDE-MID.jpg",
    category: "Sneaker",
    brand: "Converse",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 13,
    name: "FENG CHENG WANG QS",
    price: "4200000",
    image: "./layout/asset/img/catalogue/FENG-CHENG-WANG-QS.jpg",
    category: "Sneaker",
    brand: "Converse",
    sex: "U",
    size: [36, 37, 38, 41, 42],
    isDeleted: false,
  },
  {
    id: 14,
    name: "GAZELLE (PS)",
    price: "1800000",
    image: "./layout/asset/img/catalogue/GAZELLE-(PS).jpg",
    category: "Kid",
    brand: "Adidas",
    sex: "U",
    size: [20, 21, 22, 23, 24],
    isDeleted: false,
  },
  {
    id: 15,
    name: "GAZELLE INDOOR (W)",
    price: "2800000",
    image: "./layout/asset/img/catalogue/GAZELLE-INDOOR-(W).jpg",
    category: "Sneaker",
    brand: "Adidas",
    sex: "F",
    size: [36, 37, 38, 39],
    isDeleted: false,
  },
  {
    id: 16,
    name: "HANDBALL SPEZIAL (W)",
    price: "2500000",
    image: "./layout/asset/img/catalogue/HANDBALL-SPEZIAL-(W).jpg",
    category: "Sneaker",
    brand: "Adidas",
    sex: "F",
    size: [36, 37, 38, 39],
    isDeleted: false,
  },
  {
    id: 17,
    name: "NIKE CALM BEIGE (W)",
    price: "2349000",
    image: "./layout/asset/img/catalogue/Nike_Calm_Be(w).jpg",
    category: "Sandal",
    brand: "Nike",
    sex: "F",
    size: [36, 37, 38, 39],
    isDeleted: false,
  },
  {
    id: 18,
    name: "NMD S1",
    price: "3000000",
    image: "./layout/asset/img/catalogue/NMD_S1.jpg",
    category: "Sneaker",
    brand: "Adidas",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 19,
    name: "RUN STAR HIKE HI",
    price: "3200000",
    image: "./layout/asset/img/catalogue/RUN-STAR-HIKE-HI.jpg",
    category: "Sneaker",
    brand: "Converse",
    sex: "U",
    size: [36, 37, 38, 41, 42],
    isDeleted: false,
  },
  {
    id: 20,
    name: "SAMBA OG",
    price: "2500000",
    image: "./layout/asset/img/catalogue/SAMBA-OG.jpg",
    category: "Sneaker",
    brand: "Adidas",
    sex: "U",
    size: [36, 37, 38, 41, 42],
    isDeleted: false,
  },
  {
    id: 21,
    name: "SABA XLG",
    price: "3500000",
    image: "./layout/asset/img/catalogue/SAMBA-XLG.jpg",
    category: "Sneaker",
    brand: "Adidas",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 22,
    name: "SL72 RS (PS)",
    price: "2000000",
    image: "./layout/asset/img/catalogue/SL-72-RS-(PS).jpg",
    category: "Kid",
    brand: "Adidas",
    sex: "U",
    size: [20, 21, 22, 23, 24],
    isDeleted: false,
  },
  {
    id: 23,
    name: "SL72 RS (TD)",
    price: "1800000",
    image: "./layout/asset/img/catalogue/SL72-RS-(TD).jpg",
    category: "Kid",
    brand: "Adidas",
    sex: "U",
    size: [20, 21, 22, 23, 24],
    isDeleted: false,
  },
  {
    id: 24,
    name: "SL72 RS",
    price: "2500000",
    image: "./layout/asset/img/catalogue/SL72-RS.jpg",
    category: "Sneaker",
    brand: "Adidas",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 25,
    name: "STAN SMITH (TD)",
    price: "1500000",
    image: "./layout/asset/img/catalogue/STAN-SMITH-(TD).jpg",
    category: "Kid",
    brand: "Adidas",
    sex: "U",
    size: [20, 21, 22, 23, 24],
    isDeleted: false,
  },
  {
    id: 26,
    name: "SUPERSTAR",
    price: "2500000",
    image: "./layout/asset/img/catalogue/SUPERSTAR.jpg",
    category: "Sneaker",
    brand: "Adidas",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 27,
    name: "TEVA HURRICANE DRIFT (M)",
    price: "990000",
    image: "./layout/asset/img/catalogue/Teva_Hurricane_Drift(m)-990k.jpg",
    category: "Sandal",
    brand: "Teva",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 28,
    name: "TEVA TERRA FI 5 UNIVERSAL",
    price: "2099000",
    image: "./layout/asset/img/catalogue/Teva_Terra_Fi_5_Universal-2099k.jpg",
    category: "Sandal",
    brand: "Teva",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
  {
    id: 29,
    name: "TEVA VOYA STRAPPY (W)",
    price: "845000",
    image: "./layout/asset/img/catalogue/Teva_Voya_Strappy(w)-845k.jpg",
    category: "Sandal",
    brand: "Teva",
    sex: "F",
    size: [36, 37, 38, 39],
    isDeleted: false,
  },
  {
    id: 30,
    name: "TEVA ZYMIC (W)",
    price: "1600000",
    image: "./layout/asset/img/catalogue/Teva_Zymic-1600k(w).jpg",
    category: "Sandal",
    brand: "Teva",
    sex: "F",
    size: [36, 37, 38, 39],
    isDeleted: false,
  },
  {
    id: 31,
    name: "TEVA SANDALS HURRICANE (W)",
    price: "1900000",
    image: "./layout/asset/img/catalogue/TevaSandalsHunrricane(w).jpg",
    category: "Sandal",
    brand: "Teva",
    sex: "F",
    size: [36, 37, 38, 39],
    isDeleted: false,
  },
  {
    id: 32,
    name: "UNISEX FILA PONG SD (W)",
    price: "1595000",
    image: "./layout/asset/img/catalogue/Unisex_Fila_Pong_Sd-1595k(w).jpg",
    category: "Sandal",
    brand: "Fila",
    sex: "F",
    size: [36, 37, 38, 39],
    isDeleted: false,
  },
  {
    id: 33,
    name: "UNISEX FILA TORI (M)",
    price: "1995000",
    image: "./layout/asset/img/catalogue/unisex_fila_tori-1995k(m).jpg",
    category: "Sandal",
    brand: "Fila",
    sex: "M",
    size: [41, 42, 43],
    isDeleted: false,
  },
];
localStorage.setItem("products", JSON.stringify(productArray));
// product.
// Doi sang dinh dang tien VND
function vnd(price) {
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(price);
}

// Close popup
const body = document.querySelector("body");
let modalContainer = document.querySelectorAll(".modal");
let modalBox = document.querySelectorAll(".mdl-cnt");

// Click vùng ngoài sẽ tắt Popup
modalContainer.forEach((item) => {
  item.addEventListener("click", closeModal);
});

modalBox.forEach((item) => {
  item.addEventListener("click", function (event) {
    event.stopPropagation();
  });
});

function closeModal() {
  modalContainer.forEach((item) => {
    item.classList.remove("open");
  });
  // console.log(modalContainer);
  body.style.overflow = "auto";
}

function increasingNumber(e) {
  let qty = e.parentNode.querySelector(".input-qty");
  if (parseInt(qty.value) < qty.max) {
    qty.value = parseInt(qty.value) + 1;
  } else {
    qty.value = qty.max;
  }
}

function decreasingNumber(e) {
  let qty = e.parentNode.querySelector(".input-qty");
  if (qty.value > qty.min) {
    qty.value = parseInt(qty.value) - 1;
  } else {
    qty.value = qty.min;
  }
}

function detailProduct(index) {
  let modal = document.querySelector(".modal.product-detail");
  let products = JSON.parse(localStorage.getItem("products"));
  event.preventDefault();
  let infoProduct = products.find((sp) => {
    return sp.id === index;
  });
  const sizeButtonsHTML = infoProduct.size
    .map(
      (size) => `
        <button class="size-button">${size}</button>
    `
    )
    .join("");
  let modalHtml = `
    <div class="img-container">
        <img src="${infoProduct.image}" alt="">
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
    <div class="size-container">${sizeButtonsHTML}</div>
    <div class="modal-footer">
        <div class="price-total">
            <span class="thanhtien">Total</span>
            <span class="price">${vnd(infoProduct.price)}</span>
        </div>
        <div class="modal-footer-control">
            <button class="button-dathangngay" data-product="${
              infoProduct.id
            }">Buy now</button>
            <button class="button-dat" id="add-cart"><i class="fa-solid fa-cart-shopping "></i></button>
        </div>
    </div>`;
  document.querySelector("#product-detail-content").innerHTML = modalHtml;
  modal.classList.add("open");
  body.style.overflow = "hidden";

  //Cap nhat gia tien khi tang so luong san pham
  let tgbtn = document.querySelectorAll(".is-form");
  let qty = document.querySelector(".product-control .input-qty");
  let priceText = document.querySelector(".price");
  tgbtn.forEach((element) => {
    element.addEventListener("click", () => {
      let price = infoProduct.price * parseInt(qty.value.trim());
      priceText.innerHTML = vnd(price);
    });
  });

  // qty.addEventListener("keyup", () => {
  //     qty.value = qty.value.trim().replace(/[^0-9]/g, "");

  //     let quantity = parseInt(qty.value.trim());
  //     let price = infoProduct.price * (isNaN(quantity) ? 0 : quantity);

  //     priceText.innerHTML = vnd(price);
  // });

  // Select a shoes size
  let selectedSize;
  document
    .querySelector(".size-container")
    .addEventListener("click", (event) => {
      if (event.target.tagName === "BUTTON") {
        document
          .querySelectorAll(".size-container button")
          .forEach((button) => {
            button.classList.remove("active");
          });

        event.target.classList.add("active");
        selectedSize = event.target.textContent.trim();
        console.log("Selected size: " + selectedSize);
      }
    });

  document.querySelector(".button-dat").addEventListener("click", () => {
    if (!selectedSize) {
      toastMsg({ title: "HELP", message: "Chose a shoe size!", type: "info" });
      return;
    }

    if (localStorage.getItem("currentuser")) {
      addCart(infoProduct.id, selectedSize, parseInt(qty.value));
    } else {
      toastMsg({
        title: "HELP",
        message: "Please login to add to cart.",
        type: "info",
      });
      closeModal();
    }
  });
}

function displayProducts(productShow) {
  const productContainer = document.getElementById("home-product");
  productContainer.innerHTML = ""; // Clear current content

  let productHTML = ""; // Create HTML string

  productShow.forEach((product) => {
    if (product.isDeleted) return;

    productHTML += `
            <div class="product-box" onclick="detailProduct(${product.id})">
                <div class="img-container">
                    <img src="${product.image}" alt="${
      product.name
    }" onerror="this.src='./layout/asset/img/catalogue/coming-soon.jpg'" />
                </div>
                <div class="shoes-name">${product.name}</div>
                <div class="shoes-price">${vnd(product.price)}</div>
            </div>
        `;
  });

  productContainer.innerHTML = productHTML;
}

// Phân trang
let perPage = 8;
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
  let displayCatalogueAmount = document.getElementById(
    "display-catalogue-amount"
  );
  displayCatalogueAmount.textContent = filteredProducts.length + " ";

  displayList(filteredProducts, perPage, currentPage);
  setupPagination(filteredProducts, perPage);
  window.scrollTo({ top: 0 });
}

function setupPagination(productAll, perPage) {
  document.querySelector(".page-nav-list").innerHTML = "";
  let page_count = Math.ceil(productAll.length / perPage);
  for (let i = 1; i <= page_count; i++) {
    let li = paginationChange(i, productAll, currentPage);
    document.querySelector(".page-nav-list").appendChild(li);
  }
}

function paginationChange(page, productAll, currentPage) {
  let node = document.createElement(`li`);
  node.classList.add("page-nav-item");
  node.innerHTML = `<a href="javascript:;">${page}</a>`;
  if (currentPage == page) node.classList.add("active");
  node.addEventListener("click", function () {
    currentPage = page;
    displayList(productAll, perPage, currentPage);
    let t = document.querySelectorAll(".page-nav-item.active");
    for (let i = 0; i < t.length; i++) {
      t[i].classList.remove("active");
    }
    node.classList.add("active");
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
  return node;
}

window.onload = () => {
  window.scrollTo({ top: 0 });
  createProduct(); // Ensure products are created in localStorage
  let products = JSON.parse(localStorage.getItem("products")); // Fetch the products from localStorage
  showHomeProduct(products); // Display products after initialization

  //For main.js
  updateMenuVisibility();
  updateCartTotalPrice();
  updateCartTotalAmount();
  showCart();
};
