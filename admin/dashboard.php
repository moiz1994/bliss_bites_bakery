<?php
$pageTitle = 'Dashboard';
include 'includes/header.php';

// Include database connection
require_once '../config/database.php';

// ============ FETCH STATISTICS ============

// Total Orders
$query_orders = "SELECT COUNT(*) as total FROM orders";
$result_orders = mysqli_query($conn, $query_orders);
$totalOrders = mysqli_fetch_assoc($result_orders)['total'] ?? 0;

// Total Revenue (excluding cancelled orders)
$query_revenue = "SELECT COALESCE(SUM(total_amount), 0) as total FROM orders WHERE order_status != 'Cancelled'";
$result_revenue = mysqli_query($conn, $query_revenue);
$totalRevenue = mysqli_fetch_assoc($result_revenue)['total'] ?? 0;

// Total Cakes
$query_cakes = "SELECT COUNT(*) as total FROM cakes";
$result_cakes = mysqli_query($conn, $query_cakes);
$totalCakes = mysqli_fetch_assoc($result_cakes)['total'] ?? 0;

// Pending Orders
$query_pending = "SELECT COUNT(*) as total FROM orders WHERE order_status = 'Pending'";
$result_pending = mysqli_query($conn, $query_pending);
$pendingOrders = mysqli_fetch_assoc($result_pending)['total'] ?? 0;

// Recent Orders
$query_recent = "SELECT o.order_number, o.customer_name, c.cake_name, wc.weight_name, o.total_amount, o.order_status, o.created_at
                 FROM orders o
                 LEFT JOIN order_items oi ON o.id = oi.order_id
                 LEFT JOIN cakes c ON oi.cake_id = c.id
                 LEFT JOIN weight_classes wc ON oi.weight_class_id = wc.id
                 GROUP BY o.id
                 ORDER BY o.created_at DESC
                 LIMIT 5";
$result_recent = mysqli_query($conn, $query_recent);
?>

<!-- Dashboard Page Header -->
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
      <div class="stat-value"><?php echo $totalOrders; ?></div>
      <div class="stat-label">Total Orders</div>
      <div class="stat-change positive">
        <i class="bi bi-arrow-up-short"></i> All time
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="stat-icon revenue">
        <i class="bi bi-currency-dollar"></i>
      </div>
      <div class="stat-value">Rs. <?php echo number_format($totalRevenue); ?></div>
      <div class="stat-label">Total Revenue</div>
      <div class="stat-change positive">
        <i class="bi bi-arrow-up-short"></i> All time
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="stat-icon cakes">
        <i class="bi bi-cake2"></i>
      </div>
      <div class="stat-value"><?php echo $totalCakes; ?></div>
      <div class="stat-label">Total Cakes</div>
      <div class="stat-change positive">
        <i class="bi bi-plus-circle"></i> In catalog
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="stat-icon pending">
        <i class="bi bi-hourglass-split"></i>
      </div>
      <div class="stat-value"><?php echo $pendingOrders; ?></div>
      <div class="stat-label">Pending Orders</div>
      <?php if ($pendingOrders > 0): ?>
        <div class="stat-change" style="color: #E53E3E;">
          <i class="bi bi-exclamation-circle"></i> Needs attention
        </div>
      <?php else: ?>
        <div class="stat-change positive">
          <i class="bi bi-check-circle"></i> All caught up
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Recent Orders -->
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>Recent Orders</span>
    <a href="orders.php" class="btn btn-sm text-decoration-none" style="background: var(--peach-pale); color: var(--peach-dark);">
      View All <i class="bi bi-arrow-right"></i>
    </a>
  </div>
  <div class="table-responsive">
    <?php if (mysqli_num_rows($result_recent) > 0): ?>
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
          <?php while ($order = mysqli_fetch_assoc($result_recent)):
            // Determine status badge class
            $statusClass = '';
            switch ($order['order_status']) {
              case 'Pending':
                $statusClass = 'badge-pending';
                break;
              case 'Confirmed':
                $statusClass = 'badge-confirmed';
                break;
              case 'Processing':
                $statusClass = 'badge-confirmed';
                break;
              case 'Ready':
                $statusClass = 'badge-ready';
                break;
              case 'Delivered':
                $statusClass = 'badge-delivered';
                break;
              case 'Cancelled':
                $statusClass = 'badge-cancelled';
                break;
            }
          ?>
            <tr>
              <td><strong>#<?php echo htmlspecialchars($order['order_number']); ?></strong></td>
              <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
              <td><?php echo htmlspecialchars($order['cake_name'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($order['weight_name'] ?? 'N/A'); ?></td>
              <td>Rs. <?php echo number_format($order['total_amount']); ?></td>
              <td><span class="badge-status <?php echo $statusClass; ?>"><?php echo $order['order_status']; ?></span></td>
              <td><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="text-center p-5">
        <i class="bi bi-inbox" style="font-size: 48px; color: var(--peach-light);"></i>
        <p class="mt-3 text-muted">No orders yet</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php
// Close database connection
mysqli_close($conn);
include 'includes/footer.php';
?>