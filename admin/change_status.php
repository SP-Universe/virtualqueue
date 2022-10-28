<?php
    ob_start();
    require '../main.php';

    if(isset($_GET['view'])){
        header("Location: index.php?view=" . $_GET['view']);
    } else {
        header("Location: index.php?view=groups");
    }
    
    connectmysql();

    if(checklogin()){
        if(isset($_POST['status'])){

            $status = $_POST['status'];
            set_data_for_settings("current_status", $status);
        }
        if(isset($_POST['custom_message'])){
            $custom_message = $_POST['custom_message'];
            set_data_for_settings("custom_message", $custom_message);
        }
    } else {
        echo'FORBIDDEN!';
    }

    close_connection();
?>
