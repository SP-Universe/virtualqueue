<?php
  require 'utils/mysql.php';
  require 'utils/variables.php';
  
  $cookie_name = "vq_guestid";
  $loggedinkey = "kkfftggge83";

  connectmysql();
  load_settings();

  function get_test() {
    echo "Test!";
  }

  function checkforexistingid($id)
  {
    global $conn;
    global $table_guests;
    if($id == "null")
    {
      return true;
    }
    $sql = "SELECT id FROM $table_guests WHERE guestid = '$id'";
    $result = $conn->query($sql);
    if($result-> num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }

  function generate_random_string($length = 4) {
      $characters = '12345679ABCDEFGJKLMNPQRSTUVWXYZ';
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, strlen($characters) - 1)];
      }
      return $randomString;
  }

  function checkforforbiddenword($id){
    $forbiddenWords = array("ACAB", "NUDE", "GEEZ", "WIXX", "JAVA");
    foreach ($forbiddenWords as $word){
      if($id === $word){
        return true;
      }
    }
    return false;
  }

  function add_new_guest($number_of_new_guests){
    global $conn;

    $id = "null";

    while(checkforexistingid($id) || checkforforbiddenword($id))
    {
      $id = generate_random_string();
    }

    add_guest_to_database($id, $number_of_new_guests);
    recalculateTimes($id);

    return $id;
  }

  function group_next(){
    global $current_group;
    if($current_group <= mysqli_num_rows(get_all_groups())){
      $current_group += 1;
      set_data_for_settings("current_group", $current_group);
    }
  }

  function group_before(){
    global $current_group;
    if($current_group > 0){
      $current_group -= 1;
      set_data_for_settings("current_group", $current_group);
    }
  }

  function checkforcookie(){
    global $cookie_name;
    
    if (isset($_COOKIE[$cookie_name])) {
      // true, cookie is set
      $guestid = $_COOKIE[$cookie_name];
      //echo 'cookie is set';
      if(checkforexistingid($guestid))
      {
        return $guestid;
      }
      else {
        unset($_COOKIE[$cookie_name]);
        setcookie($cookie_name, null, -1, '/'); 
      }
    }
    else {
      return null;
    }
  }

  function remove_guest($id){
    global $cookie_name;
    global $conn;
    global $table_guests;

    setcookie($cookie_name, null, -1, '/'); 
    if(!checkforexistingid($id)){
      $sql = "DELETE FROM " . $table_guests . " WHERE guestid = '" . $id . "'";
      if ($conn->query($sql) === TRUE) {
        echo "User removed successfully";
      } else {
        echo "Error removing user: " . $conn->error;
      }
    }
  }

  function setusercookie($id){
    global $cookie_name;
    setcookie($cookie_name, $id, time() + (86400), "/");
  }

  function var_dump_pretty($any) {
    echo "<pre>\n";
    var_dump($any);
    echo "</pre>\n";  
  }

  /*
  * Checks if a user is logged in
  */
  function checklogin(){
    global $loggedinkey;
    $cookie_loggedin = "vq_loggedin";

    if (isset($_COOKIE[$cookie_loggedin])) {
      $setcookie = $_COOKIE[$cookie_loggedin];
      if($setcookie === $loggedinkey) {
        return true;
      } else {
        unset($_COOKIE[$cookie_loggedin]);
        setcookie($cookie_loggedin, null, -1, '/');
        return false;
      }
    }
    else {
      return false;
    }
  }

  function load_settings()
  {
    global $current_group;
    global $current_status;
    global $max_vq_users_per_group;
    global $min_sq_users_per_group;

    $max_vq_users_per_group = get_data_from_setting("max_vq");
    $min_sq_users_per_group = get_data_from_setting("min_sq");

    $current_group = get_data_from_setting("current_group");
    if($current_group === null){
      set_data_for_settings("current_group", 0);
      $current_group = 0;
    }
    $current_status = get_data_from_setting("current_status");
    if($current_status === null){
      set_data_for_settings("current_status", "closedbefore");
      $current_status = "closedbefore";
    }
  }

  function sum_the_time($time1, $time2) {
    $times = array($time1, $time2);
    $seconds = 0;
    foreach ($times as $time)
    {
      list($hour,$minute,$second) = explode(':', $time);
      $seconds += $hour*3600;
      $seconds += $minute*60;
      $seconds += $second;
    }
    $hours = floor($seconds/3600);
    $seconds -= $hours*3600;
    $minutes  = floor($seconds/60);
    $seconds -= $minutes*60;
    if($seconds < 9)
    {
      $seconds = "0".$seconds;
    }
    if($minutes < 9)
    {
      $minutes = "0".$minutes;
    }
      if($hours < 9)
    {
      $hours = "0".$hours;
    }
    return "{$hours}:{$minutes}:{$seconds}";
  }

  function recalculateTimes($groupid){
    global $current_group;

    if(get_data_from_setting("current_status") === "showclosed" || time() < strtotime(get_data_from_setting("start_time"))){
      $now = strtotime(get_data_from_setting("start_time"));
    } else {
        $now = strtotime("+0 hours", time());
    }

    $time_between_groups = get_data_from_setting("time_between_groups");
    $time_between_groups_in_seconds = strtotime("1970-01-01 $time_between_groups UTC");

    $maritime = get_data_from_setting("time_between_groups");
    $seconds = strtotime("1970-01-01 $maritime UTC");
    $multiply = $seconds * ($groupid - $current_group);  #Here you can multiply with your dynamic value
    $newTime = strtotime("+{$multiply} seconds", $now);

    set_data_for_group($groupid, "time", date('H:i:s', $newTime));

    echo get_data_from_group($groupid, "time") . "<br>";
  }
?>

