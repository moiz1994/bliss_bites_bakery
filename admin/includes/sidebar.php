<?php
// ============ SIDEBAR INCLUDE ============
// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- ============ SIDEBAR OVERLAY (Mobile) ============ -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ============ SIDEBAR ============ -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <img
      src="../assets/images/logo.webp"
      alt="Bliss Bites Logo"
      class="brand-logo"
      width="50px" />
    <div class="brand-text">
      <h5>Bliss Bites</h5>
      <small>Admin Panel</small>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-item">
      <a href="dashboard.php" class="nav-link <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
        <i class="bi bi-speedometer2"></i>
        Dashboard
      </a>
    </div>
    <div class="nav-item">
      <a href="orders.php" class="nav-link <?php echo ($currentPage == 'orders.php') ? 'active' : ''; ?>">
        <i class="bi bi-cart-check"></i>
        Orders
        <span class="badge">12</span>
      </a>
    </div>
    <div class="nav-item">
      <a href="cakes.php" class="nav-link <?php echo ($currentPage == 'cakes.php') ? 'active' : ''; ?>">
        <i class="bi bi-cake2"></i>
        Cakes
      </a>
    </div>
    <div class="nav-item">
      <a href="categories.php" class="nav-link <?php echo ($currentPage == 'categories.php') ? 'active' : ''; ?>">
        <i class="bi bi-grid"></i>
        Categories
      </a>
    </div>
    <div class="nav-item">
      <a href="weight-classes.php" class="nav-link <?php echo ($currentPage == 'weight-classes.php') ? 'active' : ''; ?>">
        <i class="bi bi-boxes"></i>
        Weight Classes
      </a>
    </div>
    <div class="nav-item">
      <a href="settings.php" class="nav-link <?php echo ($currentPage == 'settings.php') ? 'active' : ''; ?>">
        <i class="bi bi-gear"></i>
        Settings
      </a>
    </div>
  </nav>
</aside>