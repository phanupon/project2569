<?php  
session_start();  
include 'db.php'; // นำเข้าการเชื่อมต่อฐานข้อมูล

// ตรวจสอบสิทธิ์ Admin
if (($_SESSION['status'] ?? '') !== 'ADMIN') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Dashboard</title>
</head>
<body class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Admin Dashboard</h1>
        <div>
            <span>Welcome, <strong><?= $_SESSION['username']; ?></strong></span>
            <a href="logout_process.php" class="btn btn-danger btn-sm ms-3">Logout</a>
        </div>
    </div>

    <div class="card shadow-sm p-4">
        <div class="d-flex justify-content-between mb-3">
            <h3>รายชื่อพนักงาน (MySQLi)</h3>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
              + เพิ่มพนักงาน
            </button>
        </div>

        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Position</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // เปลี่ยนเป็น SQL Query แบบ MySQLi
                $sql = "SELECT * FROM employee";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // วนลูปแสดงข้อมูลด้วย fetch_assoc()
                    while($mem = $result->fetch_assoc()) {
                ?>
                <tr>
                    <th scope="row"><?= $mem['id']; ?></th>
                    <td><?= $mem['firstname']; ?></td>
                    <td><?= $mem['lastname']; ?></td>
                    <td><?= $mem['position']; ?></td>
                    <td style="width: 150px;">
                        <img src="uploads/<?= $mem['img']; ?>" class="img-thumbnail" alt="member profile">
                    </td>
                    <td>
                        <a href="edit.php?id=<?= $mem['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a onclick="return confirm('Are you sure?');" href="?delete=<?= $mem['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No Member found</td></tr>";
                } 
                ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="insert_process.php" method="POST" enctype="multipart/form-data">
              <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">เพิ่มพนักงานใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">ชื่อ (Firstname)</label>
                    <input type="text" name="firstname" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">นามสกุล (Lastname)</label>
                    <input type="text" name="lastname" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">ตำแหน่ง (Position)</label>
                    <input type="text" name="position" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">รูปภาพ</label>
                    <input type="file" name="img" class="form-control">
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="submit" name="submit" class="btn btn-primary">บันทึกข้อมูล</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>