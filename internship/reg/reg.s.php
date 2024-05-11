<link rel="stylesheet" href="../Styles.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<?php
session_start();
require_once("../libs/connect.class.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="../p/public/assets/css/theme.css" rel="stylesheet" />
</head>

<body>
  <!--  -->

  <!--  -->
  <div class="container">
    <br>
    <!-- register -->
    <div class="container">
        <body>
            <div class="waviy">
                <span style="--i:1">R</span>
                <span style="--i:2">E</span>
                <span style="--i:3">G</span>
                <span style="--i:4">I</span>
                <span style="--i:5">S</span>
                <span style="--i:6">T</span>
                <span style="--i:7">E</span>
                <span style="--i:8">R</span>
            </div>
        </body>
        <!--  -->
        <style>
        * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
 
</style>
    <!--  -->
    <hr>
    <form id="registration-form" action="regsuc.php" method="post" enctype="multipart/form-data" onsubmit="return checkIfNotBot();">
      <div class="mb-3">
        <a href="../?page=1" class="btn btn-dark">หน้าหลัก</a>
        <a href="../?page=login" class="btn btn-warning">เข้าสู่หน้า login</a>
      </div>


      <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger" role="alert">
          <?php
          echo $_SESSION['error'];
          unset($_SESSION['error']);
          ?>
        </div>
      <?php } ?>


      <div class="mb-3">
        <label class="form-label">อีเมล</label>
        <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label class="form-label">ชื่อ - นามสกุล</label>
        <input type="text" class="form-control" name="name" require>
      </div>

      <!--  -->
      <div class="mb-3">
    <label class="form-check-label">
        <input type="checkbox" name="not_msu" id="not_msu">
        ไม่เป็นนิสิต MSU
    </label>
</div>

<!-- แสดง/ซ่อน ช่องกรอกข้อมูลคณะและรหัสนิสิต ตามการติ๊กเช็กบ็อก -->
<div class="mb-3" id="faculty_section">
    <label class="form-label">คณะ</label>
    <select name="fac" id="faculty" require>
        <option value="">เลือกคณะ</option>
        <?php
        $db = new ConnectDb();
        $conn = $db->getConn();

        $sql = "SELECT * FROM faculty";
        $result = mysqli_query($conn, $sql);

        // วนลูปแสดงตัวเลือกคณะ
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['f_id'] . "'>" . $row['f_name'] . "</option>";
        }
        // ปิดการเชื่อมต่อฐานข้อมูล
        mysqli_close($conn);
        ?>
    </select>
</div>

<div class="mb-3" id="s_code_section">
    <label class="form-label">รหัสนิสิต</label>
    <input type="text" class="form-control" name="s_code" require>
</div>

<!-- แสดงช่องกรอกข้อมูลมหาวิทยาลัยและคณะเมื่อไม่ได้เลือก MSU -->
<div class="mb-3" id="university_section" style="display: none;">
    <label class="form-label">มหาวิทยาลัย</label>
    <input type="text" class="form-control" name="university" require>
</div>

<div class="mb-3" id="faculty_outside_section" style="display: none;">
    <label class="form-label">คณะ</label>
    <input type="text" class="form-control" name="faculty_outside" require>
</div>

<!-- ถ้าติ๊กที่เช็คบ็อก MSU ซ่อนฟอร์มมหาวิทยาลัยและคณะ -->
<script>
    document.getElementById("not_msu").addEventListener("change", function () {
        var isNotMSU = !this.checked;

        document.getElementById("faculty_section").style.display = isNotMSU ? "block" : "none";
        document.getElementById("s_code_section").style.display = isNotMSU ? "block" : "none";

        document.getElementById("university_section").style.display = isNotMSU ? "none" : "block";
        document.getElementById("faculty_outside_section").style.display = isNotMSU ? "none" : "block";
    });
</script>

<!--  -->

<div class="mb-3">
    <label class="form-label">รหัสผ่าน</label>
    <input type="password" class="form-control" require name="pass1">
    <small class="text-danger"><span class="note">หมายเหตุ: รหัสผ่านต้องมีความยาวระหว่าง 6 ถึง 10 ตัวอักษร</span></small>
</div>

      <div class="mb-3">
        <label class="form-label">ยืนยันรหัสผ่าน</label>
        <input type="password" class="form-control" name="pass2" require>
      </div>
      <div class="mb-3">
        <label class="form-label">โทรศัพท์</label>
        <input type="number" class="form-control" name="tel" require>
      </div>

      <div class="mb-3">
        <label  class="form-label" >รูป Profile</label>
        <input class="form-control" name="file" type="file" accept="image/gif, image/jpeg, image/png" >
        <p class="small mb-0 mt-2"><b>Note:</b>สามารถอัพโหลดทีหลังได้ </p>
    </div>

    <div class="mb-3">
        <label  class="form-label" >รูป Resume</label>
        <input class="form-control" name="rfile" type="file" accept="image/gif, image/jpeg, image/png" >
        <p class="small mb-0 mt-2"><b>Note:</b>สามารถอัพโหลดทีหลังได้</p>
    </div>    

      <!--  -->
      <div class="g-recaptcha" data-sitekey="6LfpEGYpAAAAADCl_jJncaYml7OmaVmnkF41-iCC" align='center'></div>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <button type="submit" name="submit" class="btn btn-success">ยืนยัน</button>
</div>

    </form>
<br>

  </div>
<!--  -->
<!--  -->
<script>
    function checkIfNotBot() {
        // ตรวจสอบว่า reCAPTCHA ถูกติ๊กหรือไม่
        var response = grecaptcha.getResponse();

        if (response.length !== 0) {
            // ถ้าติ๊กที่ reCAPTCHA แล้ว
            // ตรวจสอบบอทโดยใช้ reCAPTCHA Verification API
            verifyCaptcha(response);
        } else {
            // ถ้าไม่ติ๊กที่ reCAPTCHA
            alert('กรุณายืนยันว่าท่านไม่ใช่บอท');
            return false; // ไม่ส่งแบบฟอร์ม
        }
    }

    function verifyCaptcha(response) {
        // ทำการส่ง request ไปยัง Google reCAPTCHA Verification API
        fetch('https://www.google.com/recaptcha/api/siteverify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `secret=6LfpEGYpAAAAADCl_jJncaYml7OmaVmnkF41-iCC&response=${response}`,
        })
            .then(response => response.json())
            .then(data => {
                // ตรวจสอบค่า success จาก response
                if (data.success) {
                    // ถ้าเป็นบอทจะไม่ทำการ submit ฟอร์ม
                    alert('คุณไม่ใช่บอท ยินดีต้อนรับ!');
                    // หรือสามารถทำการ submit ฟอร์มต่อได้
                    document.getElementById('registration-form').submit();
                } else {
                    // ถ้าเป็นบอทจะแสดง alert และไม่ทำการ submit ฟอร์ม
                    alert('คุณอาจเป็นบอท กรุณาลองใหม่');
                }
            })
            .catch(error => console.error('Error:', error));

        return false; // ไม่ส่งแบบฟอร์ม
    }
</script>


<!--  -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
</body>
</html>

