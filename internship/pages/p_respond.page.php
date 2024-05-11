<h3 class="animate-charcter1 bi bi-incognito col-md-12 pb-3 mb-4 py-5 border-bottom" align="center">
      รายการที่สมัครเข้ามา
    </h3>

<?php
// เชื่อมต่อกับฐานข้อมูล
$db = new ConnectDb();
$conn = $db->getConn();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$f_id = $_SESSION['internship_user_f_id'];

// สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
$sql = "SELECT s_selected.*, faculty.*, job_description.*, users.*, type_of_work.*
        FROM s_selected
        JOIN faculty ON faculty.f_id = s_selected.f_id
        JOIN job_description ON job_description.f_id = s_selected.f_id
        JOIN users ON users.u_id = s_selected.u_id
        JOIN type_of_work ON job_description.type_id = type_of_work.type_id
        WHERE s_selected.f_id = '$f_id'
        AND s_selected.u_id = users.u_id
        AND s_selected.w_id = job_description.w_id
        ORDER BY s_selected.s_date DESC";

$rs = $conn->query($sql);
if ($rs && $rs->num_rows > 0) {
    while ($data = $rs->fetch_array(MYSQLI_BOTH)) {
        $current_u_id = $data['u_id']; // เก็บค่า u_id ปัจจุบันในตัวแปร
        $selected_id = $data['selected_id'];
        $hasRespond = $db->checkIfRespondExists($conn, $selected_id);
        ?>
        <!--  -->


        <div class="container p-4">
            <div class="row gy-5">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="card-header">
                                <?= $data['title']; ?>
                            </h5>
                        </div>

                        <div class="col-md-11">
                            <div class="card-body">
                                <h5><strong class="card-title">ตำแหน่ง:
                                        <?= $data['type_name']; ?>
                                    </strong></h5>
                                <p class="card-text">ชื่อผู้สมัคร:
                                    <?= $data['name']; ?>
                                </p>

                                <p class="card-text col-md-11">รายละเอียด:
                                    <?= $data['detail']; ?>
                                </p>

                                <p><strong class="card-text" id="card_quantity" style="font-size: 12px;">ช่วงระยะเวลาฝึกงาน:
                                        <?= $data['internship_period']; ?>
                                    </strong>
                                </p>

                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#respond<?= $data['selected_id']; ?>">นัดหมายสัมภาษณ์</a>


                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#candidate_details<?= $current_u_id; ?>">รายละเอียดผู้สมัคร</button>

                                <!-- รายละเอียดการนัดสัมภาษณ์ เมื่อนัดไปแล้ว -->
                                <?php if ($hasRespond) { ?>
                                    <a href="#" class="btn btn-outline-warning" data-bs-toggle="modal"
                                        data-bs-target="#interview<?= $selected_id; ?>">ดูรายละเอียดนัดสัมภาษณ์</a>
                                <?php } ?>
                                <!--  -->

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <!--  -->
                                    <?php if ($hasRespond) { ?>
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#p_accepted<?= $selected_id ?>">รับเข้าฝึกงาน</button>
                                    <?php } ?>
                                    <!--  -->

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#rejectModal<?= $data['selected_id']; ?>">ปฏิเสธการสมัคร</button>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-1 p-2 gy-3">

                            <div class="card-image">
                                <img src="images/<?php echo isset($data['image']) ? $data['image'] : 'no_image.png'; ?>" alt=""
                                    width="100px" class="float-end ">
                            </div>
                        </div>
<!--  -->

<div class="col-md-12 ">
                                <div class="card-footer text-muted text-end">
                                    สมัครเมื่อ:
                                    <?= $data['s_date']; ?>
                                </div>
                            </div>

                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Candidate details modal -->
        <div class="modal fade" id="candidate_details<?= $current_u_id; ?>" tabindex="-1" aria-labelledby="sendLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="sendLabel">รายละเอียดผู้สมัคร</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container ">
                            <div class="row gy-5">
                                <?php
                                $sql_details = "SELECT users.*, faculty.f_name
                        FROM users 
                        LEFT JOIN faculty ON users.f_id = faculty.f_id
                        WHERE users.u_id = '$current_u_id'";

                                $result = $conn->query($sql_details);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <div class="container p-4">
                                            <div class="row gy-7">
                                                <div class="card1">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <div class="card-details">
                                                                <h3><i class="bi bi-person-circle"></i> Profile</h3>
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
                                                                <img src="images/<?php echo $row['image']; ?>" alt="" width="100px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            <div class="card1">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card-details">
                                                            <h3><i class="bi bi-person-circle"></i> Resume</h3>
                                                            <br>
                                                            <div class="card-image">
                                                                <?php if (!empty($resume)): ?>
                                                                    <img src="images/resume/<?php echo $resume; ?>" alt=""
                                                                        width="160%">
                                                                <?php else: ?>
                                                                    <p style="color: red;">ไม่มีรูป Resume</p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Candidate details modal -->

        <?php
    }
} else {
    echo "<script>";
    echo "alert('No user found.')";
    echo $conn->error;
}
?>

<?php
// เชื่อมต่อกับฐานข้อมูล
$db = new ConnectDb();
$conn = $db->getConn();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$f_id = $_SESSION['internship_user_f_id'];

// สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
$sql = "SELECT s_selected.*, faculty.*, job_description.*, users.*
        FROM s_selected
        JOIN faculty ON faculty.f_id = s_selected.f_id
        JOIN job_description ON job_description.f_id = s_selected.f_id
        JOIN users ON users.u_id = s_selected.u_id
        WHERE s_selected.f_id = '$f_id'
        AND s_selected.u_id = users.u_id
        AND s_selected.w_id = job_description.w_id";

$rs = $conn->query($sql);
if ($rs && $rs->num_rows > 0) {
    while ($data = $rs->fetch_array(MYSQLI_BOTH)) {
        $current_u_id = $data['u_id']; // เก็บค่า u_id ปัจจุบันในตัวแปร
        $internship_period = $data['internship_period'];
        ?>
        <!-- ... -->

        <!-- modal respond -->
        <div class="modal fade" id="respond<?= $data['selected_id']; ?>" tabindex="-1" aria-labelledby="sendLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="sendLabel">นัดหมายสัมภาษณ์</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mb-3">
                        <!-- ... -->
                        <!-- in form -->
                        <form method="POST" action="crud/insert_respond.php">
                            <!--  -->
                            <input type="hidden" name="internship_period" value="<?php echo $internship_period; ?>">

                            <!--  -->
                            <div class="form-group mb-3">
                                <label for="date">วันที่</label>
                                <input type="date" class="form-control" id="date" name="date">
                            </div>
                            <div class="form-group mb-3">
                                <label for="location">สถานที่นัดหมาย</label>
                                <input type="text" class="form-control" id="location" name="location">
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone">เบอร์โทร</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="form-group mb-3">
                                <label for="notes">หมายเหตุ</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>
                            <!-- end in form -->

                            <!-- Hidden fields for s_name and selected_id -->
                            <div class="form-group mb-3">
                                <label for="sname">ถึงคุณ:</label>
                                <input type="text" id="sname" name="sname" value="<?= $data['name']; ?>" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <input type="hidden" id="selected_id" name="selected_id" value="<?= $data['selected_id']; ?>">
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="upload" class="btn btn-warning">นัดหมาย</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal respond -->

        <?php
    }
} else {
    echo "<script>";
    echo "alert('No user found.')";
    echo $conn->error;
}
?>

<!-- Reject modal -->
<?php
$f_id = $_SESSION['internship_user_f_id'];

// สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
$sql = "SELECT s_selected.selected_id, faculty.*, job_description.*, users.*
        FROM s_selected
        JOIN faculty ON faculty.f_id = s_selected.f_id
        JOIN job_description ON job_description.f_id = s_selected.f_id
        JOIN users ON users.u_id = s_selected.u_id
        WHERE s_selected.f_id = '$f_id'
        AND s_selected.u_id = users.u_id
        AND s_selected.w_id = job_description.w_id";

$rs = $conn->query($sql);
if ($rs && $rs->num_rows > 0) {
    while ($data = $rs->fetch_array(MYSQLI_BOTH)) {
        $current_u_id = $data['u_id'];
        ?>
        <!--  -->
        <div class="modal fade" id="rejectModal<?= $data['selected_id']; ?>" tabindex="-1" aria-labelledby="rejectModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="rejectModalLabel">ปฏิเสธการสมัคร</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>
                            <p><b>คุณต้องการปฏิเสธการสมัครของผู้สมัครคนนี้ใช่หรือไม่?</b></p>
                        </h6>
                        <form action="?page=clear_respond&id=<?= $data['selected_id']; ?>" method="POST">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                <button type="submit" class="btn btn-danger">ปฏิเสธการสมัคร</button>
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
<!-- End Reject modal -->

<!--  -->
<?php
$f_id = $_SESSION['internship_user_f_id'];

// สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
$sql = "SELECT s_selected.selected_id, faculty.*, job_description.*, users.*
        FROM s_selected
        JOIN faculty ON faculty.f_id = s_selected.f_id
        JOIN job_description ON job_description.f_id = s_selected.f_id
        JOIN users ON users.u_id = s_selected.u_id
        WHERE s_selected.f_id = '$f_id'
        AND s_selected.u_id = users.u_id
        AND s_selected.w_id = job_description.w_id";

$rs = $conn->query($sql);
if ($rs && $rs->num_rows > 0) {
    while ($data = $rs->fetch_array(MYSQLI_BOTH)) {
        $selected_id = $data['selected_id']; // เพิ่มบรรทัดนี้เพื่อรับค่า selected_id จากฐานข้อมูล
        $current_u_id = $data['u_id'];
        ?>
        <!-- Modal interview -->
        <div class="modal fade" id="interview<?= $selected_id; ?>" tabindex="-1" aria-labelledby="interviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="interviewModalLabel">รายละเอียดนัดสัมภาษณ์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <?php
                        // ตรวจสอบว่ามีการตอบกลับหรือไม่
                        $respondSql = "SELECT * FROM respond WHERE selected_id = '$selected_id'";
                        $respondResult = $conn->query($respondSql);
                        if ($respondResult && $respondResult->num_rows > 0) {
                            while ($respondData = $respondResult->fetch_assoc()) {
                                $date = $respondData['date'];
                                $location = $respondData['location'];
                                $phone = $respondData['Phone'];
                                $notes = $respondData['notes'];
                                ?>
                                <p>Date:
                                    <?php echo $date; ?>
                                </p>
                                <p>Location:
                                    <?php echo $location; ?>
                                </p>
                                <p>Phone:
                                    <?php echo $phone; ?>
                                </p>
                                <p>Notes:
                                    <?php echo $notes; ?>
                                </p>
                                <?php
                            }
                        } else {
                            echo "<p>No respond found.</p>";
                        }
                        ?>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
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

<!--  -->

<?php
$f_id = $_SESSION['internship_user_f_id'];

// สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
$sql = "SELECT s_selected.*, faculty.*, job_description.*, users.*, respond.*, type_of_work.*
        FROM s_selected
        JOIN faculty ON faculty.f_id = s_selected.f_id
        JOIN job_description ON job_description.f_id = s_selected.f_id
        JOIN users ON users.u_id = s_selected.u_id
        JOIN respond ON respond.selected_id = s_selected.selected_id
        JOIN type_of_work ON job_description.type_id = type_of_work.type_id
        WHERE s_selected.f_id = '$f_id'
        AND s_selected.u_id = users.u_id
        AND s_selected.w_id = job_description.w_id";

$rs = $conn->query($sql);
if ($rs && $rs->num_rows > 0) {
    while ($data = $rs->fetch_array(MYSQLI_BOTH)) {
        $selected_id = $data['selected_id']; // เพิ่มบรรทัดนี้เพื่อรับค่า selected_id จากฐานข้อมูล
        $name = $data['name'];
        $position = $data['type_name'];
        $phone = $data['phone'];
        $f_id;
        $w_id = $data['w_id'];
        $u_id = $data['u_id'];
        $type_id = $data['type_id'];
        $respond_id = $data['respond_id'];
        $internship_period = $data['internship_period'];
        ?>
        <!-- Modal interview -->
        <div class="modal fade" id="p_accepted<?= $selected_id; ?>" tabindex="-1" aria-labelledby="p_acceptedModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="p_acceptedModalLabel">ยืนยันการรับเข้าฝึกงาน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="crud/insert_accepted.php" method="POST">
                        <h5><p>เมื่อกดยอมรับแล้วข้อมูลการนัดสัมภาษณ์จะถูกลบ</p></h5>                    
                            <h6><p><b>คุณต้องการรับเข้าฝึกงานใช่หรือไม่?</b></p></h6>
                            <!--  -->
                            <input type="hidden" name="selected_id" value="<?php echo $selected_id; ?>">
                            <input type="hidden" name="respond_id" value="<?php echo $respond_id; ?>">
                            <input type="hidden" name="position" value="<?php echo $position; ?>">
                            <input type="hidden" name="name" value="<?php echo $name; ?>">
                            <input type="hidden" name="phone" value="<?php echo $phone; ?>">
                            <input type="hidden" name="f_id" value="<?php echo $f_id; ?>">
                            <input type="hidden" name="w_id" value="<?php echo $w_id; ?>">
                            <input type="hidden" name="u_id" value="<?php echo $u_id; ?>">
                            <input type="hidden" name="type_id" value="<?php echo $type_id; ?>">
                            <input type="hidden" name="internship_period" value="<?php echo $internship_period; ?>">

                            <!--  -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" name="submit" class="btn btn-success">รับเข้าฝึกงาน</button>

                    </div>
                    </form>
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