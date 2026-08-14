<?php
$pageTitle = 'Categories';
include 'includes/header.php';
?>

<!-- Categories Page Header -->
<div class="page-header d-flex justify-content-between align-items-center flex-wrap">
  <div>
    <h4><i class="bi bi-grid me-2"></i>Categories</h4>
    <p>Manage cake categories for occasions</p>
  </div>
  <button class="btn text-white" style="background: linear-gradient(135deg, var(--peach-primary), var(--peach-dark)); border-radius: 10px; padding: 10px 20px;" onclick="openAddCategoryModal()">
    <i class="bi bi-plus-lg me-2"></i>Add Category
  </button>
</div>

<!-- Categories Grid -->
<div class="row g-4">
  <?php
  $categories = [
    ['Birthday', 'birthday', 'Special cakes for birthday celebrations', '12 Cakes', 'linear-gradient(135deg, #FFB5A7, #F08080)', 'bi-gift-fill'],
    ['Wedding', 'wedding', 'Elegant wedding cakes for your special day', '6 Cakes', 'linear-gradient(135deg, #FCD5CE, #FF9B85)', 'bi-heart-fill'],
    ['Anniversary', 'anniversary', 'Celebrate your special moments with love', '4 Cakes', 'linear-gradient(135deg, #FFD1D1, #FF8A80)', 'bi-calendar-heart-fill'],
    ['Baby Shower', 'baby-shower', 'Adorable cakes for baby shower celebrations', '2 Cakes', 'linear-gradient(135deg, #FFE0E0, #FFB5A7)', 'bi-balloon-heart-fill'],
    ['Custom', 'custom', 'Custom designed cakes for any occasion', '5 Cakes', 'linear-gradient(135deg, #E8F5E9, #A5D6A7)', 'bi-star-fill'],
    ['Eid Special', 'eid-special', 'Special cakes for Eid celebrations', '3 Cakes', 'linear-gradient(135deg, #FFF9C4, #FFD54F)', 'bi-moon-stars-fill']
  ];

  foreach ($categories as $index => $cat):
  ?>
    <div class="col-xl-3 col-md-6">
      <div class="card h-100" style="border-radius: 16px; border: 1px solid var(--border-color); overflow: hidden;">
        <div class="position-relative" style="height: 140px; background: <?php echo $cat[4]; ?>; display: flex; align-items: center; justify-content: center;">
          <i class="bi <?php echo $cat[5]; ?> text-white" style="font-size: 48px; opacity: 0.8;"></i>
          <span class="badge position-absolute top-0 end-0 m-2" style="background: rgba(255,255,255,0.3);"><?php echo $cat[3]; ?></span>
        </div>
        <div class="card-body text-center">
          <h6 class="fw-bold mb-1"><?php echo $cat[0]; ?></h6>
          <small class="text-muted"><?php echo $cat[1]; ?></small>
          <p class="small text-muted mt-2 mb-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
            <?php echo $cat[2]; ?>
          </p>
        </div>
        <div class="card-footer bg-white d-flex gap-2" style="border-top: 1px solid var(--border-color);">
          <button class="btn btn-sm flex-grow-1" style="background: var(--peach-pale); color: var(--peach-dark); border-radius: 8px;" onclick="editCategory(<?php echo $index + 1; ?>)">
            <i class="bi bi-pencil me-1"></i>Edit
          </button>
          <button class="btn btn-sm flex-grow-1 btn-outline-danger" style="border-radius: 8px;" onclick="deleteCategory(<?php echo $index + 1; ?>)">
            <i class="bi bi-trash me-1"></i>Delete
          </button>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--border-color);">
      <div class="modal-header" style="background: var(--peach-pale); border-radius: 16px 16px 0 0; border-bottom: 1px solid var(--border-color);">
        <h5 class="modal-title" id="categoryModalTitle">
          <i class="bi bi-plus-circle me-2"></i>Add Category
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="categoryForm">
          <div class="mb-3">
            <label class="form-label fw-semibold">Category Name *</label>
            <input type="text" class="form-control" id="categoryName" placeholder="e.g., Birthday" style="border-color: var(--peach-light);" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Slug *</label>
            <input type="text" class="form-control" id="categorySlug" placeholder="e.g., birthday" style="border-color: var(--peach-light);" readonly>
            <small class="text-muted">Auto-generated from name</small>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea class="form-control" id="categoryDescription" rows="3" placeholder="Brief description" style="border-color: var(--peach-light);"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Status</label>
            <select class="form-select" id="categoryStatus" style="border-color: var(--peach-light);">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
        <button type="button" class="btn text-white" style="background: var(--peach-dark); border-radius: 8px;" onclick="saveCategory()">
          <i class="bi bi-check-lg me-1"></i>Save Category
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('categoryName').addEventListener('input', function() {
    document.getElementById('categorySlug').value = this.value
      .toLowerCase()
      .replace(/\s+/g, '-')
      .replace(/[^a-z0-9-]/g, '');
  });

  function openAddCategoryModal() {
    document.getElementById('categoryModalTitle').innerHTML = '<i class="bi bi-plus-circle me-2"></i>Add Category';
    document.getElementById('categoryForm').reset();
    new bootstrap.Modal(document.getElementById('categoryModal')).show();
  }

  function editCategory(id) {
    document.getElementById('categoryModalTitle').innerHTML = '<i class="bi bi-pencil me-2"></i>Edit Category';
    new bootstrap.Modal(document.getElementById('categoryModal')).show();
  }

  function deleteCategory(id) {
    if (confirm('Are you sure you want to delete this category?')) {
      alert('Category #' + id + ' deleted successfully!');
    }
  }

  function saveCategory() {
    alert('Category saved successfully!');
    bootstrap.Modal.getInstance(document.getElementById('categoryModal')).hide();
  }
</script>

<?php include 'includes/footer.php'; ?>