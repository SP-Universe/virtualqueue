<?php
    ob_start();
    require '../main.php';

    header("Location: ../admin.php");
    
    connectmysql();

    

    if(checklogin()){
        if(isset($_POST['status'])){

            $status = $_POST['status'];
            set_data_for_settings("current_status", $status);
        }
    } else {
        echo'FORBIDDEN!';
    }

    close_connection();
?>
