<?php
$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_GET['id'])) {
    $ac_id = $_GET['id'];

    // Check if selected_id belongs to the user
    $sql_check = "SELECT * FROM accepted WHERE accepted_id = '$ac_id'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Update the status and end_date
        $sql_update = "UPDATE accepted SET status = 'ประเมินไม่ผ่าน', end_date = NOW() WHERE accepted_id = '$ac_id'";
        if (mysqli_query($conn, $sql_update)) {
            echo "<script>";
            echo "alert('นิสิตคนนี้ไม่ผ่านการฝึกงาน');";
            echo "window.location='?page=p_accepted'";
            echo "</script>";
        } else {
            die(mysqli_error($conn));
        }
    } else {
        echo "<script>";
        echo "alert('ไม่สามารถอัพเดทข้อมูลได้');";
        echo "window.location='?page=p_accepted'";
        echo "</script>";
    }
}
?>
