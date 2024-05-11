<?php
require_once("../libs/connect.class.php");

$db = new ConnectDb();
$conn = $db->getConn();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT s_selected.*, faculty.*, job_description.*, users.*
        FROM s_selected
        JOIN faculty ON faculty.f_id = s_selected.f_id
        JOIN job_description ON job_description.f_id = s_selected.f_id
        JOIN users ON users.u_id = s_selected.u_id
        WHERE s_selected.u_id = users.u_id
        AND s_selected.w_id = job_description.w_id";
// รับข้อมูลจากฟอร์ม
$Date = $_POST['date'];
$location = $_POST['location'];
$phoneNumber = $_POST['phone'];
$notes = $_POST['notes'];
$sname = $_POST['sname'];
$selectedId = $_POST['selected_id'];
$internship_period = is_array($_POST['internship_period']) ? implode(' - ', $_POST['internship_period']) : $_POST['internship_period'];


if (empty($Date) || empty($location) || empty($phoneNumber) || empty($notes) || empty($sname) || empty($selectedId)) {
    echo "<script>";
    echo "alert('กรุณากรอกข้อมูลให้ครบทุกช่อง');";
    echo "window.location='../?page=p_respond'";
    echo "</script>";
    exit; // หยุดการทำงานต่อไป
}

// สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูลในตาราง respond
$sql = "INSERT INTO respond (date, location, phone, notes, sname, selected_id, internship_period)
        VALUES ('$Date', '$location', '$phoneNumber', '$notes', '$sname', '$selectedId', '$internship_period')";

if ($conn->query($sql) === TRUE) {
    $updateNotesSql = "UPDATE s_selected SET notes = CONCAT(notes, ' มีนัดสัมภาษณ์') WHERE selected_id = '$selectedId'";
    if ($conn->query($updateNotesSql) === TRUE) {
        echo "<script>";
        echo "alert('นัดหมายสำเร็จ');";
        echo "window.location='../?page=p_respond'";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('มีบางอย่างผิดพลาด: ');" . $conn->error;
        echo "window.location='../?page=p_respond'";
        echo "</script>";
    }
} else {
    echo "<script>";
    echo "alert('มีบางอย่างผิดพลาด: ');" . $conn->error;
    echo "window.location='../?page=p_respond'";
    echo "</script>";
}

$conn->close();
?>
