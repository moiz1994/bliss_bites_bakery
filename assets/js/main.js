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

// ============ RESPONSIVE HANDLING ============
window.addEventListener("resize", () => {
  if (window.innerWidth > 991) {
    overlay.classList.remove("show");
    sidebar.classList.remove("mobile-show");
  }
});

// ============ ORDERS PAGE FUNCTIONS ============
function filterOrders() {
  const search = document.getElementById("orderSearch").value.toLowerCase();
  const status = document.getElementById("statusFilter").value;
  const dateFrom = document.getElementById("dateFrom").value;
  const dateTo = document.getElementById("dateTo").value;
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

function viewOrderDetails(orderNumber) {
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

  const modal = new bootstrap.Modal(
    document.getElementById("orderDetailModal"),
  );
  modal.show();
}

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

// ============ CATEGORIES PAGE FUNCTIONS ============
document.addEventListener("DOMContentLoaded", function () {
  const nameInput = document.getElementById("categoryName");
  const slugInput = document.getElementById("categorySlug");

  if (nameInput && slugInput) {
    nameInput.addEventListener("input", function () {
      slugInput.value = nameInput.value
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^a-z0-9-]/g, "");
    });
  }
});

function openAddCategoryModal() {
  document.getElementById("categoryModalTitle").innerHTML =
    '<i class="bi bi-plus-circle me-2"></i>Add Category';
  document.getElementById("categoryForm").reset();
  document.getElementById("categoryStatus").value = "active";
  new bootstrap.Modal(document.getElementById("categoryModal")).show();
}

function editCategory(id) {
  document.getElementById("categoryModalTitle").innerHTML =
    '<i class="bi bi-pencil me-2"></i>Edit Category';

  const categories = {
    1: {
      name: "Birthday",
      slug: "birthday",
      description: "Special cakes for birthday celebrations",
      status: "active",
    },
    2: {
      name: "Wedding",
      slug: "wedding",
      description: "Elegant wedding cakes for your special day",
      status: "active",
    },
    3: {
      name: "Anniversary",
      slug: "anniversary",
      description: "Celebrate your special moments with love",
      status: "active",
    },
    4: {
      name: "Baby Shower",
      slug: "baby-shower",
      description: "Adorable cakes for baby shower celebrations",
      status: "active",
    },
    5: {
      name: "Custom",
      slug: "custom",
      description: "Custom designed cakes for any occasion",
      status: "active",
    },
    6: {
      name: "Eid Special",
      slug: "eid-special",
      description: "Special cakes for Eid celebrations",
      status: "inactive",
    },
  };

  const data = categories[id] || categories[1];

  document.getElementById("categoryName").value = data.name;
  document.getElementById("categorySlug").value = data.slug;
  document.getElementById("categoryDescription").value = data.description;
  document.getElementById("categoryStatus").value = data.status;

  new bootstrap.Modal(document.getElementById("categoryModal")).show();
}

function deleteCategory(id) {
  if (
    confirm(
      "Are you sure you want to delete this category? Cakes in this category will need to be reassigned.",
    )
  ) {
    alert("Category #" + id + " deleted successfully!");
  }
}

function saveCategory() {
  const name = document.getElementById("categoryName").value;
  const slug = document.getElementById("categorySlug").value;

  if (!name || !slug) {
    alert("Category name is required!");
    return;
  }

  alert('Category "' + name + '" saved successfully!');
  bootstrap.Modal.getInstance(document.getElementById("categoryModal")).hide();
}

// ============ WEIGHT CLASSES PAGE FUNCTIONS ============
function openAddWeightClassModal() {
  document.getElementById("weightClassModalTitle").innerHTML =
    '<i class="bi bi-plus-circle me-2"></i>Add Weight Class';
  document.getElementById("weightClassForm").reset();
  document.getElementById("weightStatus").value = "active";
  document.getElementById("weightUnit").value = "Pound";
  new bootstrap.Modal(document.getElementById("weightClassModal")).show();
}

function editWeightClass(id) {
  document.getElementById("weightClassModalTitle").innerHTML =
    '<i class="bi bi-pencil me-2"></i>Edit Weight Class';

  const weightClasses = {
    1: { name: "1 Pound Cake", value: 1.0, unit: "Pound", status: "active" },
    2: { name: "2 Pound Cake", value: 2.0, unit: "Pound", status: "active" },
    3: { name: "3 Pound Cake", value: 3.0, unit: "Pound", status: "active" },
    4: { name: "4 Pound Cake", value: 4.0, unit: "Pound", status: "active" },
    5: { name: "5 Pound Cake", value: 5.0, unit: "Pound", status: "inactive" },
  };

  const data = weightClasses[id] || weightClasses[1];

  document.getElementById("weightName").value = data.name;
  document.getElementById("weightValue").value = data.value;
  document.getElementById("weightUnit").value = data.unit;
  document.getElementById("weightStatus").value = data.status;

  new bootstrap.Modal(document.getElementById("weightClassModal")).show();
}

function deleteWeightClass(id) {
  if (
    confirm(
      "Are you sure you want to delete this weight class? All associated cake prices will be removed.",
    )
  ) {
    alert("Weight class #" + id + " deleted successfully!");
  }
}

function saveWeightClass() {
  const name = document.getElementById("weightName").value;
  const value = document.getElementById("weightValue").value;

  if (!name || !value) {
    alert("Weight name and value are required!");
    return;
  }

  if (value < 0.5 || value > 20) {
    alert("Weight value must be between 0.5 and 20 pounds!");
    return;
  }

  alert('Weight class "' + name + '" saved successfully!');
  bootstrap.Modal.getInstance(
    document.getElementById("weightClassModal"),
  ).hide();
}

// ============ SETTINGS PAGE FUNCTIONS ============

function saveAllSettings() {
  // Collect all form data (simulated)
  const settings = {
    siteName:
      document.querySelector('#generalSettingsForm input[type="text"]')
        ?.value || "Bliss Bites Bakery",
    phone:
      document.querySelector('#contactSettingsForm input[type="tel"]')?.value ||
      "0300-1234567",
    email:
      document.querySelector('#contactSettingsForm input[type="email"]')
        ?.value || "info@blissbites.com",
    instagram:
      document.querySelector('#socialSettingsForm input[type="url"]')?.value ||
      "",
  };

  // Show saving state
  const saveBtn = document.querySelector(
    "#settingsContent .btn.text-white.w-100",
  );
  const originalHTML = saveBtn.innerHTML;
  saveBtn.innerHTML =
    '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
  saveBtn.disabled = true;

  // Simulate API call
  setTimeout(() => {
    alert(
      "✅ All settings saved successfully!\n\nSite Name: " +
        settings.siteName +
        "\nPhone: " +
        settings.phone +
        "\nEmail: " +
        settings.email,
    );

    saveBtn.innerHTML = originalHTML;
    saveBtn.disabled = false;
  }, 1000);
}

// Add input change listeners to track unsaved changes
document.addEventListener("DOMContentLoaded", function () {
  const settingsForms = document.querySelectorAll("#settingsContent form");
  let hasChanges = false;

  settingsForms.forEach((form) => {
    form.addEventListener("input", () => {
      if (!hasChanges) {
        hasChanges = true;
        // Could show "unsaved changes" indicator here
      }
    });
  });
});
