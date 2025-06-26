<?php
session_start();

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

// Initialize variables
$farmId = isset($_GET['farmId']) ? $_GET['farmId'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs to prevent SQL injection
    $farmId = mysqli_real_escape_string($conn, $farmId);
    $password = mysqli_real_escape_string($conn, $password);

    // Query to fetch farm details based on farmId
    $sql = "SELECT * FROM farms WHERE farm_id = '$farmId'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session and redirect
            $_SESSION['farmId'] = $farmId;
            header("Location: farm_select_role.php");
            exit();
            
        } else {
              $error = "Invalid farm ID or password. Please try again.";

        }
    } else {
        $error = "Invalid farm ID or password. Please try again.";
 
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            background-color: whitesmoke;
            font-family: 'Poppins', sans-serif;
        }
        * {
            font-size: 14px;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            line-height: 1.5;
        }
        .container {
            max-width: 400px;
            height: 400px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: red;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: 300;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .error {
            color: red;
            font-size: 11px;
            font-style: italic;
            margin-top: 5px;
        }
        button {
            background-color: #4caf50;
            margin-top: 10px;
            color: #fff;
            width: 100%;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <center>
            <img src="mkulima-high-resolution-logo-black-transparent.png" alt="Mkulima Logo" width="130" height="auto" style="margin-top: 10px;margin-bottom: 20px;">
        </center>
        <center>
            <h1>Farm Login</h1>
        </center>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="farmId">Farm ID:</label>
                <input type="text" id="farmId" name="farmId" value="<?php echo htmlspecialchars($farmId); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($error)) { ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php } ?>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
