<?php
    ob_start();

    if(isset($_GET['view'])){
        header("Location: index.php?view=" . $_GET['view']);
    } else {
        header("Location: index.php?view=display");
    }
    require '../main.php';
    connectmysql();

    set_data_for_group($current_group, "sq_guests", get_data_from_setting("display_guest_count"));
    set_data_for_settings("display_guest_count", 0);
    set_data_for_settings("current_group", $current_group + 1);

    close_connection();

?>
