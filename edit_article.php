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

// ตรวจสอบว่า id ของบทความถูกส่งมาหรือไม่
if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

    // ดึงข้อมูลบทความจากฐานข้อมูล
    $sql = "SELECT * FROM articles WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        // ผูกพารามิเตอร์
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // ดึงข้อมูลบทความ
            $article = $result->fetch_assoc();
        } else {
            // ถ้าไม่พบข้อมูลบทความ
            echo "<script>
                    alert('ไม่พบบทความ');
                    window.location.href = 'articles_list.php';
                  </script>";
        }
        $stmt->close();
    }
}

// ถ้าผู้ใช้ส่งข้อมูลแก้ไข
if (isset($_POST['update'])) {
    // รับข้อมูลจากฟอร์ม
    $title = $_POST['title'];
    $content = $_POST['content'];
    $status = $_POST['status'];

    // ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพหรือไม่
    $imageUrl = $article['image_url']; // ใช้รูปเดิมถ้าไม่มีการอัปโหลดใหม่


    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
      // ตรวจสอบประเภทไฟล์ที่อัปโหลด
      $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // กำหนดประเภทไฟล์ที่อนุญาต
      $fileType = $_FILES['image']['type'];

      if (in_array($fileType, $allowedTypes)) {
          // อัปโหลดไฟล์รูปภาพใหม่
          $imageUrl = 'uploads/' . basename($_FILES['image']['name']);
          move_uploaded_file($_FILES['image']['tmp_name'], $imageUrl);
      } else {
          echo "<script>
                  alert('ประเภทไฟล์ไม่ถูกต้อง! กรุณาอัปโหลดไฟล์รูปภาพ');
                  window.location.href = 'edit_article.php?id=$articleId';
                </script>";
          exit();
      }
  }
    // อัปเดตข้อมูลบทความในฐานข้อมูล
    $updateSql = "UPDATE articles SET title = ?, content = ?, image_url = ?, status = ? WHERE id = ?";
    if ($updateStmt = $conn->prepare($updateSql)) {
        $updateStmt->bind_param("ssssi", $title, $content, $imageUrl, $status, $articleId);
        if ($updateStmt->execute()) {
            // ถ้าอัปเดตสำเร็จ
            echo "<script>
                    alert('อัปเดตข้อมูลบทความสำเร็จ');
                    window.location.href = 'article.php';
                  </script>";
        } else {
            // ถ้าอัปเดตไม่สำเร็จ
            echo "<script>
                    alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล');
                  </script>";
        }
        $updateStmt->close();
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขบทความ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>แก้ไขบทความ</h2>
    <form action="edit_article.php?id=<?php echo $articleId; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">หัวข้อ:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">เนื้อหา:</label>

            <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($article['content']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">สถานะ:</label>
            <select class="form-control" id="status" name="status">
                <option value="draft" <?php if ($article['status'] == 'draft') echo 'selected'; ?>>ซ่อน</option>
                <option value="published" <?php if ($article['status'] == 'published') echo 'selected'; ?>>เผยแพร่</option>
            </select>
        </div>
        <div class="form-group">
            <label for="image">รูปภาพ (ถ้ามี):</label>
            <input type="file" class="form-control" id="image" name="image">
            <br>
            <?php if ($article['image_url']): ?>
                <img src="<?php echo htmlspecialchars($article['image_url']); ?>" alt="Current Image" width="100">
            <?php endif; ?>
        </div>
        <button type="submit" name="update" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
