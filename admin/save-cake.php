<?php
// ============ SAVE CAKE (CREATE & UPDATE) ============
session_start();

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header('Location: index.php');
  exit();
}

// Include database connection
require_once '../config/database.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $cakeId = isset($_POST['cake_id']) ? (int)$_POST['cake_id'] : 0;
  $cakeName = mysqli_real_escape_string($conn, $_POST['cake_name'] ?? '');
  $flavor = mysqli_real_escape_string($conn, $_POST['flavor'] ?? '');
  $categoryId = (int)($_POST['category_id'] ?? 0);
  $cakeType = mysqli_real_escape_string($conn, $_POST['cake_type'] ?? '');
  $preparationTime = mysqli_real_escape_string($conn, $_POST['preparation_time'] ?? '');
  $status = mysqli_real_escape_string($conn, $_POST['status'] ?? 'Available');
  $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
  $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients'] ?? '');
  $weightClassIds = $_POST['weight_class_id'] ?? [];
  $prices = $_POST['price'] ?? [];

  // Generate slug
  $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $cakeName)));

  // Handle image upload
  $imageName = '';
  if (isset($_FILES['cake_image']) && $_FILES['cake_image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../assets/images/uploads/';

    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $fileExtension = pathinfo($_FILES['cake_image']['name'], PATHINFO_EXTENSION);
    $imageName = time() . '_' . $slug . '.' . $fileExtension;
    $uploadPath = $uploadDir . $imageName;

    if (!move_uploaded_file($_FILES['cake_image']['tmp_name'], $uploadPath)) {
      $imageName = '';
    }
  }

  // Start transaction
  mysqli_begin_transaction($conn);

  try {
    if ($cakeId > 0) {
      // UPDATE existing cake
      $query = "UPDATE cakes SET 
                        cake_name = ?, 
                        slug = ?, 
                        category_id = ?, 
                        cake_type = ?, 
                        flavor = ?, 
                        description = ?, 
                        ingredients = ?, 
                        preparation_time = ?, 
                        status = ?";

      // Add image to update if new image uploaded
      if ($imageName) {
        $query .= ", image = ?";
      }

      $query .= " WHERE id = ?";

      $stmt = mysqli_prepare($conn, $query);

      if ($imageName) {
        mysqli_stmt_bind_param(
          $stmt,
          "ssisssssssi",
          $cakeName,
          $slug,
          $categoryId,
          $cakeType,
          $flavor,
          $description,
          $ingredients,
          $preparationTime,
          $status,
          $imageName,
          $cakeId
        );
      } else {
        mysqli_stmt_bind_param(
          $stmt,
          "ssissssssi",
          $cakeName,
          $slug,
          $categoryId,
          $cakeType,
          $flavor,
          $description,
          $ingredients,
          $preparationTime,
          $status,
          $cakeId
        );
      }

      mysqli_stmt_execute($stmt);

      // Delete existing prices
      $deletePrices = "DELETE FROM cake_prices WHERE cake_id = ?";
      $stmtDelete = mysqli_prepare($conn, $deletePrices);
      mysqli_stmt_bind_param($stmtDelete, "i", $cakeId);
      mysqli_stmt_execute($stmtDelete);
    } else {
      // INSERT new cake
      $query = "INSERT INTO cakes (cake_name, slug, category_id, cake_type, flavor, description, ingredients, preparation_time, image, status) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param(
        $stmt,
        "ssisssssss",
        $cakeName,
        $slug,
        $categoryId,
        $cakeType,
        $flavor,
        $description,
        $ingredients,
        $preparationTime,
        $imageName,
        $status
      );

      mysqli_stmt_execute($stmt);

      $cakeId = mysqli_insert_id($conn);
    }

    // Insert new prices
    if (!empty($weightClassIds) && !empty($prices)) {
      $insertPrice = "INSERT INTO cake_prices (cake_id, weight_class_id, price) VALUES (?, ?, ?)";
      $stmtPrice = mysqli_prepare($conn, $insertPrice);

      foreach ($weightClassIds as $key => $weightClassId) {
        if (!empty($weightClassId) && !empty($prices[$key])) {
          $price = (float)$prices[$key];
          mysqli_stmt_bind_param($stmtPrice, "iid", $cakeId, $weightClassId, $price);
          mysqli_stmt_execute($stmtPrice);
        }
      }
    }

    // Commit transaction
    mysqli_commit($conn);

    // Redirect with success message
    header('Location: cakes.php?msg=saved');
    exit();
  } catch (Exception $e) {
    // Rollback on error
    mysqli_rollback($conn);

    // Redirect with error message
    header('Location: cakes.php?msg=error');
    exit();
  }
} else {
  // Not a POST request
  header('Location: cakes.php');
  exit();
}

mysqli_close($conn);
