<?php
// ============ DELETE CAKE ============
session_start();

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header('Location: index.php');
  exit();
}

// Include database connection
require_once '../config/database.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $cakeId = (int)$_GET['id'];

  // Start transaction
  mysqli_begin_transaction($conn);

  try {
    // Delete cake prices first (foreign key constraint)
    $deletePrices = "DELETE FROM cake_prices WHERE cake_id = ?";
    $stmtPrices = mysqli_prepare($conn, $deletePrices);
    mysqli_stmt_bind_param($stmtPrices, "i", $cakeId);
    mysqli_stmt_execute($stmtPrices);

    // Delete the cake
    $deleteCake = "DELETE FROM cakes WHERE id = ?";
    $stmtCake = mysqli_prepare($conn, $deleteCake);
    mysqli_stmt_bind_param($stmtCake, "i", $cakeId);
    mysqli_stmt_execute($stmtCake);

    // Commit transaction
    mysqli_commit($conn);

    header('Location: cakes.php?msg=deleted');
    exit();
  } catch (Exception $e) {
    mysqli_rollback($conn);
    header('Location: cakes.php?msg=error');
    exit();
  }
}

mysqli_close($conn);
header('Location: cakes.php');
exit();
