<?php
$pageTitle = 'Settings';
include 'includes/header.php';
?>

<!-- Settings Page Header -->
<div class="page-header">
  <div>
    <h4><i class="bi bi-gear me-2"></i>Settings</h4>
    <p>Configure your bakery website settings</p>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <!-- General Settings -->
    <div class="card mb-4" style="border-radius: 16px; border: 1px solid var(--border-color);">
      <div class="card-header">
        <i class="bi bi-building me-2" style="color: var(--peach-dark);"></i>General Information
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Site Name *</label>
            <input type="text" class="form-control" value="Bliss Bites Bakery" style="border-color: var(--peach-light);">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Tagline</label>
            <input type="text" class="form-control" value="Delicious homemade cakes for every occasion" style="border-color: var(--peach-light);">
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Site Description</label>
            <textarea class="form-control" rows="3" style="border-color: var(--peach-light);">Bliss Bites Bakery specializes in custom cream and fondant cakes for all occasions.</textarea>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Currency</label>
            <select class="form-select" style="border-color: var(--peach-light);">
              <option selected>PKR - Pakistani Rupee</option>
              <option>USD - US Dollar</option>
              <option>GBP - British Pound</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Currency Symbol</label>
            <input type="text" class="form-control" value="Rs." style="border-color: var(--peach-light);">
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Information -->
    <div class="card mb-4" style="border-radius: 16px; border: 1px solid var(--border-color);">
      <div class="card-header">
        <i class="bi bi-telephone me-2" style="color: var(--peach-dark);"></i>Contact Information
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Phone Number *</label>
            <input type="tel" class="form-control" value="0300-1234567" style="border-color: var(--peach-light);">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Email Address</label>
            <input type="email" class="form-control" value="info@blissbites.com" style="border-color: var(--peach-light);">
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Complete Address</label>
            <textarea class="form-control" rows="2" style="border-color: var(--peach-light);">Shop #45, Main Boulevard, Gulberg III, Lahore, Punjab, Pakistan</textarea>
          </div>
        </div>
      </div>
    </div>

    <!-- Social Media -->
    <div class="card mb-4" style="border-radius: 16px; border: 1px solid var(--border-color);">
      <div class="card-header">
        <i class="bi bi-share me-2" style="color: var(--peach-dark);"></i>Social Media Links
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">
              <i class="bi bi-instagram me-1" style="color: #E1306C;"></i>Instagram URL
            </label>
            <input type="url" class="form-control" value="https://instagram.com/blissbitesbakery" style="border-color: var(--peach-light);">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">
              <i class="bi bi-facebook me-1" style="color: #1877F2;"></i>Facebook URL
            </label>
            <input type="url" class="form-control" placeholder="https://facebook.com/yourpage" style="border-color: var(--peach-light);">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <!-- Logo Upload -->
    <div class="card mb-4" style="border-radius: 16px; border: 1px solid var(--border-color);">
      <div class="card-header">
        <i class="bi bi-image me-2" style="color: var(--peach-dark);"></i>Site Logo
      </div>
      <div class="card-body text-center">
        <div class="mb-3 p-4 rounded-3" style="background: var(--peach-pale);">
          <img src="../assets/images/logo.webp" alt="Logo" style="width: 100px; height: 100px; border-radius: 20px; object-fit: cover; margin-bottom: 10px;">
          <p class="small text-muted mb-0">Current Logo</p>
        </div>
        <input type="file" class="form-control mb-2" accept="image/*" style="border-color: var(--peach-light);">
        <small class="text-muted">Recommended: 200x200px PNG</small>
      </div>
    </div>

    <!-- Save Button -->
    <button class="btn text-white w-100 py-3" style="background: linear-gradient(135deg, var(--peach-primary), var(--peach-dark)); border-radius: 12px; font-weight: 600;" onclick="saveAllSettings()">
      <i class="bi bi-check-lg me-2"></i>Save All Settings
    </button>
  </div>
</div>

<script>
  function saveAllSettings() {
    alert('All settings saved successfully!');
  }
</script>

<?php include 'includes/footer.php'; ?>