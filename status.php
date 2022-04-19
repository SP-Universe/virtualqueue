<?php
    require "main.php";

    $arr = array('current_group' => $current_group, 
    'current_status' => $current_status); 
    echo json_encode($arr)."\n";

?>
