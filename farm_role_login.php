<?php
session_start();

// Check if user is logged in and role is set
if (!isset($_SESSION['farmId']) || !isset($_POST['role'])) {
    header("Location: login.php");
    exit();
}

// Get the farmId and role from session and POST
$farmId = $_SESSION['farmId'];
$role = $_POST['role'];

// Redirect to the appropriate login page based on the role
if ($role === 'manager') {
    header("Location: manager_login.php?farmId=$farmId");
    exit();
} elseif ($role === 'worker') {
    header("Location: worker_login.php?farmId=$farmId");
    exit();
} else {
    // Handle unexpected role value
    header("Location: farm_select_role.php");
    exit();
}
?>
