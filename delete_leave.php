<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "leave_management";

// สร้างการเชื่อมต่อกับฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งค่า 'id' มาใน URL หรือไม่
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM leave_requests WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "ลบข้อมูลสำเร็จ";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
header("Location: list_leave.php");  // กลับไปที่หน้ารายการหลังลบเสร็จ
?>
