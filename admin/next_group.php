<?php
    ob_start();

    if(isset($_GET['view'])){
        header("Location: index.php?view=" . $_GET['view']);
    } else {
        header("Location: index.php?view=display");
    }
    require '../main.php';
    connectmysql();    

    $now = date('H:i:s', time());

    set_data_for_group($current_group, "sq_guests", get_data_from_setting("display_guest_count"));
    set_data_for_group($current_group, "time", $now);
    set_data_for_settings("display_guest_count", 0);
    set_data_for_settings("current_group", $current_group + 1);

    $current_group = get_data_from_setting("current_group");

    foreach(get_all_groups() as $group){
        if($group['groupid'] > $current_group){
            recalculateTimes($group['groupid']);
        }
    }
    
    close_connection();

?>
