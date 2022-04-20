<?php
    ob_start();
    require '../main.php';
    
    connectmysql();

    if(checklogin()){
        if(isset($_GET['guestid'])){

            $guestid = $_GET['guestid'];
            if(get_data_from_guest($guestid, "checkedin") === "checkedin"){
                set_data_for_guest($guestid, "checkedin", "checkedout");
            } else {
                set_data_for_guest($guestid, "checkedin", "checkedin");
            }
        }
    } else {
        echo'FORBIDDEN!';
    }

    header("Location: admin.php");

    close_connection();
?>
