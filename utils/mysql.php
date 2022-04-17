<?php
    

    function connectmysql()
    {
        global $conn;
        global $servername;
        global $username;
        global $password;
        global $dbname;
        global $table_guests;
        global $table_settings;
        global $table_groups;

        // Create connection
        $conn = new mysqli($servername, $username, $password);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Create database
        $sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
        if ($conn->query($sql) === FALSE) {
            echo "Error creating database: " . $conn->error;
        }

        // Set database in connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Create tables
        $sql = "CREATE TABLE IF NOT EXISTS " . $table_guests . " (id INT(6) AUTO_INCREMENT PRIMARY KEY, guestid VARCHAR(20) NOT NULL, booktime TIME, groupid INT, guestcount INT)";
        if ($conn->query($sql) === FALSE) {
            echo "Error creating guesttable: " . $conn->error;
        }

        $sql = "CREATE TABLE IF NOT EXISTS " . $table_settings . " (id INT(6) AUTO_INCREMENT PRIMARY KEY, identifier VARCHAR(50) NOT NULL, data VARCHAR(50))";
        if ($conn->query($sql) === FALSE) {
            echo "Error creating settingstable: " . $conn->error;
        }

        $sql = "CREATE TABLE IF NOT EXISTS " . $table_groups . " (id INT(6) AUTO_INCREMENT PRIMARY KEY, groupid VARCHAR(255) NOT NULL, time TIME, guestcount INT)";
        if ($conn->query($sql) === FALSE) {
            echo "Error creating groupstable: " . $conn->error;
        }
    }

    function add_guest_to_database($guestid, $number_of_new_guests){
        global $conn;
        global $table_guests;

        $sql = "INSERT INTO " . $table_guests . "(guestid, booktime, groupid, guestcount) VALUES ('" . $guestid . "', CURRENT_TIME(), " . get_next_group($guestid, $number_of_new_guests) . ", " . $number_of_new_guests . ")";

        if ($conn->query($sql) === FALSE) {
            echo "Error creating user: " . $conn->error;
        }
    }

    function add_group_to_database($groupid, $guestcount){
        global $conn;
        global $table_groups;

        $sql = "INSERT INTO " . $table_groups . "(groupid, time, guestcount) VALUES ('" . $groupid . "', NOW(), " . $guestcount . ")";

        if ($conn->query($sql) === FALSE) {
            echo "Error creating group: " . $conn->error;
        }
    }

    function set_data_for_group($groupid, $datakey, $datavalue){
        global $conn;
        global $table_groups;

        $sql = "UPDATE " . $table_groups . " SET " . $datakey . " = '" . $datavalue . "' WHERE groupid = " . $groupid . "";
        if(mysqli_query($conn, $sql)){
            return true;
        } else {
            echo "Error setting " . $datakey . ": " . $conn->error;
            return false;
        }
    }

    function set_data_for_guest($guestid, $datakey, $datavalue){
        global $conn;
        global $table_guests;

        $sql = "UPDATE " . $table_guests . " SET " . $datakey . " = '" . $datavalue . "' WHERE guestid = " . $guestid . "";
        if(mysqli_query($conn, $sql)){
            return true;
        } else {
            echo "Error setting " . $datakey . ": " . $conn->error;
            return false;
        }
    }

    function set_data_for_settings($identifier, $data){
        global $conn;
        global $table_settings;

        $sql = "UPDATE " . $table_settings . " SET data = '" . $data . "' WHERE identifier = " . $identifier . "";
        if(mysqli_query($conn, $sql)){
            return true;
        } else {
            echo "Error setting " . $identifier . ": " . $conn->error;
            return false;
        }
    }

    function get_data_from_guest($guestid, $datakey){
        global $conn;
        global $table_guests;

        $sql = "SELECT * FROM " . $table_guests . " WHERE guestid = '" . $guestid . "'";
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_array($result);
                return $row[$datakey];
            }
        } else {
            echo "Error getting " . $datakey . ": " . $conn->error;
        }
    }

    function get_data_from_group($groupid, $datakey){
        global $conn;
        global $table_groups;

        $sql = "SELECT * FROM " . $table_groups . " WHERE groupid = '" . $groupid . "'";
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_array($result);
                return $row[$datakey];
            }
        } else {
            echo "Error getting " . $datakey . ": " . $conn->error;
        }
    }

    function get_data_from_setting($identifier){
        global $conn;
        global $table_settings;

        $sql = "SELECT * FROM " . $table_settings . " WHERE identifier = '" . $identifier . "'";
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_array($result);
                return $row['data'];
            }
        } else {
            echo "Error getting " . $identifier . ": " . $conn->error;
        }
    }

    function get_all_groups(){
        global $conn;
        global $table_groups;

        $sql = "SELECT * FROM " . $table_groups;

        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                return $result;
            }
        }
    }

    function get_next_group($guestid, $number_of_new_guests)
    {
        global $table_guests;
        global $conn;
        global $max_users_per_group;
        global $current_group;

        $sql = "SELECT * FROM " . $table_guests;

        if($result = mysqli_query($conn, $sql)){

            if(mysqli_num_rows($result) > 0){
                $highest_groupid = 0;
                $users_in_highest_groupid = 0;

                foreach ($result as $g){
                    if ($g['groupid'] > $highest_groupid){
                        $highest_groupid = $g['groupid'];
                        $users_in_highest_groupid = $g['guestcount'];
                    } else if($g['groupid'] === $highest_groupid) {
                        $users_in_highest_groupid += $g['guestcount'];
                    }
                }

                if($users_in_highest_groupid + $number_of_new_guests <= $max_users_per_group){
                    if($current_group < $highest_groupid){
                        set_data_for_group($highest_groupid, "guestcount", get_data_from_group($highest_groupid, "guestcount") + $number_of_new_guests);
                        return $highest_groupid;
                    } else {
                        add_group_to_database($current_group + 1, $number_of_new_guests);
                        return $current_group + 1;
                    }
                } else {
                    add_group_to_database($highest_groupid + 1, $number_of_new_guests);
                    return $highest_groupid + 1;
                }
            } else {
                add_group_to_database($current_group + 1, $number_of_new_guests);
                return $current_group + 1;
            }
        }
    }

    function close_connection()
    {
        global $conn;
        $conn->close();
    }
?>
