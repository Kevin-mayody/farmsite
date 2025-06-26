<?php
session_start();

// Check if worker is logged in
if (!isset($_SESSION['workerId'])) {
    header("Location: worker_login.php");
    exit();
}

// Get the worker ID from the session
$workerId = $_SESSION['workerId'];
$farmId = $_SESSION['farmId'];

// Fetch worker details from the database if needed
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "farm_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch worker details
$sql = "SELECT * FROM workers WHERE worker_id = '$workerId' AND farm_id = '$farmId'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $workerDetails = $result->fetch_assoc();
} else {
    // Handle case where worker details are not found
    echo "Error fetching worker details.";
    exit();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            background-color: whitesmoke;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: red;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            font-size: 16px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Worker Dashboard</h1>
        <div class="details">
            <p><strong>Worker Name:</strong> <?php echo htmlspecialchars($workerDetails['name']); ?></p>
            <p><strong>Farm ID:</strong> <?php echo htmlspecialchars($farmId); ?></p>
            <!-- Add more worker details here -->
        </div>
        <!-- Add more dashboard content here -->
    </div>
</body>
</html>
