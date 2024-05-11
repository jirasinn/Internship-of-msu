<div class="container">
    <!-- chart -->
    <br><br>
    <h4>
        <div class='text'> Chart การรับสมัครนิสิตฝึกงานของนิสิต
    </h4>
    <br><br>

    <canvas id="internChart" width="600" height="200"></canvas>
    <!--  -->

    <?php
    // ดึงข้อมูลจากฐานข้อมูลเพื่อใช้ใน JavaScript  
    $sqlChartData = "SELECT faculty.f_name,
   COUNT(CASE WHEN s_selected.selected_id  THEN 1 END) AS totalInterns,
    COUNT(CASE WHEN accepted.status = 'ประเมินผ่าน' THEN 1 END) AS passedInterns,
    COUNT(CASE WHEN accepted.status = 'ประเมินไม่ผ่าน' THEN 1 END) AS failedInterns,
    COUNT(CASE WHEN accepted.status = 'อยู่ในระหว่างฝึกงาน' THEN 1 END) AS currentInterns
FROM faculty
LEFT JOIN s_selected ON s_selected.f_id = faculty.f_id
LEFT JOIN accepted ON accepted.f_id = faculty.f_id
-- LEFT JOIN users ON users.f_id = s_selected.f_id
GROUP BY faculty.f_name";

$rsChartData = $conn->query($sqlChartData);

$facultyData = array('labels' => array(), 'totalInterns' => array(), 'passedInterns' => array(), 'failedInterns' => array(), 'currentInterns' => array());

while ($rChartData = $rsChartData->fetch_assoc()) {
    $facultyData['labels'][] = $rChartData['f_name'];
    $facultyData['totalInterns'][] = $rChartData['totalInterns'];
    $facultyData['passedInterns'][] = $rChartData['passedInterns'];
    $facultyData['failedInterns'][] = $rChartData['failedInterns'];
    $facultyData['currentInterns'][] = $rChartData['currentInterns'];
}
    ?>


    <!--  -->
    <script>
        // ดึงข้อมูลจาก PHP ไปใช้ใน JavaScript
        var facultyData = <?php echo json_encode($facultyData); ?>;
        try {
            var parsedData = JSON.parse(facultyData);
            console.log(parsedData.labels);
        } catch (error) {
            console.error("Error parsing JSON:", error);
        }


        // สร้างแผนภูมิแท่ง
        var ctx = document.getElementById('internChart').getContext('2d');
        var internChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: facultyData.labels,
                datasets: [{
                    label: 'จำนวนคนที่สมัครทั้งหมด',
                    data: facultyData.totalInterns,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'อยู่ในระหว่างฝึกงาน',
                    data: facultyData.currentInterns,
                    backgroundColor: 'rgba(255, 255, 0, 0.2)',
                    borderColor: 'rgba(255, 255, 0, 1)',
                    borderWidth: 1
                },{
                    label: 'ประเมินผ่าน',
                    data: facultyData.passedInterns,
                    backgroundColor: 'rgba(0, 128, 0, 0.2)',
                    borderColor: 'rgba(0, 128, 0, 1)',
                    borderWidth: 1
                }, {
                    label: 'ประเมินไม่ผ่าน',
                    data: facultyData.failedInterns,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]

            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!--  -->



    <!-- Emd chart -->
    <?php
    // รับค่าจากฟอร์ม
    $filterIntern = isset($_POST['filterIntern']) ? $_POST['filterIntern'] : 'all';
    $facultyFilter = isset($_POST['facultyFilter']) ? $_POST['facultyFilter'] : '0';
    ?>
    <br><br>
    <form method="post" action="">
        <label for="filterIntern">Filter </label>
        <select name="filterIntern" id="filterIntern">
            <option value="all" <?php echo ($filterIntern == 'all') ? 'selected' : ''; ?>>ทั้งหมด</option>
            <option value="onlymsu" <?php echo ($filterIntern == 'onlymsu') ? 'selected' : ''; ?>>นิสิตสังกัด MSU
            <option value="outmsu" <?php echo ($filterIntern == 'outmsu') ? 'selected' : ''; ?>>นิสิตนอกสังกัด MSU
            <option value="intern" <?php echo ($filterIntern == 'intern') ? 'selected' : ''; ?>>นิสิตที่กำลังฝึกงาน
            </option>
        </select>


        <!-- เพิ่มฟอร์มสำหรับเลือกคณะ -->
        <label for="facultyFilter">เลือกคณะ </label>
        <select name="facultyFilter" id="facultyFilter">
            <option value="0">ทั้งหมด </option>
            <?php
            // ดึงข้อมูลคณะจากตาราง faculty
            $facultySql = "SELECT * FROM faculty";
            $facultyResult = $conn->query($facultySql);

            // แสดงตัวเลือกคณะ
            while ($facultyRow = $facultyResult->fetch_assoc()) {
                $selected = ($facultyRow['f_id'] == $_POST['facultyFilter']) ? 'selected' : '';
                echo '<option value="' . $facultyRow['f_id'] . '" ' . $selected . '>' . $facultyRow['f_name'] . '</option>';
            }
            ?>
        </select>


        <button type="submit">กรอง</button>
    </form>

    <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container-fluid ">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-6 mb-lg-4">
                </ul>
                <span class="navbar-text">
                    <!-- <a href="insert.php" class="btn btn-primary" style="color:white;">เพิ่มข้อมูลสินค้า</a>
      <a href="order_detail.php" class="btn btn-danger" style="color:white;">Order</a>
      <a href="member_detail.php" class="btn btn-danger" style="color:white;">Member Board</a> -->
                </span>
            </div>
        </div>
    </nav>

    <?php

    $sql1 = "SELECT * FROM users 
    LEFT JOIN faculty ON users.f_id = faculty.f_id";


    // ตรวจสอบค่าจากฟอร์มเพื่อกรอง
    if ($filterIntern == 'intern') {
        $sql1 .= " WHERE users.u_id IN (SELECT u_id FROM accepted) AND users.urole = 'student'";

        // เพิ่มเงื่อนไขสำหรับคณะ (ถ้ามีการเลือกคณะ)
        if ($facultyFilter != '0') {
            $sql1 .= " AND users.f_id = " . $facultyFilter;
        }

    } elseif ($filterIntern == 'all') {
        $sql1 .= " WHERE users.u_id IS NOT NULL AND users.urole = 'student'";
        // เพิ่มเงื่อนไขสำหรับคณะ (ถ้ามีการเลือกคณะ)
        if (!empty($facultyFilter) && $facultyFilter != '0') {
            $sql1 .= " AND users.f_id = " . $facultyFilter;
        }

    } elseif ($filterIntern == 'onlymsu') {
        $sql1 .= " WHERE users.university IS NULL AND users.urole = 'student'";
// เพิ่มเงื่อนไขสำหรับคณะ (ถ้ามีการเลือกคณะ)
        if (!empty($facultyFilter) && $facultyFilter != '0') {
            $sql1 .= " AND users.f_id = " . $facultyFilter;
        }
    } elseif ($filterIntern == 'outmsu') {
        $sql1 .= " WHERE users.f_id = '0' AND users.urole = 'student'";
// เพิ่มเงื่อนไขสำหรับคณะ (ถ้ามีการเลือกคณะ)
if (!empty($facultyFilter) && $facultyFilter != '0') {
    $sql1 .= " AND users.f_id = " . $facultyFilter;
}
    }
    // $sql1 .= " ORDER BY users.u_id ASC";
    

    // ดึงข้อมูล
    $rs1 = $conn->query($sql1);

    // เริ่มต้นตาราง
    echo '<table class="table">';
    echo '<th scope="col" width=5%>รหัสผู้</th>';
    echo '<th scope="col" width=10%>โปรไฟล์</th>';
    echo '<th scope="col" width=10%>ชื่อ</th>';
    echo '<th scope="col" width=13%>อีเมล</th>';
    echo '<th scope="col" width=15%>มหาลัย</th>';
    echo '<th scope="col" width=15%>คณะ</th>';
    echo '<th scope="col" width=15%>กำลังฝึกงานที่</th>';
    echo '<th scope="col" width=10%>ตำแหน่ง</th>';
    echo '<th scope="col" width=7%>สถานะการฝึก</th>';

    // วนลูปแสดงผล
    if ($rs1->num_rows > 0) {
        while ($r = $rs1->fetch_assoc()) {
            echo "<tr>";
            echo "<th scope='row'>" . $r['u_id'] . "</th>";
            echo "<td><img src='images/" . $r['image'] . "' width='100%'></td>";
            echo "<td>" . $r['name'] . "</td>";
            echo "<td>" . $r['email'] . "</td>";
            echo "<td>" . (!empty($r['university']) ? $r['university'] : "มหาวิทยาลัยมหาสารคาม") . "</td>";
            echo "<td>" . (!empty($r['f_name']) ? $r['f_name'] : $r['faculty_outside']) . "</td>";

            // ดึงข้อมูลจากตาราง accepted
            $sql2 = "SELECT * FROM accepted 

                LEFT JOIN faculty ON accepted.f_id = faculty.f_id
                LEFT JOIN type_of_work ON type_of_work.type_id = accepted.type_id
                WHERE accepted.u_id = " . $r['u_id'] . "";
            $rs2 = $conn->query($sql2);

            if ($rs2->num_rows > 0) {
                while ($r2 = $rs2->fetch_assoc()) {
                    echo "<td>" . $r2['f_name'] . "</td>";
                    echo "<td>" . $r2['type_name'] . "</td>";


                    $status = $r2['status'];
$statusColor = ($status == 'ประเมินไม่ผ่าน') ? 'red' : (($status == 'ประเมินผ่าน') ? 'green' : 'blue');
$textColor = "color: $statusColor; font-weight: bold;";


echo "<td style='$textColor'>$status</td>";
                }
            } else {
                echo "<td colspan='3'>ยังไม่ได้ฝึกงาน</td>";
            }
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>ยังไม่มีผู้เข้ารับการฝึกงาน</td></tr>";
    }
    $conn->close();
    ?>
    </tbody>
    </table>
</div>

<!-- css -->
<style>
    /* เลือกสีพื้นหลัง */
    select {
        background-color: #f2f2f2;
        /* ปรับขนาดตัวอักษร */
        font-size: 16px;
        /* เปลี่ยนสีขอบ */
        border: 1px solid #ccc;
        /* ทำให้เลือกได้ง่ายขึ้น */
        padding: 8px;
        /* ปรับรูปแบบ cursor */
        cursor: pointer;
        /* เปลี่ยนรูปร่างของ select */
        border-radius: 5px;
    }

    /* เมื่อ hover */
    select:hover {
        border-color: #666;
    }

    /* เมื่อถูกเลือก */
    select:focus {
        outline: none;
        border-color: #4CAF50;
    }

    /* เวลาที่ dropdown ขึ้นมา */
    select option {
        /* สีพื้นหลัง */
        background-color: #f2f2f2;
        /* สีข้อความ */
        color: #333;
        /* ปรับขนาดตัวอักษร */
        font-size: 16px;
    }

    /* ปุ่มกรอง */
    button[type="submit"] {
        /* เลือกสีพื้นหลัง */
        background-color: yellow;
        /* เปลี่ยนสีข้อความ */
        color: black;
        /* ปรับขนาดตัวอักษร */
        font-size: 14px;
        /* ปรับขนาดของปุ่ม */
        padding: 10px 20px;
        /* เปลี่ยนรูปแบบ cursor */
        cursor: pointer;
        /* เปลี่ยนรูปร่างของปุ่ม */
        border-radius: 5px;
        /* ลบการสร้างขอบ */
        border: none;
    }

    /* เมื่อ hover */
    button[type="submit"]:hover {
        /* ปรับสีพื้นหลังเมื่อ hover */
        background-color: #45a049;
    }
</style>