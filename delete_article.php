<?php
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
include 'connect.php';

// ตรวจสอบว่าได้รับค่า 'id' จาก URL หรือไม่
if (isset($_GET['id'])) {
    // รับค่า 'id' ที่ส่งมาจาก URL
    $articleId = $_GET['id'];

    // ตรวจสอบว่า 'id' เป็นตัวเลขหรือไม่
    if (is_numeric($articleId)) {
        // สร้างคำสั่ง SQL เพื่อลบบทความจากฐานข้อมูล
        $sql = "DELETE FROM articles WHERE id = ?";

        // เตรียมคำสั่ง SQL
        if ($stmt = $conn->prepare($sql)) {
            // ผูกตัวแปรกับคำสั่ง SQL
            $stmt->bind_param("i", $articleId);

            // ดำเนินการคำสั่ง SQL
            if ($stmt->execute()) {
                // ถ้าลบสำเร็จ, รีไดเรกไปยังหน้าแสดงรายการบทความ
                echo "<script>alert('ลบบทความสำเร็จ'); window.location.href = 'article.php';</script>";
            } else {
                // ถ้าไม่สามารถลบได้, แสดงข้อความข้อผิดพลาด
                echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล'); window.location.href = 'article.php';</script>";
            }
        }
    } else {
        // ถ้า 'id' ไม่ใช่ตัวเลข, แสดงข้อความข้อผิดพลาด
        echo "<script>alert('ID ไม่ถูกต้อง'); window.location.href = 'article.php';</script>";
    }
} else {
    // ถ้าไม่มี 'id' ใน URL, รีไดเรกไปยังหน้ารายการบทความ
    echo "<script>alert('ไม่พบข้อมูลบทความ'); window.location.href = 'article.php';</script>";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
