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

$sql = "SELECT * FROM leave_requests ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ชื่อ - นามสกุล</th><th>ประเภทการลา</th><th>วันที่ขอลา</th><th>ถึงวันที่</th><th>สถานะ</th><th>การจัดการ</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["full_name"]. "</td><td>" . $row["leave_type"]. "</td><td>" . $row["start_date"]. "</td><td>" . $row["end_date"]. "</td><td>" . $row["status"]. "</td><td><button>เปลี่ยนสถานะ</button> <button>ลบ</button></td></tr>";
    }
    echo "</table>";
} else {
    echo "ไม่มีข้อมูลการลาหยุด";
}

$conn->close();
?>
