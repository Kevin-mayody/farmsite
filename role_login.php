<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['farmId'])) {
    header("Location: login.php");
    exit();
}

// Get the farm ID from the session
$farmId = $_SESSION['farmId'];
$role = isset($_POST['role']) ? $_POST['role'] : '';

// Redirect based on the selected role
if ($role === 'manager') {
    header("Location: manager_login.php?farmId=$farmId");
} elseif ($role === 'worker') {
    header("Location: worker_login.php?farmId=$farmId");
} else {
    header("Location: select_role.php");
}
exit();
?>
