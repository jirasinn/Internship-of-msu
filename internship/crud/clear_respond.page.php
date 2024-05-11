<?php
$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_GET['id'])) {
    $se_id = $_GET['id'];

    // Check if selected_id belongs to the user
    $sql_check = "SELECT * FROM s_selected WHERE selected_id = '$se_id'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        $sql_delete = "DELETE FROM s_selected WHERE selected_id = '$se_id'";
        if (mysqli_query($conn, $sql_delete)) {
            // Delete from the 'respond' table
            $sql_delete_respond = "DELETE FROM respond WHERE selected_id = '$se_id'";
            if (mysqli_query($conn, $sql_delete_respond)) {
                echo "<script>";
                echo "alert('ลบข้อมูลสำเร็จ');";
                echo "window.location='?page=p_respond'";
                echo "</script>";
            } else {
                die(mysqli_error($conn));
            }
        } else {
            die(mysqli_error($conn));
        }
    } else {
        echo "<script>";
        echo "alert('ไม่สามารถลบข้อมูลได้');";
        echo "window.location='?page=p_respond'";
        echo "</script>";
    }
}
?>
