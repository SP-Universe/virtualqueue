<?php
    require '../main.php';

    connectmysql();

    header("Location: ../admin.php");

    set_data_for_settings("current_group", $current_group + 1);

    close_connection();

?>
