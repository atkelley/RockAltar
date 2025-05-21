<?php 
  ob_start();

  $db['db_host'] = getenv("DB_HOST") ?: "d6rii63wp64rsfb5.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
  $db['db_user'] = getenv("DB_USER") ?: "iq3wbqe8g8kutk17";
  $db['db_pass'] = getenv("DB_PASSWORD") ?: "p76k4nv3b8razqhd";
  $db['db_name'] = getenv("DB_NAME") ?: "yo5zkyojiqd0cu4m";

  if (getenv("JAWSDB_URL")) {
    $url = parse_url(getenv("JAWSDB_URL"));

    if ($url) {
      $db['db_host'] = $url["host"];
      $db['db_user'] = $url["user"];
      $db['db_pass'] = $url["pass"];
      $db['db_name'] = substr($url["path"], 1);
    } else {
      die("Unable to parse JAWSDB_URL.");
    }
  }

  foreach($db as $key => $value){
    define(strtoupper($key), $value);
  }

  $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $query = "SET NAMES utf8";
  mysqli_query($connection, $query);
?>
