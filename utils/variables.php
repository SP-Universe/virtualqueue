<?php
    $conn = new mysqli();
    $servername = "localhost";
    $username = "silverstripe";
    $password = "password";
    $dbname = "virtualqueue";
    $table_guests = "guests";
    $table_settings = "settings";
    $table_groups = "groups";
    $max_users_per_group = 10;
    $minutes_per_group = 10;
    $current_group = 1;
    $duration_per_group = new DateInterval('PT' . $minutes_per_group . 'M');
    $starttime = "18:00:00";
?>
