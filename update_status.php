<?php
// เชื่อมต่อกับฐานข้อมูล
include 'connect.php';

// รับข้อมูลจาก AJAX
if (isset($_POST['article_id']) && isset($_POST['status'])) {
    $article_id = $_POST['article_id'];
    $status = $_POST['status'];

    // ปรับปรุงสถานะในฐานข้อมูล
    $sql = "UPDATE articles SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $article_id);

    if ($stmt->execute()) {
        echo "สถานะบทความถูกอัปเดตเรียบร้อย";
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตสถานะ";
    }

    $stmt->close();
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
