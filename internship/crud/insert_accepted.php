<?php
session_start();
require_once("../libs/connect.class.php");
$db = new ConnectDb();
$conn = $db->getConn();

if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// รับค่าที่ส่งมาจากฟอร์ม
$respond_id = $_POST['respond_id'];
$position = $_POST['position'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$f_id = $_POST['f_id'];
$w_id = $_POST['w_id'];
$u_id = $_POST['u_id'];
$type_id = $_POST['type_id'];
$selected_id = $_POST['selected_id'];
$internship_period = $_POST['internship_period'];

// ตรวจสอบว่า respond_id ที่ต้องการเพิ่มไม่ซ้ำกันในตาราง accepted
$checkQuery = "SELECT respond_id FROM accepted WHERE respond_id = '$respond_id'";
$checkResult = $conn->query($checkQuery);

if ($checkResult && $checkResult->num_rows > 0) {
    echo "<script>";
    echo "alert('respond_id นี้ถูกใช้ไปแล้ว');";
    echo "window.location='../?page=p_respond'";
    echo "</script>";
} else {
    // สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูลลงในตาราง accepted
    $sql = "INSERT INTO accepted (position, sname, phone, f_id, respond_id, w_id, u_id, type_id, begin_date, status, internship_period) 
    VALUES ('$position', '$name', '$phone', '$f_id', '$respond_id', '$w_id', '$u_id', $type_id, NOW(), 'อยู่ในระหว่างฝึกงาน', '$internship_period')";


    if ($conn->query($sql) === TRUE) {
        // สร้างคำสั่ง SQL สำหรับการลบข้อมูลในตาราง respond
        $deleteRespondQuery = "DELETE FROM respond WHERE respond_id = '$respond_id'";
        $conn->query($deleteRespondQuery);

        // สร้างคำสั่ง SQL สำหรับการลบข้อมูลในตาราง s_selected
        $deleteSSelectedQuery = "DELETE FROM s_selected WHERE selected_id = '$selected_id'";
        $conn->query($deleteSSelectedQuery);

        echo "<script>";
        echo "alert('รับเข้าฝึกงานเรียบร้อยแล้ว');";
        echo "window.location='../?page=p_respond'";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('มีบางอย่างผิดพลาด: " . $conn->error . "');";
        echo "window.location='../?page=p_respond'";
        echo "</script>";
    }
}

$conn->close();
?>
