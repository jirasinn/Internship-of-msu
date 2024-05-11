    <?php
// ดึงค่า ID ที่ส่งมาจากการคลิก
if (isset($_GET['id'])) {
    $selectedId = $_GET['id'];
} else {
    // ถ้าไม่มี ID ที่ส่งมา ให้กำหนดค่าเริ่มต้นเป็น 0 หรือค่าอื่นๆ ที่เหมาะสม
    $selectedId = 0;
}
$db = new ConnectDb();
$conn = $db->getConn();
$sql = "SELECT type_of_work.type_name
        FROM type_of_work
        WHERE type_id = " . $selectedId;
        $rs = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($rs);
        ?>
<!--  -->
    <!-- -->
    <div class="container p-3">
        <div class="row gy-1">
            <div class="row g-3">
                <div class="col-md-9">

                        <div class="pb-3 mb-4  border-bottom">
                            <h3 class="animate-charcter1 bi bi-megaphone">
                                ประเภทงาน <?= $data['type_name']; ?>
                        </div>
                
                    <!--  -->
                    <?php
          $db = new ConnectDb();
          $conn = $db->getConn();

          $sql = "SELECT job_description.*, faculty.f_name, type_of_work.type_name
        FROM job_description
        JOIN faculty ON job_description.f_id = faculty.f_id
        JOIN type_of_work ON job_description.type_id = type_of_work.type_id
        WHERE (job_description.type_id >= 25 AND '" . $selectedId . "' >= 25) OR (job_description.type_id = '" . $selectedId . "' AND '" . $selectedId . "' < 25)
        ORDER BY job_description.d_date DESC";

  



          $rs = mysqli_query($conn, $sql);
          $i = 0;
          while ($data = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
            $i++;
            if ($i > 0) {
              echo "<div class='row' align='center' style='width:100%;'>";
            }
            if ($i == 10) {
              break;
            }
            ?>

                    <!-- CARD -->
                    <div class="card mb-3" style="max-width: 950px;">
                        <div class="row g-0" align='Left'>
                            <div class="col-md-2">
                                <img src="images/no_image.png" width="100%">
                            </div>
                            <div class="col-md-10">
                                <div class="card-body">

                                    <h5><strong class="card-title"> <?=$data['title'];?></strong></h5>

                                    <p><strong class="card-text" id="card_faculty">
                                            <?= $data['f_name']; ?>
                                        </strong></p>
                                    <p><strong class="card-text" id="card_detail">รายละเอียด: </strong>
                                        <?= $data['detail']; ?>
                                    </p>
                                    <p><strong class="card-text" id="card_position">ตำแหน่ง: </strong>
                                        <?= $data['type_name']; ?>
                                    </p>
                                    <p><strong class="card-text" id="card_quantity">จำนวน: </strong>
                                        <?= $data['quantity']; ?>
                                    </p>

                                    <?php
                                            if (!isset($_SESSION['internship_user_type']) || $_SESSION['internship_user_type'] !== 'professor') {
                                                // ถ้าไม่มี session หรือ session ไม่เป็น 'professor'
                                                ?>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group">
                                                    <p><a href="?page=job_description&id=<?= $data['w_id']; ?>" button
                                                        type="button"
                                                        class="btn btn-sm btn-outline-warning">สมัครงานนี้</button></a></p>
                                                </div>
                                                </div>
                                                <?php
                                            } 
                                            ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 ">
                                                <div class="card-footer text-muted text-end">
                                                ประกาศเมื่อ: <?= $data['d_date']; ?>
                                                </div>
                                            </div>

                    </div>
                </div>
                <?php } ?>
                <!-- END CARD -->
                <br>
            </div>

            <div class="col-md-3">
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
        </div></div>
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

