<?php
session_start();
require_once "db.php";

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $position = $_POST['position'];
    $img = $_FILES['img'];

    // กำหนดไฟล์ที่อนุญาต
    $allow = array('jpg', 'jpeg', 'png');
    $extension = explode('.', $img['name']);
    $fileActExt = strtolower(end($extension)); // แก้ชื่อตัวแปรจาก fireActExt
    $fileNew = rand() . "." . $fileActExt;
    $filePath = "uploads/" . $fileNew;

    // ตรวจสอบนามสกุลไฟล์
    if (in_array($fileActExt, $allow)) {
        // ตรวจสอบว่าไม่มี error และขนาดไฟล์มากกว่า 0 (เติม $ หน้า img)
        if ($img['size'] > 0 && $img['error'] == 0) {
            
            if (move_uploaded_file($img['tmp_name'], $filePath)) {
                
                // แก้ไข SQL: 1. เปลี่ยนชื่อตารางให้ตรงกับ dashboard (employee) 
                // 2. ใช้เครื่องหมาย ? สำหรับ bind_param
                $stmt = $conn->prepare("INSERT INTO employee (firstname, lastname, position, img) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $firstname, $lastname, $position, $fileNew);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "Data inserted successfully";
                    header("location: admin_dashboard.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Database error: " . $stmt->error;
                    header("location: admin_dashboard.php");
                    exit();
                }
                $stmt->close();
            } else {
                $_SESSION['error'] = "Failed to upload image";
                header("location: admin_dashboard.php");
                exit();
            }
        }
    } else {
        $_SESSION['error'] = "Invalid file type";
        header("location: admin_dashboard.php");
        exit();
    }
}
?>