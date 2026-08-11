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
