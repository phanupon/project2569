<?php
$name = $_GET['name'];
$loginname = $_GET['loginname'];
$email = $_GET['email'];
$pwd = $_GET['passwd'];
$pass = md5($pwd);

include 'db.php'; // Include the database connection file

$status = "USER";
//INSERT INTO `member` (`id`, `name`, `username`, `email`, `password`, `status`) VALUES (NULL, 'user01', 'user01', 'user01@mail.com', MD5('user01'), 'USER');
$sql = "INSERT INTO member (name, username, email, password, status) VALUES ('$name', '$loginname', '$email', '$pass', '$status')";
if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
// Process the registration logic here
// For example, you could insert the data into a database

echo "Registration successful!";
?>