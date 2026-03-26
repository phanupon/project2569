<?php 
session_start();
include 'db.php'; // เชื่อมต่อฐานข้อมูลโดยใช้ตัวแปร $conn จากไฟล์เดิม

// 1. ตรวจสอบสิทธิ์การเข้าถึง (ต้องมีการ Login และเก็บ Session username ไว้)
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$session_user = $_SESSION['username'];
$msg = "";
$msg_class = "";

// 2. ส่วนการอัปเดตข้อมูลเมื่อมีการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_update'])) {
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];

    // ปรับชื่อตารางเป็น member ตามที่คุณระบุ
    $sql_update = "UPDATE member SET name = ?, email = ? WHERE username = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sss", $new_name, $new_email, $session_user);
    
    if ($stmt_update->execute()) {
        $msg = "อัปเดตข้อมูลโปรไฟล์สำเร็จ!";
        $msg_class = "alert-success";
    } else {
        $msg = "เกิดข้อผิดพลาด: " . $conn->error;
        $msg_class = "alert-danger";
    }
    $stmt_update->close();
}

// 3. ดึงข้อมูลปัจจุบันจากตาราง member มาแสดงใน Form
$sql_select = "SELECT name, email FROM member WHERE username = ?";
$stmt_get = $conn->prepare($sql_select);
$stmt_get->bind_param("s", $session_user);
$stmt_get->execute();
$result = $stmt_get->get_result();
$row = $result->fetch_assoc();
$stmt_get->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขโปรไฟล์ - Member System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border: none; border-radius: 12px; }
        .form-control:focus { box-shadow: none; border-color: #0d6efd; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-person-gear"></i> แก้ไขข้อมูลส่วนตัว</h5>
                </div>
                <div class="card-body p-4">
                    
                    <?php if ($msg): ?>
                        <div class="alert <?= $msg_class; ?> alert-dismissible fade show" role="alert">
                            <?= $msg; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="edit_profile.php" method="post">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">ชื่อผู้ใช้งาน (Username)</label>
                            <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($session_user); ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?= htmlspecialchars($row['name'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">อีเมล</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($row['email'] ?? ''); ?>" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="btn_update" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> บันทึกการเปลี่ยนแปลง
                            </button>
                            <a href="user_dashboard.php" class="btn btn-outline-secondary">
                                <i class="bi bi-house-door"></i> กลับหน้าหลัก
                            </a>
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