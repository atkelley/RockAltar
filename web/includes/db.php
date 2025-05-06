<?php ob_start();

  // $db['db_host'] = "localhost";
  // $db['db_user'] = "root";
  // $db['db_pass'] = "";
  // $db['db_name'] = "rockAltar";



  $host = getenv('MYSQL_HOST');
  $user = getenv('MYSQL_USER');
  $password = getenv('MYSQL_PASSWORD');
  $dbname = getenv('MYSQL_DATABASE');
  
  $connection = mysqli_connect($host, $user, $password, $dbname);
  
  if (!$connection) {
      die("Database connection failed: " . mysqli_connect_error());
  }
  // if (getenv("MYSQL_HOST")) {
  //   $url = parse_url(getenv("JAWSDB_URL"));

  //   if ($url) {
  //     $db['db_host'] = getenv('MYSQL_HOST');
  //     $db['db_user'] = getenv('MYSQL_USER');
  //     $db['db_pass'] = getenv('MYSQL_PASSWORD');
  //     $db['db_name'] = getenv('MYSQL_DATABASE');

  //     else {
  //     die("Unable to connect to site.");
  //   }
  //   } else {
  //     die("Unable to connect to site.");
  //   }
  // }

  // foreach($db as $key => $value){
  //   define(strtoupper($key), $value);
  // }

  // $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // $query = "SET NAMES utf8";
  // mysqli_query($connection, $query);
?>