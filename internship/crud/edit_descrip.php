<?php
require_once("../libs/connect.class.php");
session_start();
$db = new ConnectDb();
$conn = $db->getConn();

// ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าที่ส่งมาจากฟอร์ม
    $title = $_POST['title'];
    $nature = $_POST['nature'];
    $detail = $_POST['detail'];
    $feature = $_POST['feature'];
    $welfare = $_POST['welfare'];
    $type_id = isset($_POST['type_id']) ? (int) $_POST['type_id'] : 0;
    $quantity = $_POST['quantity'];
    $post_period = $_POST['post_period'];
    $internship_period = $_POST['internship_period'];
// 
$other_type = isset($_POST['other_type']) ? mysqli_real_escape_string($conn, $_POST['other_type']) : '';

    $f_id = $_SESSION['internship_user_f_id'];
    $id = $_POST['id'];

    // ตรวจสอบความถูกต้องของข้อมูล
    if (empty($title) || empty($nature) || empty($detail) || empty($feature) || empty($welfare) || empty($f_id)  || empty($post_period) || empty($type_id)) {
        echo "<script>";
        echo "alert('กรุณากรอกข้อมูลทุกช่อง')";
        echo "</script>";
    }
    if ($type_id === 25) {
        // ถ้าเป็น 'other' ให้เพิ่มข้อมูลลงใน type_of_work
        // ดึงค่า type_id ที่มีค่ามากที่สุดในตาราง type_of_work
        $sqlMaxTypeId = "SELECT MAX(type_id) FROM type_of_work";
        $resultMaxTypeId = mysqli_query($conn, $sqlMaxTypeId);
        $rowMaxTypeId = mysqli_fetch_assoc($resultMaxTypeId);

        // ตรวจสอบว่ามีข้อมูลในตารางหรือไม่
        if ($rowMaxTypeId['MAX(type_id)'] !== null) {
            $nextTypeId = $rowMaxTypeId['MAX(type_id)'] + 1;
        } else {
            // ถ้ายังไม่มีข้อมูลในตารางให้กำหนดค่าเริ่มต้นเป็น 1
            $nextTypeId = 1;
        }

        // ตัวอย่างการใช้ค่า $nextTypeId เมื่อทำการเพิ่มข้อมูล
        $InsertTypeOfWork = "INSERT INTO type_of_work (type_id, type_name) 
        VALUES ($nextTypeId, '$other_type')";
        $result  = mysqli_query($conn, $InsertTypeOfWork);

        if (!$result) {
            die('ไม่สามารถเพิ่มข้อมูลประเภทงานใหม่ได้: ' . mysqli_error($conn));
        }

        // ดึงค่า type_id ที่เพิ่มล่าสุด
        $lastInsertedId = mysqli_insert_id($conn);

        // ให้ $type_id เป็นค่าที่เพิ่มล่าสุด
        $type_id = $lastInsertedId;

        // เพิ่มข้อมูลในตาราง job_description ด้วย type_id ที่ได้จากการเพิ่ม
        $internship_period = mysqli_real_escape_string($conn, $_POST['internship_period']);
        $sql = "UPDATE job_description SET 
        title = '$title',
        nature = '$nature',
        detail = '$detail',
        feature = '$feature',
        welfare = '$welfare',
        type_id = (
            SELECT type_id FROM type_of_work WHERE type_name = '$other_type'
        ),
        quantity = '$quantity',
        post_period = '$post_period',
        internship_period = '$internship_period',
        d_date = NOW()  -- เพิ่มส่วนนี้เพื่ออัปเดตเวลาทุกครั้ง
        WHERE w_id = $id";
        // ดำเนินการเพิ่มข้อมูล
        $result = $conn->query($sql); // $conn คือการเชื่อมต่อฐานข้อมูลที่ได้จาก $db->getConn();

        if ($result === TRUE) {
            echo "<script>";
            echo "alert('ทำการแก้ไขเสร็จเรียบร้อยแล้ว');";
            echo "window.location.href = '../?page=job_description&id=" . $id . "';";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert('ทำการแก้ไขไม่สำเร็จ: " . $conn->error . "');";
            echo "window.location.href = '../?page=job_description&id=" . $id . "';";
            echo "</script>";
        }

    } else {

    $sql = "UPDATE job_description SET 
        title = '$title',
        nature = '$nature',
        detail = '$detail',
        feature = '$feature',
        welfare = '$welfare',
        type_id = '$type_id',
        quantity = '$quantity',
        post_period = '$post_period',
        internship_period = '$internship_period',
        d_date = NOW()  -- เพิ่มส่วนนี้เพื่ออัปเดตเวลาทุกครั้ง
        WHERE w_id = $id"; 


    $result = $conn->query($sql); // $conn คือการเชื่อมต่อฐานข้อมูลที่ได้จาก $db->getConn();

    if ($result === TRUE) {
        echo "<script>";
        echo "alert('ทำการแก้ไขเสร็จเรียบร้อยแล้ว');";
        echo "window.location.href = '../?page=job_description&id=" . $id . "';";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('ทำการแก้ไขไม่สำเร็จ: " . $conn->error . "');";
        echo "window.location.href = '../?page=job_description&id=" . $id . "';";
        echo "</script>";
    }
    }
}
?>
