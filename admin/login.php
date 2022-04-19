<?php
    ob_start();
    require '../main.php';

    if(!checklogin()){
        if(isset($_POST['password'])){
            if($_POST['password'] == "hw40a2022"){
                header("Location: ../admin.php?info=Login Successful!");
                setcookie("vq_loggedin", $loggedinkey, time() + (86400), "/");
            } else {
                header("Location: ../admin.php?info=Login Failed!");
            }
        }
    } else {
        echo'FORBIDDEN!';
    }
?>
