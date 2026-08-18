<?php
// ============ HEADER INCLUDE ============
// Start session and check authentication
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header('Location: index.php');
  exit();
}

// Contains HTML head, opening body, sidebar, and topnav
// Usage: $pageTitle must be set before including this file
if (!isset($pageTitle)) {
  $pageTitle = 'Dashboard';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?> - Bliss Bites Bakery</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Admin CSS -->
  <link rel="stylesheet" href="../assets/css/admin.css">

  <link rel="shortcut icon" href="../assets/images/logo.webp" type="image/x-icon">
</head>

<body>

  <!-- Include Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Main Content -->
  <main class="main-content" id="mainContent">

    <!-- Top Navigation -->
    <?php include 'topnav.php'; ?>

    <!-- Page Content Container -->
    <div class="page-content">