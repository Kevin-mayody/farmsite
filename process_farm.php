<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $farmName = $_POST["farm_name"];
    $farmId = $_POST["farmId"];

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

    // Prepare and execute SQL statement to insert the new farm into the database
    $sql = "INSERT INTO farms (farm_id, farm_name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $farmId, $farmName);

    if ($stmt->execute() === TRUE) {
        // Redirect to farm list page after successful insertion
        echo "<script>
                alert('Farm added successfully.');
                window.location.href = 'farm_list.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // If the form is not submitted, redirect to the add farm page
    header("Location: add_farm.php");
    exit();
}
?>
