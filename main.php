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
      $characters = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, strlen($characters) - 1)];
      }
      return $randomString;
  }

  function add_new_guest($number_of_new_guests){
    global $conn;

    $id = "null";

    while(checkforexistingid($id))
    {
      $id = generate_random_string();
    }

    add_guest_to_database($id, $number_of_new_guests);

    return $id;
  }

  function set_planned_time($id)
  {
    $joinedtime = get_data_from_guest($id, "booktime");
    $dateTime = new DateTime('2011-11-17 05:05');
    $dateTime = $joinedtime;
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

  function checklogin(){
    global $loggedinkey;
    $cookie_loggedin = "vq_loggedin";

    return true;

    if (isset($_COOKIE[$cookie_loggedin])) {
      // true, cookie is set
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
    $current_group = get_data_from_setting("current_group");
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
?>

