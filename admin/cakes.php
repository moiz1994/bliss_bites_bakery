<?php
$pageTitle = 'Cakes';
include 'includes/header.php';
?>

<!-- Cakes Page Header -->
<div class="page-header d-flex justify-content-between align-items-center flex-wrap">
  <div>
    <h4><i class="bi bi-cake2 me-2"></i>Cakes</h4>
    <p>Manage your cake catalog</p>
  </div>
  <button class="btn text-white" style="background: linear-gradient(135deg, var(--peach-primary), var(--peach-dark)); border-radius: 10px; padding: 10px 20px;" onclick="openAddCakeModal()">
    <i class="bi bi-plus-lg me-2"></i>Add New Cake
  </button>
</div>

<!-- Stats Mini Cards -->
<div class="row g-3 mb-4">
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="stat-value" style="font-size: 24px;">24</div>
          <div class="stat-label">Total Cakes</div>
        </div>
        <div class="stat-icon cakes" style="width: 40px; height: 40px; font-size: 18px;">
          <i class="bi bi-cake2"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="stat-value" style="font-size: 24px;">14</div>
          <div class="stat-label">Cream Cakes</div>
        </div>
        <div class="stat-icon" style="background: #E8F5E9; color: #4CAF50; width: 40px; height: 40px; font-size: 18px;">
          <i class="bi bi-droplet"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="stat-value" style="font-size: 24px;">10</div>
          <div class="stat-label">Fondant Cakes</div>
        </div>
        <div class="stat-icon" style="background: #FFF3E0; color: #FF9800; width: 40px; height: 40px; font-size: 18px;">
          <i class="bi bi-palette"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="stat-value" style="font-size: 24px; color: #E53E3E;">2</div>
          <div class="stat-label">Unavailable</div>
        </div>
        <div class="stat-icon" style="background: #FDE8E8; color: #E53E3E; width: 40px; height: 40px; font-size: 18px;">
          <i class="bi bi-slash-circle"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Search & Filter -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row g-3 align-items-end">
      <div class="col-md-3">
        <label class="form-label fw-semibold" style="font-size: 13px; color: var(--text-muted);">SEARCH</label>
        <div class="input-group">
          <span class="input-group-text" style="background: var(--peach-pale); border-color: var(--peach-light);">
            <i class="bi bi-search" style="color: var(--peach-dark);"></i>
          </span>
          <input type="text" class="form-control" placeholder="Cake name..." style="border-color: var(--peach-light);" id="cakeSearch">
        </div>
      </div>
      <div class="col-md-2">
        <label class="form-label fw-semibold" style="font-size: 13px; color: var(--text-muted);">TYPE</label>
        <select class="form-select" style="border-color: var(--peach-light);" id="cakeTypeFilter">
          <option value="all">All Types</option>
          <option value="cream">Cream</option>
          <option value="fondant">Fondant</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label fw-semibold" style="font-size: 13px; color: var(--text-muted);">CATEGORY</label>
        <select class="form-select" style="border-color: var(--peach-light);" id="cakeCategoryFilter">
          <option value="all">All Categories</option>
          <option value="birthday">Birthday</option>
          <option value="wedding">Wedding</option>
          <option value="anniversary">Anniversary</option>
          <option value="baby-shower">Baby Shower</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label fw-semibold" style="font-size: 13px; color: var(--text-muted);">STATUS</label>
        <select class="form-select" style="border-color: var(--peach-light);" id="cakeStatusFilter">
          <option value="all">All Status</option>
          <option value="available">Available</option>
          <option value="unavailable">Unavailable</option>
        </select>
      </div>
      <div class="col-md-3">
        <button class="btn text-white w-100" style="background: linear-gradient(135deg, var(--peach-primary), var(--peach-dark)); border-radius: 10px;" onclick="filterCakes()">
          <i class="bi bi-funnel me-2"></i>Apply Filters
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Cakes Grid -->
<div class="row g-4" id="cakesGrid">
  <?php
  $cakes = [
    ['Chocolate Fudge Cake', 'Cream', 'Birthday', 'Chocolate', '4-5 hours', 'Rich chocolate cake with creamy fudge frosting.', 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&h=300&fit=crop', [['1lb', 1800], ['2lb', 3500], ['3lb', 5000]]],
    ['Elegant Wedding Cake', 'Fondant', 'Wedding', 'Vanilla', '2-3 days', 'Three-tier fondant wedding cake with floral decorations.', 'https://images.unsplash.com/photo-1558301211-0d8c8ddee6ec?w=400&h=300&fit=crop', [['3lb', 8500], ['5lb', 14000]]],
    ['Red Velvet Dream', 'Cream', 'Anniversary', 'Red Velvet', '3-4 hours', 'Classic red velvet with cream cheese frosting.', 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?w=400&h=300&fit=crop', [['1lb', 2200], ['2lb', 4000], ['3lb', 5800]]],
    ['Pineapple Cream Cake', 'Cream', 'Birthday', 'Pineapple', '3 hours', 'Light and fluffy cake with fresh pineapple filling.', 'https://images.unsplash.com/photo-1562440499-64c9a111f713?w=400&h=300&fit=crop', [['1lb', 1600], ['2lb', 3000]]],
    ['Fondant Birthday Cake', 'Fondant', 'Birthday', 'Custom', '1-2 days', 'Custom themed fondant cake with edible toppers.', 'https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=400&h=300&fit=crop', [['2lb', 4500], ['3lb', 6500]]],
    ['Strawberry Cream Cake', 'Cream', 'Baby Shower', 'Strawberry', '3-4 hours', 'Fresh strawberry cake layered with strawberry cream.', 'https://images.unsplash.com/photo-1535141192574-5d4897c12636?w=400&h=300&fit=crop', [['1lb', 2000], ['2lb', 3800]]]
  ];

  foreach ($cakes as $index => $cake):
    $badgeClass = ($cake[1] === 'Cream') ? 'badge-cream' : 'badge-fondant';
    $badgeStyle = ($cake[1] === 'Cream') ? 'background: var(--peach-dark);' : 'background: #FF9800;';
  ?>
    <div class="col-xl-4 col-md-6">
      <div class="card h-100" style="border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden;">
        <div class="position-relative">
          <img src="<?php echo $cake[6]; ?>" class="card-img-top" alt="<?php echo $cake[0]; ?>" style="height: 200px; object-fit: cover;">
          <span class="badge position-absolute top-0 end-0 m-2" style="<?php echo $badgeStyle; ?>"><?php echo $cake[1]; ?></span>
        </div>
        <div class="card-body">
          <h6 class="fw-bold mb-1"><?php echo $cake[0]; ?></h6>
          <small class="text-muted d-block mb-2"><?php echo $cake[2]; ?></small>
          <p class="small text-muted mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
            <?php echo $cake[5]; ?>
          </p>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge" style="background: var(--peach-pale); color: var(--peach-dark);"><?php echo $cake[3]; ?></span>
            <small><i class="bi bi-clock me-1"></i><?php echo $cake[4]; ?></small>
          </div>
          <div class="d-flex flex-wrap gap-1">
            <?php foreach ($cake[7] as $price): ?>
              <span class="badge bg-light text-dark border"><?php echo $price[0]; ?>: Rs. <?php echo number_format($price[1]); ?></span>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="card-footer bg-white d-flex gap-2" style="border-top: 1px solid var(--border-color);">
          <button class="btn btn-sm flex-grow-1" style="background: var(--peach-pale); color: var(--peach-dark); border-radius: 8px;" onclick="editCake(<?php echo $index + 1; ?>)">
            <i class="bi bi-pencil me-1"></i>Edit
          </button>
          <button class="btn btn-sm flex-grow-1 btn-outline-danger" style="border-radius: 8px;" onclick="deleteCake(<?php echo $index + 1; ?>)">
            <i class="bi bi-trash me-1"></i>Delete
          </button>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- Add/Edit Cake Modal -->
<div class="modal fade" id="cakeModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--border-color);">
      <div class="modal-header" style="background: var(--peach-pale); border-radius: 16px 16px 0 0; border-bottom: 1px solid var(--border-color);">
        <h5 class="modal-title" id="cakeModalTitle">
          <i class="bi bi-plus-circle me-2"></i>Add New Cake
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
        <form id="cakeForm">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Cake Name *</label>
              <input type="text" class="form-control" placeholder="Enter cake name" style="border-color: var(--peach-light);" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Flavor *</label>
              <select class="form-select" style="border-color: var(--peach-light);">
                <option value="">Select flavor</option>
                <option>Chocolate</option>
                <option>Vanilla</option>
                <option>Red Velvet</option>
                <option>Pineapple</option>
                <option>Strawberry</option>
                <option>Black Forest</option>
                <option>Custom</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Category *</label>
              <select class="form-select" style="border-color: var(--peach-light);">
                <option value="">Select category</option>
                <option>Birthday</option>
                <option>Wedding</option>
                <option>Anniversary</option>
                <option>Baby Shower</option>
                <option>Custom</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Cake Type *</label>
              <select class="form-select" style="border-color: var(--peach-light);">
                <option value="">Select type</option>
                <option>Cream</option>
                <option>Fondant</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Preparation Time</label>
              <input type="text" class="form-control" placeholder="e.g., 3-4 hours" style="border-color: var(--peach-light);">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Status</label>
              <select class="form-select" style="border-color: var(--peach-light);">
                <option>Available</option>
                <option>Unavailable</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Description</label>
              <textarea class="form-control" rows="2" placeholder="Short description of the cake" style="border-color: var(--peach-light);"></textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Ingredients</label>
              <textarea class="form-control" rows="2" placeholder="List of ingredients" style="border-color: var(--peach-light);"></textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Cake Image</label>
              <input type="file" class="form-control" accept="image/*" style="border-color: var(--peach-light);">
            </div>

            <!-- Weight & Price Section -->
            <div class="col-12 mt-3">
              <label class="form-label fw-semibold">
                <i class="bi bi-boxes me-1"></i>Weight & Price *
              </label>
              <div id="weightPriceContainer">
                <div class="row g-2 mb-2 weight-price-row">
                  <div class="col-md-4">
                    <select class="form-select" style="border-color: var(--peach-light);">
                      <option>1 Pound</option>
                      <option>2 Pound</option>
                      <option>3 Pound</option>
                      <option>4 Pound</option>
                      <option>5 Pound</option>
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
              </div>
              <button type="button" class="btn btn-sm mt-2" style="background: var(--peach-pale); color: var(--peach-dark); border-radius: 8px;" onclick="addWeightPrice()">
                <i class="bi bi-plus me-1"></i>Add Weight Option
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
        <button type="button" class="btn text-white" style="background: var(--peach-dark); border-radius: 8px;" onclick="saveCake()">
          <i class="bi bi-check-lg me-1"></i>Save Cake
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function openAddCakeModal() {
    document.getElementById('cakeModalTitle').innerHTML = '<i class="bi bi-plus-circle me-2"></i>Add New Cake';
    document.getElementById('cakeForm').reset();
    new bootstrap.Modal(document.getElementById('cakeModal')).show();
  }

  function editCake(id) {
    document.getElementById('cakeModalTitle').innerHTML = '<i class="bi bi-pencil me-2"></i>Edit Cake';
    new bootstrap.Modal(document.getElementById('cakeModal')).show();
  }

  function deleteCake(id) {
    if (confirm('Are you sure you want to delete this cake?')) {
      alert('Cake #' + id + ' deleted successfully!');
    }
  }

  function addWeightPrice() {
    const container = document.getElementById('weightPriceContainer');
    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 weight-price-row';
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
    container.appendChild(row);
  }

  function removeWeightPrice(btn) {
    btn.closest('.weight-price-row').remove();
  }

  function saveCake() {
    alert('Cake saved successfully!');
    bootstrap.Modal.getInstance(document.getElementById('cakeModal')).hide();
  }

  function filterCakes() {
    alert('Filters applied!');
  }
</script>

<?php include 'includes/footer.php'; ?>