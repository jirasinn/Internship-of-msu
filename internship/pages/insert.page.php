<?php
// if(!isset($_SESSION['professor_login'])){
// 	echo "กรุณาเข้าสู่ระบบ";
// 	exit;
// }
?>

<!-- nav -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid ">
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-6 mb-lg-4">
            </ul>
            <span class="navbar-text">
                <a href="?page=insert" class="btn btn-primary" style="color:white ;">เพิ่มข้อมูลอีกครั้ง</a>
            </span>
        </div>
    </div>
</nav>
<!-- nav -->

<div class="container">

    <form action="" method="post" enctype="multipart/form-data">
        <!-- <div class="mb-3">
            <label class="form-label" for="w_id">รหัสงาน</label>
            <input class="form-control" type="text" placeholder="รหัสงาน" name="w_id" id="w_id" type="text" value=""
                required autofocus>
        </div> -->
        <div class="mb-3">
            <label class="form-label" for="title">หัวเรื่อง</label>
            <textarea class="form-control" placeholder="หัวเรื่อง" id="title" name="title" type="text" rows="3" required
                autofocus></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="nature">ลักษณะงาน</label>
            <textarea class="form-control" placeholder="ลักษณะงาน" id="nature" name="nature" type="text" rows="3"
                required autofocus></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="detail">รายละเอียดงาน</label>
            <textarea class="form-control" placeholder="รายละเอียดงาน" id="detail" name="detail" type="text" rows="3"
                required autofocus></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="feature">คุณสมบัติ</label>
            <textarea class="form-control" placeholder="คุณสมบัติ" id="feature" name="feature" type="text" rows="3"
                required autofocus></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="welfare">สวัสดิการ</label>
            <textarea class="form-control" placeholder="สวัสดิการ" id="welfare" name="welfare" type="text" rows="3"
                required autofocus></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">ตำแหน่ง</label>
            <select name="type_id" id="type_id" onchange="checkOtherOption()" required>
                <option value="">ระบุตำแหน่ง</option>
                <?php
                $db = new ConnectDb();
                $conn = $db->getConn();

                $sql = "SELECT * FROM type_of_work ORDER BY CASE WHEN type_id = 25 THEN 1 ELSE 0 END, type_id ASC";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['type_id'] . "'>" . $row['type_name'] . "</option>";
                }
                mysqli_close($conn);
                ?>
            </select>
        </div>

        <div class="mb-3" id="otherPositionInput" style="display:none;">
            <label class="form-label" for="other_type">โปรดระบุตำแหน่งเพิ่มเติม</label>
            <input class="form-control" id="other_type" type="text" placeholder="ระบุตำแหน่งเพิ่มเติม" name="other_type"
                autofocus>
        </div>

        <script>
            function checkOtherOption() {
                const selectedOption = document.getElementById('type_id').value;
                const otherPositionInput = document.getElementById('otherPositionInput');

                if (parseInt(selectedOption) === 25) {
                    otherPositionInput.style.display = 'block';
                } else {
                    otherPositionInput.style.display = 'none';
                }
            }
        </script>

        <!--  -->
        <!--  -->
        <div class="mb-3">
            <label class="form-label" for="quantity">จำนวนที่รับ (อัตรา)</label>
            <input class="form-control" id="quantity" type="text" placeholder="จำนวนที่รับ" name="quantity" require
                autofocus>
        </div>
        <!--  -->

        <div class="mb-3">
            <label for="post_period">ประกาศรับสมัครถึง:</label>
            <input type="date" id="post_period" name="post_period">
        </div>
        <!--  -->
        <form id="internshipForm" onsubmit="submitForm()">
            <div class="mb-3">
                <label for="internship_period">ช่วงระยะการฝึกงาน:</label>
                <input type="text" id="internship_period" name="internship_period" readonly>
            </div>
            <label for="start_date">เริ่ม:</label>
            <input type="date" id="start_date" name="start_date" onchange="updateInternshipPeriod()" required>

            <label for="end_date">สิ้นสุด:</label>
            <input type="date" id="end_date" name="end_date" onchange="updateInternshipPeriod()" required>

            <script>
                function updateInternshipPeriod() {
                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;

                    // Update the internship_period input with the selected date range
                    document.getElementById('internship_period').value = `${startDate} - ${endDate}`;
                }

                function submitForm() {
                    // Get values and perform additional validation or processing if needed
                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;
                    const internshipPeriod = document.getElementById('internship_period').value;

                    console.log("Selected Start Date:", startDate);
                    console.log("Selected End Date:", endDate);
                    console.log("Internship Period:", internshipPeriod);

                    // Prevent the form from submitting in the traditional way
                    event.preventDefault();
                }
            </script>

            <br><br>
            <!--  -->
            <div class="container-login100-form-btn m-t-32" align="center">
                <button id="submit" type="submit" name="upload" class="btn btn-primary"
                    style="color:white ;">บันทึกข้อมูล</button>
        </form>
</div>
<br>

<?php

$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_POST['upload'])) {
    // ตรวจสอบค่าที่ส่งมาจากฟอร์ม
    $title = isset($_POST['title']) ? mysqli_real_escape_string($conn, $_POST['title']) : '';
    $nature = isset($_POST['nature']) ? mysqli_real_escape_string($conn, $_POST['nature']) : '';
    $detail = isset($_POST['detail']) ? mysqli_real_escape_string($conn, $_POST['detail']) : '';
    $feature = isset($_POST['feature']) ? mysqli_real_escape_string($conn, $_POST['feature']) : '';
    $welfare = isset($_POST['welfare']) ? mysqli_real_escape_string($conn, $_POST['welfare']) : '';
    $type_id = isset($_POST['type_id']) ? (int) $_POST['type_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;
    $f_id = $_SESSION['internship_user_f_id'];
    // 
    $other_type = isset($_POST['other_type']) ? mysqli_real_escape_string($conn, $_POST['other_type']) : '';
    // 
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $post_period = isset($_POST['post_period']) ? $_POST['post_period'] : '';

    // ตรวจสอบความถูกต้องของข้อมูล
    if (empty($title) || empty($nature) || empty($detail) || empty($feature) || empty($welfare) || empty($f_id) || empty($start_date) || empty($end_date) || empty($post_period) || empty($type_id)) {
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
        $sql = "INSERT INTO `job_description`(`title`, `nature`, `detail`, `feature`, `welfare`, `type_id`, `quantity`, `f_id`, `d_date`, `internship_period`, `post_period`)
            VALUES ('$title','$nature','$detail','$feature','$welfare', $type_id, $quantity, $f_id, NOW(), '$internship_period', '$post_period')";

        // ดำเนินการเพิ่มข้อมูล
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // แสดงคำแนะนำหลังจากเพิ่มข้อมูลสำเร็จ
            echo "<script>";
            echo "alert('โพสต์สำเร็จ')";
            echo "</script>";
        } else {
            // แสดงคำเตือนหากมีปัญหาในการเพิ่มข้อมูล
            echo "<script>";
            echo "alert('ไม่สามารถเพิ่มข้อมูลได้: ' . mysqli_error($conn)";
            echo "</script>";
        }

    } else {

        // ในกรณีที่ไม่ใช่ 'other' ให้ดำเนินการเพิ่มข้อมูลในตาราง job_description ตรงๆ
        $internship_period = mysqli_real_escape_string($conn, $_POST['internship_period']);
        $sql = "INSERT INTO `job_description`(`title`, `nature`, `detail`, `feature`, `welfare`, `type_id`, `quantity`, `f_id`, `d_date`, `internship_period`, `post_period`)
            VALUES ('$title','$nature','$detail','$feature','$welfare', $type_id, $quantity, $f_id, NOW(), '$internship_period', '$post_period')";

        // ดำเนินการเพิ่มข้อมูล
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // แสดงคำแนะนำหลังจากเพิ่มข้อมูลสำเร็จ
            echo "<script>";
            echo "alert('โพสต์สำเร็จ')";
            echo "</script>";
        } else {
            // แสดงคำเตือนหากมีปัญหาในการเพิ่มข้อมูล
            echo "<script>";
            echo "alert('ไม่สามารถเพิ่มข้อมูลได้: ' . mysqli_error($conn)";
            echo "</script>";
        }
    }
}


?>