<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid ">
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
            <a class="nav-link active" aria-current="page" href="?page=dashboard">
            <i class="bi bi-clipboard-data-fill"></i>
            Dashboard</a>
          </li>

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="reg/reg.p.php">
            <i class="bi bi-person-fill-add"></i>
            Register profes</a>
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


<ul class="nav">
          <!--  -->
          <li class="nav-item">                                   
          <li><hr class="dropdown-divider"></li>
    <?php
    if (isset($_SESSION['internship_user_id'])) {
      echo '<li><a class="btn btn-dark" href="?page=logout"><i class="bi bi-person-slash"></i> ออกจากระบบ</a></li>';
    } else {
      echo '<li><a class="btn btn-dark" href="?page=login"><i class="bi bi-person-circle"></i> เข้าสู่ระบบ</a></li>';
    }
    ?>
    </li>
    </li>
        </ul>
      </div>
    </div>
</nav>