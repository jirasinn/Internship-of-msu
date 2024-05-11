<?php
          $u_id = $_SESSION['internship_user_id'];
          $f_id = $_SESSION['internship_user_f_id'];
          $name = $_SESSION['internship_user_name'];
          $image = $_SESSION['internship_user_image'];
          ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <div class="col-md-12">
      <a class="navbar-brand mb-0 h1" href="?page=1">INTERNSHIP OF MSU <img src="images/msu_icon.png" width="2%"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown"
        aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="?page=1">
              <i class="bi bi-house-door"></i>
              หน้าหลัก</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?page=faculty">คณะ</a>
          </li>
          <!--  -->
          <!--  -->
          <?php
          $db = new ConnectDb();
          $conn = $db->getConn();
          $sql = "SELECT * FROM faculty";
          $query = mysqli_query($conn, $sql);
          ?>
           <form>
            <div class="form-row">
              <select name="faculty_id" id="faculty" class="form-control">



              <option value="0">เลือกคณะ</option>
                <?php while ($result = mysqli_fetch_assoc($query)): ?>
                  <option 
                    value="<?=$result['f_id']?>" 
                    
                    <?= isset($_GET["id"]) &&$_GET["id"]==$result['f_id']?"selected":"" ?>
                    ><?= $result['f_name'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </form>

         <script>
    document.getElementById('faculty').addEventListener('change', function () {
    var selectedOption = this.options[this.selectedIndex];
    var selectedValue = selectedOption.value;
    var selectedText = selectedOption.textContent;
    var newPageUrl = '?page=f_profile&id=' + encodeURIComponent(selectedValue);

    console.log('Selected Faculty: ' + selectedText);

    if (selectedValue === '') {
        selectedText = 'เลือกคณะ';
    }

    if (selectedValue !== '0') {
        newPageUrl = '?page=f_profile&id=' + encodeURIComponent(selectedValue);
        window.location.href = newPageUrl;
    }
});

</script>
          <!--  -->
          </ul>

          <!--  -->
<ul class="nav">

<!-- Dropdown -->
<li class="nav-item">
<div class="dropdown text-end">
  <a href="#" class="d-block text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">

  <?php if (isset($image)): ?>
                                    <img src="images/<?php echo $image; ?>" alt="mdo" width="32" height="32" class="rounded-circle">
                                <?php else: ?>
                                    <img src="images/no_image.png" alt="mdo" width="32" height="32" class="rounded-circle">
                                <?php endif; ?>
  
  </i>Professor <?= $name; ?>
  </a>
  <ul class="dropdown-menu text-small">

          <li><a class="dropdown-item" href="?page=s_profile&id=<?= $u_id; ?>">
          <i class="bi bi-person-circle"></i> Profile</a></li>
          <hr class="dropdown-divider">

          

            <li><a class="dropdown-item" href="?page=p_respond">
            <i class="bi bi-person-plus"></i> รอการตอบกลับ</a></li>

            <li><a class="dropdown-item" href="?page=p_accepted">
            <i class="bi bi-person-check"></i> รับแล้ว</a></li>
            <hr class="dropdown-divider">

            <li><a class="dropdown-item" href="?page=f_profile&id=<?= $f_id; ?>">
            <i class="bi bi-houses-fill"></i> Fac Profile</a></li>

            <li><a class="dropdown-item" href="?page=insert">
            <i class="bi bi-box-arrow-in-up"></i> ประกาศงาน</a></li>

            <hr class="dropdown-divider">
    <?php
    if (isset($_SESSION['internship_user_id'])) {
      echo '<li><a class="dropdown-item" href="?page=logout"><i class="bi bi-person-slash"></i>ออกจากระบบ</a></li>';
    } else {
      echo '<li><a class="dropdown-item" href="?page=login"><i class="bi bi-person-circle"></i>เข้าสู่ระบบ</a></li>';
    }
    ?>
    </li>
  </ul>
</div>

<script>
// เพิ่มการเปิด/ปิดสถานะของ dropdown เมื่อคลิกที่ลูกศร dropdown
document.addEventListener('DOMContentLoaded', function() {
  var dropdownToggle = document.querySelector('.dropdown-toggle');
  var dropdownMenu = document.querySelector('.dropdown-menu');

  dropdownToggle.addEventListener('click', function() {
    var isOpen = dropdownMenu.classList.contains('show');
    if (isOpen) {
      dropdownMenu.classList.remove('show');
    } else {
      dropdownMenu.classList.add('show');
    }
  });
});
</script>


<!-- ...โค้ดอื่น ๆ... -->

    </div>
</nav>