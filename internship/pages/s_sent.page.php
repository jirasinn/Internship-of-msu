<div class='row' align='center' style='width:100%;'>
<h3 class="animate-charcter1 bi bi-incognito col-md-12 pb-3 mb-4 py-5 border-bottom">
      งานที่สมัคร
    </h3>
</div>

<?php
$db = new ConnectDb();
$conn = $db->getConn();
          
$u_id = $_SESSION['internship_user_id'];

$sql = "SELECT s_selected.*, job_description.*, faculty.f_name, type_of_work.*
FROM s_selected 
JOIN job_description ON s_selected.w_id = job_description.w_id
JOIN faculty ON faculty.f_id = job_description.f_id
JOIN type_of_work ON job_description.type_id = type_of_work.type_id
WHERE s_selected.u_id = $u_id
ORDER BY s_selected.s_date DESC";

$rs = mysqli_query($conn, $sql);
$i = 0;

if ($rs) {
  // การค้นหาสำเร็จ
  $numRows = mysqli_num_rows($rs);

  if ($numRows > 0) {

?>

<div class='row' align='center' style='width:100%;'>
    
  <?php
  $i = 0;
  while ($data = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
    $selected_id = $data['selected_id'];
        $hasRespond = $db->checkIfRespondExists($conn, $selected_id);
    $i++;
  ?>

    <!-- CARD -->
    <div class="col-md-12">
      <div class="card mb-3" style="max-width: 1200px;">
        <div class="row g-0" align='left'>
          <div class="col-md-2">
            <img src="images/profile.jpg" width="100%">
          </div>
          <div class="col-md-12">
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
              <p><strong class="card-text" id="card_quantity">จำนวน: </strong>
                <?= $data['quantity']; ?>
              </p>
              <p><strong class="card-text" id="card_quantity"  style="font-size: 12px;">ช่วงระยะเวลาฝึกงาน: 
                                            <?= $data['internship_period']; ?></strong>
                                        </p>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <?php if ($hasRespond) { ?>
                                    <a href="?page=interview_appointment" class="btn btn-warning" >ดูรายละเอียดนัดสัมภาษณ์</a>
                                <?php } ?>
                                
              <div class="btn-group">
              <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#sentModal<?= $data['w_id']; ?>">ยกเลิกการสมัคร</button>
             
              
              </div>


                                </div>

            </div>
          </div>
        </div>

        <div class="col-md-12 ">
                                <div class="card-footer text-muted text-end">
                                    สมัครเมื่อ:
                                    <?= $data['s_date']; ?>
                                </div>
                            </div>

      </div>
    </div>
  <?php
  }
  ?>
</div>
<?php
if ($i === 0) {
  // ไม่พบข้อมูลที่ส่งกลับจากฐานข้อมูล
  echo "ไม่พบงานที่สมัคร";
}
}}
?>
<!--  -->


<?php
$f_id = $_SESSION['internship_user_f_id'];

// สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
$sql = "SELECT s_selected.*, job_description.*, faculty.f_name, type_of_work.*
FROM s_selected 
JOIN job_description ON s_selected.w_id = job_description.w_id
JOIN faculty ON faculty.f_id = job_description.f_id
JOIN type_of_work ON job_description.type_id = type_of_work.type_id
WHERE s_selected.u_id = $u_id
ORDER BY s_selected.s_date DESC";
$rs = $conn->query($sql);
if ($rs && $rs->num_rows > 0) {
    while ($data = $rs->fetch_array(MYSQLI_BOTH)) {
        ?>

        <div class="modal fade" id="sentModal<?= $data['w_id']; ?>" tabindex="-1" aria-labelledby="sentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="sentModalLabel">ยกเลิกการสมัคร</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>
                            <p><b>คุณต้องการยกเลิกการสมัครงานนี้ ใช่หรือไม่??</b></p>
                        </h6>
                        <form action="?page=clear_sent&id=<?= $data['w_id']; ?>" method="POST">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                <button type="submit" class="btn btn-danger">ตกลง</button>
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
    echo "alert('ไม่สามารถยกเลิกการสมัครได้')";
    echo $conn->error;
}
?>