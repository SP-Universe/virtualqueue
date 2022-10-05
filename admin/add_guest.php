<?php 
    ob_start();
    require '../main.php';
    connectmysql();

    if(checklogin()){
        if (isset($_POST['new_guests'])) {
            header("Location: index.php?view=groups");
            add_new_guest($_POST['new_guests']);
        }
    } else {
        echo'FORBIDDEN!';
    }
    close_connection();
    exit;
?>
