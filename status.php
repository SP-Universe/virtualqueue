<?php
    require "main.php";

    $guestid = checkforcookie();

    $arr = array('current_group' => $current_group, 
    'current_status' => $current_status,
    'usergroup' => get_data_from_guest($guestid, "groupid")); 
    echo json_encode($arr)."\n";

?>
