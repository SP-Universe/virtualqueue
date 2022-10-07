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
        global $table_feedback;

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
        $sql = "CREATE TABLE IF NOT EXISTS " . $table_guests . " (id INT(6) AUTO_INCREMENT PRIMARY KEY, guestid VARCHAR(20) NOT NULL, booktime TIME, groupid INT, guestcount INT, checkedin VARCHAR(10), initgroupsbefore INT)";
        if ($conn->query($sql) === FALSE) {
            echo "Error creating guesttable: " . $conn->error;
        }

        $sql = "CREATE TABLE IF NOT EXISTS " . $table_settings . " (id INT(6) AUTO_INCREMENT PRIMARY KEY, identifier VARCHAR(50) NOT NULL, data VARCHAR(50))";
        if ($conn->query($sql) === FALSE) {
            echo "Error creating settingstable: " . $conn->error;
        }

        $sql = "CREATE TABLE IF NOT EXISTS " . $table_groups . " (id INT(6) AUTO_INCREMENT PRIMARY KEY, groupid INT NOT NULL, time TIME, vq_guests INT, sq_guests INT)";
        if ($conn->query($sql) === FALSE) {
            echo "Error creating groupstable: " . $conn->error;
        }

        $sql = "CREATE TABLE IF NOT EXISTS " . $table_feedback . " (id INT(6) AUTO_INCREMENT PRIMARY KEY, time TIMESTAMP, stars INT, text VARCHAR(255))";
        if ($conn->query($sql) === FALSE) {
            echo "Error creating feedbacktable: " . $conn->error;
        }

        //Create settings entries:
        $sql = "INSERT IGNORE INTO settings (id, identifier, data) VALUES ('1', 'current_group', '0');"; //The current group that should enter the show
        $conn->query($sql);
        $sql = "INSERT IGNORE INTO settings (id, identifier, data) VALUES ('2', 'current_status', 'closedbefore');"; //The current status for the whole queue
        $conn->query($sql);
        $sql = "INSERT IGNORE INTO settings (id, identifier, data) VALUES ('3', 'display_guest_count', '0');"; //How many guests from the standby queue are already counted
        $conn->query($sql);
        $sql = "INSERT IGNORE INTO settings (id, identifier, data) VALUES ('4', 'max_vq', '0');"; //How many people from the virtual group get into a block
        $conn->query($sql);
        $sql = "INSERT IGNORE INTO settings (id, identifier, data) VALUES ('5', 'min_sq', '0');"; //How many people in total can be in a block
        $conn->query($sql);
        $sql = "INSERT IGNORE INTO settings (id, identifier, data) VALUES ('6', 'start_time', '18:00');"; //When the first show should start
        $conn->query($sql);
        $sql = "INSERT IGNORE INTO settings (id, identifier, data) VALUES ('7', 'delay_time', '00:00');"; //How much the queue is behind schedule
        $conn->query($sql);
        $sql = "INSERT IGNORE INTO settings (id, identifier, data) VALUES ('8', 'time_between_groups', '10:00');"; //How much time is planned between the groups
        $conn->query($sql);
    }

    function add_feedback($stars, $text){
        global $conn;
        global $table_feedback;

        $sql = "INSERT INTO " . $table_feedback . "(time, stars, text) VALUES (CURRENT_TIME(), " . $stars . ",  '" . $text . "')";

        if ($conn->query($sql) === FALSE) {
            echo "Error creating feedback: " . $conn->error;
        }
    }

    function add_guest_to_database($guestid, $number_of_new_guests){
        global $conn;
        global $table_guests;
        global $current_group;

        $guestgroup = get_next_group($number_of_new_guests);
        $groupsbefore = $guestgroup - $current_group;
        $sql = "INSERT INTO " . $table_guests . "(guestid, booktime, groupid, guestcount, initgroupsbefore) VALUES ('" . $guestid . "', CURRENT_TIME(), " . $guestgroup . ", " . $number_of_new_guests . ", " . $groupsbefore . ")";

        if ($conn->query($sql) === FALSE) {
            echo "Error creating user: " . $conn->error;
        }
    }

    function add_group_to_database($groupid, $vq_guests){
        global $conn;
        global $table_groups;

        $sql = "INSERT INTO " . $table_groups . "(groupid, time, vq_guests) VALUES ('" . $groupid . "', NOW(), " . $vq_guests . ")";

        if ($conn->query($sql) === FALSE) {
            echo "Error creating group: " . $conn->error;
        }
    }

    function set_data_for_group($groupid, $datakey, $datavalue){
        global $conn;
        global $table_groups;

        $sql = "UPDATE " . $table_groups . " SET " . $datakey . " = '" . $datavalue . "' WHERE groupid = '" . $groupid . "'";
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

        $sql = "UPDATE " . $table_guests . " SET " . $datakey . " = '" . $datavalue . "' WHERE guestid = '" . $guestid . "'";
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

        $sql = "UPDATE " . $table_settings . " SET data = '" . $data . "' WHERE identifier = '" . $identifier . "';";
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

        $sql = "SELECT * FROM " . $table_groups . " ORDER BY groupid ASC";

        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                return $result;
            }
        }
    }

    function get_last_group(){
        global $conn;
        global $table_groups;

        $sql = "SELECT groupid FROM " . $table_groups . " ORDER BY groupid DESC LIMIT 1";

        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                $assoc = $result->fetch_row()[0];
                return $assoc;
            }
        }
    }

    function get_all_guests(){
        global $conn;
        global $table_guests;

        $sql = "SELECT * FROM " . $table_guests;

        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                return $result;
            }
        }
    }

    function get_all_ids_from_group($groupid){
        global $conn;
        global $table_guests;

        $sql = "SELECT * FROM " . $table_guests . " WHERE groupid = '" . $groupid . "'";

        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                return $result;
            }
        }
    }

    function get_next_group($number_of_new_guests)
    {
        global $table_guests;
        global $conn;
        global $max_vq_users_per_group;
        global $current_group;

        $max_vq_users_per_group = get_data_from_setting("max_vq");

        $sql = "SELECT * FROM " . $table_guests;

        if($all_guests = mysqli_query($conn, $sql)){

            if(mysqli_num_rows($all_guests) > 0){
                $highest_groupid = get_last_group();
                //$users_in_highest_groupid = 0;

                foreach(get_all_groups() as $group){
                    if($group['groupid'] > $current_group){
                        if(get_data_from_group($group['groupid'], "vq_guests") + $number_of_new_guests <= $max_vq_users_per_group){
                            set_data_for_group($group['groupid'], "vq_guests", get_data_from_group($group['groupid'], "vq_guests") + $number_of_new_guests);
                            return $group['groupid'];
                        }
                    }
                }

                /*foreach ($all_guests as $g){
                    if ($g['groupid'] > $highest_groupid){
                        $highest_groupid = $g['groupid'];
                        //$users_in_highest_groupid = $g['guestcount'];
                    } else if($g['groupid'] === $highest_groupid) {
                        //$users_in_highest_groupid += $g['guestcount'];
                    }
                } */

                /* if($users_in_highest_groupid + $number_of_new_guests <= $max_vq_users_per_group){
                    if($current_group < $highest_groupid){
                        set_data_for_group($highest_groupid, "vq_guests", get_data_from_group($highest_groupid, "vq_guests") + $number_of_new_guests);
                        return $highest_groupid;
                    } else {
                        add_group_to_database($current_group + 1, $number_of_new_guests);
                        return $current_group + 1;
                    }
                } else { */
                    add_group_to_database($highest_groupid + 1, $number_of_new_guests);
                    return $highest_groupid + 1;
                //}
            } else {
                add_group_to_database($current_group + 1, $number_of_new_guests);
                return $current_group + 1;
            }
        }
    }

    function remove_group($groupid){
        global $table_groups;
        global $conn;
        $sql = "DELETE FROM " . $table_groups . " WHERE groupid=" . $groupid . ";";
        mysqli_query($conn, $sql);
    }

    function close_connection()
    {
        global $conn;
        $conn->close();
    }

    function recalculateGroups(){
        /* global $max_vq_users_per_group;
        global $min_sq_users_per_group;
        global $max_people_per_group;
        $allguests = get_all_guests();
        $allgroups = get_all_groups();

        $max_people_per_group = $max_vq_users_per_group + $min_sq_users_per_group;
        $currentTime = time();

        foreach ($allgroups as $group){
            if ($group['time'] > $currentTime) {
                remove_group($group['groupid']);
            }
        }

        foreach ($allguests as $guest){
            foreach ($allgroups as $group){
                if ($group['time'] > $currentTime) {
                    if($group['vq_count'] <= $max_vq_users_per_group - $guest['guestcount'])
                    {
                        set_data_for_group($group['groupid'], "vq_guests", $group['vq_count'] + $guest['guestcount']);
                        set_data_for_guest($guest['guestid'], "groupid", $guest['guestcount']);
                        //TODO!!!!
                    }
                } else {

                }
            }
        } */
    }
?>
