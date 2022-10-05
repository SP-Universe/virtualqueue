<?php 
    ob_start();
    require 'main.php';
    connectmysql();
    $guestid = checkforcookie();
    if($guestid === null)
    {
        if (isset($_GET['new_guests'])) {
            header("Location: index.php?hint=new_user&guestid=" . $guestid);
            if($_GET['new_guests'] < get_data_from_setting("max_vq")){
                $guestid = add_new_guest($_GET['new_guests']);
                setusercookie($guestid);
            } else {
                header("Location: index.php?error=Too many people in your group!");
                close_connection();
                exit;
            }
        }
    }
    else if(checkforexistingid($guestid))
    {
        header("Location: index.php?hint=existing_user");
    } else {
        header("Location: index.php?error=Unbekannter Gast! " . $guestid);
    }
    close_connection();
    exit;
?>
