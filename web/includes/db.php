<?php ob_start();

  $db['db_host'] = "localhost";
  $db['db_user'] = "root";
  $db['db_pass'] = "";
  $db['db_name'] = "rockAltar";

  if (getenv("MYSQL_HOST")) {
    $db['db_host'] = getenv('MYSQL_HOST');
    $db['db_user'] = getenv('MYSQL_USER');
    $db['db_pass'] = getenv('MYSQL_PASSWORD');
    $db['db_name'] = getenv('MYSQL_DATABASE');
  }

  foreach($db as $key => $value){
    define(strtoupper($key), $value);
  }

  $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  $query = "SET NAMES utf8";
  mysqli_query($connection, $query);
?>