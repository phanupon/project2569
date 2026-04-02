<?php
session_start();
require_once "db.php";

// 1. ตรวจสอบว่ามีการส่ง id มาหรือไม่
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$id = $_GET['id'];

// 2. ดึงข้อมูลเดิมจากฐานข้อมูลมาแสดงใน Form
$stmt = $conn->prepare("SELECT * FROM employee WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("ไม่พบข้อมูลพนักงาน");
}

// 3. ส่วนประมวลผลการแก้ไขเมื่อกดปุ่ม Submit
if (isset($_POST['update'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $position = $_POST['position'];
    $old_img = $_POST['old_img']; // รูปเดิม
    $img = $_FILES['img'];

    // ตรวจสอบว่ามีการเลือกรูปใหม่หรือไม่
    if ($img['name'] != "") {
        // มีการเปลี่ยนรูปใหม่
        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;
        $filePath = "uploads/" . $fileNew;

        if (in_array($fileActExt, $allow)) {
            if (move_uploaded_file($img['tmp_name'], $filePath)) {
                // ลบรูปเก่าทิ้ง (Optional)
                if (file_exists("uploads/" . $old_img)) {
                    unlink("uploads/" . $old_img);
                }
                $img_name = $fileNew;
            }
        }
    } else {
        // ไม่มีการเปลี่ยนรูป ให้ใช้ชื่อรูปเดิม
        $img_name = $old_img;
    }

    // 4. บันทึกข้อมูลกลับลงฐานข้อมูล
    $update_stmt = $conn->prepare("UPDATE employee SET firstname=?, lastname=?, position=?, img=? WHERE id=?");
    $update_stmt->bind_param("ssssi", $firstname, $lastname, $position, $img_name, $id);

    if ($update_stmt->execute()) {
        $_SESSION['success'] = "แก้ไขข้อมูลเรียบร้อยแล้ว";
        header("location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการแก้ไข";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Employee</title>
</head>
<body class="container mt-5">
    <div class="card shadow-sm p-4 mx-auto" style="max-width: 600px;">
        <h3>แก้ไขข้อมูลพนักงาน</h3>
        <hr>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="old_img" value="<?= $row['img']; ?>">

            <div class="mb-3">
                <label class="form-label">ชื่อ (Firstname)</label>
                <input type="text" name="firstname" class="form-control" value="<?= $row['firstname']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">นามสกุล (Lastname)</label>
                <input type="text" name="lastname" class="form-control" value="<?= $row['lastname']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">ตำแหน่ง (Position)</label>
                <input type="text" name="position" class="form-control" value="<?= $row['position']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">รูปภาพปัจจุบัน</label><br>
                <img src="uploads/<?= $row['img']; ?>" width="150" class="img-thumbnail mb-2">
                <input type="file" name="img" class="form-control">
                <small class="text-muted">* เว้นว่างไว้หากไม่ต้องการเปลี่ยนรูปภาพ</small>
            </div>
            <div class="mt-4">
                <button type="submit" name="update" class="btn btn-success">บันทึกการแก้ไข</button>
                <a href="admin_dashboard.php" class="btn btn-secondary">ยกเลิก</a>
            </div>
        </form>
    </div>
</body>
</html>