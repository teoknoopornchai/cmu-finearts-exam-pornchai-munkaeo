<?php
// เริ่มต้น session
session_start();

// ชื่อผู้ใช้และรหัสผ่านที่กำหนดไว้
$valid_username = "admin";
$valid_password = "123456789";

// รับค่าจากฟอร์ม
$username = $_POST['username'];
$password = $_POST['password'];

// ตรวจสอบชื่อผู้ใช้และรหัสผ่าน
if ($username === $valid_username && $password === $valid_password) {
    // เก็บข้อมูลเข้าสู่ระบบใน session
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;

    // เปลี่ยนเส้นทางไปยังหน้า dashboard หรือหน้าหลัก
    header("Location: article.php");
    exit();
} else {
    // แสดงข้อความผิดพลาดและเปลี่ยนเส้นทางกลับไปยังหน้า login
    echo "<script>
            alert('Invalid username or password!');
            window.location.href = 'index.php';
          </script>";
    exit();
}
?>
