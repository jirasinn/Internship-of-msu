<?php 
       session_unset();
       session_destroy();
       echo '<script>window.location.href="?page=1";</script>';
?>
