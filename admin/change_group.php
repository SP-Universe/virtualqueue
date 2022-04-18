<?php
    ob_start();
    require '../main.php';

    connectmysql();

    header("Location: ../admin.php");

    if(checklogin()){
        if(isset($_POST['group'])){

            $setgroup = $_POST['group'];
            set_data_for_settings("current_group", $setgroup);
        }
    } else {
        echo'FORBIDDEN!';
    }

    close_connection();
?>
