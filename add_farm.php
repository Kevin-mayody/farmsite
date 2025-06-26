<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Farm Details</title>
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
            max-width: 600px;
            margin: 50px auto;
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
            color: green;
        }
        small {
            color: red;
            font-size: 11px;
            font-style: italic;
        }
        .error {
            color: red;
            font-size: 11px;
            font-style: italic;
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
        .info {
            font-size: 12px;
            color: #666;
        }
    </style>
    <script>
        // Function to generate a unique farm ID
        function generateFarmId() {
            return 'FARM_' + Math.random().toString(36).substr(2, 9);
        }

        // Set the generated farm ID to the input field
        function setFarmId() {
            document.getElementById('farmId').value = generateFarmId();
        }

        // Ensure the farm ID is set when the page loads
        window.onload = function() {
            setFarmId();
            loadFormData();
        };

        // Password validation function
        function validateForm() {
            const password = document.getElementById('password').value;
            const error = document.getElementById('error');
            const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

            if (!passwordPattern.test(password)) {
                error.textContent = 'Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number.';
                return false;
            }

            // Perform AJAX check for managerId uniqueness
            const managerId = document.getElementById('managerId').value;
            return checkManagerId(managerId);
        }

        // AJAX function to check managerId
        function checkManagerId(managerId) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'check_manager_id.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);
                            if (response.valid) {
                                resolve(true); // ManagerId is valid
                            } else {
                                document.getElementById('managerId').focus();
                                document.getElementById('managerId').setCustomValidity('Manager ID already exists.');
                                document.getElementById('managerId').reportValidity();
                                reject(false); // ManagerId is not valid
                            }
                        } else {
                            reject(false); // Error in AJAX request
                        }
                    }
                };
                xhr.send('managerId=' + encodeURIComponent(managerId));
            });
        }

        // Load form data from local storage
        function loadFormData() {
            if (localStorage.getItem('farm_name')) {
                document.getElementById('farm_name').value = localStorage.getItem('farm_name');
            }
            if (localStorage.getItem('location')) {
                document.getElementById('location').value = localStorage.getItem('location');
            }
            if (localStorage.getItem('managerId')) {
                document.getElementById('managerId').value = localStorage.getItem('managerId');
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <center>
            <img src="mkulima-high-resolution-logo-black-transparent.png" alt="Mkulima Logo" width="130" height="auto" style="margin-top: 10px;">
        </center>
        <h1>Add Farm Details</h1>
        <form action="process_add_farm.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="farm_name">Farm Name:</label>
                <input type="text" id="farm_name" name="farm_name" required>
            </div>
            <div class="form-group">
                <label for="farmId">Farm ID:</label>
                <input type="text" id="farmId" name="farmId" readonly>
                <small>The Farm ID is generated automatically and cannot be changed.</small>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="managerId">Manager ID:</label>
                <input type="text" id="managerId" name="managerId" required>
                <small>Please provide the ID of the manager responsible for this farm.</small>
            </div>
            <div class="form-group">
                <label for="password">Farm Password:</label>
                <input type="password" id="password" name="password" required>
                <p class="error" id="error"></p>
            </div>
            <button type="submit">Add Farm</button>
        </form>
    </div>
</body>
</html>
