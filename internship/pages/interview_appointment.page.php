<?php
// เชื่อมต่อกับฐานข้อมูล
$db = new ConnectDb();
$conn = $db->getConn();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$u_id = $_SESSION['internship_user_id'];

// สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
$sql = "SELECT respond.*, job_description.*, faculty.*, type_of_work.*
        FROM respond
        JOIN s_selected ON s_selected.selected_id = respond.selected_id
        JOIN job_description ON job_description.w_id = s_selected.w_id
        JOIN faculty ON faculty.f_id = s_selected.f_id
        JOIN type_of_work ON job_description.type_id = type_of_work.type_id
        WHERE s_selected.u_id = '$u_id'";



$rs = $conn->query($sql);
if ($rs && $rs->num_rows > 0) {
    while ($data = $rs->fetch_array(MYSQLI_BOTH)) {
?>
        <!-- ... -->

        <!-- interview card -->
        <div class="container p-4">
            <div class="row gy-1">
<div class="card mb-3">
    <div class="card-header">
        <h1 class="fs-5">นัดหมายสัมภาษณ์</h1>
    </div>
    <div class="card-body">
        <p>จากคณะ: <?= $data['f_name']; ?></p>
        <p>ตำแหน่ง: <?= $data['type_name']; ?></p>
        <p>วันที่: <?= $data['date']; ?></p>
        <p>สถานที่นัดหมาย: <?= $data['location']; ?></p>
        <p>เบอร์โทร: <?= $data['Phone']; ?></p>
        <p>หมายเหตุ: <?= $data['notes']; ?></p>
        <!-- <p>selected_id: <?= $data['selected_id']; ?></p> -->
    </div>
</div>
</div>
</div>
<!-- End interview card -->

        <!-- End interview card -->
<?php
    }
} else {
    echo "<script>";
    echo "alert('No user found.')";
    echo $conn->error;
}
?>
