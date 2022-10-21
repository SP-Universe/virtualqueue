<?php
    require "main.php";

    $guestid = checkforcookie();
    if($guestid != null){
        $current_group = get_data_from_setting("current_group");

        $arr = array('current_group' => $current_group, 
            'current_status' => $current_status,
            'usergroup' => get_data_from_guest($guestid, "groupid"),
            'estimatedtime' => get_data_from_group(get_data_from_guest($guestid, "groupid"), "time")); 
        echo json_encode($arr)."\n";
    } else {
        $arr = array('current_group' => $current_group, 
            'current_status' => $current_status); 
        echo json_encode($arr)."\n";
    }
    

?>
