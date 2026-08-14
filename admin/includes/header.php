<?php
// ============ HEADER INCLUDE ============
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