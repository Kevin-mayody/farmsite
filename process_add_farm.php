<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $farmName = $_POST["farm_name"];
    $farmId = $_POST["farmId"];
    $location = $_POST["location"];
    $managerId = $_POST["managerId"];
    $password = $_POST["password"];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Database connection settings
    $servername = "localhost";
    $username = "root";
    $db_password = ""; // Database password
    $dbname = "farm_management";

    // Create connection
    $conn = new mysqli($servername, $username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL statement to insert the new farm into the database
    $sql = "INSERT INTO farms (farm_name, farm_id, farm_location, manager_id, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sssss", $farmName, $farmId, $location, $managerId, $hashedPassword);

    if ($stmt->execute()) {
        // Redirect to farm list page after successful insertion
        echo "<script>
                alert('Farm added successfully.');
                window.location.href = 'farm_list.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // If the form is not submitted, redirect to the add farm page
    header("Location: add_farm.php");
    exit();
}
?>
