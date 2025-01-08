<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
    <div class="login-container">
        <h1>เข้าสู่ระบบ</h1>
        <form action="process_login.php" method="POST">
            <div class="form-group">
                <label for="username">ผู้ใช้งาน</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">เข้าสู่ระบบ</button>
        </form>
    </div>
</body>
</html>
