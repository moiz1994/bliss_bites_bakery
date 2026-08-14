<?php
$pageTitle = 'Orders';
include 'includes/header.php';
?>

<!-- Orders Content -->
<div id="ordersContent">
  <div
    class="page-header d-flex justify-content-between align-items-center flex-wrap">
    <div>
      <h4><i class="bi bi-cart-check me-2"></i>Orders</h4>
      <p>Manage all customer orders</p>
    </div>
    <button
      class="btn text-white"
      style="
                background: linear-gradient(
                  135deg,
                  var(--peach-primary),
                  var(--peach-dark)
                );
                border-radius: 10px;
                padding: 10px 20px;
              ">
      <i class="bi bi-download me-2"></i>Export Orders
    </button>
  </div>

  <!-- Stats Mini Cards -->
  <div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="stat-value" style="font-size: 24px">156</div>
            <div class="stat-label">All Orders</div>
          </div>
          <div
            class="stat-icon orders"
            style="width: 40px; height: 40px; font-size: 18px">
            <i class="bi bi-cart-check"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div
              class="stat-value"
              style="font-size: 24px; color: #856404">
              8
            </div>
            <div class="stat-label">Pending</div>
          </div>
          <div
            class="stat-icon"
            style="
                      background: #fff3cd;
                      color: #856404;
                      width: 40px;
                      height: 40px;
                      font-size: 18px;
                    ">
            <i class="bi bi-hourglass-split"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div
              class="stat-value"
              style="font-size: 24px; color: #155724">
              98
            </div>
            <div class="stat-label">Delivered</div>
          </div>
          <div
            class="stat-icon"
            style="
                      background: #d4edda;
                      color: #155724;
                      width: 40px;
                      height: 40px;
                      font-size: 18px;
                    ">
            <i class="bi bi-check-circle"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div
              class="stat-value"
              style="font-size: 24px; color: #e53e3e">
              3
            </div>
            <div class="stat-label">Cancelled</div>
          </div>
          <div
            class="stat-icon"
            style="
                      background: #fde8e8;
                      color: #e53e3e;
                      width: 40px;
                      height: 40px;
                      font-size: 18px;
                    ">
            <i class="bi bi-x-circle"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filters & Search -->
  <div class="card mb-4">
    <div class="card-body">
      <div class="row g-3 align-items-end">
        <div class="col-md-3">
          <label
            class="form-label fw-semibold"
            style="font-size: 13px; color: var(--text-muted)">SEARCH</label>
          <div class="input-group">
            <span
              class="input-group-text"
              style="
                        background: var(--peach-pale);
                        border-color: var(--peach-light);
                      ">
              <i
                class="bi bi-search"
                style="color: var(--peach-dark)"></i>
            </span>
            <input
              type="text"
              class="form-control"
              placeholder="Order # or customer name..."
              style="border-color: var(--peach-light)"
              id="orderSearch" />
          </div>
        </div>
        <div class="col-md-2">
          <label
            class="form-label fw-semibold"
            style="font-size: 13px; color: var(--text-muted)">STATUS</label>
          <select
            class="form-select"
            style="border-color: var(--peach-light)"
            id="statusFilter">
            <option value="all">All Status</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="processing">Processing</option>
            <option value="ready">Ready</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
          </select>
        </div>
        <div class="col-md-2">
          <label
            class="form-label fw-semibold"
            style="font-size: 13px; color: var(--text-muted)">DATE FROM</label>
          <input
            type="date"
            class="form-control"
            style="border-color: var(--peach-light)"
            id="dateFrom" />
        </div>
        <div class="col-md-2">
          <label
            class="form-label fw-semibold"
            style="font-size: 13px; color: var(--text-muted)">DATE TO</label>
          <input
            type="date"
            class="form-control"
            style="border-color: var(--peach-light)"
            id="dateTo" />
        </div>
        <div class="col-md-3">
          <button
            class="btn text-white w-100"
            style="
                      background: linear-gradient(
                        135deg,
                        var(--peach-primary),
                        var(--peach-dark)
                      );
                      border-radius: 10px;
                    "
            onclick="filterOrders()">
            <i class="bi bi-funnel me-2"></i>Apply Filters
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Orders Table -->
  <div class="card">
    <div
      class="card-header d-flex justify-content-between align-items-center">
      <span>All Orders <small class="text-muted">(156 orders)</small></span>
      <div>
        <button
          class="btn btn-sm btn-outline-secondary me-2"
          style="border-radius: 8px">
          <i class="bi bi-printer me-1"></i> Print
        </button>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th><input type="checkbox" /></th>
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
        <tbody id="ordersTableBody">
          <tr>
            <td><input type="checkbox" /></td>
            <td><strong>#BB-1001</strong></td>
            <td>
              <div class="fw-semibold">Ayesha Khan</div>
              <small class="text-muted">Lahore, Punjab</small>
            </td>
            <td>0300-1234567</td>
            <td>
              Chocolate Fudge (2 Pound)
              <br /><small class="text-muted">+ Vanilla Cream (1 Pound)</small>
            </td>
            <td>20 Mar 2024</td>
            <td><strong>Rs. 5,300</strong></td>
            <td>
              <span class="badge-status badge-pending">Pending</span>
            </td>
            <td>
              <div class="dropdown">
                <button
                  class="btn btn-sm"
                  style="
                            background: var(--peach-pale);
                            border-radius: 8px;
                          "
                  data-bs-toggle="dropdown">
                  <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul
                  class="dropdown-menu dropdown-menu-end shadow-sm"
                  style="
                            border: 1px solid var(--border-color);
                            border-radius: 10px;
                          ">
                  <li>
                    <a
                      class="dropdown-item"
                      href="#"
                      onclick="viewOrderDetails('BB-1001')"><i class="bi bi-eye me-2"></i>View Details</a>
                  </li>
                  <li>
                    <a
                      class="dropdown-item"
                      href="#"
                      onclick="updateStatus('BB-1001', 'confirmed')"><i class="bi bi-check-circle me-2"></i>Confirm</a>
                  </li>
                  <li>
                    <a
                      class="dropdown-item text-danger"
                      href="#"
                      onclick="updateStatus('BB-1001', 'cancelled')"><i class="bi bi-x-circle me-2"></i>Cancel</a>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          <tr>
            <td><input type="checkbox" /></td>
            <td><strong>#BB-1002</strong></td>
            <td>
              <div class="fw-semibold">Fatima Ali</div>
              <small class="text-muted">Karachi, Sindh</small>
            </td>
            <td>0321-9876543</td>
            <td>Vanilla Cream (1 Pound)</td>
            <td>20 Mar 2024</td>
            <td><strong>Rs. 1,800</strong></td>
            <td>
              <span class="badge-status badge-confirmed">Confirmed</span>
            </td>
            <td>
              <div class="dropdown">
                <button
                  class="btn btn-sm"
                  style="
                            background: var(--peach-pale);
                            border-radius: 8px;
                          "
                  data-bs-toggle="dropdown">
                  <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul
                  class="dropdown-menu dropdown-menu-end shadow-sm"
                  style="
                            border: 1px solid var(--border-color);
                            border-radius: 10px;
                          ">
                  <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-arrow-right-circle me-2"></i>Processing</a>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          <tr>
            <td><input type="checkbox" /></td>
            <td><strong>#BB-1003</strong></td>
            <td>
              <div class="fw-semibold">Zara Ahmed</div>
              <small class="text-muted">Islamabad</small>
            </td>
            <td>0333-5551234</td>
            <td>Red Velvet (3 Pound)</td>
            <td>19 Mar 2024</td>
            <td><strong>Rs. 5,200</strong></td>
            <td><span class="badge-status badge-ready">Ready</span></td>
            <td>
              <div class="dropdown">
                <button
                  class="btn btn-sm"
                  style="
                            background: var(--peach-pale);
                            border-radius: 8px;
                          "
                  data-bs-toggle="dropdown">
                  <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul
                  class="dropdown-menu dropdown-menu-end shadow-sm"
                  style="
                            border: 1px solid var(--border-color);
                            border-radius: 10px;
                          ">
                  <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-truck me-2"></i>Mark Delivered</a>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          <tr>
            <td><input type="checkbox" /></td>
            <td><strong>#BB-1004</strong></td>
            <td>
              <div class="fw-semibold">Hira Imran</div>
              <small class="text-muted">Faisalabad</small>
            </td>
            <td>0345-1112233</td>
            <td>Pineapple Cream (2 Pound)</td>
            <td>18 Mar 2024</td>
            <td><strong>Rs. 3,200</strong></td>
            <td>
              <span class="badge-status badge-delivered">Delivered</span>
            </td>
            <td>
              <button
                class="btn btn-sm"
                style="
                          background: var(--peach-pale);
                          border-radius: 8px;
                        ">
                <i class="bi bi-eye"></i>
              </button>
            </td>
          </tr>
          <tr>
            <td><input type="checkbox" /></td>
            <td><strong>#BB-1005</strong></td>
            <td>
              <div class="fw-semibold">Sana Tariq</div>
              <small class="text-muted">Rawalpindi</small>
            </td>
            <td>0312-9998877</td>
            <td>Fondant Wedding Cake (4 Pound)</td>
            <td>17 Mar 2024</td>
            <td><strong>Rs. 8,500</strong></td>
            <td>
              <span class="badge-status badge-pending">Pending</span>
            </td>
            <td>
              <div class="dropdown">
                <button
                  class="btn btn-sm"
                  style="
                            background: var(--peach-pale);
                            border-radius: 8px;
                          "
                  data-bs-toggle="dropdown">
                  <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul
                  class="dropdown-menu dropdown-menu-end shadow-sm"
                  style="
                            border: 1px solid var(--border-color);
                            border-radius: 10px;
                          ">
                  <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-check-circle me-2"></i>Confirm</a>
                  </li>
                  <li>
                    <a class="dropdown-item text-danger" href="#"><i class="bi bi-x-circle me-2"></i>Cancel</a>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          <tr>
            <td><input type="checkbox" /></td>
            <td><strong>#BB-1006</strong></td>
            <td>
              <div class="fw-semibold">Nida Hassan</div>
              <small class="text-muted">Multan</small>
            </td>
            <td>0300-4455667</td>
            <td>Strawberry Cream (1 Pound)</td>
            <td>16 Mar 2024</td>
            <td><strong>Rs. 1,900</strong></td>
            <td>
              <span class="badge-status badge-delivered">Delivered</span>
            </td>
            <td>
              <button
                class="btn btn-sm"
                style="
                          background: var(--peach-pale);
                          border-radius: 8px;
                        ">
                <i class="bi bi-eye"></i>
              </button>
            </td>
          </tr>
          <tr>
            <td><input type="checkbox" /></td>
            <td><strong>#BB-1007</strong></td>
            <td>
              <div class="fw-semibold">Mariam Yousaf</div>
              <small class="text-muted">Peshawar</small>
            </td>
            <td>0334-7788990</td>
            <td>Black Forest (3 Pound)</td>
            <td>15 Mar 2024</td>
            <td><strong>Rs. 4,800</strong></td>
            <td>
              <span
                class="badge-status badge-cancelled"
                style="background: #fde8e8; color: #e53e3e">Cancelled</span>
            </td>
            <td>
              <button
                class="btn btn-sm"
                style="
                          background: var(--peach-pale);
                          border-radius: 8px;
                        ">
                <i class="bi bi-eye"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="card-footer border-top" style="background: transparent">
      <div
        class="d-flex justify-content-between align-items-center flex-wrap">
        <small class="text-muted">Showing 1-7 of 156 orders</small>
        <nav>
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled">
              <a
                class="page-link"
                href="#"
                style="color: var(--peach-dark)">Previous</a>
            </li>
            <li class="page-item active">
              <a
                class="page-link"
                href="#"
                style="
                          background: var(--peach-primary);
                          border-color: var(--peach-primary);
                        ">1</a>
            </li>
            <li class="page-item">
              <a
                class="page-link"
                href="#"
                style="color: var(--peach-dark)">2</a>
            </li>
            <li class="page-item">
              <a
                class="page-link"
                href="#"
                style="color: var(--peach-dark)">3</a>
            </li>
            <li class="page-item">
              <a
                class="page-link"
                href="#"
                style="color: var(--peach-dark)">...</a>
            </li>
            <li class="page-item">
              <a
                class="page-link"
                href="#"
                style="color: var(--peach-dark)">23</a>
            </li>
            <li class="page-item">
              <a
                class="page-link"
                href="#"
                style="color: var(--peach-dark)">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>

  <!-- Order Detail Modal -->
  <div class="modal fade" id="orderDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div
        class="modal-content"
        style="
                  border-radius: 16px;
                  border: 1px solid var(--border-color);
                ">
        <div
          class="modal-header"
          style="
                    background: var(--peach-pale);
                    border-radius: 16px 16px 0 0;
                    border-bottom: 1px solid var(--border-color);
                  ">
          <h5 class="modal-title">
            <i class="bi bi-receipt me-2"></i>Order Details -
            <span id="modalOrderNumber">#BB-1001</span>
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <small class="text-muted">CUSTOMER</small>
              <p class="fw-semibold mb-1" id="modalCustomer">
                Ayesha Khan
              </p>
              <p class="mb-0" id="modalPhone">0300-1234567</p>
              <p id="modalAddress">
                House 123, Street 5, Lahore, Punjab
              </p>
            </div>
            <div class="col-md-6 text-md-end">
              <small class="text-muted">ORDER INFO</small>
              <p class="mb-1">
                <strong>Order Date:</strong> 15 Mar 2024
              </p>
              <p class="mb-1">
                <strong>Delivery Date:</strong> 20 Mar 2024
              </p>
              <p>
                <span
                  class="badge-status badge-pending"
                  id="modalStatus">Pending</span>
              </p>
            </div>
          </div>

          <hr />

          <small class="text-muted">ORDER ITEMS</small>
          <table
            class="table table-bordered mt-2"
            style="border-color: var(--border-color)">
            <thead style="background: var(--peach-pale)">
              <tr>
                <th>Cake</th>
                <th>Type</th>
                <th>Weight</th>
                <th>Qty</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody id="modalOrderItems">
              <tr>
                <td>Chocolate Fudge</td>
                <td>Cream</td>
                <td>2 Pound</td>
                <td>1</td>
                <td>Rs. 3,500</td>
              </tr>
              <tr>
                <td>Vanilla Cream</td>
                <td>Cream</td>
                <td>1 Pound</td>
                <td>1</td>
                <td>Rs. 1,800</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4" class="text-end fw-bold">Total:</td>
                <td class="fw-bold">Rs. 5,300</td>
              </tr>
            </tfoot>
          </table>

          <div
            class="p-3 rounded-3"
            style="background: var(--peach-pale)">
            <small class="text-muted">SPECIAL INSTRUCTIONS</small>
            <p class="mb-0 mt-1" id="modalInstructions">
              Please write "Happy Birthday Ayesha" on the cake with pink
              icing.
            </p>
          </div>
        </div>
        <div
          class="modal-footer"
          style="border-top: 1px solid var(--border-color)">
          <select
            class="form-select d-inline-block w-auto me-2"
            style="border-color: var(--peach-light)">
            <option>Update Status</option>
            <option value="confirmed">Confirm</option>
            <option value="processing">Processing</option>
            <option value="ready">Ready</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancel</option>
          </select>
          <button
            type="button"
            class="btn text-white"
            style="background: var(--peach-dark); border-radius: 8px">
            Update
          </button>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
            style="border-radius: 8px">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>