<?php
// ============ UPDATE ORDER STATUS ============
session_start();

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header('Location: index.php');
  exit();
}

// Include database connection
require_once '../config/database.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
  $orderId = (int)$_GET['id'];
  $status = $_GET['status'];

  // Validate status
  $validStatuses = ['Pending', 'Confirmed', 'Processing', 'Ready', 'Delivered', 'Cancelled'];

  if (in_array($status, $validStatuses)) {
    $query = "UPDATE orders SET order_status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $status, $orderId);

    if (mysqli_stmt_execute($stmt)) {
      // Redirect back to orders page
      header('Location: orders.php?msg=status_updated');
      exit();
    }

    mysqli_stmt_close($stmt);
  }
}

mysqli_close($conn);
header('Location: orders.php');
exit();
