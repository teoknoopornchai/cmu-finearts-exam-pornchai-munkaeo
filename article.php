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
    <title>Articles List</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

     <!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table thead th {
            background-color: #007bff;
            color: white;
        }
        .btn-add {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            text-transform: uppercase;
        }
        .btn-add:hover {
            background-color: #0056b3;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: right;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        td .btn {
    display: inline-block;
    padding: 5px 10px;
    font-size: 12px;  /* ปรับขนาดข้อความ */
    text-decoration: none;
    border-radius: 4px;
    margin-right: 5px;  /* ระยะห่างระหว่างปุ่ม */
    text-align: center;
}

.btn-view {
    background-color: #007bff;
    color: white;
}

.btn-edit {
    background-color: #ffc107;
    color: white;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
}

.btn:hover {
    opacity: 0.8;
}.btn-delete {
    background-color: #dc3545;
    color: white;
    padding: 5px 10px;
    font-size: 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-delete:hover {
    background-color: #c82333;
}

.toggle-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .toggle-switch {
            position: relative;
            width: 60px;
            height: 30px;
        }

        .toggle-switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 50px;
        }

        .slider:before {
            content: "";
            position: absolute;
            height: 22px;
            width: 22px;
            border-radius: 50px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
        }

        input:checked + .slider {
            background-color: #4CAF50; /* สีเขียวเมื่อเปิด */
        }

        input:checked + .slider:before {
            transform: translateX(30px); /* ย้ายไปขวาเมื่อเปิด */
        }

    </style>
</head>
<body>
<div class="header">
        <h1>บทความ</h1>
        <a href="add_article.php" class="btn-add">+ เพิ่มบทความใหม่</a><a href="logout.php" class="btn-add">ออกจากระบบ</a>
    </div>


    <table id="articlesTable" class="display">
        <thead>
            <tr>
                <th></th>
                <th>หัวข้อ</th>
                <th></th>

            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr><td><center>
                    <?php if ($row['image_url']): ?>
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Image" width="50">
                    <?php else: ?>
                        No Image
                    <?php endif; ?></center>
                </td>
                <td>
                <a href="article_detail.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                       <?php echo htmlspecialchars($row['title']); ?>
                    </a>
                    <br>
                <img src="uploads/dates.png" width="16"> &nbsp;<?php echo htmlspecialchars($row['created_at']); ?>

              </td>

              <td>


              <a href="article_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-view">ดูรายละเอียด</a>
              <a href="edit_article.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">แก้ไข</a>
              <button class="btn btn-delete" onclick="confirmDelete(<?php echo $row['id']; ?>, '<?php echo addslashes($row['title']); ?>')">ลบ</button>
              &nbsp;&nbsp;&nbsp;&nbsp;
              สถานะ: <span id="statusLabel">ซ่อน</span>
              <div class="toggle-wrapper">
                <label class="toggle-switch">
                    <!-- สวิทเปิด/ปิด เปลี่ยนสถานะ -->
                    <input type="checkbox" id="toggle" onchange="toggleFunction(1)"> <!-- id=1 เป็นตัวอย่างบทความ -->
                    <span class="slider"></span>
                </label>
            </div>

</td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <!-- ลบ script ที่ซ้ำซ้อนออก และเหลือแค่ชุดเดียว -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function () {
            $('#articlesTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20],
                order: [[0, 'desc']]
            });


        });
    </script>
    <script>
    function confirmDelete(articleId, title) {
    Swal.fire({
        imageUrl: 'uploads/delete.png',  // ลิงค์ไปยังภาพถังขยะสีแดง (เปลี่ยนเป็นลิงค์ของคุณเอง)
        imageWidth: 50,
        imageHeight: 50,
        title: 'ลบข้อมูล',  // หัวข้อของกล่องแจ้งเตือน
        titleColor: '#dc3545',  // ตั้งสีหัวข้อเป็นสีแดง
        text: 'ยืนยันการลบ: ' + title,  // ข้อความที่จะเตือนก่อนการลบ
        textColor: '#dc3545',  // ตั้งสีข้อความเป็นสีแดง
        showCancelButton: true,  // ให้มีปุ่มยกเลิก
        confirmButtonColor: '#dc3545',  // ปุ่มยืนยัน (สีแดง)
        cancelButtonColor: '#6c757d',  // ปุ่มยกเลิก (สีเทา)
        confirmButtonText: 'ลบ',  // ข้อความบนปุ่มยืนยัน
        cancelButtonText: 'ยกเลิก',  // ข้อความบนปุ่มยกเลิก
    }).then((result) => {
        if (result.isConfirmed) {
            // เมื่อกด "ลบ", จะรีไดเรกไปยังหน้า delete_article.php พร้อมกับ id ของบทความที่ต้องการลบ
            window.location.href = "delete_article.php?id=" + articleId;
        }
    });
}


</script>

<script>
    function toggleFunction(articleId) {
        var toggle = document.getElementById('toggle');
        var statusLabel = document.getElementById('statusLabel');
        var status = toggle.checked ? 'publish' : 'draft';

        // เปลี่ยนข้อความสถานะ
        statusLabel.textContent = (status === 'publish') ? 'เผยแพร่' : 'ซ่อน';

        // ส่งข้อมูลผ่าน AJAX เพื่อปรับปรุงสถานะในฐานข้อมูล
        $.ajax({
            url: 'update_status.php',
            type: 'POST',
            data: {
                article_id: articleId,
                status: status
            },
            success: function(response) {
                console.log("Status updated:", response);
            },
            error: function(xhr, status, error) {
                console.error("Error updating status:", error);
            }
        });
    }
</script>

</body>
</html>

<?php
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
