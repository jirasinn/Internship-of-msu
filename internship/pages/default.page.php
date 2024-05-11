<!-- รูปหน้าหลัก -->

<!-- <img src="https://multisite2.msu.ac.th/wp-content/uploads/2020/10/1920x580_s3.jpg" class="img-fluid"> -->
<style>
    .clock {
        display: block;
        padding: 10px;
        visibility: visible;
        border-radius: 10px;
        clear: both;
        float: right;
        font-size: 45px;
        margin-top: 50px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        font-family: "Digital", sans-serif;
        padding: 20px;
        border-radius: 20px;
        color: wheat;
    }

    .watch-back {
        position: relative;
        display: inline-block;
        background-image: url('images/titlepage.jpg');
        background-size: cover;
        width: 100%;
        padding-bottom: 20.25%;
    }

    .text-center {
        position: absolute;
        color: white;
        font-size: 50px;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }
</style>

<div class="watch-back">
    <div class="clock" id="clock"></div>
</div>
<script>
    function updateClock() {
        let now = new Date();
        let hours = String(now.getHours()).padStart(2, '0');
        let minutes = String(now.getMinutes()).padStart(2, '0');
        let seconds = String(now.getSeconds()).padStart(2, '0');
        let time = `${hours}:${minutes}:${seconds}`;

        let amPm = now.getHours() >= 12 ? 'PM' : 'AM';

        // Append the AM/PM value to the time
        time += ` ${amPm}`;

        document.getElementById('clock').textContent = time;
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>
<!--  -->

<div class="text-center">
    <div class="waviy">
        <span style="--i:1"><b>ยิ</b></span>
        <span style="--i:2"><b>น</b></span>
        <span style="--i:3"><b>ดี</b></span>
        <span style="--i:4"><b>ต้</b></span>
        <span style="--i:5"><b>อ</b></span>
        <span style="--i:6"><b>น</b></span>
        <span style="--i:7"><b>รั</b></span>
        <span style="--i:8"><b>บ</b></span>
        <span style="--i:1"><b>สู่</b></span>
        <span style="--i:2"><b>เ</b></span>
        <span style="--i:3"><b>ว็</b></span>
        <span style="--i:4"><b>บ</b></span>
        <span style="--i:5"><b>ไ</b></span>
        <span style="--i:6"><b>ซ</b></span>
        <span style="--i:7"><b>ต์</b></span>
    </div>
    <p style="color: whith;"><b>INTERNSHIP OF</b><a style="color: yellow;"><b> MSU</b> <img src="images/msu_icon.png"
                width="15%"></a></p>
</div>
<br><br><br><br>
<!--  -->

    <!-- ข้อมูลเเต่ละคณะ -->
    <br><br><br>
    <div class="container" align='center'>

        <div class="col-md-12">
            <div class="row">

                <?php
                // $db = new ConnectDb();
// $conn = $db->getConn();
                
                // $sql = "SELECT * FROM faculty";
// $result = mysqli_query($conn, $sql);
                
                // while ($row = mysqli_fetch_assoc($result)) {
//   echo '<div class="row">';
//   for ($i = 0; $i < 4; $i++) {
//       if ($row = mysqli_fetch_assoc($result)) {
//           $image = $row['img'];
//           $base64 = base64_encode($image);
                
                //       }
//     }
                
                ?>
                <!-- 
    <div id="carouselExampleIndicators" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="../images/<?= $base64['f_id']; ?>.jpg" class="card-img-top" alt="..." height="130">
    </div>
    <div class="card-body">
          <p class="card-text"><?= $row['f_name']; ?></p>
          <div class="btn-group">
                      <a href="" button type="button"
                        class="btn btn-sm btn-outline-warning">เยี่ยมชม</button></a>
                    </div>
        </div>

  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div> -->
                <!--  -->
                <br>
                <!-- Fac -->
                <hr>

                <style>
                    .card-body8 a {
                        color: inherit;
                        /* ให้ลิงค์มีสีเหมือนกับข้อความปกติ */
                        text-decoration: none;
                        /* ไม่มีขีดเส้นใต้ข้อความลิงค์ */
                    }

                    .card-body8 a:hover {
                        text-decoration: underline;
                        /* ขีดเส้นใต้ข้อความลิงค์เมื่อ hover */
                    }
                </style>


                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide-to="0" class="active" aria-current="true"
                                        aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide-to="2" aria-label="Slide 3"></button>

                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row">

                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=1">
                                                        <img src="images/1.jpg" height="140" class="d-block w-100"
                                                            alt="">
                                                        <p class="card-text">คณะมนุษยศาสตร์และสังคมศาสตร์</p>
                                                    </a>
                                                </div>

                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=2">
                                                        <img src="images/2.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะวิทยาศาสตร์</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=3">
                                                        <img src="images/3.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะวิศวกรรมศาสตร์</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=4">
                                                        <img src="images/4.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะพยาบาลศาสตร์</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=5">
                                                        <img src="images/5.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะศึกษาศาสตร์</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=6">
                                                        <img src="images/6.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะเภสัชศาสตร์</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=7">
                                                        <img src="images/7.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะเทคโนโลยี</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=8">
                                                        <img src="images/8.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะการบัญชีเเละการจัดการ</p>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Add new slide -->
                                    <div class="carousel-item">
                                        <div class="row">

                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=9">
                                                        <img src="images/9.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะการท่องเที่ยวและการโรงแรม</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=10">
                                                        <img src="images/10.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะสถาปัตยกรรมศาสตร์</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=11">
                                                        <img src="images/11.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะวิทยาการสารสนเทศ</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=12">
                                                        <img src="images/12.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">วิทยาลัยการเมืองการปกครอง</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=13">
                                                        <img src="images/13.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะสาธารณสุขศาสตร์</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=14">
                                                        <img src="images/14.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะแพทยศาสตร์</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=15">
                                                        <img src="images/15.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะสิ่งแวดล้อมและทรัพยากรศาสตร์</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=16">
                                                        <img src="images/16.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะดุริยางคศิลป์</p>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="carousel-item">
                                        <div class="row">

                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=17">
                                                        <img src="images/17.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะสัตวแพทยศาสตร์</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=18">
                                                        <img src="images/18.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะนิติศาสตร์</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=19">
                                                        <img src="images/19.jpg" height="140" class="d-block w-100"
                                                            alt="...">
                                                        <p class="card-text">คณะศิลปกรรมศาสตร์และวัฒนธรรมศาสตร์</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=20">
                                                        <img src="images/สำนักวิทยบริการ.jpg" height="140"
                                                            class="d-block w-100" alt="...">
                                                        <p class="card-text">สำนักวิทยบริการ</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-3" style="width: 20rem;">
                                                <div class="card-body8">
                                                    <a href="?page=f_profile&id=21">
                                                        <img src="images/สำนักคอม.jpg" height="140"
                                                            class="d-block w-100" alt="...">
                                                        <p class="card-text">สำนักคอมพิวเตอร์</p>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">ก่อนหน้า</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">ถัดไป</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <!--  -->
            </div>
        </div>
        <!--  -->


        <!--  -->
        <br>
        <hr>

        <div id="content-container" class="row g-2">
            <div class="col-md-9">

                <div class="pb-3 mb-4 border-bottom">
                    <h3 class="animate-charcter1 bi bi-megaphone">ประกาศล่าสุด</h3> 
                </div>
                <?php
                $db = new ConnectDb();
                $conn = $db->getConn();

                $itemsPerPage = 5;

                // รับค่าหน้าปัจจุบันจากพารามิเตอร์ใน URL
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                // ประกาศตัวแปร $offset และตรวจสอบว่ามีค่าถูกต้องหรือไม่
                $offset = ($page - 1) * $itemsPerPage;

                // ปรับเปลี่ยนคำสั่ง SQL เพื่อรวม LIMIT และ OFFSET
                $sql = "SELECT job_description.*, faculty.f_name, type_of_work.type_name
        FROM job_description
        JOIN faculty ON job_description.f_id = faculty.f_id
        JOIN type_of_work ON job_description.type_id = type_of_work.type_id
        ORDER BY job_description.d_date DESC";

                $rs = mysqli_query($conn, $sql);
                if ($rs) {
                    // ส่วนที่เหลือของโค้ดเดิมคงเดิม
                    $i = 0;
                    $cardsToShow = array();

                    while ($data = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
                        $i++;
                        if ($i > $offset && $i <= $offset + $itemsPerPage) {
                            $cardsToShow[] = $data;  // เก็บข้อมูล card ที่ต้องการแสดง
                        }
                    }
                    foreach ($cardsToShow as $data) {
                        echo "<div class='row' align='center' style='width:100%;'>";
                        ?>
                        <!-- CARD -->
                        <div class="card mb-3" style="max-width: 950px;">
                            <div class="row g-0" align='Left'>
                                <div class="col-md-2">
                                    <img src="images/no_image.png" width="100%">
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body">

                                        <h5><strong class="card-title">
                                                <?= $data['title']; ?>
                                            </strong></h5>

                                        <p><strong class="card-text" id="card_faculty">
                                                <?= $data['f_name']; ?>
                                            </strong></p>
                                        <p><strong class="card-text" id="card_detail">รายละเอียด: </strong>
                                            <?= $data['detail']; ?>
                                        </p>
                                        <p><strong class="card-text" id="card_position">ตำแหน่ง: </strong>
                                            <?= $data['type_name']; ?>
                                        </p>
                                        <p><strong class="card-text" id="card_quantity">จำนวนที่รับ: </strong>
                                            <?= $data['quantity']; ?> (อัตรา)
                                        </p>
                                        <p><strong class="card-text" id="card_quantity"  style="font-size: 12px;">ช่วงระยะเวลาฝึกงาน: 
                                            <?= $data['internship_period']; ?></strong>
                                        </p>
                                        <p><strong class="card-text" id="card_quantity"  style="font-size: 12px;">ประกาศรับสมัครถึง: 
                                            <?= $data['post_period']; ?></strong>
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

                                        <?php
                                        if (!isset($_SESSION['internship_user_type']) || $_SESSION['internship_user_type'] !== 'professor') {
                                            // ถ้าไม่มี session หรือ session ไม่เป็น 'professor'
                                            ?>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <div class="btn-group">
                                                    <p><a href="?page=job_description&id=<?= $data['w_id']; ?>" button type="button"
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
                                    ประกาศเมื่อ:
                                    <?= $data['d_date']; ?>
                                </div>
                            </div>

                        </div>

                        <?php echo "</div>";
                    }
                }
                $totalPages = isset($rs) ? ceil($i / $itemsPerPage) : 0; ?>

                <!-- END CARD -->
                <br>
                <!--  -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?= $page - 1; ?>">ก่อนหน้า</a>
                        </li>
                        <?php for ($pageNum = 1; $pageNum <= $totalPages; $pageNum++): ?>
                            <li class="page-item <?php echo ($pageNum == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $pageNum; ?>">
                                    <?= $pageNum; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?= $page + 1; ?>">ถัดไป</a>
                        </li>
                    </ul>
                </nav>
                <!-- กรอบขวา -->
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
    </div>
<!--  -->


<!-- เพิ่มส่วนนี้ในตำแหน่งที่คุณต้องการให้แสดง -->
<br><br><br><br><br>
<hr><br>


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
        background-color: #333;
        /* สีเทาเข้ม */
        color: white;
        /* สีข้อความ */
        padding: 30px;
        /* ระยะห่างขอบ */
        text-align: right;
        /* จัดข้อความตรงกลาง */
        width: 100%;
    }

    .social-icons ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: right;
        gap: 10px;
        /* ระยะห่างระหว่างไอคอน */
    }

    .social-icons li {
        display: inline-block;
    }
</style>