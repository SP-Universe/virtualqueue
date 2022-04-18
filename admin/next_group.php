<?php
    ob_start();
    header("Location: ../admin.php");
    require '../main.php';
    connectmysql();

    set_data_for_settings("current_group", $current_group + 1);

    close_connection();

?>
