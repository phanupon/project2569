<?php
include 'db.php';
?>

<?php 
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hash the password using MD5
    $hashed_password = md5($password);
    
    // Prepare and execute the SQL query to check for user credentials
    $sql = "SELECT * FROM member WHERE username='$username' AND password='$hashed_password'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // User found, login successful
        echo "Login successful!";
        // You can redirect the user to a dashboard or home page here
    } else {
        // User not found, login failed
        echo "Invalid username or password.";
    }
} else {
    echo "Please enter both username and password.";
}


?>