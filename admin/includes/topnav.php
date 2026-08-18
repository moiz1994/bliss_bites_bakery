<?php
// ============ TOP NAVBAR INCLUDE ============
?>

<!-- Top Navbar -->
<nav class="top-navbar">
  <button class="toggle-btn" id="toggleSidebar">
    <i class="bi bi-list"></i>
  </button>

  <div class="nav-right">
    <button class="icon-btn">
      <i class="bi bi-bell"></i>
      <span class="dot"></span>
    </button>
    <div class="dropdown">
      <div class="admin-avatar dropdown-toggle" data-bs-toggle="dropdown" title="Admin" style="cursor: pointer;">
        A
      </div>
      <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border: 1px solid var(--border-color); border-radius: 10px;">
        <li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear me-2"></i>Settings</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
      </ul>
    </div>
  </div>
</nav>