<?php
$pageTitle = 'Cakes';
include 'includes/header.php';

// Include database connection
require_once '../config/database.php';

// ============ FETCH CAKE STATISTICS ============

// Total Cakes
$query_total = "SELECT COUNT(*) as total FROM cakes";
$result_total = mysqli_query($conn, $query_total);
$totalCakes = mysqli_fetch_assoc($result_total)['total'] ?? 0;

// Cream Cakes
$query_cream = "SELECT COUNT(*) as total FROM cakes WHERE cake_type = 'Cream'";
$result_cream = mysqli_query($conn, $query_cream);
$creamCakes = mysqli_fetch_assoc($result_cream)['total'] ?? 0;

// Fondant Cakes
$query_fondant = "SELECT COUNT(*) as total FROM cakes WHERE cake_type = 'Fondant'";
$result_fondant = mysqli_query($conn, $query_fondant);
$fondantCakes = mysqli_fetch_assoc($result_fondant)['total'] ?? 0;

// Unavailable Cakes
$query_unavailable = "SELECT COUNT(*) as total FROM cakes WHERE status = 'Unavailable'";
$result_unavailable = mysqli_query($conn, $query_unavailable);
$unavailableCakes = mysqli_fetch_assoc($result_unavailable)['total'] ?? 0;

// ============ FETCH ALL CAKES ============
$query_cakes = "SELECT c.*, cat.category_name, cat.slug as category_slug,
                       GROUP_CONCAT(CONCAT(wc.weight_name, ':', cp.price) SEPARATOR '|') as prices
                FROM cakes c
                LEFT JOIN categories cat ON c.category_id = cat.id
                LEFT JOIN cake_prices cp ON c.id = cp.cake_id
                LEFT JOIN weight_classes wc ON cp.weight_class_id = wc.id
                GROUP BY c.id
                ORDER BY c.created_at DESC";
$result_cakes = mysqli_query($conn, $query_cakes);

// ============ FETCH CATEGORIES FOR DROPDOWN ============
$query_categories = "SELECT id, category_name FROM categories WHERE is_active = 1 ORDER BY category_name";
$result_categories = mysqli_query($conn, $query_categories);

// ============ FETCH WEIGHT CLASSES FOR PRICING ============
$query_weights = "SELECT id, weight_name FROM weight_classes WHERE is_active = 1 ORDER BY weight_value";
$result_weights = mysqli_query($conn, $query_weights);
?>

<!-- Cakes Page Header -->
<div class="page-header d-flex justify-content-between align-items-center flex-wrap">
  <div>
    <h4><i class="bi bi-cake2 me-2"></i>Cakes</h4>
    <p>Manage your cake catalog</p>
  </div>
  <button class="btn text-white" style="background: linear-gradient(135deg, var(--peach-primary), var(--peach-dark)); border-radius: 10px; padding: 10px 20px;" data-bs-toggle="modal" data-bs-target="#cakeModal" onclick="resetCakeForm()">
    <i class="bi bi-plus-lg me-2"></i>Add New Cake
  </button>
</div>

<?php if (isset($_GET['msg'])): ?>
  <?php if ($_GET['msg'] === 'saved'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
      <i class="bi bi-check-circle me-2"></i>Cake saved successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php elseif ($_GET['msg'] === 'deleted'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
      <i class="bi bi-check-circle me-2"></i>Cake deleted successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php elseif ($_GET['msg'] === 'error'): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px;">
      <i class="bi bi-exclamation-circle me-2"></i>An error occurred. Please try again.
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>
<?php endif; ?>

<!-- Stats Mini Cards -->
<div class="row g-3 mb-4">
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="stat-value" style="font-size: 24px;"><?php echo $totalCakes; ?></div>
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
          <div class="stat-value" style="font-size: 24px;"><?php echo $creamCakes; ?></div>
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
          <div class="stat-value" style="font-size: 24px;"><?php echo $fondantCakes; ?></div>
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
          <div class="stat-value" style="font-size: 24px; color: #E53E3E;"><?php echo $unavailableCakes; ?></div>
          <div class="stat-label">Unavailable</div>
        </div>
        <div class="stat-icon" style="background: #FDE8E8; color: #E53E3E; width: 40px; height: 40px; font-size: 18px;">
          <i class="bi bi-slash-circle"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Cakes Grid -->
<div class="row g-4">
  <?php if (mysqli_num_rows($result_cakes) > 0): ?>
    <?php while ($cake = mysqli_fetch_assoc($result_cakes)):
      $badgeStyle = ($cake['cake_type'] === 'Cream') ? 'background: var(--peach-dark);' : 'background: #FF9800;';

      // Parse prices
      $priceTags = '';
      if ($cake['prices']) {
        $prices = explode('|', $cake['prices']);
        foreach ($prices as $price) {
          list($weight, $amount) = explode(':', $price);
          $priceTags .= '<span class="badge bg-light text-dark border">' . htmlspecialchars($weight) . ': Rs. ' . number_format($amount) . '</span> ';
        }
      }
    ?>
      <div class="col-xl-4 col-md-6">
        <div class="card h-100" style="border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden; <?php echo ($cake['status'] === 'Unavailable') ? 'opacity: 0.6;' : ''; ?>">
          <!-- <div class="position-relative">
            <?php if ($cake['image']): ?>
              <img src="../assets/images/uploads/<?php echo htmlspecialchars($cake['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($cake['cake_name']); ?>" style="height: 200px; object-fit: cover;">
            <?php else: ?>
              <div style="height: 200px; background: var(--peach-pale); display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-cake2" style="font-size: 48px; color: var(--peach-light);"></i>
              </div>
            <?php endif; ?>
            <span class="badge position-absolute top-0 end-0 m-2" style="<?php echo $badgeStyle; ?>"><?php echo $cake['cake_type']; ?></span>
            <?php if ($cake['status'] === 'Unavailable'): ?>
              <span class="badge position-absolute top-0 start-0 m-2" style="background: #E53E3E;">Unavailable</span>
            <?php endif; ?>
          </div> -->
          <div class="position-relative cake-card-img-container">
            <?php if ($cake['image']): ?>
              <img src="../assets/images/uploads/<?php echo htmlspecialchars($cake['image']); ?>"
                class="cake-card-img"
                alt="<?php echo htmlspecialchars($cake['cake_name']); ?>">
            <?php else: ?>
              <i class="bi bi-cake2 cake-card-placeholder"></i>
            <?php endif; ?>
            <span class="badge position-absolute top-0 end-0 m-2" style="<?php echo $badgeStyle; ?>"><?php echo $cake['cake_type']; ?></span>
            <?php if ($cake['status'] === 'Unavailable'): ?>
              <span class="badge position-absolute top-0 start-0 m-2" style="background: #E53E3E;">Unavailable</span>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <h6 class="fw-bold mb-1"><?php echo htmlspecialchars($cake['cake_name']); ?></h6>
            <small class="text-muted d-block mb-2"><?php echo htmlspecialchars($cake['category_name'] ?? 'N/A'); ?></small>
            <p class="small text-muted mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
              <?php echo htmlspecialchars($cake['description'] ?? ''); ?>
            </p>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="badge" style="background: var(--peach-pale); color: var(--peach-dark);"><?php echo htmlspecialchars($cake['flavor']); ?></span>
              <small><i class="bi bi-clock me-1"></i><?php echo htmlspecialchars($cake['preparation_time'] ?? 'N/A'); ?></small>
            </div>
            <div class="d-flex flex-wrap gap-1">
              <?php echo $priceTags ?: '<span class="text-muted small">No prices set</span>'; ?>
            </div>
          </div>
          <div class="card-footer bg-white d-flex gap-2" style="border-top: 1px solid var(--border-color);">
            <button class="btn btn-sm flex-grow-1" style="background: var(--peach-pale); color: var(--peach-dark); border-radius: 8px;" onclick="editCake(<?php echo $cake['id']; ?>)">
              <i class="bi bi-pencil me-1"></i>Edit
            </button>
            <button class="btn btn-sm flex-grow-1 btn-outline-danger" style="border-radius: 8px;" onclick="deleteCake(<?php echo $cake['id']; ?>)">
              <i class="bi bi-trash me-1"></i>Delete
            </button>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="col-12">
      <div class="text-center p-5">
        <i class="bi bi-cake2" style="font-size: 48px; color: var(--peach-light);"></i>
        <p class="mt-3 text-muted">No cakes added yet</p>
        <button class="btn text-white mt-2" style="background: var(--peach-dark); border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#cakeModal" onclick="resetCakeForm()">
          <i class="bi bi-plus-lg me-2"></i>Add Your First Cake
        </button>
      </div>
    </div>
  <?php endif; ?>
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
        <form id="cakeForm" action="save-cake.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="cake_id" id="cake_id" value="">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Cake Name *</label>
              <input type="text" class="form-control" name="cake_name" id="cake_name" placeholder="Enter cake name" style="border-color: var(--peach-light);" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Flavor *</label>
              <input type="text" class="form-control" name="flavor" id="flavor" placeholder="e.g., Chocolate" style="border-color: var(--peach-light);" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Category *</label>
              <select class="form-select" name="category_id" id="category_id" style="border-color: var(--peach-light);" required>
                <option value="">Select category</option>
                <?php while ($cat = mysqli_fetch_assoc($result_categories)): ?>
                  <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['category_name']); ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Cake Type *</label>
              <select class="form-select" name="cake_type" id="cake_type" style="border-color: var(--peach-light);" required>
                <option value="">Select type</option>
                <option value="Cream">Cream</option>
                <option value="Fondant">Fondant</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Preparation Time</label>
              <input type="text" class="form-control" name="preparation_time" id="preparation_time" placeholder="e.g., 3-4 hours" style="border-color: var(--peach-light);">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Status</label>
              <select class="form-select" name="status" id="status" style="border-color: var(--peach-light);">
                <option value="Available">Available</option>
                <option value="Unavailable">Unavailable</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Description</label>
              <textarea class="form-control" name="description" id="description" rows="2" placeholder="Short description of the cake" style="border-color: var(--peach-light);"></textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Ingredients</label>
              <textarea class="form-control" name="ingredients" id="ingredients" rows="2" placeholder="List of ingredients" style="border-color: var(--peach-light);"></textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Cake Image</label>
              <input type="file" class="form-control" name="cake_image" id="cake_image" accept="image/*" style="border-color: var(--peach-light);">
            </div>

            <!-- Weight & Price Section -->
            <div class="col-12 mt-3">
              <label class="form-label fw-semibold">
                <i class="bi bi-boxes me-1"></i>Weight & Price *
              </label>
              <div id="weightPriceContainer">
                <div class="row g-2 mb-2 weight-price-row">
                  <div class="col-md-4">
                    <select class="form-select" name="weight_class_id[]" style="border-color: var(--peach-light);" required>
                      <option value="">Select weight</option>
                      <?php
                      mysqli_data_seek($result_weights, 0);
                      while ($weight = mysqli_fetch_assoc($result_weights)):
                      ?>
                        <option value="<?php echo $weight['id']; ?>"><?php echo htmlspecialchars($weight['weight_name']); ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-text" style="background: var(--peach-pale); border-color: var(--peach-light);">Rs.</span>
                      <input type="number" class="form-control" name="price[]" placeholder="Price" style="border-color: var(--peach-light);" required>
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
        <button type="button" class="btn text-white" style="background: var(--peach-dark); border-radius: 8px;" onclick="document.getElementById('cakeForm').submit();">
          <i class="bi bi-check-lg me-1"></i>Save Cake
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function resetCakeForm() {
    document.getElementById('cakeModalTitle').innerHTML = '<i class="bi bi-plus-circle me-2"></i>Add New Cake';
    document.getElementById('cakeForm').reset();
    document.getElementById('cake_id').value = '';
    document.getElementById('weightPriceContainer').innerHTML = `
            <div class="row g-2 mb-2 weight-price-row">
                <div class="col-md-4">
                    <select class="form-select" name="weight_class_id[]" style="border-color: var(--peach-light);" required>
                        <option value="">Select weight</option>
                        <?php
                        mysqli_data_seek($result_weights, 0);
                        while ($weight = mysqli_fetch_assoc($result_weights)):
                        ?>
                        <option value="<?php echo $weight['id']; ?>"><?php echo htmlspecialchars($weight['weight_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text" style="background: var(--peach-pale); border-color: var(--peach-light);">Rs.</span>
                        <input type="number" class="form-control" name="price[]" placeholder="Price" style="border-color: var(--peach-light);" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeWeightPrice(this)" style="border-radius: 8px;">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        `;
  }

  function editCake(id) {
    // In a real app, fetch cake data via AJAX and populate form
    document.getElementById('cakeModalTitle').innerHTML = '<i class="bi bi-pencil me-2"></i>Edit Cake';
    document.getElementById('cake_id').value = id;
    new bootstrap.Modal(document.getElementById('cakeModal')).show();
  }

  function deleteCake(id) {
    if (confirm('Are you sure you want to delete this cake? This action cannot be undone.')) {
      window.location.href = 'delete-cake.php?id=' + id;
    }
  }

  function addWeightPrice() {
    const container = document.getElementById('weightPriceContainer');
    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 weight-price-row';
    row.innerHTML = `
            <div class="col-md-4">
                <select class="form-select" name="weight_class_id[]" style="border-color: var(--peach-light);" required>
                    <option value="">Select weight</option>
                    <?php
                    mysqli_data_seek($result_weights, 0);
                    while ($weight = mysqli_fetch_assoc($result_weights)):
                    ?>
                    <option value="<?php echo $weight['id']; ?>"><?php echo htmlspecialchars($weight['weight_name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" style="background: var(--peach-pale); border-color: var(--peach-light);">Rs.</span>
                    <input type="number" class="form-control" name="price[]" placeholder="Price" style="border-color: var(--peach-light);" required>
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
    const container = document.getElementById('weightPriceContainer');
    if (container.children.length > 1) {
      btn.closest('.weight-price-row').remove();
    } else {
      alert('At least one weight option is required.');
    }
  }
</script>

<?php
// Close database connection
mysqli_close($conn);
include 'includes/footer.php';
?>