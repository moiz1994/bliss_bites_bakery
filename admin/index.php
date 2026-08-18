<?php
// ============ ADMIN LOGIN PAGE ============
session_start();

// Include database connection
require_once '../config/database.php';

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
  header('Location: dashboard.php');
  exit();
}

$errorMessage = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if (!empty($username) && !empty($password)) {
    // Prepare statement to prevent SQL injection
    $query = "SELECT id, username, password, email FROM admin WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
      // Verify password (using password_verify for hashed passwords)
      if (password_verify($password, $row['password'])) {
        // Login successful
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_username'] = $row['username'];
        $_SESSION['admin_email'] = $row['email'];

        header('Location: dashboard.php');
        exit();
      } else {
        $errorMessage = 'Invalid username or password!';
      }
    } else {
      $errorMessage = 'Invalid username or password!';
    }

    mysqli_stmt_close($stmt);
  } else {
    $errorMessage = 'Please enter username and password!';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Bliss Bites Bakery</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>
  <div class="login-container">
    <div class="login-header">
      <div class="login-logo">
        <img src="../assets/images/logo.webp" alt="Bliss Bites Logo">
      </div>
      <h2>Bliss Bites</h2>
      <p>Admin Panel Login</p>
    </div>

    <div class="login-body">
      <!-- <div id="alertMessage" style="display: none;"></div> -->
      <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
          <i class="bi bi-exclamation-circle me-2"></i><?php echo $errorMessage; ?>
        </div>
      <?php endif; ?>

      <form id="loginForm" method="POST" action="#">
        <div class=" form-group">
          <label class="form-label">Username</label>
          <div class="input-group">
            <span class="input-group-text">
              <i class="bi bi-person-fill"></i>
            </span>
            <input type="text" class="form-control" id="username" name="username"
              placeholder="Enter username" required autocomplete="username">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text">
              <i class="bi bi-lock-fill"></i>
            </span>
            <input type="password" class="form-control" id="password" name="password"
              placeholder="Enter password" required autocomplete="current-password">
          </div>
        </div>

        <button type="submit" class="btn btn-login">
          <i class="bi bi-box-arrow-in-right me-2"></i>Login to Dashboard
        </button>
      </form>

      <div class="back-link">
        <a href="../index.html">
          <i class="bi bi-arrow-left me-1"></i>Back to Website
        </a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>