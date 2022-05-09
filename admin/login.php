<?php
    ob_start();
    require '../main.php';

    if(!checklogin()){
        if(isset($_POST['password'])){
            if($_POST['password'] == "hw40a2022"){
                header("Location: index.php?info=Login Successful!");
                setcookie("vq_loggedin", $loggedinkey, time() + (86400), "/");
            } else {
                header("Location: index.php?info=Login Failed!");
            }
        }
    } else {
        echo'FORBIDDEN!';
    }
?>
