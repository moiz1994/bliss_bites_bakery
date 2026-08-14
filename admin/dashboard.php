<?php
$pageTitle = 'Dashboard';
include 'includes/header.php';
?>
<!-- Dashboard Content (Default) -->
<div id="dashboardContent">
  <div class="page-header">
    <h4><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
    <p>Welcome back! Here's what's happening with your bakery today.</p>
  </div>

  <!-- Stats Cards -->
  <div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="stat-icon orders">
          <i class="bi bi-cart-check"></i>
        </div>
        <div class="stat-value">156</div>
        <div class="stat-label">Total Orders</div>
        <div class="stat-change positive">
          <i class="bi bi-arrow-up-short"></i> 12% from last month
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="stat-icon revenue">
          <i class="bi bi-currency-dollar"></i>
        </div>
        <div class="stat-value">Rs. 85,400</div>
        <div class="stat-label">Total Revenue</div>
        <div class="stat-change positive">
          <i class="bi bi-arrow-up-short"></i> 8% from last month
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="stat-icon cakes">
          <i class="bi bi-cake2"></i>
        </div>
        <div class="stat-value">24</div>
        <div class="stat-label">Total Cakes</div>
        <div class="stat-change positive">
          <i class="bi bi-plus-circle"></i> 3 new added
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="stat-icon pending">
          <i class="bi bi-hourglass-split"></i>
        </div>
        <div class="stat-value">8</div>
        <div class="stat-label">Pending Orders</div>
        <div class="stat-change" style="color: #e53e3e">
          <i class="bi bi-exclamation-circle"></i> Needs attention
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Orders -->
  <div class="card">
    <div
      class="card-header d-flex justify-content-between align-items-center">
      <span>Recent Orders</span>
      <a
        href="#"
        class="btn btn-sm text-decoration-none"
        style="background: var(--peach-pale); color: var(--peach-dark)"
        onclick="showPage('orders')">
        View All <i class="bi bi-arrow-right"></i>
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Cake</th>
            <th>Weight</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><strong>#BB-1001</strong></td>
            <td>Ayesha Khan</td>
            <td>Chocolate Fudge</td>
            <td>2 Pound</td>
            <td>Rs. 3,500</td>
            <td>
              <span class="badge-status badge-pending">Pending</span>
            </td>
            <td>15 Mar 2024</td>
          </tr>
          <tr>
            <td><strong>#BB-1002</strong></td>
            <td>Fatima Ali</td>
            <td>Vanilla Cream</td>
            <td>1 Pound</td>
            <td>Rs. 1,800</td>
            <td>
              <span class="badge-status badge-confirmed">Confirmed</span>
            </td>
            <td>15 Mar 2024</td>
          </tr>
          <tr>
            <td><strong>#BB-1003</strong></td>
            <td>Zara Ahmed</td>
            <td>Red Velvet</td>
            <td>3 Pound</td>
            <td>Rs. 5,200</td>
            <td><span class="badge-status badge-ready">Ready</span></td>
            <td>14 Mar 2024</td>
          </tr>
          <tr>
            <td><strong>#BB-1004</strong></td>
            <td>Hira Imran</td>
            <td>Pineapple Cream</td>
            <td>2 Pound</td>
            <td>Rs. 3,200</td>
            <td>
              <span class="badge-status badge-delivered">Delivered</span>
            </td>
            <td>14 Mar 2024</td>
          </tr>
          <tr>
            <td><strong>#BB-1005</strong></td>
            <td>Sana Tariq</td>
            <td>Fondant Wedding</td>
            <td>4 Pound</td>
            <td>Rs. 8,500</td>
            <td>
              <span class="badge-status badge-pending">Pending</span>
            </td>
            <td>13 Mar 2024</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>