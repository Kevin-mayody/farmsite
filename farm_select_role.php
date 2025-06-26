<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['farmId'])) {
    header("Location: login.php");
    exit();
}

// Get the farmId from the session
$farmId = $_SESSION['farmId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Role</title>
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
            height: 370px;
            border: 1px solid #ccc;
            margin: 100px auto;
            background-color: #fff;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 0px;
            color: red;
        }
        .form-group {
            margin-bottom: 20px;
        }
        button {
            background-color: #4caf50;
            margin-top: 30px;
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
        <img src="mkulima-high-resolution-logo-black-transparent.png" alt="Mkulima Logo" width="130" height="auto" style="margin-top: 10px; margin-bottom: 20px;">
        </center>
        <h1>Select Role</h1>
        <form action="farm_role_login.php" method="POST">
          <input type="hidden" name="farmId" value="<?php echo htmlspecialchars($farmId); ?>">
            <div class="form-group">
                <button type="submit" name="role" value="manager">Manager Login</button>
            </div>
            <div class="form-group">
                <button type="submit" name="role" value="worker">Worker Login</button>
            </div>
            
        </form>
    </div>
</body>
</html>
