<?php 
session_start();
include 'db.php'; // เชื่อมต่อฐานข้อมูลแบบ MySQLi

// ตรวจสอบสิทธิ์ USER
if (!isset($_SESSION['username']) || ($_SESSION['status'] ?? '') !== 'USER') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <title>User Dashboard</title>
    <style>
        body { background-color: #f8f9fa; }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="user_dashboard.php">
        <i class="bi bi-speedometer2"></i> UserPanel
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="user_dashboard.php">หน้าแรก</a>
        </li>
      </ul>
      
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i> สวัสดี, <?= htmlspecialchars($_SESSION['username']); ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
            <li><a class="dropdown-item" href="edit_profile.php"><i class="bi bi-pencil-square"></i> แก้ไขโปรไฟล์</a></li>
            <li><a class="dropdown-item" href="change_password.php"><i class="bi bi-key"></i> เปลี่ยนรหัสผ่าน</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout_process.php"><i class="bi bi-box-arrow-right"></i> ออกจากระบบ</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-4">รายชื่อพนักงาน</h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>ตำแหน่ง</th>
                                    <th>รูปภาพ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sql = "SELECT * FROM employee";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($mem = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $mem['id']; ?></td>
                                    <td><?= $mem['firstname'] . " " . $mem['lastname']; ?></td>
                                    <td><span class="badge bg-secondary"><?= $mem['position']; ?></span></td>
                                    <td>
                                        <img src="uploads/<?= $mem['img']; ?>" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                    </td>
                                </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>ไม่พบข้อมูล</td></tr>";
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>