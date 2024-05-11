<h3 class="animate-charcter1 bi bi-incognito col-md-12 pb-3 mb-4 py-5 border-bottom" align="center">
    นิสิตที่เข้ารับการฝึกงาน
</h3>

<div class="container">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
            data-bs-target="#candidate_details">ประวัติการฝึกงาน</button>
    </div>
</div>

<?php
// เชื่อมต่อกับฐานข้อมูล
$db = new ConnectDb();
$conn = $db->getConn();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$f_id = $_SESSION['internship_user_f_id'];

// สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
$sql = "SELECT accepted.*, faculty.*, users.*, type_of_work.type_name
        FROM accepted
        JOIN faculty ON faculty.f_id = accepted.f_id
        JOIN users ON users.u_id = accepted.u_id
        JOIN type_of_work ON accepted.type_id = type_of_work.type_id
        WHERE accepted.f_id = $f_id
        AND accepted.u_id = users.u_id
        AND accepted.status != 'ประเมินไม่ผ่าน'
        AND accepted.status != 'ประเมินผ่าน'
        ORDER BY begin_date DESC";

// accepted.f_id = '$f_id'

$rs = $conn->query($sql);
if ($rs && $rs->num_rows >= 0) {
    while ($data = $rs->fetch_array(MYSQLI_BOTH)) {
        $current_u_id = $data['u_id']; // เก็บค่า u_id ปัจจุบันในตัวแปร
        ?>
        <!--  -->

        <div class="container p-4">
            <div class="row gy-5">
                <div class="card">
                    <div class="row">

                        <div class="col-md-12">
                            <h5 class="card-header">
                                <strong><label>Position:</label>
                                    <?= $data['type_name']; ?>
                                </strong>
                            </h5>
                        </div>

                        <div class="col-md-11">
                            <div class="card-body">

                                <label>Name:</label>
                                    <?= $data['name']; ?>
                                

                                <!--  -->
                                <?php
                                                        $sql3 = "SELECT faculty.f_name, users.*
                                FROM users 
                                LEFT JOIN faculty ON users.f_id = faculty.f_id
                                WHERE  users.f_id = faculty.f_id
                                AND users.u_id = '" . $data['u_id'] . "';";

                                                        $result1 = $conn->query($sql3);
                                                        if ($result1->num_rows > 0) {
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                ?>
                                                                <?php if (empty($row1['university'])): ?>
                                                                    <div class="field">
                                                                        <label>Student Code:</label>
                                                                        <?php echo $row1['s_code']; ?>
                                                                    </div>
                                                                    <div class="field">
                                                                        <label>Faculty:</label>
                                                                        <?php echo $row1['f_name']; ?>
                                                                    </div>
                                                                <?php endif;


                                                            }
                                                        } ?>
                                                        <!--  -->
                                                    

                                                    <?php if (!empty($data['university'])): ?>
                                                        <div class="field"><label>University:</label>
                                                            <?php echo $data['university']; ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if (!empty($data['faculty_outside'])): ?>
                                                        <label>Faculty:</label>
                                                        <?php echo $data['faculty_outside']; ?>
                                                    <?php endif; ?>

<!--  -->

                                <label>Phone:</label>
                                    <?= $data['phone']; ?>
                                
                                <p><label>Email:</label>
                                    <?= $data['email']; ?>
                                </p>

                                <p><strong class="card-text" id="card_quantity" style="font-size: 12px;">ช่วงระยะเวลาฝึกงาน:
                                        <?= $data['internship_period']; ?>
                                    </strong>
                                </p>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <!--  -->
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#accepModal2<?= $data['accepted_id']; ?>">ประเมินผ่าน</button>

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#accepModal<?= $data['accepted_id']; ?>">ประเมินไม่ผ่าน</button>
                                </div>
                                <!--  -->

                            </div>
                        </div>

                        <div class="col-md-1 p-3 gy-3">

                            <div class="card-image">
                                <img src="images/<?php echo isset($data['image']) ? $data['image'] : 'no_image.png'; ?>" alt=""
                                    width="100px" class="float-end ">
                            </div>
                        </div>

                        <div class="col-md-12 ">
                            <div class="card-footer text-muted text-end">
                                เริ่มฝึกงานเมื่อ:
                                <?= $data['begin_date']; ?>
                            </div>
                        </div>
                        <!--  -->

                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        <?php
    }
} else {
    echo "<script>";
    echo "alert('No user found.')";
    echo $conn->error;
}
?>

<!-- ถามประเมินไม่ผ่าน -->
<?php
$f_id = $_SESSION['internship_user_f_id'];

// สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
$sql = "SELECT accepted.accepted_id, faculty.*, users.*
        FROM accepted
        
        JOIN faculty ON faculty.f_id = accepted.f_id
        JOIN users ON users.u_id = accepted.u_id
        WHERE accepted.f_id = $f_id
        AND accepted.u_id = users.u_id";

$rs = $conn->query($sql);
if ($rs && $rs->num_rows > 0) {
    while ($data = $rs->fetch_array(MYSQLI_BOTH)) {
        ?>

        <div class="modal fade" id="accepModal<?= $data['accepted_id']; ?>" tabindex="-1" aria-labelledby="accepModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="accepModalLabel">ประเมินไม่ผ่าน</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>
                            <p><b>คุณต้องการประเมินสถานะของนิสิตคนนี้ให้ไม่ผ่าน ใช่หรือไม่??</b></p>
                        </h6>
                        <form action="?page=update_accepted&id=<?= $data['accepted_id']; ?>" method="POST">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                <button type="submit" class="btn btn-danger">ประเมินไม่ผ่าน</button>
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

<!-- ถามประเมินผ่าน -->
<?php
$f_id = $_SESSION['internship_user_f_id'];

// สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
$sql = "SELECT accepted.accepted_id, faculty.*, users.*
        FROM accepted
       
        JOIN faculty ON faculty.f_id = accepted.f_id
        JOIN users ON users.u_id = accepted.u_id
        WHERE accepted.f_id = $f_id
        AND accepted.u_id = users.u_id";

$rs = $conn->query($sql);
if ($rs && $rs->num_rows > 0) {
    while ($data = $rs->fetch_array(MYSQLI_BOTH)) {
        ?>

        <div class="modal fade" id="accepModal2<?= $data['accepted_id']; ?>" tabindex="-1" aria-labelledby="accepModal2Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="accepModal2Label">ประเมินผ่าน</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>
                            <p><b>คุณต้องการประเมินสถานะของนิสิตคนนี้ให้ผ่าน ใช่หรือไม่?</b></p>
                        </h6>
                        <form action="?page=update2_accepted&id=<?= $data['accepted_id']; ?>" method="POST">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                <button type="submit" class="btn btn-success">ประเมินผ่าน</button>
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

<!-- ประวัติการฝึกงาน -->

<div class="modal fade" id="candidate_details" tabindex="-1" aria-labelledby="sendLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="sendLabel">ประวัติการฝึกงาน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container ">
                    <div class="row gy-1">

                        <?php
                        $sql2 = "SELECT accepted.*, faculty.f_name, users.*
                        FROM accepted 
                        JOIN faculty ON accepted.f_id = faculty.f_id
                        JOIN users ON accepted.u_id = users.u_id
                        WHERE accepted.f_id = $f_id
                        AND users.u_id = accepted.u_id
                        ORDER BY begin_date DESC";

                        $result = $conn->query($sql2);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                ?>
                                <div class="container p-1">
                                    <div class="row gy-7">
                                        <div class="card1">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="card-details">
                                                        <h3><i class="bi bi-person-circle"></i>ประวัติการฝึกงาน</h3>
                                                        <div class="field">

                                                            <label>Name:</label>
                                                            <?php echo $row['sname']; ?>
                                                        </div>
                                                        <div class="field">
                                                            <label>Position:</label>
                                                            <?php echo $row['position']; ?>
                                                        </div>

                                                        <?php
                                                        $sql3 = "SELECT faculty.f_name, users.*
                                FROM users 
                                LEFT JOIN faculty ON users.f_id = faculty.f_id
                                WHERE  users.f_id = faculty.f_id
                                AND users.u_id = '" . $row['u_id'] . "';";

                                                        $result1 = $conn->query($sql3);
                                                        if ($result1->num_rows > 0) {
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                ?>
                                                                <?php if (empty($row1['university'])): ?>
                                                                    <div class="field">
                                                                        <label>Student Code:</label>
                                                                        <?php echo $row1['s_code']; ?>
                                                                    </div>
                                                                    <div class="field">
                                                                        <label>Faculty:</label>
                                                                        <?php echo $row1['f_name']; ?>
                                                                    </div>
                                                                <?php endif;


                                                            }
                                                        } ?>
                                                        <!--  -->
                                                    

                                                    <?php if (!empty($row['university'])): ?>
                                                        <div class="field"><label>University:</label>
                                                            <?php echo $row['university']; ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if (!empty($row['faculty_outside'])): ?>
                                                        <label>Faculty:</label>
                                                        <?php echo $row['faculty_outside']; ?>
                                                    <?php endif; ?>

<!--  -->
                                                    <div class="field">
                                                        <label>Email:</label>
                                                        <?php echo $row['email']; ?>
                                                    </div>
                                                    <div class="field">
                                                        <label>Phone:</label>
                                                        <?php echo $row['phone']; ?>
                                                    </div>
                                                    <div class="field">
                                                        <label>Begin Date:</label>
                                                        <a style="color: blue;">
                                                            <?php echo $row['begin_date']; ?>
                                                        </a>
                                                    </div>

                                                    <?php if (isset($row['end_date']) && !empty($row['end_date'])): ?>
                                                        <div class="field">
                                                            <label>End Date:</label>
                                                            <a style="color: red;">
                                                                <?php echo $row['end_date']; ?>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="field">
                                                        <label>Status:</label>
                                                        <?php
                                                        $status = $row['status'];
                                                        $textColor = ($status == 'ประเมินไม่ผ่าน') ? 'color: red;' :
                                                            (($status == 'ประเมินผ่าน') ? 'color: green;' : 'color: blue;');
                                                        ?>
                                                        <a style="<?= $textColor; ?>">
                                                            <?php echo $status; ?>
                                                        </a>
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
               
            
        
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- End สถานะการฝึกงาน -->