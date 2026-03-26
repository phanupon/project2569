<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Member System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #f0f2f5;
        }
        .register-card {
            max-width: 500px;
            border: none;
            border-radius: 1rem;
        }
        .btn-register {
            background-image: linear-gradient(to right, #4e73df, #224abe);
            border: none;
            padding: 12px;
        }
        .btn-register:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="card register-card shadow-lg mx-auto">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-dark">ลงทะเบียนสมาชิก</h2>
                        <p class="text-muted">กรุณากรอกข้อมูลให้ครบถ้วนเพื่อเริ่มใช้งาน</p>
                    </div>

                    <form action="register_process.php" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control bg-light" id="name" name="name" placeholder="ระบุชื่อจริงของคุณ" required>
                        </div>

                        <div class="mb-3">
                            <label for="loginname" class="form-label fw-semibold">ชื่อผู้ใช้งาน (Username)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">@</span>
                                <input type="text" class="form-control bg-light" id="loginname" name="loginname" placeholder="ภาษาอังกฤษหรือตัวเลข" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">อีเมล (Email)</label>
                            <input type="email" class="form-control bg-light" id="email" name="email" placeholder="example@mail.com" required>
                        </div>

                        <div class="mb-4">
                            <label for="passwd" class="form-label fw-semibold">รหัสผ่าน (Password)</label>
                            <input type="password" class="form-control bg-light" id="passwd" name="passwd" placeholder="กำหนดรหัสผ่านของคุณ" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-register fw-bold shadow-sm">
                                ยืนยันการลงทะเบียน
                            </button>
                        </div>

                        <div class="text-center">
                            <span class="small text-muted">เป็นสมาชิกอยู่แล้ว?</span> 
                            <a href="login.php" class="small text-decoration-none fw-bold">เข้าสู่ระบบ</a>
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