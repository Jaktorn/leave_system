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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $department_position = $_POST['department_position'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $leave_type = $_POST['leave_type'];
    $leave_reason = $_POST['leave_reason'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    $valid_request = true; // ตัวแปรตรวจสอบว่าเงื่อนไขผ่านหรือไม่

    // ตรวจสอบเงื่อนไขการลาพักร้อน
    if ($leave_type == 'พักร้อน') {
        $today = new DateTime();
        $start = new DateTime($start_date);
        $diff = $today->diff($start)->days;

        // ต้องล่วงหน้าอย่างน้อย 3 วัน
        if ($diff < 3) {
            echo "<script>alert('การลาพักร้อนต้องล่วงหน้าอย่างน้อย 3 วัน');</script>";
            $valid_request = false;
        }

        // ลาติดต่อกันได้ไม่เกิน 2 วัน
        $day_diff = (new DateTime($end_date))->diff($start)->days;
        if ($day_diff > 2) {
            echo "<script>alert('การลาพักร้อนสามารถลาติดต่อกันได้ไม่เกิน 2 วัน');</script>";
            $valid_request = false;
        }
    }

    // ห้ามลาย้อนหลัง
    if (new DateTime($start_date) < new DateTime()) {
        echo "<script>alert('ไม่อนุญาตให้บันทึกวันลาย้อนหลัง');</script>";
        $valid_request = false;
    }

    // หากไม่อยู่ในเงื่อนไขที่จำกัด ให้บันทึกข้อมูลลงฐานข้อมูล
    if ($valid_request) {
        // เตรียมคำสั่ง SQL
        $stmt = $conn->prepare("INSERT INTO leave_requests (full_name, department_position, email, phone, leave_type, leave_reason, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $full_name, $department_position, $email, $phone, $leave_type, $leave_reason, $start_date, $end_date);

        // ดำเนินการคำสั่ง
        if ($stmt->execute()) {
            echo "<script>alert('บันทึกการลาสำเร็จ!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='index.php';</script>";
        }
        $stmt->close(); // ปิดคำสั่ง
    } else {
        // ถ้าไม่ตรงตามเงื่อนไข สามารถส่งกลับไปที่หน้า index ได้
        echo "<script>window.location.href='index.php';</script>";
    }
}

$conn->close();
?>
