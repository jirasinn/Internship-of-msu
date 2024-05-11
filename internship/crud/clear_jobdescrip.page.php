<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // เชื่อมต่อฐานข้อมูล
    $db = new ConnectDb();
    $conn = $db->getConn();

    // รับค่ารหัสตำแหน่งงานที่ต้องการลบ
    $id = $_POST['id'];
    $f_id = $_SESSION['internship_user_f_id'];
    // สร้างคำสั่ง SQL สำหรับการลบข้อมูล
    $sql = "DELETE FROM job_description WHERE w_id='$id'";

    // ทำการลบข้อมูล
    if ($conn->query($sql) === TRUE) {
        echo "<script>";
        echo "alert('ลบข้อมูลสำเร็จ');";
        echo "window.location='?page=f_profile&id=" . $f_id . "'";
        echo "</script>";
    } else {
        echo "<script>";
        echo "เกิดข้อผิดพลาดในการลบข้อมูล: " . $conn->error;
        echo "window.location='?page=f_profile&id=" . $f_id . "'";
        echo "</script>";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
?>
