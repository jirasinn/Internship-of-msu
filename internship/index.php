<?php 
    session_start();
    require_once("libs/connect.class.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Mahasarakham University</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="internship.js"></script>
    <script src="path/to/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="Styles.css">
    <link rel="stylesheet" href="styles.js">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e3s4Wz6iJgD/+ub2oU" crossorigin="anonymous">

</head>
<body>
    <!--  -->

    <?php
        $page = "home";
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }

        if(isset($_SESSION['internship_user_id'])){
           //professor
            if($_SESSION['internship_user_type']=='professor'){
                require_once("themes/professor.bar.php");
                   
                if($page=='faculty' || isset($_GET["faculty"])) require_once("pages/faculty.page.php");
                elseif($page=='job_description' || isset($_GET["job_description"])) require_once("pages/job_description.page.php");
                elseif($page=='insert' || isset($_GET["insert"])) require_once("pages/insert.page.php");
                elseif($page=='p_respond' || isset($_GET["p_respond"])) require_once("pages/p_respond.page.php");
                elseif($page=='p_accepted' || isset($_GET["p_accepted"])) require_once("pages/p_accepted.page.php");
                //  clear
                elseif($page=='clear_respond' || isset($_GET["clear_respond"])) require_once("crud/clear_respond.page.php");
                elseif($page=='clear_jobdescrip' || isset($_GET["clear_jobdescrip"])) require_once("crud/clear_jobdescrip.page.php");
                // update
                elseif($page=='update_accepted' || isset($_GET["update_accepted"])) require_once("crud/update_accepted.page.php");
                elseif($page=='update2_accepted' || isset($_GET["update2_accepted"])) require_once("crud/update2_accepted.page.php");
                // 
                elseif($page=='type_of_work' || isset($_GET["type_of_work"])) require_once("pages/type_of_work.page.php");
                elseif($page=='f_profile' || isset($_GET["f_profile"])) require_once("pages/f_profile.page.php");
                elseif($page=='s_profile' || isset($_GET["s_profile"])) require_once("pages/s_profile.page.php");
                elseif($page=='logout' || isset($_GET["logout"])) require_once("logins/logout.page.php");
                else require_once("pages/default.page.php"); 
            }
            //admin
            elseif($_SESSION['internship_user_type']=='admin'){
                require_once("themes/admin.bar.php");
                if($page=='faculty' || isset($_GET["faculty"])) require_once("pages/faculty.page.php");
                elseif($page=='job_description' || isset($_GET["job_description"])) require_once("pages/job_description.page.php");
                
                elseif($page=='type_of_work' || isset($_GET["type_of_work"])) require_once("pages/type_of_work.page.php");
                elseif($page=='f_profile' || isset($_GET["f_profile"])) require_once("pages/f_profile.page.php");
// Dashboard
                elseif($page=='dashboard' || isset($_GET["dashboard"])) require_once("pages/dashboard.page.php");

                elseif($page=='login' || isset($_GET["login"]))require_once("logins/login.page.php");
                elseif($page=='logout' || isset($_GET["logout"])) require_once("logins/logout.page.php");
                else require_once("pages/default.page.php");            
            }
            //student
            elseif($_SESSION['internship_user_type']=='student'){
                require_once("themes/student.bar.php");
                if($page=='faculty' || isset($_GET["faculty"])) require_once("pages/faculty.page.php");
                elseif($page=='job_description' || isset($_GET["job_description"])) require_once("pages/job_description.page.php");

                elseif($page=='s_sent' || isset($_GET["s_sent"])) require_once("pages/s_sent.page.php");
                elseif($page=='interview_appointment' || isset($_GET["interview_appointment"])) require_once("pages/interview_appointment.page.php");
            // clear
                elseif($page=='clear_sent' || isset($_GET["clear_sent"])) require_once("crud/clear_sent.page.php");
            // 
                elseif($page=='type_of_work' || isset($_GET["type_of_work"])) require_once("pages/type_of_work.page.php");
                elseif($page=='f_profile' || isset($_GET["f_profile"])) require_once("pages/f_profile.page.php");
                elseif($page=='s_profile' || isset($_GET["s_profile"])) require_once("pages/s_profile.page.php");               
                elseif($page=='logout' || isset($_GET["logout"])) require_once("logins/logout.page.php");
                else require_once("pages/default.page.php"); 
            }
            else{

            }
        }
        else{
            require_once("themes/navbar.php");
            if($page=='faculty' || isset($_GET["faculty"])) require_once("pages/faculty.page.php");
            elseif($page=='f_profile' || isset($_GET["f_profile"])) require_once("pages/f_profile.page.php");
            elseif($page=='type_of_work' || isset($_GET["type_of_work"])) require_once("pages/type_of_work.page.php");
            elseif($page=='job_description' || isset($_GET["job_description"])) require_once("pages/job_description.page.php");
            elseif($page=='login' || isset($_GET["login"]))require_once("logins/login.page.php");
            elseif($page=='logout' || isset($_GET["logout"])) require_once("logins/logout.page.php");
            else require_once("pages/default.page.php");            
        }

        

    ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</body>
</html>