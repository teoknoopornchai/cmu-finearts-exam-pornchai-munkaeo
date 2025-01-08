<?php
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
include 'connect.php';
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // ถ้ายังไม่ล็อกอิน, รีไดเรกไปที่หน้า login
    header("Location: index.php");
    exit();
}
// ดึงข้อมูลบทความจากฐานข้อมูล
$sql = "SELECT id, title, content, image_url, created_at, status FROM articles";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Article</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="article-container">
        <h1>เพิ่มบทความ</h1>
        <form action="insert_article.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">หัวข้อ*</label>
                <input type="text" id="title" name="title" placeholder="Enter article title" required>
            </div>
            <div class="form-group">
                <label for="content">เนื้อหา *</label>
                <textarea id="content" name="content" rows="6" placeholder="Write your article content here..." required></textarea>
            </div>
            <div class="form-group">
                <label for="image">รูปภาพ</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn">บันทึก</button>
        </form>
    </div>
</body>
</html>
