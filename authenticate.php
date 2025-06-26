<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $farmId = $_POST["farmId"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $password = $_POST["password"];

    // Prepare SQL statement to fetch user data based on farm ID, role, and email
    $sql = "SELECT * FROM users WHERE farm_id = ? AND email = ? AND role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $farmId, $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user;
            header("Location: dashboard.php"); // Redirect to dashboard after successful login
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid email or role.";
    }

    $stmt->close();
    $conn->close();
}
?>
