<?php
require_once("../libs/connect.class.php");
session_start();
$db = new ConnectDb();
$conn = $db->getConn();

$u_id = $_SESSION['internship_user_id'];

$sql = "SELECT * FROM users WHERE u_id = '$u_id'";
$rs = mysqli_query($conn, $sql);
$data = mysqli_fetch_array($rs);

if (isset($_POST['upload'])) {
    $email = $_POST['email'];
    $s_code = isset($_POST['s_code']) ? $_POST['s_code'] : $data['s_code'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $university = isset($_POST['university']) ? $_POST['university'] : '';
    $faculty_outside = isset($_POST['faculty_outside']) ? $_POST['faculty_outside'] : '';
    
    
    // ตรวจสอบการอัปโหลดไฟล์รูป Profile
    if ($_FILES['file']['name']) {
        $profile_file = $_FILES['file']['name'];
        $profile_tmp = $_FILES['file']['tmp_name'];
        $profile_folder = "../images/" . $profile_file;

        // ตรวจสอบประเภทของไฟล์รูปภาพ
        $image_info = getimagesize($profile_tmp);
        $allowed_image_types = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_JPEG);

        if (is_array($image_info) && in_array($image_info[2], $allowed_image_types)) {
            move_uploaded_file($profile_tmp, $profile_folder);
        } else {
            // ประเภทของไฟล์ไม่ถูกต้อง
            echo "<script>";
            echo "alert('เฉพาะไฟล์รูปภาพประเภท JPEG, PNG, GIF และ JPG เท่านั้น');";
            echo "window.location='../?page=s_profile'";
            echo "</script>";
            exit(); // เพิ่มคำสั่งนี้เพื่อหยุดการทำงานทันที
            // ตรวจสอบแล้วไม่อัปโหลดไฟล์
            $profile_file = $data['image'];
        }
    } else {
        $profile_file = $data['image'];
    }

    // ตรวจสอบการอัปโหลดไฟล์ Resume
    if (isset($_FILES['rfile']['name']) && $_FILES['rfile']['name'] !== "") {
        $resume_file = $_FILES['rfile']['name'];
        $resume_tmp = $_FILES['rfile']['tmp_name'];
        $resume_folder = "../images/resume/" . $resume_file;

        // ตรวจสอบประเภทของไฟล์ Resume
        $allowed_resume_types = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_JPEG);

        if (is_array(getimagesize($resume_tmp)) && in_array(getimagesize($resume_tmp)[2], $allowed_resume_types)) {
            move_uploaded_file($resume_tmp, $resume_folder);
        } else {
            // ประเภทของไฟล์ Resume ไม่ถูกต้อง
            echo "<script>";
            echo "alert('เฉพาะไฟล์รูปภาพประเภท JPEG, PNG, GIF และ JPG เท่านั้น');";
            echo "window.location='../?page=s_profile'";
            echo "</script>";
            exit(); // เพิ่มคำสั่งนี้เพื่อหยุดการทำงานทันที
            // ตรวจสอบแล้วไม่อัปโหลดไฟล์
            $resume_file = $data['resume'];
        }
    } else {
        $resume_file = $data['resume'];
    }


    $faculty = isset($_POST['fac']) ? $_POST['fac'] : $data['f_id'];
    
    $update_sql = "UPDATE users 
    SET email = '$email', 
    s_code = '$s_code', 
    name = '$name', 
    phone = '$phone',
    image = '$profile_file', 
    resume = '$resume_file', 
    f_id = '$faculty', 
    university = '$university', 
    faculty_outside = '$faculty_outside' 
    WHERE u_id = '$u_id'";

    mysqli_query($conn, $update_sql);

    $_SESSION['internship_user_f_id'] = $faculty;
    $_SESSION['internship_user_name'] = $name;
    $_SESSION['internship_user_image'] = $profile_file;
    $_SESSION['internship_user_resume'] = $resume_file;
    echo "<script>";
    echo "alert('แก้ไขข้อมูลสำเร็จ');";
    echo "window.location='../?page=s_profile'";
    echo "</script>";
}
?>