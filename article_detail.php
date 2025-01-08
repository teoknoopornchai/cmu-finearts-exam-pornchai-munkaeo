<?php
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
include 'connect.php';

// รับค่า ID จาก URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ตรวจสอบว่ามีบทความนี้ในฐานข้อมูลหรือไม่
$sql = "SELECT * FROM articles WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $article = $result->fetch_assoc();
} else {
    echo "Article not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .article {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .article img {
            max-width: 100%;
            margin-bottom: 20px;
        }
        .article h1 {
            margin-top: 0;
        }
        .article p {
            line-height: 1.6;
        }
        /* ตำแหน่งของ status ที่มุมขวาบน */
        .status {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="article">
        <!-- Status อยู่มุมขวาบน -->
        <div class="status"> สถานะ : <?php echo htmlspecialchars($article['status']); ?></div><br><br>

        <h1><?php echo htmlspecialchars($article['title']); ?></h1>
        <p><strong>Created At:</strong> <?php echo htmlspecialchars($article['created_at']); ?></p>

        <?php if ($article['image_url']): ?>
            <img src="<?php echo htmlspecialchars($article['image_url']); ?>" alt="Article Image">
        <?php endif; ?>

        <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>

        <a href="article.php">Back to Articles List</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
