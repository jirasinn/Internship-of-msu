<?php
$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT job_description.*, faculty.f_name, type_of_work.type_name
            FROM job_description
            JOIN faculty ON job_description.f_id = faculty.f_id
            JOIN type_of_work ON job_description.type_id = type_of_work.type_id
            WHERE w_id='$id'";

    $rs = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($rs, MYSQLI_BOTH);

    $_SESSION['wid'][$id] = $data['w_id'];
    $_SESSION['wtitle'][$id] = $data['title'];
    $_SESSION['wnature'][$id] = $data['nature'];
    $_SESSION['wdetail'][$id] = $data['detail'];
    $_SESSION['wfeature'][$id] = $data['feature'];
    $_SESSION['wwelfare'][$id] = $data['welfare'];
    $_SESSION['wtype_name'][$id] = $data['type_name'];
    $_SESSION['wquantity'][$id] = $data['quantity'];
    $_SESSION['wfaculty'][$id] = $data['f_name'];
    $_SESSION['winternship_period'][$id] = $data['internship_period'];
    $_SESSION['wpost_period'][$id] = $data['post_period'];
}

?>

<?php
if (isset($_SESSION['wid'][$_GET['id']])) {
    $id = $_GET['id'];
    $wkid = $_SESSION['wid'][$id];
    ?>

    <div class="container p-3">
        <!-- <a href='javascript:window.history.back()' class="btn btn-secondary">back</a> -->
        <div class="row gy-3">
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card mb-3" style="max-width: full;">
                        <div class="row g-0" align='Left'>
                            <div class="col-md-2">
                                <img src="images/msu_icon.png" width="100%">
                            </div>

                            <div class="col-md-10">
                                <div class="card-body">
                                    <div scope="row">
                                        <p>
                                            <strong class="card-text" id="card_faculty">
                                                <?= $_SESSION['wfaculty'][$wkid]; ?>
                                            </strong>
                                        </p>
                                        <p>
                                            <strong class="card-text" id="card_nature"><?= $_SESSION['wtitle'][$wkid]; ?></strong>

                                        </p>
                                        <p>
                                            <strong class="card-text" id="card_nature">ลักษณะงาน: </strong>
                                            <?= $_SESSION['wnature'][$wkid]; ?>
                                        </p>
                                        <p>
                                            <strong class="card-text" id="card_detail">รายละเอียด: </strong>
                                            <?= $_SESSION['wdetail'][$wkid]; ?>
                                        </p>
                                        <p>
                                            <strong class="card-text" id="card_feature">คุณสมบัติ: </strong>
                                            <?= $_SESSION['wfeature'][$wkid]; ?>
                                        </p>
                                        <p>
                                            <strong class="card-text" id="card_welfare">สวัสดิการ: </strong>
                                            <?= $_SESSION['wwelfare'][$wkid]; ?>
                                        </p>
                                        <p>
                                            <strong class="card-text" id="card_position">ตำแหน่ง: </strong>
                                            <?= $_SESSION['wtype_name'][$wkid]; ?>
                                        </p>
                                        <p>
                                            <strong class="card-text" id="card_quantity">จำนวนที่รับ: </strong>
                                            <?= $_SESSION['wquantity'][$wkid]; ?> (อัตรา)
                                        </p>

                                        <p><strong class="card-text" id="card_quantity"
                                                style="font-size: 12px;">ช่วงระยะเวลาฝึกงาน:
                                                <?= $_SESSION['winternship_period'][$wkid]; ?>
                                            </strong>
                                        </p>
                                        <p><strong class="card-text" id="card_quantity"
                                                style="font-size: 12px;">ประกาศรับสมัครถึง:
                                                <?= $_SESSION['wpost_period'][$wkid]; ?>
                                            </strong>
                                        </p>

                                        <p>
                                        <h6 class="d-grid gap-2 d-md-flex justify-content-md-end" id="card_quantity">
                                            จำนวนผู้สมัครปัจจุบัน:
                                            <?php
                                            $w_id = $data['w_id']; // เอา w_id ของงานนี้
                                            $countSql = "SELECT COUNT(*) AS total_applicants FROM s_selected WHERE w_id = $w_id";
                                            $countResult = mysqli_query($conn, $countSql);

                                            if ($countResult) {
                                                $countData = mysqli_fetch_assoc($countResult);
                                                echo $countData['total_applicants']; // แสดงจำนวนผู้สมัคร
                                            } else {
                                                echo "0"; // หรือแสดง 0 ถ้าไม่มีข้อมูล
                                            }
                                            ?>
                                        </h6>
                                        </p>

                                        <br>

                                        <?php
                                        if (!isset($_SESSION['internship_user_type'])) {
                                            // ถ้าไม่มีค่า $_SESSION['internship_user_type']
                                            ?>
                                            <script>
                                                alert("กรุณาเข้าสู่ระบบเพื่อใช้งาน");
                                            </script>
                                            <p style="color: red;">กรุณาเข้าสู่ระบบเพื่อใช้งาน</p>
                                            <?php
                                        } else {
                                            // ตรวจสอบ user_type
                                            if ($_SESSION['internship_user_type'] !== 'student' && $_SESSION['internship_user_type'] !== 'professor') {
                                                ?>
                                                <script>
                                                    alert("สามารถส่งใบสมัครงานได้ต้องเป็น Student เท่านั้น");
                                                </script>
                                                <p style="color: red;">สามารถส่งใบสมัครงานได้ต้องเป็น Student เท่านั้น</p>
                                                <?php
                                            }
                                            if ($_SESSION['internship_user_type'] === 'student'):
                                                ?>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <p><a><button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#send">
                                                                ส่งใบสมัคร
                                                            </button>
                                                        </a></p>
                                                </div>

                                            <?php endif; ?>
                                            <!--  -->

                                            <?php if ($_SESSION['internship_user_type'] === 'professor'): ?>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <div class="btn-group">
                                                        <a><button type="button" class="btn btn-warning btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit_descrip<?= $id ?>">แก้ไขประกาศนี้</button></a>
                                                    </div>

                                                    <div class="btn-group">
                                                        <a><button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectModal<?= $id ?>">ลบประกาศนี้</button></a>
                                                    </div>

                                                </div>
                                            <?php endif; ?>
                                            <!--  -->

                                        </div>



                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="card-footer text-muted text-end">
                                    ประกาศเมื่อ:
                                    <?= $data['d_date']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
} ?>
            <!--  -->

            <!-- Modal -->
            <div class="modal fade" id="send" tabindex="-1" aria-labelledby="sendLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="sendLabel">ส่งใบสมัคร</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!--  -->
                            <!--  -->
                            <div class="container p-4">
                                <div class="row gy-5">
                                    <?php
                                    $db = new ConnectDb();
                                    $conn = $db->getConn();

                                    $u_id = $_SESSION['internship_user_id'];
                                    $f_id = $_SESSION['internship_user_f_id'];
                                    $image = $_SESSION['internship_user_image'];
                                    $resume = $_SESSION['internship_user_resume'];

                                    $sql = "SELECT * FROM users 
                                LEFT JOIN faculty ON users.f_id = faculty.f_id
                                WHERE users.u_id = $u_id";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows >= 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            // แสดงข้อมูลผู้ใช้ในรูปแบบการ์ด
                                            ?>
                                            <div class="container p-4">
                                                <div class="row gy-7">
                                                    <div class="card1">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <div class="card-details">
                                                                    <h3><i class="bi bi-person-circle"> </i> Profile</h3>
                                                                    <div class="field">
                                                                        <label>Name:</label>
                                                                        <?php echo $row['name']; ?>
                                                                    </div>
         <!--  -->
                                                                    <?php if ($_SESSION['internship_user_type'] === 'student' && empty($row['university'])): ?>
                                    <div class="field">
                                        <label>Student Code:</label>
                                        <?php echo $row['s_code']; ?>
                                    </div>
                                <?php endif; ?>
                                                                    <!--  -->
                                <?php if (!empty($row['university'])): ?>
                                <div class="field"><label>University:</label>
                                    <?php echo $row['university']; ?>
                                </div>
                                <?php endif; ?>
                                <!--  -->
                                <div class="field">
                                    <?php if (!empty($row['f_id'])): ?>
                                        <label>Faculty:</label>
                                        <?php echo $row['f_name']; ?>
                                    <?php elseif (!empty($row['faculty_outside'])): ?>
                                        <label>Faculty:</label>
                                        <?php echo $row['faculty_outside']; ?>
                                    <?php endif; ?>
                                </div>
<!--  -->
                                                                    <div class="field">
                                                                        <label>Email:</label>
                                                                        <?php echo $row['email']; ?>
                                                                    </div>
                                                                    <div class="field">
                                                                        <label>Phone:</label>
                                                                        <?php echo $row['phone']; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="card-image">
                                                                    <?php if (!empty($image)): ?>
                                                                        <img src="images/<?php echo $image; ?>" alt=""
                                                                            width="100px">
                                                                    <?php else: ?>
                                                                        <img src="images/no_image.png" alt="" width="100px">
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                        }
                                    }
                                    ?>
                                            <div class="card1">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card-details">
                                                            <h3><i class="bi bi-person-circle"> </i> Resume</h3>
                                                            <br>
                                                            <div class="card-image">
                                                                <?php if (!empty($resume)): ?>
                                                                    <img src="images/resume/<?php echo $resume; ?>" alt=""
                                                                        width="160%">
                                                                <?php else: ?>
                                                                    <p style="color: red;">โปรดใส่รูป Resume
                                                                        ของคุณเพื่อการพิจารณาขององค์กร</p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <form method="POST" action="">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" name="submit"
                                                class="btn btn-primary">ส่งใบสมัคร</button>
                                            <!-- เปลี่ยนปุ่ม submit เป็นลิงก์เพื่อนำไปยังหน้าที่ต้องการ -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "SELECT job_description.*, faculty.f_name, type_of_work.type_name
                        FROM job_description
                        JOIN faculty ON job_description.f_id = faculty.f_id
                        JOIN type_of_work ON type_of_work.type_id = job_description.type_id
                        WHERE w_id='$id'";

                    $rs = mysqli_query($conn, $sql);
                    $data = mysqli_fetch_array($rs, MYSQLI_BOTH);

                    $_SESSION['wid'][$id] = $data['w_id'];
                    $_SESSION['wnature'][$id] = $data['nature'];
                    $_SESSION['wdetail'][$id] = $data['detail'];
                    $_SESSION['wfeature'][$id] = $data['feature'];
                    $_SESSION['wwelfare'][$id] = $data['welfare'];
                    $_SESSION['wtype_name'][$id] = $data['type_name'];
                    $_SESSION['wquantity'][$id] = $data['quantity'];
                    $_SESSION['wfaculty'][$id] = $data['f_name'];
                    $_SESSION['winternship_period'][$id] = $data['internship_period']; // บันทึกข้อมูล internship_period ใน session

                    $internship_period = $_SESSION['winternship_period'];
                    if (isset($_POST['submit'])) {
                        $u_id = $_SESSION['internship_user_id'];
                        $f_id = $_SESSION['internship_user_f_id'];
                
                        $sqlCheckWithinUser = "SELECT * FROM s_selected WHERE u_id = '$u_id' AND w_id = '$id'";
                        $resultCheckWithinUser = $conn->query($sqlCheckWithinUser);
                
                        if ($resultCheckWithinUser->num_rows === 0) {
                            $sqlInsert = "INSERT INTO s_selected (u_id, w_id, f_id, s_date, internship_period) 
                                          VALUES ('$u_id', '$id', (SELECT f_id FROM job_description WHERE w_id = '$id'), NOW(), '$internship_period')"; 
                            if ($conn->query($sqlInsert) === TRUE) {
                                $selectedId = $conn->insert_id;
                                echo "<script>";
                                echo "alert('ส่งใบสมัครสำเร็จ รอการพิจารณาจากคณะ');";
                                echo "window.location='?page=s_sent&id=" . $_GET['id'] . "'";
                                echo "</script>";

                            } else {
                                echo "<script>";
                                echo "alert('มีบางอย่างผิดพลาด: " . $conn->error . "');";
                                echo "window.location='?page=s_sent&id=" . $_GET['id'] . "'";
                                echo "</script>";
                            }
                        } else {
                            echo "Duplicate w_id with different u_id!";
                        }
                    }
                }
                ?>
                <!--  -->
            </div>
        </div>
    </div>

    <!--  -->

</div>
</div>
<!--  -->

<!-- delete descrip modal -->
<?php
$f_id = $_SESSION['internship_user_f_id'];
$id = $_GET['id'];
// สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
$sql = "SELECT faculty.*, job_description.*, users.*
        FROM job_description
        JOIN faculty ON faculty.f_id = job_description.f_id
        JOIN users ON users.f_id = job_description.f_id
        WHERE  job_description.w_id = $id
        AND job_description.f_id = $f_id";

$rs = $conn->query($sql);
if ($rs && $rs->num_rows > 0) {
    while ($data = $rs->fetch_array(MYSQLI_BOTH)) {
        $id;
        ?>
        <!--  -->
        <div class="modal fade" id="rejectModal<?= $id ?>" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="rejectModalLabel">ลบประกาศ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>
                            <p><b>คุณต้องการลบประกาศการรับสมัครนี้ใช่หรือไม่?</b></p>
                        </h6>

                        <form action="?page=clear_jobdescrip&id=<?= $id ?>" method="POST">
                            <div class="modal-footer">

                                <input type="hidden" name="id" value="<?= $id ?>">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                <button type="submit" class="btn btn-danger">ลบประกาศนี้</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
} else {
    echo "<script>";
    echo "alert('No user found.')";
    echo $conn->error;
}
?>
<!-- End delete modal -->

<!-- Edit descrip modal -->
<?php if ($_SESSION['internship_user_type'] === 'professor'): ?>
<div class="modal fade" id="edit_descrip<?= $id ?>" tabindex="-1" aria-labelledby="sendLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="sendLabel">แก้ไขโพสต์ประกาศรับสมัครงาน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- from -->
                <div class="container p-4">
                    <div class="row gy-5">
                        <!--  -->
                        <?php

                        $sql = "SELECT * FROM job_description 
                        where w_id = '$id'";
                        $rs = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_array($rs);
                        ?>

                        <!--  -->
                        <div class="container">
                            <form action="crud/edit_descrip.php" method="post" enctype="multipart/form-data">
                                <!--  -->
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <div class="mb-3">
                                    <label class="form-label">หัวเรื่อง</label>
                                    <textarea class="form-control" type="text" placeholder="หัวเรื่อง" name="title"
                                        rows="3"><?= $data['title'] ?></textarea>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ลักษณะงาน</label>
                                    <textarea class="form-control" type="text" placeholder="ลักษณะงาน" name="nature"
                                        rows="3"><?= $data['nature'] ?>
                                        </textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">รายละเอียดงาน</label>
                                    <textarea class="form-control" type="text" placeholder="รายละเอียดงาน" name="detail"
                                        rows="3"><?= $data['detail'] ?>
                                        </textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">คุณสมบัติ</label>
                                    <textarea class="form-control" type="text" placeholder="คุณสมบัติ" name="feature"
                                        rows="3"><?= $data['feature'] ?>
                                        </textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">สวัสดิการ</label>
                                    <textarea class="form-control" type="text" placeholder="สวัสดิการ" name="welfare"
                                        rows="3"><?= $data['welfare'] ?>
                                        </textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">ตำแหน่ง</label>
                                    <select name="type_id" id="type_id" onchange="checkOtherOption()" required>
                                        <option value="" selected>ระบุตำแหน่ง</option>
                                        <?php
                                        $db = new ConnectDb();
                                        $conn = $db->getConn();

                                        $sql = "SELECT * FROM type_of_work ORDER BY CASE WHEN type_id = 25 THEN 1 ELSE 0 END, type_id ASC";
                                        $result = mysqli_query($conn, $sql);

                                        // วนลูปแสดงตัวเลือกตำแหน่ง
                                        while ($row = mysqli_fetch_assoc($result)) {

                                            $selected = ''; // เพิ่มตัวแปรสำหรับเก็บค่า selected
                                            if (isset($data['type_id']) && $data['type_id'] == $row['type_id']) {
                                                $selected = 'selected'; // ถ้ามีการส่งค่า type_id และตรงกับค่าในฐานข้อมูล ให้เซ็ตค่า selected
                                            }
                                            echo "<option value='" . $row['type_id'] . "' $selected>" . $row['type_name'] . "</option>";
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3" id="otherPositionInput" style="display:none;">
                                    <label class="form-label" for="other_type">โปรดระบุตำแหน่งเพิ่มเติม</label>
                                    <input class="form-control" id="other_type" type="text"
                                        placeholder="ระบุตำแหน่งเพิ่มเติม" name="other_type" autofocus>
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

                                <div class="mb-3">
                                    <label class="form-label">จำนวนที่รับ (อัตรา)</label>
                                    <input class="form-control" type="text" placeholder="จำนวนที่รับ" name="quantity"
                                        value="<?= $data['quantity'] ?>"> 
                                </div>

                                <div class="mb-3">
                                    <label for="post_period">ประกาศรับสมัครถึง:</label>
                                    <input type="date" id="post_period" name="post_period"
                                        value="<?= $data['post_period'] ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="internship_period">ช่วงระยะการฝึกงาน:</label>
                                    <input type="text" id="internship_period" name="internship_period" readonly
                                        value="<?= $data['internship_period'] ?>">
                                </div>
                                <!--  -->
                                <label for="start_date">เริ่ม:</label>
                                <input type="date" id="start_date" name="start_date" onchange="updateInternshipPeriod()">

                                <label for="end_date">สิ้นสุด:</label>
                                <input type="date" id="end_date" name="end_date" onchange="updateInternshipPeriod()">

                                <script>
                                    function updateInternshipPeriod() {
                                        const startDate = document.getElementById('start_date').value;
                                        const endDate = document.getElementById('end_date').value;

                                        // Update the internship_period input with the selected date range
                                        document.getElementById('internship_period').value = `${startDate} - ${endDate}`;
                                    }

                                    function submitForm(event) {
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
                                <!--  -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="upload" class="btn btn-warning" onclick="submitForm()">Edit</button>


                                </div>
                            </form>
                        </div>

                        <!--  -->

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- End Edit descrip modal  -->