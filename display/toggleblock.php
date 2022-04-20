<?php 
    ob_start();
    require '../main.php';
    header("Location: admin.php");
    if(checklogin()){
        group_next();
        set_data_for_settings("current_guest_count", 0);
    }
?>
