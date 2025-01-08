<?php
// กำหนดค่าการเชื่อมต่อฐานข้อมูล
$host = "localhost"; // ชื่อโฮสต์
$username = "root";  // ชื่อผู้ใช้ฐานข้อมูล (แก้ไขตามจริง)
$password = "";      // รหัสผ่านฐานข้อมูล (แก้ไขตามจริง)
$database = "fineart"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตั้งค่าภาษาไทย (ถ้าใช้ภาษาไทย)
$conn->set_charset("utf8");
?>
