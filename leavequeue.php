<?php
ob_start();
require 'main.php';
connectmysql();
$guestid = checkforcookie();
if($guestid != null)
{
    header("Location: index.php?hint=logout");
    $groupid = get_data_from_guest($guestid, "groupid");
    $groupsize = get_data_from_group($groupid, "vq_guests");
    set_data_for_group($groupid, "vq_guests", $groupsize - get_data_from_guest($guestid, "guestcount"));
    if($currentGroup < $groupid) 
    {
        remove_guest($guestid);
    }
    if(get_data_from_group($groupid, "vq_guests") <= 0){
        //remove_group($groupid);
    }
    close_connection();
    exit;
}
else 
{
    header("Location: index.php?hint=error");
}
?>
