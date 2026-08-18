<?php
// ============ DATABASE CONNECTION ============
// Using MySQLi with prepared statements

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "bliss_bites_db";

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8");

// Function to get connection (for use in other files)
function getConnection()
{
  global $conn;
  return $conn;
}

// Function to close connection
function closeConnection()
{
  global $conn;
  if ($conn) {
    mysqli_close($conn);
  }
}
