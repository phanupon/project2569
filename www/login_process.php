<?php
session_start();
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
      // --- จุดที่แก้ไข: ดึงข้อมูลออกมาเป็น Array ---
        $row = $result->fetch_assoc();
        // ใช้ตัวแปร $row ในการเก็บค่าเข้า Session
        $_SESSION['username'] = $row['username']; 
        $_SESSION['status'] = $row['status']; 
        $_SESSION['name'] = $row['name']; 

        if($_SESSION['status'] == 'ADMIN') {
            header("Location: admin_dashboard.php");
            exit(); // ใส่ exit ทุกครั้งหลัง header redirect เพื่อหยุดการทำงานของสคริปต์
        } else {
            header("Location: user_dashboard.php"); // Redirect to user dashboard
            exit(); // ใส่ exit ทุกครั้งหลัง header redirect เพื่อหยุดการทำงานของสคริปต์
        }
        //header("Location: dashboard.php"); // Redirect to a dashboard page after successful login
        // You can redirect the user to a dashboard or home page here
    } else {
        // User not found, login failed
        echo "Invalid username or password.";
    }
} else {
    echo "Please enter both username and password.";
}


?>