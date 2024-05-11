<?php
session_start();
require_once("../libs/connect.class.php");
$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $s_code = $_POST['s_code'];
    $name = $_POST['name'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $urole = "student";
    $tel = $_POST['tel'];
    $fac = $_POST['fac'];
    $university = $_POST['university'];
    $faculty_outside = $_POST['faculty_outside'];

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
    // if (empty($s_code)) {
    //     $errorMsg .= 'กรุณากรอกรหัสนักศึกษา<br>';
    // }
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
// 
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
    $resume = ""; // Default empty value for the resume

    if (!empty($_FILES["file"]["name"])) {
        $targetDir = "../images/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($fileType, $allowTypes)) {
            $_SESSION['error'] = 'เฉพาะไฟล์รูปภาพประเภท JPEG, PNG, GIF และ JPG เท่านั้น)';
            header("location: reg.s.php");
            exit;
        }

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            $image = $fileName;
        } else {
            $_SESSION['error'] = 'เกิดข้อผิดพลาดในการอัปโหลดรูป Profile';
            header("location: reg.s.php");
            exit;
        }
    }

 // ตรวจสอบการอัปโหลดไฟล์ Resume
if (!empty($_FILES["rfile"]["name"])) {
    $resumeDir = "../images/resume/";
    $resumeFileName = basename($_FILES["rfile"]["name"]);
    $resumeFilePath = $resumeDir . $resumeFileName;
    $resumeFileType = pathinfo($resumeFilePath, PATHINFO_EXTENSION);

    // ตรวจสอบประเภทของไฟล์ Resume
    $allowedResumeTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($resumeFileType, $allowedResumeTypes)) {
        $_SESSION['error'] = 'เฉพาะไฟล์รูปภาพประเภท JPEG, PNG, GIF และ JPG เท่านั้น)';
        header("location: reg.s.php");
        exit;
    }
    if (move_uploaded_file($_FILES["rfile"]["tmp_name"], $resumeFilePath)) {
        $resume = $resumeFileName;
    } else {
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการอัปโหลดรูป Resume';
        header("location: reg.s.php");
        exit;
    }
}

    $sql = "INSERT INTO users (email, s_code, name, pass, phone, urole, f_id, image , resume, university, faculty_outside) 
    VALUES ('$email', '$s_code', '$name', md5('$pass1'), '$tel', '$urole', '$fac', '$image', '$resume', '$university', '$faculty_outside')";

mysqli_query($conn, $sql) or die('ไม่สามารถเพิ่มข้อมูลได้');

echo "<script>";
echo "alert('สมัครสำเร็จ');";
echo "window.location='../?page=login';";
echo "</script>";
}
?>