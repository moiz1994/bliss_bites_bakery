// ============ SIDEBAR TOGGLE ============
const sidebar = document.getElementById("sidebar");
const mainContent = document.getElementById("mainContent");
const toggleBtn = document.getElementById("toggleSidebar");
const overlay = document.getElementById("sidebarOverlay");

// Desktop: collapse sidebar
toggleBtn.addEventListener("click", () => {
  if (window.innerWidth > 991) {
    sidebar.classList.toggle("collapsed");
    mainContent.classList.toggle("expanded");
  } else {
    // Mobile: show/hide sidebar
    sidebar.classList.toggle("mobile-show");
    overlay.classList.toggle("show");
  }
});

// Close sidebar when clicking overlay (mobile)
overlay.addEventListener("click", () => {
  sidebar.classList.remove("mobile-show");
  overlay.classList.remove("show");
});

// ============ PAGE NAVIGATION ============
function showPage(pageName) {
  // Hide all content divs
  const contents = [
    "dashboard",
    "orders",
    "cakes",
    "categories",
    "weightClasses",
    "settings",
  ];
  contents.forEach((name) => {
    const el = document.getElementById(name + "Content");
    if (el) el.style.display = "none";
  });

  // Show selected content
  const target = document.getElementById(pageName + "Content");
  if (target) target.style.display = "block";

  // Update active nav link
  document.querySelectorAll(".sidebar-nav .nav-link").forEach((link) => {
    link.classList.remove("active");
    if (link.dataset.page === pageName) {
      link.classList.add("active");
    }
  });

  // Close sidebar on mobile after navigation
  if (window.innerWidth <= 991) {
    sidebar.classList.remove("mobile-show");
    overlay.classList.remove("show");
  }
}

// Add click handlers to all nav links
document.querySelectorAll(".sidebar-nav .nav-link").forEach((link) => {
  link.addEventListener("click", (e) => {
    e.preventDefault();
    const page = link.dataset.page;
    if (page) showPage(page);
  });
});

// ============ RESPONSIVE HANDLING ============
window.addEventListener("resize", () => {
  if (window.innerWidth > 991) {
    overlay.classList.remove("show");
    sidebar.classList.remove("mobile-show");
  }
});

// ============ ORDERS PAGE FUNCTIONS ============

// Filter orders (simulated)
function filterOrders() {
  const search = document.getElementById("orderSearch").value.toLowerCase();
  const status = document.getElementById("statusFilter").value;
  const dateFrom = document.getElementById("dateFrom").value;
  const dateTo = document.getElementById("dateTo").value;

  // In real app, this would call an API
  alert(
    "Filters applied!\nSearch: " +
      search +
      "\nStatus: " +
      status +
      "\nFrom: " +
      dateFrom +
      "\nTo: " +
      dateTo,
  );
}

// View order details in modal
function viewOrderDetails(orderNumber) {
  // Static data for demo
  const orderData = {
    "BB-1001": {
      customer: "Ayesha Khan",
      phone: "0300-1234567",
      address: "House 123, Street 5, Lahore, Punjab",
      status: "Pending",
      statusClass: "badge-pending",
      items: [
        {
          cake: "Chocolate Fudge",
          type: "Cream",
          weight: "2 Pound",
          qty: 1,
          price: "Rs. 3,500",
        },
        {
          cake: "Vanilla Cream",
          type: "Cream",
          weight: "1 Pound",
          qty: 1,
          price: "Rs. 1,800",
        },
      ],
      total: "Rs. 5,300",
      instructions:
        'Please write "Happy Birthday Ayesha" on the cake with pink icing.',
    },
  };

  const data = orderData[orderNumber] || orderData["BB-1001"];

  document.getElementById("modalOrderNumber").textContent = orderNumber;
  document.getElementById("modalCustomer").textContent = data.customer;
  document.getElementById("modalPhone").textContent = data.phone;
  document.getElementById("modalAddress").textContent = data.address;
  document.getElementById("modalStatus").textContent = data.status;
  document.getElementById("modalStatus").className =
    "badge-status " + data.statusClass;
  document.getElementById("modalInstructions").textContent = data.instructions;

  let itemsHtml = "";
  data.items.forEach((item) => {
    itemsHtml += `
            <tr>
                <td>${item.cake}</td>
                <td>${item.type}</td>
                <td>${item.weight}</td>
                <td>${item.qty}</td>
                <td>${item.price}</td>
            </tr>
        `;
  });
  document.getElementById("modalOrderItems").innerHTML = itemsHtml;

  // Show modal
  const modal = new bootstrap.Modal(
    document.getElementById("orderDetailModal"),
  );
  modal.show();
}

// Update order status (simulated)
function updateStatus(orderNumber, status) {
  const statusLabels = {
    confirmed: "Confirmed",
    cancelled: "Cancelled",
    processing: "Processing",
    ready: "Ready",
    delivered: "Delivered",
  };

  if (
    confirm(
      `Are you sure you want to mark order ${orderNumber} as "${statusLabels[status]}"?`,
    )
  ) {
    alert(`Order ${orderNumber} has been marked as ${statusLabels[status]}!`);
    // In real app, this would call an API
  }
}

// ============ CAKES PAGE FUNCTIONS ============

function filterCakes() {
  const search = document.getElementById("cakeSearch").value;
  const type = document.getElementById("cakeTypeFilter").value;
  const category = document.getElementById("cakeCategoryFilter").value;
  const status = document.getElementById("cakeStatusFilter").value;
  alert(
    "Filters applied!\nSearch: " +
      search +
      "\nType: " +
      type +
      "\nCategory: " +
      category +
      "\nStatus: " +
      status,
  );
}

function openAddCakeModal() {
  document.getElementById("cakeModalTitle").innerHTML =
    '<i class="bi bi-plus-circle me-2"></i>Add New Cake';
  document.getElementById("cakeForm").reset();
  document.getElementById("weightPriceContainer").innerHTML = `
        <div class="row g-2 mb-2 weight-price-row">
            <div class="col-md-4">
                <select class="form-select" style="border-color: var(--peach-light);">
                    <option>1 Pound</option><option>2 Pound</option><option>3 Pound</option><option>4 Pound</option><option>5 Pound</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" style="background: var(--peach-pale); border-color: var(--peach-light);">Rs.</span>
                    <input type="number" class="form-control" placeholder="Price" style="border-color: var(--peach-light);">
                </div>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeWeightPrice(this)" style="border-radius: 8px;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
    `;
  new bootstrap.Modal(document.getElementById("cakeModal")).show();
}

function editCake(id) {
  document.getElementById("cakeModalTitle").innerHTML =
    '<i class="bi bi-pencil me-2"></i>Edit Cake';
  new bootstrap.Modal(document.getElementById("cakeModal")).show();
  alert("Editing cake #" + id + " - form would be pre-filled with cake data");
}

function deleteCake(id) {
  if (
    confirm(
      "Are you sure you want to delete this cake? This action cannot be undone.",
    )
  ) {
    alert("Cake #" + id + " deleted successfully!");
  }
}

function addWeightPrice() {
  const row = document.createElement("div");
  row.className = "row g-2 mb-2 weight-price-row";
  row.innerHTML = `
        <div class="col-md-4">
            <select class="form-select" style="border-color: var(--peach-light);">
                <option>1 Pound</option><option>2 Pound</option><option>3 Pound</option><option>4 Pound</option><option>5 Pound</option>
            </select>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text" style="background: var(--peach-pale); border-color: var(--peach-light);">Rs.</span>
                <input type="number" class="form-control" placeholder="Price" style="border-color: var(--peach-light);">
            </div>
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeWeightPrice(this)" style="border-radius: 8px;">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    `;
  document.getElementById("weightPriceContainer").appendChild(row);
}

function removeWeightPrice(btn) {
  const container = document.getElementById("weightPriceContainer");
  if (container.children.length > 1) {
    btn.closest(".weight-price-row").remove();
  } else {
    alert("At least one weight option is required.");
  }
}

function saveCake() {
  alert("Cake saved successfully!");
  bootstrap.Modal.getInstance(document.getElementById("cakeModal")).hide();
}
