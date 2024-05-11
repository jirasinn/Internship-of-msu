<?php
session_start();
require_once("../libs/connect.class.php");
$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $urole = "professor";
    $tel = $_POST['tel'];
    $fac = $_POST['fac'];

    $errorMsg = '';

     // ตรวจสอบการซ้ำกันของอีเมลในฐานข้อมูล
     $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
     $checkEmailResult = mysqli_query($conn, $checkEmailQuery);
 
     if (mysqli_num_rows($checkEmailResult) > 0) {
         $errorMsg .= 'อีเมลนี้มีการใช้งานแล้ว<br>';
     }
 

    if (empty($name)) {
        $errorMsg .= 'กรุณากรอกชื่อ - นามสกุล<br>';
    }
    if (empty($email)) {
        $errorMsg .= 'กรุณากรอกอีเมล<br>';
    }
    if (empty($tel)) {
        $errorMsg .= 'กรุณากรอกเบอร์โทร<br>';
    }
    if (empty($pass1)) {
        $errorMsg .= 'กรุณากรอกรหัสผ่าน<br>';
    }
    if (empty($pass2)) {
        $errorMsg .= 'กรุณากรอกรหัสผ่านอีกครั้ง<br>';
    }
    // reg.s.php
    if (strlen($pass1) < 6) {
        $errorMsg .= 'รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร<br>';
    }
    
    if (strlen($pass1) > 10) {
        $errorMsg .= 'รหัสผ่านต้องมีความยาวไม่เกิน 10 ตัวอักษร<br>';
    }
    
    // ตรวจสอบความยาวของรหัสผ่านซ้ำ
    if (strlen($pass2) < 6 || strlen($pass2) > 10) {
        $errorMsg .= 'รหัสผ่านต้องมีความยาวระหว่าง 6 ถึง 10 ตัวอักษร<br>';
    }
    // 
        if (!empty($errorMsg)) {
            $_SESSION['error'] = $errorMsg;
            header("location: reg.s.php");
            exit;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            header("location: reg.s.php");
            exit;
        } elseif ($pass1 !== $pass2) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่านให้ตรงกัน';
            header("location: reg.s.php");
            exit;
        }

    $image = ""; // Default empty value for the image
   

    if (!empty($_FILES["file"]["name"])) {
        $targetDir = "../images/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($fileType, $allowTypes)) {
            $_SESSION['error'] = 'เฉพาะไฟล์รูปภาพประเภท JPEG, PNG, GIF และ JPG เท่านั้น)';
            header("location: reg.p.php");
            exit;
        }

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            $image = $fileName;
        } else {
            $_SESSION['error'] = 'เกิดข้อผิดพลาดในการอัปโหลดรูป Profile';
            header("location: reg.p.php");
            exit;
        }
    }

    $sql = "INSERT INTO users (email, name, pass, phone, urole, f_id, image) 
            VALUES ('$email', '$name', md5('$pass1'), '$tel', '$urole', '$fac', '$image')";

    mysqli_query($conn, $sql) or die('ไม่สามารถเพิ่มข้อมูลได้');

    echo "<script>";
    echo "alert('สมัครสมาชิกสำหรับ Professor สำเร็จ');";
    echo "window.location='../?page=home';";
    echo "</script>";
}
?>
