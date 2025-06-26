<?php
// Assuming you have a database connection established
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "farm_management"; // Adjust to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get managerId from POST request
$managerId = $_POST['managerId'];

// SQL query to check if managerId (email) exists in the users table
$sql = "SELECT COUNT(*) as count FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $managerId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Close statement and database connection
$stmt->close();
$conn->close();

// Send JSON response
if ($row['count'] == 0) {
    echo json_encode(array('valid' => true));
} else {
    echo json_encode(array('valid' => false));
}
?>
