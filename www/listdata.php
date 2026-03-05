Get your own PHP Server
<?php
include 'db.php'; // Include the database connection file
$sql = "SELECT * FROM member";
// Execute the SQL query
$result = $conn->query($sql);

// Process the result set
if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["username"]. "<br>";
  }
} else {
  echo "0 results";
}

$conn->close();
?>