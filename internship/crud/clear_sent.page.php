<?php
$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_GET['id'])) {
    $wid = $_GET['id'];
    $u_id = $_SESSION['internship_user_id'];

    // Check if w_id belongs to the user
    $sql_check = "SELECT * FROM s_selected WHERE w_id = '$wid' AND u_id = '$u_id'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        $sql_delete = "DELETE FROM s_selected WHERE w_id = '$wid'";
        if (mysqli_query($conn, $sql_delete)) {
            // Get the selected_id
            $selected_id = mysqli_fetch_assoc($result_check)['selected_id'];
            
            // Delete from the 'respond' table
            $sql_delete_respond = "DELETE FROM respond WHERE selected_id = '$selected_id'";
            if (mysqli_query($conn, $sql_delete_respond)) {
                echo "<script>";
                echo "alert('ลบข้อมูลสำเร็จ');";
                echo "window.location='?page=s_sent'";
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
        echo "window.location='?page=s_sent'";
        echo "</script>";
    }
}
?>
