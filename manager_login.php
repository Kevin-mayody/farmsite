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
$managerUsername = isset($_POST['username']) ? $_POST['username'] : '';
$managerPassword = isset($_POST['password']) ? $_POST['password'] : '';
$farmId = isset($_GET['farmId']) ? $_GET['farmId'] : '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs to prevent SQL injection
    $managerUsername = mysqli_real_escape_string($conn, $managerUsername);
    $managerPassword = mysqli_real_escape_string($conn, $managerPassword);

    // Query to fetch manager details based on farmId and username
    $sql = "SELECT * FROM managers WHERE farm_id = '$farmId' AND username = '$managerUsername'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($managerPassword, $row['password'])) {
            // Password is correct, set session and redirect
            $_SESSION['managerId'] = $row['manager_id'];
            $_SESSION['farmId'] = $farmId;
            header("Location: manager_dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password. Please try again.";
        }
    } else {
        $error = "Invalid username or password. Please try again.";
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
    <title>Manager Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        * {
            font-size: 14px;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            line-height: 1.5;
        }
        body {
            background-color: whitesmoke;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 400px;
            height: 450px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
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
            border: 1px solid #a0b19b;
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
            margin-bottom: 20px;
        }
        button:hover {
            background-color: #45a049;
        }
        a {
            
            text-decoration: none;
            color: blue;
            padding: 8px 12px;
            margin: 2px;
            border-radius: 4px;
            display: inline-block;
        }
        a:hover{
            
            
            color: green;
            
        }
    </style>
</head>
<body>
    <div class="container">
        <center>
            <img src="mkulima-high-resolution-logo-black-transparent.png" alt="Mkulima Logo" width="130" height="auto" style="margin-top: 10px;margin-bottom: 20px;">
        </center>
        <center>
            <h1>Manager Login</h1>
        </center>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?farmId=' . urlencode($farmId); ?>" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($managerUsername); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($error)) { ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php } ?>
            </div>
            <button type="submit">Login</button>
            <center>
            <a href="#">Don't have an account?</a>
            </center>
        </form>
    </div>
</body>
</html>
