<!-- telegram -->

<?php


if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == TRUE) {
    die(header('Location: pages/s_profile.page.php'));
}

// Place username of your bot here
define('BOT_USERNAME', 'MSUInternBOT');

// if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] === TRUE) {
//     echo "User is logged in.";
// } else {
//     echo "User is not logged in.";
// }

// // ตรวจสอบค่า telegram_id
// if (isset($_SESSION['telegram_id'])) {
//     $telegramId = $_SESSION['telegram_id'];
//     echo "Telegram ID: $telegramId";
// } else {
//     echo "Telegram ID not found in session.";
// }
?>

<?php
// เชื่อมต่อกับฐานข้อมูล
$db = new ConnectDb();
$conn = $db->getConn();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$u_id = $_SESSION['internship_user_id'];
$image = $_SESSION['internship_user_image'];
$resume = $_SESSION['internship_user_resume'];
$f_id = $_SESSION['internship_user_f_id'];
// echo "$image";

// สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
$sql = "SELECT * FROM users 
        LEFT JOIN faculty ON users.f_id = faculty.f_id
        WHERE users.u_id = $u_id";
$result = $conn->query($sql);

if ($result->num_rows >= 0) {
    while ($row = $result->fetch_assoc()) {
        // แสดงข้อมูลผู้ใช้ในรูปแบบการ์ด
        ?>
        <div class="container p-4">
            <div class="row gy-2">
                <div class="card1">

                    <!--  -->
                    <div class="container" align="right">
                        <!-- telegram -->
                        <!-- <button type="" class="btn btn-primary-circle" >
                            <script async src="https://telegram.org/js/telegram-widget.js?22"
                                    data-telegram-login="MSUInternBOT" data-size="large" data-auth-url="libs/auth.php"
                                    data-onauth="onTelegramAuth(user)" data-request-access="write"></script> -->
                        <!-- End telegram -->

                        <!-- ปุ่มแก้ไข -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit_sprofile"
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <!--  -->
                    </div>
                    <br>
                    <!--  -->
                    <div class="row">
                        <div class="col-md-9">

                            <div class="card-details">
                                <h3><i class="bi bi-person-circle"></i> Profile
                                </h3>
                                <div class="field"><label>Name:</label>
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
                                <?php if ($_SESSION['internship_user_type'] === 'student' && !empty($row['university'])): ?>
                                    <div class="field"><label>University:</label>
                                        <?php echo $row['university']; ?>
                                    </div>
                                <?php endif; ?>
                                <!--  -->
                                <div class="field">
                                    <?php if (!empty($row['f_id'])): ?>
                                        <label>Faculty:</label>
                                        <?php echo $row['f_name']; ?>
                                    <?php elseif ($_SESSION['internship_user_type'] === 'student' &&!empty($row['faculty_outside'])): ?>
                                        <label>Faculty:</label>
                                        <?php echo $row['faculty_outside']; ?>
                                    <?php endif; ?>
                                </div>
                                <!--  -->
                                <div class="field"><label>Email:</label>
                                    <?php echo $row['email']; ?>
                                </div>
                                <div class="field"><label>Phone:</label>
                                    <?php echo $row['phone']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card-image">
                                <?php if (!empty($image)): ?>
                                    <img src="images/<?php echo $image; ?>" alt="" width="100px">
                                <?php else: ?>
                                    <img src="images/no_image.png" alt="" width="100px" class="rounded-circle">
                                <?php endif; ?>
                            </div>
                            <br><br>
                            <br><br>
                        </div>

                        <?php
    }
    ?>

                    <?php if ($_SESSION['internship_user_type'] === 'student'): ?>
                        <br><br>
                        <h3><i class="bi bi-person-circle"></i> Resume</h3>
                        <br><br>

                        <div class="container" align='center'>
                            <?php if (!empty($resume)): ?>
                                <img src="images/resume/<?php echo $resume; ?>" alt="" width="100%">
                            <?php else: ?>
                                <p style="color: red;">ยังไม่มี resume ของคุณ</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php
} else {
    echo "No user found.";
}
?>
            </div>
        </div>
    </div>
</div>



<!-- from edit -->
<div class="modal fade" id="edit_sprofile" tabindex="-1" aria-labelledby="sendLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="sendLabel">แก้ไขข้อมูลส่วนตัว</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- from -->
                <div class="container p-4">
                    <div class="row gy-5">
                        <!--  -->
                        <?php

                        $sql = "SELECT * FROM users where u_id = '$u_id'";
                        $rs = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_array($rs);
                        ?>


                        <!--  -->
                        <div class="container">

                            <form action="crud/edit_sprofile.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">อีเมล</label>
                                    <input class="form-control" type="text" placeholder="อีเมล" name="email"
                                        value="<?= $data['email'] ?>">
                                </div>

                                <?php if ($_SESSION['internship_user_type'] === 'student' && empty($data['university'])): ?>
                                    <div class="mb-3">
                                        <label class="form-label">รหัสนิสิต</label>
                                        <input class="form-control" type="text" placeholder="รหัสนิสิต" name="s_code"
                                            value="<?= $data['s_code'] ?>">
                                    </div>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label class="form-label">ชื่อ - นามสกุล</label>
                                    <input class="form-control" type="text" placeholder="ชื่อ - นามสกุล" name="name"
                                        value="<?= $data['name'] ?>">
                                </div>
                                <!--  -->
                                <?php if ($_SESSION['internship_user_type'] === 'student' && !empty($data['university'])): ?>
                                    <div class="mb-3">
                                        <label class="form-label">มหาวิทยาลัย</label>
                                        <input class="form-control" type="text" placeholder="มหาลัย" name="university"
                                            value="<?= $data['university'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">คณะ</label>
                                        <input class="form-control" type="text" placeholder="มหาลัย" name="faculty_outside"
                                            value="<?= $data['faculty_outside'] ?>">
                                    </div>
                                <?php endif; ?>
                                <!--  -->
                                <div class="mb-3">
                                    <label class="form-label">โทรศัพท์</label>
                                    <input class="form-control" type="number" placeholder="โทรศัพท์" name="phone"
                                        value="<?= $data['phone'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">รูป Profile</label>
                                    <input class="form-control" name="file" type="file"
                                        accept="image/gif, image/jpeg, image/png" value="<?= $data['image'] ?>">
                                </div>

                                <?php if ($_SESSION['internship_user_type'] === 'student'): ?>
                                    <div class="mb-3">
                                        <label class="form-label">รูป Resume</label>
                                        <input class="form-control" name="rfile" type="file"
                                            accept="image/gif, image/jpeg, image/png" value="<?= $data['resume'] ?>">
                                    </div>
                                <?php endif; ?>

                                <!--  -->
                                <?php if (empty($data['university'])): ?>
                                    <div class="mb-3">
                                        <label class="form-label">คณะ</label>
                                        <select name="fac" id="fac" required>
                                            <option value="">เลือกคณะ</option>
                                            <?php
                                            $sql = "SELECT * FROM faculty";
                                            $result = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $selected = ($row['f_id'] == $f_id) ? "selected" : "";
                                                echo "<option value='" . $row['f_id'] . "' " . $selected . ">" . $row['f_name'] . "</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                <?php endif; ?>

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
<!--  -->
<!--  -->

<!-- telegram -->
<div class="modal fade" id="telegram_info" tabindex="-1" aria-labelledby="sendLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="sendLabel">TELEGRAM</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- from -->
                <div class="container p-4">
                    <div class="row gy-5">
                        <!--  -->
                        <?php

                        $sql = "SELECT * FROM users where u_id = '$u_id'";
                        $rs = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_array($rs);
                        ?>


                        <!--  -->
                        <div class="container">

                            <form action="?page=logout" method="post" enctype="multipart/form-data">
                                <!-- telegram login widget -->
                                <!-- <script async src="https://telegram.org/js/telegram-widget.js?22"
                                    data-telegram-login="MSUInternBOT" data-size="large" data-auth-url="auth.php"
                                    data-onauth="onTelegramAuth(user)" data-request-access="write"></script> -->
                                <!--  -->

                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">LOGOUT</button>
                            <!-- <button type="submit" name="upload" class="btn btn-warning">Edit</button> -->

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
<!--  -->