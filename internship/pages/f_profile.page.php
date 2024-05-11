<?php
// ดึงค่า ID ที่ส่งมาจากการคลิก
if (isset($_GET['id'])) {
    $selectedId = $_GET['id'];
} else {
    // ถ้าไม่มี ID ที่ส่งมา ให้กำหนดค่าเริ่มต้นเป็น 0 หรือค่าอื่นๆ ที่เหมาะสม
    $selectedId = 0;
}

$sql = "SELECT * FROM faculty WHERE f_id = " . $selectedId;
$i = 0;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // ดึงข้อมูลงานจากตาราง job_description
        $jobSql = "SELECT * FROM job_description WHERE f_id = " . $selectedId;
        $jobResult = $conn->query($jobSql);
        if ($jobResult->num_rows >= 0) {
            $jobRow = $jobResult->fetch_assoc();
            ?>


<div class="container p-1" align='center'>
<div class="row">
                    <div class="col-md-10" align='left'>
                        <main class="container">
                            <div class="p-4 p-md-5 mb-4 text-bg-dark profile-section">
                                <div class="col-md-12 px-0">
                                        <!--  -->

                                        <?php
if (isset($_SESSION['internship_user_type']) && $_SESSION['internship_user_type'] === 'admin'):
?>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <div class="btn-group">
            <a>
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit_f_profile<?= $selectedId ?>">แก้ไขข้อมูลคณะ</button>
            </a>
        </div>
    </div>
<?php endif; ?>


    <!--  -->
                                    <div class="col-md-2">
                                        <img src="images/msu_icon.png" width="100%">
                                    </div>
                                    <h1 class="display-5 profile-name">
                                        <small>
                                            <?= $row['f_name']; ?>
                                        </small>
                                    </h1>
                                    <p class="lead my-3 profile-detail">
                                        <small>
                                            <?= $row['f_detail']; ?>
                                        </small>
                                    </p>
                                    <hr>
                                    <p class="lead my-3 profile-detail">สวัสดิการ:
                                        <small>
                                            <?= $row['f_welfare']; ?>
                                        </small>
                                    </p>
                                    <p class="lead my-3 profile-detail">
                                        <small>
                                            <?= $row['f_location']; ?>
                                        </small>
                                    </p>
                                    <p class="lead my-3 profile-detail">
                                        <small>
                                            <?= $row['f_contact']; ?>
                                        </small>
                                    </p>

                                    <br>
                                    <hr>
                                    <h5 class="fst">เเผนที่รถราง MSU</h5>
                                    <img src="images/แผนที่รถราง.jpg" class="img-fluid" width="100%" height="auto">
                                    <hr><br>
                                </div>

                                <!--  -->
                                <hr>
                                <div class="container" align='center'>
                                    <h5 class="animate-charcter1 bi bi-megaphone fst"> งานที่ประกาศรับ</h5>
                                </div>
                                <hr>

                                <!--  -->

    

                                <?php
                                $jobSql = "SELECT * FROM job_description 
                      JOIN type_of_work ON job_description.type_id = type_of_work.type_id
                      WHERE f_id = " . $selectedId . " ORDER BY d_date DESC";
                      
                                $jobResult = $conn->query($jobSql);
                                if ($jobResult->num_rows > 0) {
                                    while ($jobRow = $jobResult->fetch_assoc()) {
                                        ?>

                                        <div class="card mb-3" style="max-width: 950px;">
                                            <div class="card-body" align='left'>
                                                <h5><strong class="card-title">
                                                        <?= $jobRow['title']; ?>
                                                    </strong></h5>
                                                <p><strong class="card-text" id="card_detail">รายละเอียด: </strong>
                                                    <?= $jobRow['detail']; ?>
                                                </p>
                                                <p><strong class="card-text" id="card_type_work">ตำแหน่ง:
                                                    </strong>
                                                    <?= $jobRow['type_name']; ?>
                                                </p>
                                                <p><strong class="card-text" id="card_quantity">จำนวน: </strong>
                                                    <?= $jobRow['quantity']; ?>
                                                </p>

                                                <p><strong class="card-text" id="card_quantity"  style="font-size: 12px;">ช่วงระยะเวลาฝึกงาน: 
                                            <?= $jobRow['internship_period']; ?></strong>
                                        </p>
                                        <p><strong class="card-text" id="card_quantity"  style="font-size: 12px;">ประกาศรับสมัครถึง: 
                                            <?= $jobRow['post_period']; ?></strong>
                                        </p>

<p>
                                        <h6 class="d-grid gap-2 d-md-flex justify-content-md-end" id="card_quantity">
                                            จำนวนผู้สมัครปัจจุบัน:
                                            <?php
                                            $w_id = $jobRow['w_id']; // เอา w_id ของงานนี้
                                            $countSql = "SELECT COUNT(*) AS total_applicants FROM s_selected WHERE w_id = $w_id";
                                            $countResult = mysqli_query($conn, $countSql);

                                            if ($countResult) {
                                                $countjobRow = mysqli_fetch_assoc($countResult);
                                                echo $countjobRow['total_applicants']; // แสดงจำนวนผู้สมัคร
                                            } else {
                                                echo "0"; // หรือแสดง 0 ถ้าไม่มีข้อมูล
                                            }
                                            ?>
                                        </h6>
                                        </p>

                                                <!--  -->
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <?php 
                                            if (!isset($_SESSION['internship_user_type']) || $_SESSION['internship_user_type'] !== 'professor') {
                                                // ถ้าไม่มี session หรือ session ไม่เป็น 'professor'
                                            ?>
                                                <div class="btn-group">
                                                    <p><a href="?page=job_description&id=<?= $jobRow['w_id']; ?>" button type="button" 
                                                    class="btn btn-sm btn-warning">สมัครงานนี้</button></a></p>
                                                </div>
                                            <?php 
                                            } elseif ($_SESSION['internship_user_type'] === 'professor' && $f_id === $selectedId) {
                                                // ถ้า session เป็น 'professor' และ $f_id เท่ากับ $selectedId
                                            ?>
                                                <p><a href="?page=job_description&id=<?= $jobRow['w_id']; ?>" button type="button"
                                                    class="btn btn-sm btn-warning">ดูรายละเอียดงานนี้</button></a></p>
                                            <?php 
                                            } 
                                            ?>
                                        </div>
<!--  -->
                                            <div class="col-md-12 ">
                                            <div class="card-footer text-muted text-end">
                                                ประกาศเมื่อ: <?= $jobRow['d_date']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo "<p>ไม่มีประกาศรับสมัครงาน</p>";
                                }

        }
    }
} else {
    echo "ไม่พบข้อมูลที่ตรงกับ ID: " . $selectedId;
}
?>
                    <!--  -->
            </main>
            </div>
        

        <!-- กรอบขวา -->
        <div class="col-md-2">
                    <div class="position-sticky" style="top: 2rem;">
                    <div class="p-4 mb-3 bg-body-tertiary rounded">
                        <h4 class="animate-charcter1 fst">About</h4>
                        <p class="mb-0">เว็บหาที่ฝึกงาน ที่มอบประสบการณ์และโอกาสให้นักศึกษาฝึกงาน
                            และนักศึกษาจบใหม่กับหน่วยงานภายในมหาวิทยาลัยมหาสารคาม</p>
                    </div>
                        <!--  -->
                        <?php
                        $db = new ConnectDb();
                        $conn = $db->getConn();
                        $sql = "SELECT * FROM faculty";
                        $query = mysqli_query($conn, $sql);
                        ?>
                        <!--  -->
                        <div class="p-4">
                            <h4 class="animate-charcter1 fst">FACULTY</h4>
                            <ol class="list-unstyled mb-0" align='left'>
                                <?php while ($result = mysqli_fetch_assoc($query)): ?>
                                    <li>
                                        <a class="text-dark" href="?page=f_profile&id=<?= $result['f_id'] ?>">
                                            <?= $result['f_name'] ?>,
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ol>
                        </div>
                        <!--  -->

                        <!--  -->
                        <?php
                        $db = new ConnectDb();
                        $conn = $db->getConn();
                        $sql = "SELECT * FROM type_of_work WHERE type_id <= 25";

                        $query = mysqli_query($conn, $sql);
                        ?>
                        <!-- ประเภทงาน  -->
                        <div class="p-4">
                            <h4 class="animate-charcter1 fst">Type of work</h4>
                            <ol class="list-unstyled mb-0" align='left'>
                                <?php while ($result = mysqli_fetch_assoc($query)): ?>
                                    <li>
                                        <a class="text-dark" href="?page=type_of_work&id=<?= $result['type_id'] ?>">
                                            <?= $result['type_name'] ?>,
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ol>
                        </div>
                        <!--  -->

                            </div>
                        </div>
                    </div>
                </div>
           
            <!-- buttom -->

<br><br><br><br><hr><br>


<div class="contact-section">
    <h4 class="text">Contact</h4>
    <div class="social-icons">
        <ul>
            <li>
                <a class="btn btn-white" href="?page=login">
                    <i class="text-white bi bi-facebook"> Facebook</i>
                </a>
            </li>
            <li>
                <a class="btn btn-white" href="?page=login">
                    <i class="text-white bi bi-line"> Line</i>
                </a>
            </li>
            <li>
                <a class="btn btn-white" href="?page=login">
                    <i class="text-white bi bi-github"> Github</i>
                </a>
            </li>
            <li>
                <a class="btn btn-white" href="?page=login">
                    <i class="text-white bi bi-envelope-exclamation"> Email</i>
                </a>
            </li>
        </ul>
    </div>
</div>

<style>
    .contact-section {
        background-color: #333; /* สีเทาเข้ม */
        color: white; /* สีข้อความ */
        padding: 30px; /* ระยะห่างขอบ */
        text-align: right; /* จัดข้อความตรงกลาง */
        width: 100%;
    }

    .social-icons ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: right;
        gap: 10px; /* ระยะห่างระหว่างไอคอน */
    }

    .social-icons li {
        display: inline-block;
    }
</style>


<!-- Edit f_profile modal -->
<div class="modal fade" id="edit_f_profile<?= $selectedId ?>" tabindex="-1" aria-labelledby="sendLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="sendLabel">แก้ไขข้อมูลคณะ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- from -->
                <div class="container p-4">
                    <div class="row gy-5">
                        <!--  -->
                        <?php

                        $sql = "SELECT * FROM faculty
                        where f_id = '$selectedId'";
                        $rs = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_array($rs);
                        ?>

                        <!--  -->
                        <div class="container">
                            <form action="crud/edit_f_profile.php" method="post" enctype="multipart/form-data">
                                <!--  -->
                                <input type="hidden" name="id" value="<?= $selectedId ?>">
                                <div class="mb-3">
                                    <label class="form-label">ชื่อคณะ</label>
                                    <input class="form-control" type="text" placeholder="ชื่อคณะ" name="f_name"
                                        value="<?= $data['f_name'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">รายละเอียด</label>
                                    <textarea class="form-control" placeholder="รายละเอียด" name="f_detail" 
                                    rows="7"><?= $data['f_detail'] ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">สวัสดิการ</label>
                                    <input class="form-control" type="text" placeholder="สวัสดิการ" name="f_welfare"
                                        value="<?= $data['f_welfare'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ที่ตั้ง</label>
                                    <textarea class="form-control" placeholder="ที่ตั้ง" name="f_location"
                                        rows="4"><?= $data['f_location'] ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ติดต่อ</label>
                                    <textarea class="form-control" placeholder="ติดต่อ" name="f_contact"
                                    rows="6"><?= $data['f_contact'] ?></textarea>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="upload" class="btn btn-warning">Edit</button>

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
<!-- End Edit f_profile modal  -->
