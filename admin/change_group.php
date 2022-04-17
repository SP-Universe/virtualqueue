<?php
    require '../main.php';

    connectmysql();

    header("Location: ../admin.php");

    if(checklogin()){
        if(isset($_POST['group'])){
            set_data_for_settings("current_group", $_POST['group']);
        }
    } else {
        echo'FORBIDDEN!';
    }

    close_connection();
?>
