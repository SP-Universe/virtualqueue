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

    if(isset($_GET['view'])){
        header("Location: index.php?view=" . $_GET['view']);
    } else {
        header("Location: index.php?view=groups");
    }

    close_connection();
?>
