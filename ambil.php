<?php
// Database connection variables
$servername = "10.32.100.21";
$username = "ne2rks";
$password = "HackIdea#5";
$dbname = "data_cacti_ont";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select data
$sql = "SELECT * FROM jakarta_utara ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Start table
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>STATUS</th>
            <!-- Add other column headers as needed -->
          </tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['description']}</td>
                <td>{$row['status']}</td>
                <!-- Add other columns as needed -->
              </tr>";
    }

    // End table
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
