<?php
    ob_start();
    require '../main.php';
    
    connectmysql();

    if(checklogin()){
        if(isset($_GET['method'])){
            $current_guest_count = get_data_from_setting("current_guest_count");
            if($_GET['method'] == "increase"){
                if($current_guest_count < $max_guests_per_show) {
                    set_data_for_settings("current_guest_count", $current_guest_count + 1);
                }
            } else if($_GET['method'] == "decrease") {
                if($current_guest_count > 0) {
                    set_data_for_settings("current_guest_count", $current_guest_count - 1);
                }
            }
        }
    } else {
        echo'FORBIDDEN!';
    }

    header("Location: admin.php");

    close_connection();
?>
