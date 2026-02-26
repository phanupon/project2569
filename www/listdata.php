Get your own PHP Server
<?php
$servername = "db";
$username = "user";
$password = "password";
$dbname = "my_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM employee";
// Execute the SQL query
$result = $conn->query($sql);

// Process the result set
if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["staff_id"]. " - Name: " . $row["staff_name"]. " " . $row["staff_surname"]. "<br>";
  }
} else {
  echo "0 results";
}

$conn->close();
?>