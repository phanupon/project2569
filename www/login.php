
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin-top: 100px;
        }
        .card {
            border: none;
            border-radius: 15px;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-container w-100">
        <div class="card shadow-lg">
            <div class="card-body p-5">
                <h3 class="text-center mb-4 fw-bold text-primary">เข้าสู่ระบบ</h3>
                
                <form action="login_process.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">ชื่อผู้ใช้งาน (User name)</label>
                        <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="ใส่ชื่อผู้ใช้งาน" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">รหัสผ่าน (Password)</label>
                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="ใส่รหัสผ่าน" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                    </div>
                </form>

            </div>
        </div>
        <p class="text-center mt-3 text-muted">&copy; 2024 Admin Dashboard System</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>