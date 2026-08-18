<?php
$pageTitle = 'Orders';
include 'includes/header.php';

// Include database connection
require_once '../config/database.php';

// ============ FETCH ORDER STATISTICS ============

// All Orders Count
$query_all = "SELECT COUNT(*) as total FROM orders";
$result_all = mysqli_query($conn, $query_all);
$allOrders = mysqli_fetch_assoc($result_all)['total'] ?? 0;

// Pending Orders
$query_pending = "SELECT COUNT(*) as total FROM orders WHERE order_status = 'Pending'";
$result_pending = mysqli_query($conn, $query_pending);
$pendingCount = mysqli_fetch_assoc($result_pending)['total'] ?? 0;

// Delivered Orders
$query_delivered = "SELECT COUNT(*) as total FROM orders WHERE order_status = 'Delivered'";
$result_delivered = mysqli_query($conn, $query_delivered);
$deliveredCount = mysqli_fetch_assoc($result_delivered)['total'] ?? 0;

// Cancelled Orders
$query_cancelled = "SELECT COUNT(*) as total FROM orders WHERE order_status = 'Cancelled'";
$result_cancelled = mysqli_query($conn, $query_cancelled);
$cancelledCount = mysqli_fetch_assoc($result_cancelled)['total'] ?? 0;

// ============ FETCH ALL ORDERS ============
$query_orders = "SELECT o.id, o.order_number, o.customer_name, o.phone, o.address, 
                        o.delivery_date, o.delivery_time, o.cake_message, 
                        o.special_instructions, o.total_amount, o.order_status, 
                        o.created_at,
                        GROUP_CONCAT(CONCAT(c.cake_name, ' (', wc.weight_name, ' x', oi.quantity, ')') SEPARATOR '<br>') as cake_details
                 FROM orders o
                 LEFT JOIN order_items oi ON o.id = oi.order_id
                 LEFT JOIN cakes c ON oi.cake_id = c.id
                 LEFT JOIN weight_classes wc ON oi.weight_class_id = wc.id
                 GROUP BY o.id
                 ORDER BY o.created_at DESC";
$result_orders = mysqli_query($conn, $query_orders);
?>

<!-- Orders Page Header -->
<div class="page-header d-flex justify-content-between align-items-center flex-wrap">
  <div>
    <h4><i class="bi bi-cart-check me-2"></i>Orders</h4>
    <p>Manage all customer orders</p>
  </div>
  <button class="btn text-white" style="background: linear-gradient(135deg, var(--peach-primary), var(--peach-dark)); border-radius: 10px; padding: 10px 20px;">
    <i class="bi bi-download me-2"></i>Export Orders
  </button>
</div>

<!-- Stats Mini Cards -->
<div class="row g-3 mb-4">
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="stat-value" style="font-size: 24px;"><?php echo $allOrders; ?></div>
          <div class="stat-label">All Orders</div>
        </div>
        <div class="stat-icon orders" style="width: 40px; height: 40px; font-size: 18px;">
          <i class="bi bi-cart-check"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="stat-value" style="font-size: 24px; color: #856404;"><?php echo $pendingCount; ?></div>
          <div class="stat-label">Pending</div>
        </div>
        <div class="stat-icon" style="background: #FFF3CD; color: #856404; width: 40px; height: 40px; font-size: 18px;">
          <i class="bi bi-hourglass-split"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="stat-value" style="font-size: 24px; color: #155724;"><?php echo $deliveredCount; ?></div>
          <div class="stat-label">Delivered</div>
        </div>
        <div class="stat-icon" style="background: #D4EDDA; color: #155724; width: 40px; height: 40px; font-size: 18px;">
          <i class="bi bi-check-circle"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="stat-card">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="stat-value" style="font-size: 24px; color: #E53E3E;"><?php echo $cancelledCount; ?></div>
          <div class="stat-label">Cancelled</div>
        </div>
        <div class="stat-icon" style="background: #FDE8E8; color: #E53E3E; width: 40px; height: 40px; font-size: 18px;">
          <i class="bi bi-x-circle"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filters & Search -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="orders.php">
      <div class="row g-3 align-items-end">
        <div class="col-md-3">
          <label class="form-label fw-semibold" style="font-size: 13px; color: var(--text-muted);">SEARCH</label>
          <div class="input-group">
            <span class="input-group-text" style="background: var(--peach-pale); border-color: var(--peach-light);">
              <i class="bi bi-search" style="color: var(--peach-dark);"></i>
            </span>
            <input type="text" class="form-control" name="search" placeholder="Order # or customer name..."
              value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
              style="border-color: var(--peach-light);">
          </div>
        </div>
        <div class="col-md-2">
          <label class="form-label fw-semibold" style="font-size: 13px; color: var(--text-muted);">STATUS</label>
          <select class="form-select" name="status" style="border-color: var(--peach-light);">
            <option value="">All Status</option>
            <option value="Pending" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
            <option value="Confirmed" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
            <option value="Processing" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
            <option value="Ready" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Ready') ? 'selected' : ''; ?>>Ready</option>
            <option value="Delivered" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
            <option value="Cancelled" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label fw-semibold" style="font-size: 13px; color: var(--text-muted);">DATE FROM</label>
          <input type="date" class="form-control" name="date_from" style="border-color: var(--peach-light);"
            value="<?php echo isset($_GET['date_from']) ? $_GET['date_from'] : ''; ?>">
        </div>
        <div class="col-md-2">
          <label class="form-label fw-semibold" style="font-size: 13px; color: var(--text-muted);">DATE TO</label>
          <input type="date" class="form-control" name="date_to" style="border-color: var(--peach-light);"
            value="<?php echo isset($_GET['date_to']) ? $_GET['date_to'] : ''; ?>">
        </div>
        <div class="col-md-3">
          <button type="submit" class="btn text-white w-100" style="background: linear-gradient(135deg, var(--peach-primary), var(--peach-dark)); border-radius: 10px;">
            <i class="bi bi-funnel me-2"></i>Apply Filters
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Orders Table -->
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>All Orders <small class="text-muted">(<?php echo $allOrders; ?> orders)</small></span>
    <button class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
      <i class="bi bi-printer me-1"></i> Print
    </button>
  </div>
  <div class="table-responsive">
    <?php if (mysqli_num_rows($result_orders) > 0): ?>
      <table class="table table-hover">
        <thead>
          <tr>
            <th><input type="checkbox"></th>
            <th>Order #</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Cake(s)</th>
            <th>Delivery Date</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($order = mysqli_fetch_assoc($result_orders)):
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
              <td><input type="checkbox"></td>
              <td><strong>#<?php echo htmlspecialchars($order['order_number']); ?></strong></td>
              <td>
                <div class="fw-semibold"><?php echo htmlspecialchars($order['customer_name']); ?></div>
                <small class="text-muted"><?php echo htmlspecialchars(substr($order['address'], 0, 30)) . '...'; ?></small>
              </td>
              <td><?php echo htmlspecialchars($order['phone']); ?></td>
              <td><?php echo $order['cake_details'] ?? 'N/A'; ?></td>
              <td><?php echo date('d M Y', strtotime($order['delivery_date'])); ?></td>
              <td><strong>Rs. <?php echo number_format($order['total_amount']); ?></strong></td>
              <td><span class="badge-status <?php echo $statusClass; ?>"><?php echo $order['order_status']; ?></span></td>
              <td>
                <div class="dropdown">
                  <button class="btn btn-sm" style="background: var(--peach-pale); border-radius: 8px;" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border: 1px solid var(--border-color); border-radius: 10px;">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#orderDetailModal<?php echo $order['id']; ?>">
                        <i class="bi bi-eye me-2"></i>View Details</a></li>
                    <?php if ($order['order_status'] == 'Pending'): ?>
                      <li><a class="dropdown-item" href="update-order-status.php?id=<?php echo $order['id']; ?>&status=Confirmed">
                          <i class="bi bi-check-circle me-2"></i>Confirm</a></li>
                      <li><a class="dropdown-item text-danger" href="update-order-status.php?id=<?php echo $order['id']; ?>&status=Cancelled">
                          <i class="bi bi-x-circle me-2"></i>Cancel</a></li>
                    <?php endif; ?>
                  </ul>
                </div>
              </td>
            </tr>

            <!-- Order Detail Modal -->
            <div class="modal fade" id="orderDetailModal<?php echo $order['id']; ?>" tabindex="-1">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--border-color);">
                  <div class="modal-header" style="background: var(--peach-pale); border-radius: 16px 16px 0 0; border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title"><i class="bi bi-receipt me-2"></i>Order #<?php echo htmlspecialchars($order['order_number']); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <small class="text-muted">CUSTOMER</small>
                        <p class="fw-semibold mb-1"><?php echo htmlspecialchars($order['customer_name']); ?></p>
                        <p class="mb-1"><?php echo htmlspecialchars($order['phone']); ?></p>
                        <p><?php echo htmlspecialchars($order['address']); ?></p>
                      </div>
                      <div class="col-md-6 text-md-end">
                        <small class="text-muted">ORDER INFO</small>
                        <p class="mb-1"><strong>Order Date:</strong> <?php echo date('d M Y', strtotime($order['created_at'])); ?></p>
                        <p class="mb-1"><strong>Delivery Date:</strong> <?php echo date('d M Y', strtotime($order['delivery_date'])); ?></p>
                        <?php if ($order['delivery_time']): ?>
                          <p class="mb-1"><strong>Delivery Time:</strong> <?php echo htmlspecialchars($order['delivery_time']); ?></p>
                        <?php endif; ?>
                        <p><span class="badge-status <?php echo $statusClass; ?>"><?php echo $order['order_status']; ?></span></p>
                      </div>
                    </div>

                    <hr>

                    <small class="text-muted">ORDER ITEMS</small>
                    <table class="table table-bordered mt-2" style="border-color: var(--border-color);">
                      <thead style="background: var(--peach-pale);">
                        <tr>
                          <th>Cake</th>
                          <th>Weight</th>
                          <th>Qty</th>
                          <th>Price</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Fetch order items for this order
                        $query_items = "SELECT c.cake_name, wc.weight_name, oi.quantity, oi.price_per_unit, oi.total_price
                                                       FROM order_items oi
                                                       JOIN cakes c ON oi.cake_id = c.id
                                                       JOIN weight_classes wc ON oi.weight_class_id = wc.id
                                                       WHERE oi.order_id = ?";
                        $stmt_items = mysqli_prepare($conn, $query_items);
                        mysqli_stmt_bind_param($stmt_items, "i", $order['id']);
                        mysqli_stmt_execute($stmt_items);
                        $result_items = mysqli_stmt_get_result($stmt_items);

                        while ($item = mysqli_fetch_assoc($result_items)):
                        ?>
                          <tr>
                            <td><?php echo htmlspecialchars($item['cake_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['weight_name']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>Rs. <?php echo number_format($item['price_per_unit']); ?></td>
                            <td>Rs. <?php echo number_format($item['total_price']); ?></td>
                          </tr>
                        <?php endwhile; ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="4" class="text-end fw-bold">Total:</td>
                          <td class="fw-bold">Rs. <?php echo number_format($order['total_amount']); ?></td>
                        </tr>
                      </tfoot>
                    </table>

                    <?php if ($order['cake_message']): ?>
                      <div class="p-3 rounded-3 mb-2" style="background: var(--peach-pale);">
                        <small class="text-muted">MESSAGE ON CAKE</small>
                        <p class="mb-0 mt-1"><?php echo htmlspecialchars($order['cake_message']); ?></p>
                      </div>
                    <?php endif; ?>

                    <?php if ($order['special_instructions']): ?>
                      <div class="p-3 rounded-3" style="background: #FFF3CD;">
                        <small class="text-muted">SPECIAL INSTRUCTIONS</small>
                        <p class="mb-0 mt-1"><?php echo htmlspecialchars($order['special_instructions']); ?></p>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Close</button>
                    <?php if ($order['order_status'] == 'Pending'): ?>
                      <a href="update-order-status.php?id=<?php echo $order['id']; ?>&status=Confirmed" class="btn text-white" style="background: var(--peach-dark); border-radius: 8px;">
                        <i class="bi bi-check-circle me-1"></i>Confirm Order
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="text-center p-5">
        <i class="bi bi-inbox" style="font-size: 48px; color: var(--peach-light);"></i>
        <p class="mt-3 text-muted">No orders found</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php
// Close database connection
mysqli_close($conn);
include 'includes/footer.php';
?>