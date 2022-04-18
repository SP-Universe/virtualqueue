<?php
    require '../main.php';

    connectmysql();

    header("Location: ../admin.php");

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
