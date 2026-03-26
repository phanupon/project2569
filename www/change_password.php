<?php 
session_start();
include 'db.php'; // เชื่อมต่อฐานข้อมูล MySQLi

// 1. ตรวจสอบสิทธิ์ (ต้อง Login แล้ว)
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$session_user = $_SESSION['username'];
$msg = "";
$msg_class = "";

// 2. ประมวลผลเมื่อมีการกดปุ่มเปลี่ยนรหัสผ่าน
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_change'])) {
    $old_pass = md5($_POST['old_password']); // เข้ารหัส MD5 เพื่อเทียบกับ DB
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    // ตรวจสอบรหัสผ่านใหม่กับยืนยันรหัสผ่านว่าตรงกันไหม
    if ($new_pass !== $confirm_pass) {
        $msg = "รหัสผ่านใหม่และยืนยันรหัสผ่านไม่ตรงกัน";
        $msg_class = "alert-danger";
    } else {
        // ตรวจสอบว่ารหัสผ่านเดิมถูกต้องหรือไม่
        $sql_check = "SELECT password FROM member WHERE username = ? AND password = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ss", $session_user, $old_pass);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result();

        if ($res_check->num_rows === 1) {
            // ถ้ารหัสเดิมถูก ให้ทำการ Update รหัสใหม่ (เข้ารหัส MD5)
            $new_pass_md5 = md5($new_pass);
            $sql_update = "UPDATE member SET password = ? WHERE username = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ss", $new_pass_md5, $session_user);
            
            if ($stmt_update->execute()) {
                $msg = "เปลี่ยนรหัสผ่านสำเร็จแล้ว!";
                $msg_class = "alert-success";
            } else {
                $msg = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
                $msg_class = "alert-danger";
            }
            $stmt_update->close();
        } else {
            $msg = "รหัสผ่านเดิมไม่ถูกต้อง";
            $msg_class = "alert-danger";
        }
        $stmt_check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เปลี่ยนรหัสผ่าน - Member System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; }
        .card { border-radius: 15px; border: none; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-dark text-white py-3 text-center">
                    <h5 class="mb-0"><i class="bi bi-key-fill"></i> เปลี่ยนรหัสผ่าน</h5>
                </div>
                <div class="card-body p-4">
                    
                    <?php if ($msg): ?>
                        <div class="alert <?= $msg_class; ?> alert-dismissible fade show" role="alert">
                            <?= $msg; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="change_password.php" method="post">
                        <div class="mb-3">
                            <label for="old_password" class="form-label fw-bold">รหัสผ่านปัจจุบัน</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" required>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold">รหัสผ่านใหม่</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" minlength="4" required>
                        </div>

                        <div class="mb-4">
                            <label for="confirm_password" class="form-label fw-bold">ยืนยันรหัสผ่านใหม่</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="btn_change" class="btn btn-dark">
                                ยืนยันการเปลี่ยนรหัสผ่าน
                            </button>
                            <a href="user_dashboard.php" class="btn btn-outline-secondary">ยกเลิก</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>