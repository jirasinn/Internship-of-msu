<?php
class ConnectDb

{ 
    public $host = "127.0.0.1";
    public $user = "root";
    public $pwd = "";
    public $db = "internship";
    public $conn;
    public $rs;

    public function __construct() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pwd, $this->db);
        if (!$this->conn) {
            die("เชื่อมต่อฐานข้อมูลไม่ได้: " . mysqli_connect_error());
        }
    }
    public function getConn() {
        return $this->conn;
    }

    public function checkIfRespondExists($conn, $selected_id)
{
    // สร้างคำสั่ง SQL สำหรับการเลือกข้อมูล
    $sql = "SELECT * FROM respond WHERE selected_id = '$selected_id'";

    $rs = $conn->query($sql);
    return ($rs && $rs->num_rows > 0);
}
    
// telegram

    }
?>

