<!DOCTYPE html>
<html>
<head>
    <title>Leave Request Form</title>
</head>
<body>
    <h2>แบบฟอร์มขอลาหยุด</h2>
    <form method="post" action="submit_leave.php">
        ชื่อ - นามสกุล: <input type="text" name="full_name" required><br><br>
        สังกัด/ตำแหน่ง: <input type="text" name="department_position"><br><br>
        อีเมล์: <input type="email" name="email"><br><br>
        เบอร์โทรศัพท์: <input type="text" name="phone" required><br><br>
        ประเภทการลา: 
        <select name="leave_type" required>
            <option value="ลาป่วย">ลาป่วย</option>
            <option value="ลากิจ">ลากิจ</option>
            <option value="พักร้อน">พักร้อน</option>
            <option value="อื่นๆ" selected>อื่นๆ</option>
        </select><br><br>
        สาเหตุการลา: <textarea name="leave_reason" required></textarea><br><br>
        วันที่ขอลา: <input type="date" name="start_date" required><br><br>
        ถึงวันที่: <input type="date" name="end_date" required><br><br>
        <input type="submit" value="บันทึกการลา">
    </form>
</body>
</html>
