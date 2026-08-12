// ============ CART MANAGEMENT ============
let cart = JSON.parse(localStorage.getItem("blissBitesCart")) || [];

function addToCart(cakeName, price) {
  const existingItem = cart.find((item) => item.name === cakeName);

  if (existingItem) {
    existingItem.quantity++;
  } else {
    cart.push({
      name: cakeName,
      price: price,
      quantity: 1,
      weight: "1 Pound",
    });
  }

  localStorage.setItem("blissBitesCart", JSON.stringify(cart));
  updateCartCount();
  showToast(cakeName + " added to cart!");
}

function updateCartCount() {
  const count = cart.reduce((sum, item) => sum + item.quantity, 0);
  // Update cart badge if exists
  const cartBadge = document.getElementById("cartCount");
  if (cartBadge) {
    cartBadge.textContent = count;
    cartBadge.style.display = count > 0 ? "inline" : "none";
  }
}

function showToast(message) {
  const toast = document.createElement("div");
  toast.className = "toast-notification";
  toast.innerHTML = '<i class="bi bi-check-circle me-2"></i>' + message;
  toast.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: var(--peach-dark);
        color: white;
        padding: 15px 25px;
        border-radius: 10px;
        z-index: 9999;
        animation: slideInRight 0.3s ease;
        box-shadow: 0 5px 20px rgba(240,128,128,0.4);
        font-weight: 500;
    `;
  document.body.appendChild(toast);

  setTimeout(() => {
    toast.style.animation = "slideOutRight 0.3s ease";
    setTimeout(() => toast.remove(), 300);
  }, 2000);
}

// ============ CAKE FILTER ============
function filterCakes(type, btn) {
  // Update active button
  document.querySelectorAll(".filter-btn").forEach((b) => {
    b.classList.remove("active");
    b.style.background = "var(--peach-pale)";
    b.style.color = "var(--peach-dark)";
  });
  btn.classList.add("active");
  btn.style.background = "var(--peach-dark)";
  btn.style.color = "white";

  // Filter cakes
  const cakes = document.querySelectorAll(".cake-item");
  cakes.forEach((cake) => {
    if (type === "all" || cake.dataset.type === type) {
      cake.style.display = "block";
    } else {
      cake.style.display = "none";
    }
  });
}

// ============ SMOOTH SCROLL ============
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute("href"));
    if (target) {
      target.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  });
});

// ============ INITIALIZATION ============
document.addEventListener("DOMContentLoaded", () => {
  updateCartCount();

  // Add animation keyframes dynamically
  const style = document.createElement("style");
  style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        .filter-btn.active {
            background: var(--peach-dark) !important;
            color: white !important;
        }
    `;
  document.head.appendChild(style);
});

// ============ CART SIDEBAR FUNCTIONS ============
const mockCartImages = {
  "Chocolate Fudge Cake":
    "https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=60&h=60&fit=crop",
  "Elegant Wedding Cake":
    "https://images.unsplash.com/photo-1558301211-0d8c8ddee6ec?w=60&h=60&fit=crop",
  "Red Velvet Dream":
    "https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?w=60&h=60&fit=crop",
  "Pineapple Cream Cake":
    "https://images.unsplash.com/photo-1562440499-64c9a111f713?w=60&h=60&fit=crop",
  "Fondant Birthday Cake":
    "https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=60&h=60&fit=crop",
  "Strawberry Cream Cake":
    "https://images.unsplash.com/photo-1535141192574-5d4897c12636?w=60&h=60&fit=crop",
  "Black Forest Cake":
    "https://images.unsplash.com/photo-1606890737304-57a1ca8a5b62?w=60&h=60&fit=crop",
  "Fondant Anniversary Cake":
    "https://images.unsplash.com/photo-1562777717-dc6984f65a63?w=60&h=60&fit=crop",
};

function openCartSidebar() {
  const overlay = document.getElementById("cartOverlay");
  const sidebar = document.getElementById("cartSidebar");

  if (overlay && sidebar) {
    renderCartSidebar();
    overlay.classList.add("show");
    sidebar.classList.add("open");
    document.body.style.overflow = "hidden";
  }
}

function closeCartSidebar() {
  const overlay = document.getElementById("cartOverlay");
  const sidebar = document.getElementById("cartSidebar");

  if (overlay && sidebar) {
    overlay.classList.remove("show");
    sidebar.classList.remove("open");
    document.body.style.overflow = "auto";
  }
}

function renderCartSidebar() {
  const cartBody = document.getElementById("cartSidebarBody");
  const subtotalElement = document.getElementById("cartSidebarSubtotal");

  if (!cartBody) return;

  let cart = JSON.parse(localStorage.getItem("blissBitesCart")) || [];

  if (cart.length === 0) {
    cartBody.innerHTML = `
            <div class="cart-sidebar-empty">
                <i class="bi bi-cart-x"></i>
                <h6>Your cart is empty</h6>
                <p class="small">Add some delicious cakes to your cart!</p>
            </div>
        `;
    if (subtotalElement) subtotalElement.textContent = "Rs. 0";
    return;
  }

  cartBody.innerHTML = cart
    .map(
      (item, index) => `
        <div class="cart-sidebar-item">
            <img src="${mockCartImages[item.name] || "https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=60&h=60&fit=crop"}" 
                 class="cart-sidebar-item-img" alt="${item.name}">
            <div class="cart-sidebar-item-details">
                <h6>${item.name}</h6>
                <small>${item.weight || "1 Pound"}</small>
                <div class="cart-qty-controls mt-2">
                    <button class="cart-qty-btn" onclick="updateCartItemQty(${index}, -1)">-</button>
                    <span class="cart-qty-value">${item.quantity}</span>
                    <button class="cart-qty-btn" onclick="updateCartItemQty(${index}, 1)">+</button>
                </div>
            </div>
            <div class="text-end">
                <div class="cart-sidebar-item-price">Rs. ${(item.price * item.quantity).toLocaleString()}</div>
                <button class="cart-sidebar-item-remove" onclick="removeCartItemSidebar(${index})" title="Remove">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `,
    )
    .join("");

  // Update subtotal
  const subtotal = cart.reduce(
    (sum, item) => sum + item.price * item.quantity,
    0,
  );
  if (subtotalElement)
    subtotalElement.textContent = "Rs. " + subtotal.toLocaleString();

  updateCartCount();
}

function updateCartItemQty(index, delta) {
  let cart = JSON.parse(localStorage.getItem("blissBitesCart")) || [];

  if (index >= 0 && index < cart.length) {
    cart[index].quantity += delta;

    if (cart[index].quantity <= 0) {
      cart.splice(index, 1);
    }

    localStorage.setItem("blissBitesCart", JSON.stringify(cart));
    renderCartSidebar();
  }
}

function removeCartItemSidebar(index) {
  let cart = JSON.parse(localStorage.getItem("blissBitesCart")) || [];

  if (index >= 0 && index < cart.length) {
    const removedItem = cart[index];
    cart.splice(index, 1);
    localStorage.setItem("blissBitesCart", JSON.stringify(cart));
    renderCartSidebar();
    showToast(removedItem.name + " removed from cart");
  }
}

// Update existing addToCart function to open sidebar
function addToCart(cakeName, price) {
  const existingItem = cart.find((item) => item.name === cakeName);

  if (existingItem) {
    existingItem.quantity++;
  } else {
    cart.push({
      name: cakeName,
      price: price,
      quantity: 1,
      weight: "1 Pound",
    });
  }

  localStorage.setItem("blissBitesCart", JSON.stringify(cart));
  updateCartCount();
  showToast(cakeName + " added to cart!");

  // Open cart sidebar
  openCartSidebar();
}
