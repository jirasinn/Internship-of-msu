<form action="" method="post">
  <?php if (isset($_SESSION['error'])) { ?>
    <div class="alert alert-danger" role="alert">
      <?php
      echo $_SESSION['error'];
      unset($_SESSION['error']);
      ?>
    </div>
  <?php } ?>

  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <div class="mb-md-5 mt-md-4 pb-5">

                <h2 class="fw-bold mb-2 text-uppercase text-white">Login</h2>
                <p class="text-white-50 mb-5">Please enter your login and password!</p>

                <div class="mb-3">
  <label class="form-label">Email</label>
  <input type="email" class="form-control" placeholder="อีเมล" name="email" required>
</div>
                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" class="form-control" placeholder="รหัสผ่าน" require name="pass">
                </div>
                <button type="submit" name="login" class="btn btn-warning text-white" require>login</button>
                <a href='javascript:window.history.back()' class="btn btn-danger">back</a>
</form>
<div class="d-flex justify-content-center text-center mt-4 pt-1">
  <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
  <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
  <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
</div>

</div>

<!-- data-bs-toggle="modal" data-bs-target="#register" -->
<div>
<p class="mb-0">ยังไม่มีบัญชีใช่ไหม? 
    <a class="text-white-50 fw-bold" onclick="showPopup()" href="#">สมัครที่นี่</a>
</p>

</div>

</div>
</div>
</div>
</div>
</div>
</section>

<?php
if (isset($_POST['login'])) {
  $db = new ConnectDb();
  $conn = $db->getConn();

  $name = $_POST['uname'];
  $pass = $_POST['pass'];

  $email = $_POST['email'];

  $sql = "SELECT * FROM users WHERE email='$email' AND pass='" . md5($pass) . "'";

  $rs = mysqli_query($conn, $sql);
  $data = mysqli_num_rows($rs);

  if ($data = mysqli_fetch_array($rs)) {
    // print_r($data);

    $_SESSION['internship_user_id'] = $data['u_id'];
    $_SESSION['internship_user_name'] = $data['name'];
    $_SESSION['internship_user_email'] = $data['email'];
    $_SESSION['internship_user_type'] = $data['urole'];
    $_SESSION['internship_user_f_id'] = $data['f_id'];
    $_SESSION['internship_user_image'] = $data['image'];
    $_SESSION['internship_user_resume'] = $data['resume'];
    echo '<script>window.location.href="?page=1";</script>';

  } else {
    $_SESSION['error'] = "กรุณากรอกข้อมูลผู้ใช้ให้ถูกต้อง";
    echo '<script>window.location.href="?page=login";</script>';
  }
}
?>
<!--  -->

 <!-- Popup แจ้งเตือน -->
<div id="popup-container" class="popup-container">
    <div class="popup">
    <h3>ข้อตกลงและเงื่อนไข</h3>
        <p>โปรดอ่านและทำความเข้าใจข้อตกลงและเงื่อนไขต่อไปนี้ก่อนที่จะทำการสมัครสมาชิก</p>
        <ul>
            <li>1. ข้อมูลส่วนตัวที่คุณกรอกจะถูกใช้เพื่อวัตถุประสงค์ในการสมัครสมาชิก</li>
            <li>2. เราจะไม่ให้ข้อมูลส่วนตัวของคุณแก่บุคคลภายนอกโดยไม่ได้รับความยินยอมของคุณ</li>
            <li>3. คุณไม่สามารถยกเลิกการสมัครสมาชิกได้</li>
        </ul>

        <br><br><br>
        <input type="checkbox" id="acceptCheckbox"> <b>ฉันได้อ่านและยอมรับข้อตกลงและเงื่อนไข</b>
        <br>

        <button onclick="hidePopup()">ไม่ยินยอม</button>
        <button onclick="acceptAndRedirect()">ยินยอมและสมัคร</button>
        
    </div>
</div>

<script>
    // ฟังก์ชั่นแสดง popup
    function showPopup() {
        document.getElementById('popup-container').style.display = 'flex';
    }

    // ฟังก์ชั่นซ่อน popup
    function hidePopup() {
        document.getElementById('popup-container').style.display = 'none';
    }

    // ฟังก์ชั่นทำการสมัครหลังจากการยินยอม
    function acceptAndRedirect() {
        var acceptCheckbox = document.getElementById('acceptCheckbox');

        if (acceptCheckbox.checked) {
            window.location.href = 'reg/reg.s.php';
        } else {
            alert('โปรดยอมรับข้อตกลงก่อนที่จะสมัคร');
        }
    }
</script>

<style>
        /* สไตล์สำหรับ popup */
        .popup-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .popup {
            background: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            margin: 0 auto;
        }

        .popup button {
            padding: 10px 30px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .popup button.accept {
            background-color: #4CAF50;
            color: #fff;
        }

        .popup button.close {
            background-color: #f44336;
            color: #fff;
        }

        .popup input[type="checkbox"] {
            margin-right: 5px;
        }
        
        li {
        display: inline-block;
        position: relative;
        color: black;

        
        transition: 0.4s all ease;
        }
    </style>