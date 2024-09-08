<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "leave_management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_GET['approve'])) {
    $id = $_GET['id'];
    $new_status = ($_GET['approve'] == 'true') ? 'อนุมัติ' : 'ไม่อนุมัติ';

    // อัปเดตเฉพาะเมื่อสถานะเป็น "รอพิจารณา"
    $sql = "UPDATE leave_requests SET status = '$new_status' WHERE id = $id AND status = 'รอพิจารณา'";

    if ($conn->query($sql) === TRUE) {
        echo "ปรับสถานะสำเร็จ";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
header("Location: list_leaves.php");  // กลับไปที่หน้ารายการหลังอัปเดตเสร็จ
?>
