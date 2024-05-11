<?php
require_once("../libs/connect.class.php");
session_start();
$db = new ConnectDb();
$conn = $db->getConn();

// ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าที่ส่งมาจากฟอร์ม
    $f_name = $_POST['f_name'];
    $f_detail = $_POST['f_detail'];
    $f_welfare = $_POST['f_welfare'];
    $f_location = $_POST['f_location'];
    $f_contact = $_POST['f_contact'];

    // $f_id = $_SESSION['internship_user_f_id'];
    $id = $_POST['id'];

    // ตรวจสอบว่าสามารถเชื่อมต่อฐานข้อมูลได้หรือไม่
    if (!$db->conn) {
        die("Connection failed: " . $db->conn->connect_error);
    }

    $sql = "UPDATE faculty SET 
    f_name = '$f_name',
    f_detail = '$f_detail',
    f_welfare = '$f_welfare',
    f_location = '$f_location',
    f_contact = '$f_contact'
    WHERE f_id = $id";



    $result = $conn->query($sql); // $conn คือการเชื่อมต่อฐานข้อมูลที่ได้จาก $db->getConn();

    if ($result === TRUE) {
        echo "<script>";
        echo "alert('ทำการแก้ไขเสร็จเรียบร้อยแล้ว');";
        echo "window.location.href = '../?page=f_profile&id=" . $id . "';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('ทำการแก้ไขไม่สำเร็จ: " . $conn->error . "');";
        echo "window.location.href = '../?page=f_profile&id=" . $id . "';";
        echo "</script>";
    }
    }
?>
