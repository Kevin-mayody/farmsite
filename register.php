<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register at Farm</h1>
    <form action="process_register.php" method="POST">
        <!-- Remove farmId input field -->
        
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="manager">Manager</option>
            <option value="worker">Worker</option>
        </select><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <!-- Farm ID is auto-generated on the server side -->
        <input type="hidden" name="farmId" value="<?php echo generateFarmId(); ?>">

        <button type="submit">Register</button>
    </form>
</body>
</html>

<?php
// Function to generate a unique farm ID
function generateFarmId() {
    // Generate a random farm ID (you can adjust the length as needed)
    return 'FARM_' . uniqid();
}
?>
