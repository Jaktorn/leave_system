<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "leave_management";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// จัดการค้นหา
$whereClause = "";
if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $searchName = $_GET['search_name'];
    $whereClause = "WHERE full_name LIKE '%$searchName%'";
} elseif (isset($_GET['search_date']) && !empty($_GET['search_date'])) {
    $searchDate = $_GET['search_date'];
    $whereClause = "WHERE start_date = '$searchDate'";
}

// จัดการการเรียงลำดับ
$order = "DESC";  // ค่าเริ่มต้นเรียงลำดับจากมากไปน้อย
if (isset($_GET['order']) && $_GET['order'] == 'asc') {
    $order = "ASC";
}

$sql = "SELECT * FROM leave_requests $whereClause ORDER BY created_at $order";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Leave Requests</title>
</head>
<body>
    <h2>รายการขอลาหยุด</h2>

    <!-- ฟอร์มค้นหา -->
    <form method="get" action="">
        ค้นหาตามชื่อ: <input type="text" name="search_name">
        ค้นหาตามวันที่ขอลา: <input type="date" name="search_date">
        <input type="submit" value="ค้นหา">
    </form>
    <br>

    <!-- ลิงก์เรียงลำดับ -->
    <a href="?order=asc">เรียงจากน้อยไปมาก</a> | <a href="?order=desc">เรียงจากมากไปน้อย</a>
    <br><br>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ชื่อ - นามสกุล</th>
                    <th>ประเภทการลา</th>
                    <th>วันที่ขอลา</th>
                    <th>ถึงวันที่</th>
                    <th>สถานะ</th>
                    <th>การจัดการ</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["full_name"] . "</td>
                    <td>" . $row["leave_type"] . "</td>
                    <td>" . $row["start_date"] . "</td>
                    <td>" . $row["end_date"] . "</td>
                    <td>" . $row["status"] . "</td>
                    <td>
                        <a href='delete_leave.php?id=" . $row["id"] . "' onclick=\"return confirm('คุณแน่ใจที่จะลบหรือไม่?');\">ลบ</a>
                        ";
            // เฉพาะสถานะ "รอพิจารณา" เท่านั้นที่สามารถปรับสถานะได้
            if ($row['status'] == 'รอพิจารณา') {
                echo " | <a href='update_status.php?id=" . $row["id"] . "&approve=true' onclick=\"return confirm('คุณต้องการอนุมัติหรือไม่?');\">อนุมัติ</a>
                       | <a href='update_status.php?id=" . $row["id"] . "&approve=false' onclick=\"return confirm('คุณต้องการไม่อนุมัติหรือไม่?');\">ไม่อนุมัติ</a>";
            }
            echo "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "ไม่พบข้อมูล";
    }

    $conn->close();
    ?>
</body>
</html>
