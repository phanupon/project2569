<?php
$servername = "db";// ชื่อโฮสต์ของฐานข้อมูล (ในกรณีนี้คือชื่อของบริการใน Docker Compose)
$username = "root";
$password = "rootpassword";
$dbname = "my_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>