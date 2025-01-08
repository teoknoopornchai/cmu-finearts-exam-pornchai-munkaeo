<?php
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
include 'connect.php';

// ฟังก์ชั่นตรวจสอบประเภทไฟล์
function is_valid_image($file) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif']; // ประเภทไฟล์ที่อนุญาต
    $file_type = mime_content_type($file['tmp_name']);
    return in_array($file_type, $allowed_types);
}

// รับข้อมูลจากฟอร์มและป้องกัน XSS
$title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
$content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');

// ตรวจสอบและอัปโหลดรูปภาพ
$image = $_FILES['image']['name'];
$upload_dir = "uploads/"; // โฟลเดอร์เก็บรูปภาพ
$target_file = null;

if (!empty($image)) {
    // ตรวจสอบประเภทไฟล์
    if (!is_valid_image($_FILES['image'])) {
        echo "Invalid file type. Only JPEG, PNG, or GIF files are allowed.";
        exit();
    }

    // ตรวจสอบขนาดไฟล์
    if ($_FILES['image']['size'] > 5000000) { // จำกัดขนาดไฟล์ที่ 5MB
        echo "File is too large. Maximum size is 5MB.";
        exit();
    }

    // เปลี่ยนชื่อไฟล์เพื่อป้องกันการชนกับไฟล์ที่มีชื่อเดียวกัน
    $new_file_name = uniqid() . basename($image);
    $target_file = $upload_dir . $new_file_name;

    // อัปโหลดไฟล์
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        echo "Failed to upload image.<br>";
        exit();
    }
}

// สร้างคำสั่ง SQL สำหรับเพิ่มข้อมูล
$sql = "INSERT INTO articles (title, content, image_url, created_at, status)
        VALUES (?, ?, ?, NOW(), 'draft')";

// เตรียมคำสั่งและผูกตัวแปร
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $title, $content, $target_file);

// ดำเนินการคำสั่ง
if ($stmt->execute()) {
    echo "Article added successfully.";
    header("Location: article.php"); // เปลี่ยนเส้นทางไปยังหน้าแสดงบทความ
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// ปิดการเชื่อมต่อ
$stmt->close();
$conn->close();
?>
