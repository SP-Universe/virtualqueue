<?php
require 'main.php';
connectmysql();
$guestid = checkforcookie();
if($guestid != null)
    {
        header("Location: index.php?hint=logout");
        remove_guest($guestid);
        close_connection();
        exit;
    }
?>
