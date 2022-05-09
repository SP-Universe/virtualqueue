<?php
    ob_start();
    require '../main.php';

    connectmysql();

    if(checklogin()){
        if(isset($_POST['group'])){
            $setgroup = $_POST['group'];
            set_data_for_settings("current_group", $setgroup);
        } else if(isset($_GET['group'])){
            $setgroup = $_GET['group'];
            set_data_for_settings("current_group", $setgroup);
        }
        
        if(isset($_POST['max_vq'])){
            $max_vq_users_per_group = $_POST['max_vq'];
            set_data_for_settings("max_vq", $max_vq_users_per_group);
        }
        if(isset($_POST['min_sq'])){
            $min_sq_users_per_group = $_POST['min_sq'];
            set_data_for_settings("min_sq", $min_sq_users_per_group);
        }

        recalculateGroups();

        header("Location: index.php?view=groups");
    } else {
        echo'FORBIDDEN!';
    }

    close_connection();
?>
