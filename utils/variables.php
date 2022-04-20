<?php
    //DATABASE
    $conn = new mysqli();
    $servername = "localhost";
    $username = "silverstripe";
    $password = "password";
    $dbname = "virtualqueue";

    //TABLE NAMES
    $table_guests = "guests";
    $table_settings = "settings";
    $table_groups = "groups";
    $table_feedback = "feedback";

    //VALUES
    $max_vq_users_per_group = 10;
    $max_guests_per_show = 15;
    $minutes_per_group = 10;
    $current_group = 1;
    $admin_password = "hw40a2022";
    $current_status = "closedbefore";
    $duration_per_group = new DateInterval('PT' . $minutes_per_group . 'M');
    $starttime = "18:00:00";

    $standarddomain = "sp-universe.com/hw40a/virtualqueue/"
?>
