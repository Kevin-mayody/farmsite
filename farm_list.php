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

// Pagination variables
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$recordsPerPage = 8;
$offset = ($page - 1) * $recordsPerPage;

// Search term
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// SQL query to fetch farms ordered alphabetically by farm_name with pagination and search
$sql = "SELECT farm_id, farm_name, farm_location FROM farms WHERE farm_name LIKE '%$searchTerm%' ORDER BY farm_name ASC LIMIT $offset, $recordsPerPage";
$result = $conn->query($sql);

// Initialize total pages variable
$totalPages = 1;

// Fetch total number of records for pagination
$countSql = "SELECT COUNT(*) AS total FROM farms WHERE farm_name LIKE '%$searchTerm%'";
$countResult = $conn->query($countSql);

if ($countResult && $countResult->num_rows > 0) {
    $row = $countResult->fetch_assoc();
    $totalPages = ceil($row['total'] / $recordsPerPage);
} else {
    echo "Error fetching total pages."; // Handle error fetching total pages
    // Log or handle the error appropriately
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm List</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        * {
            font-size: 13px;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            line-height: 1.5;
        }
        body {
            background-color: whitesmoke;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            opacity: 100%;
            background: linear-gradient(to right, whitesmoke, whitesmoke);
        
        }
        .container {
            opacity: 100%;
            max-width: 800px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color:red;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background-color: #3b6d54; /* Dark green background for header */
            color: #fff;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }
        th {
            font-weight: 300;
        }
        tbody tr:nth-child(even) {
            background-color: whitesmoke;
            font-weight: 100;
        }
        tbody tr:nth-child(odd) {
            background-color: #b8c7bb; /* Light green background for odd rows */
            font-weight: 100;
        }
        tbody tr:hover {
            background-color: #ddd;
        }
        
        a {
            text-decoration: none;
            color: black;
            padding: 8px 12px;
            border: 1px solid #ddd;
            margin: 2px;
            border-radius: 4px;
            display: inline-block;
            background-color: white;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);

        }
        a:hover {
            
            color: green;
            

        }
        a.active {
            background-color: #3b6d54;
            color: #fff;
            border: 1px solid #3b6d54;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            color: blue;
            border: 1px solid grey;
            margin: 0 4px;
            transition: background-color 0.3s;
        }
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }
        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
        .pagination a.disabled {
            pointer-events: none;
            color: #ccc;
            border-color: #ccc;
        }
        .pagination .prev-next {
            font-weight: bold;
            margin: 0 8px;
        }
        .search-form {
            margin-bottom: 40px;
            text-align: center;
        }
        .search-form input[type="text"] {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 80%;
            opacity: 70%;

        }
        .search-form input[type="submit"] {
            padding: 8px 16px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            background-color: #3b6d54;
            color: white;
            cursor: pointer;
            box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <center>
        <img src="mkulima-high-resolution-logo-black-transparent.png" alt="Mkulima Logo" width="130" height="auto" style="margin-top: 10px; margin-bottom: 10px;">
        </center>

        <h1>SELECT YOUR FARM</h1>

        <div class="search-form">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search for farms..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <input type="submit" value="Search">
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Serial No.</th>
                    <th>Farm Name</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serialNumber = ($page - 1) * $recordsPerPage + 1; // Calculate starting serial number for current page

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $farmName = isset($row["farm_name"]) ? ucwords(strtolower(htmlspecialchars($row["farm_name"]))) : "N/A";
                        $farmLocation = isset($row["farm_location"]) ? ucwords(strtolower(htmlspecialchars($row["farm_location"]))) : "N/A";
                        $farmId = isset($row["farm_id"]) ? htmlspecialchars($row["farm_id"]) : "N/A";
                        
                        echo "<tr>";
                        echo "<td>$serialNumber</td>"; // Output serial number
                        echo "<td>$farmName</td>";
                        echo "<td>$farmLocation</td>";
                        echo "<td><a href='login.php?farmId=$farmId'>Login</a></td>";
                        echo "</tr>";

                        $serialNumber++; // Increment serial number for next row
                    }
                } else {
                    echo "<tr><td colspan='4'>No farms found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // Pagination links
        if ($totalPages > 1) {
            echo "<div class='pagination'>";
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $page) {
                    echo "<a href='#' class='active'>$i</a>";
                } else {
                    echo "<a href='?page=$i&search=$searchTerm'>$i</a>";
                }
            }
            echo "</div>";
        }
        ?>

    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
