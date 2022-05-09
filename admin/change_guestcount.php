<?php
    ob_start();
    require '../main.php';
    
    connectmysql();

    if(checklogin()){
        if(isset($_GET['method'])){
            $current_guest_count = get_data_from_setting("display_guest_count");
            if($_GET['method'] == "increase"){
                //if($current_guest_count < ($min_sq_users_per_group + $max_vq_users_per_group) - get_data_from_group($current_group, "vq_guests")) {
                    set_data_for_settings("display_guest_count", $current_guest_count + 1);
                //}
            } else if($_GET['method'] == "decrease") {
                if($current_guest_count > 0) {
                    set_data_for_settings("display_guest_count", $current_guest_count - 1);
                }
            }
        }
    } else {
        echo'FORBIDDEN!';
    }

    header("Location: index.php?view=display");

    close_connection();
?>
