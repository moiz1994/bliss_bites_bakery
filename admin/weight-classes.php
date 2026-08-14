<?php
$pageTitle = 'Weight Classes';
include 'includes/header.php';
?>

<!-- Weight Classes Page Header -->
<div class="page-header d-flex justify-content-between align-items-center flex-wrap">
  <div>
    <h4><i class="bi bi-boxes me-2"></i>Weight Classes</h4>
    <p>Manage cake weight options and pricing tiers</p>
  </div>
  <button class="btn text-white" style="background: linear-gradient(135deg, var(--peach-primary), var(--peach-dark)); border-radius: 10px; padding: 10px 20px;" onclick="openAddWeightClassModal()">
    <i class="bi bi-plus-lg me-2"></i>Add Weight Class
  </button>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card" style="border-radius: 16px; border: 1px solid var(--border-color);">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-list-ul me-2"></i>All Weight Classes</span>
        <span class="badge" style="background: var(--peach-primary); color: white;">5 Classes</span>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Weight Name</th>
              <th>Value</th>
              <th>Unit</th>
              <th>Status</th>
              <th>Used In</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $weightClasses = [
              [1, '1 Pound Cake', 1.00, 'Pound', 'Active', '18 cakes', 'badge-ready'],
              [2, '2 Pound Cake', 2.00, 'Pound', 'Active', '22 cakes', 'badge-ready'],
              [3, '3 Pound Cake', 3.00, 'Pound', 'Active', '20 cakes', 'badge-ready'],
              [4, '4 Pound Cake', 4.00, 'Pound', 'Active', '14 cakes', 'badge-ready'],
              [5, '5 Pound Cake', 5.00, 'Pound', 'Inactive', '3 cakes', 'badge-pending']
            ];

            foreach ($weightClasses as $wc):
            ?>
              <tr>
                <td><?php echo $wc[0]; ?></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div style="width: 35px; height: 35px; background: var(--peach-pale); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                      <i class="bi bi-<?php echo $wc[0]; ?>-circle-fill" style="color: var(--peach-dark);"></i>
                    </div>
                    <strong><?php echo $wc[1]; ?></strong>
                  </div>
                </td>
                <td><?php echo number_format($wc[2], 2); ?></td>
                <td><span class="badge bg-light text-dark"><?php echo $wc[3]; ?></span></td>
                <td><span class="badge-status <?php echo $wc[6]; ?>"><?php echo $wc[4]; ?></span></td>
                <td><span class="badge" style="background: var(--peach-pale); color: var(--peach-dark);"><?php echo $wc[5]; ?></span></td>
                <td>
                  <div class="d-flex gap-1">
                    <button class="btn btn-sm" style="background: var(--peach-pale); color: var(--peach-dark); border-radius: 6px;" onclick="editWeightClass(<?php echo $wc[0]; ?>)">
                      <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" style="border-radius: 6px;" onclick="deleteWeightClass(<?php echo $wc[0]; ?>)">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card mb-3" style="border-radius: 16px; border: 1px solid var(--border-color);">
      <div class="card-body">
        <h6 class="fw-bold"><i class="bi bi-info-circle me-2" style="color: var(--peach-dark);"></i>About Weight Classes</h6>
        <p class="small text-muted mb-0">Weight classes define the size options for your cakes. Each cake can have different prices for different weight classes.</p>
      </div>
    </div>
  </div>
</div>

<!-- Weight Class Modal -->
<div class="modal fade" id="weightClassModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--border-color);">
      <div class="modal-header" style="background: var(--peach-pale); border-radius: 16px 16px 0 0; border-bottom: 1px solid var(--border-color);">
        <h5 class="modal-title" id="weightClassModalTitle">
          <i class="bi bi-plus-circle me-2"></i>Add Weight Class
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="weightClassForm">
          <div class="mb-3">
            <label class="form-label fw-semibold">Weight Name *</label>
            <input type="text" class="form-control" id="weightName" placeholder="e.g., 1 Pound Cake" style="border-color: var(--peach-light);" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Weight Value (in pounds) *</label>
            <input type="number" class="form-control" id="weightValue" placeholder="e.g., 1.00" step="0.01" min="0.5" max="20" style="border-color: var(--peach-light);" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Unit</label>
            <select class="form-select" id="weightUnit" style="border-color: var(--peach-light);">
              <option value="Pound">Pound</option>
              <option value="Kg">Kilogram</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Status</label>
            <select class="form-select" id="weightStatus" style="border-color: var(--peach-light);">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
        <button type="button" class="btn text-white" style="background: var(--peach-dark); border-radius: 8px;" onclick="saveWeightClass()">
          <i class="bi bi-check-lg me-1"></i>Save Weight Class
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function openAddWeightClassModal() {
    document.getElementById('weightClassModalTitle').innerHTML = '<i class="bi bi-plus-circle me-2"></i>Add Weight Class';
    document.getElementById('weightClassForm').reset();
    new bootstrap.Modal(document.getElementById('weightClassModal')).show();
  }

  function editWeightClass(id) {
    document.getElementById('weightClassModalTitle').innerHTML = '<i class="bi bi-pencil me-2"></i>Edit Weight Class';
    new bootstrap.Modal(document.getElementById('weightClassModal')).show();
  }

  function deleteWeightClass(id) {
    if (confirm('Are you sure you want to delete this weight class?')) {
      alert('Weight class #' + id + ' deleted successfully!');
    }
  }

  function saveWeightClass() {
    alert('Weight class saved successfully!');
    bootstrap.Modal.getInstance(document.getElementById('weightClassModal')).hide();
  }
</script>

<?php include 'includes/footer.php'; ?>