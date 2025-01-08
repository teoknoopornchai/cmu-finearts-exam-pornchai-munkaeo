<?php
// เริ่มต้น session
session_start();

// ทำการลบข้อมูลทั้งหมดใน session
session_unset();

// ทำลาย session
session_destroy();

// รีไดเรกผู้ใช้ไปยังหน้า login
header("Location: index.php");
exit();
?>
