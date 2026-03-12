<?php  session_start();  ?>
<?php include 'db.php';  ?>

<h1>Admin Dashboard</h1>
<?php
if (($_SESSION['status'] ?? '') !== 'ADMIN') {
    echo "Access denied. You do not have permission to access this page.";
    exit();
}
if (($_SESSION['status'] ?? '') == 'ADMIN') {
    echo "<p>Welcome, " . $_SESSION['username'] . "!</p>";
}
if (($_SESSION['status'] ?? '') == '') {
    echo "Please log in.";
    header("Location: login.php");
    exit();
}
?>