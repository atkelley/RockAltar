<?php ob_start();

  $db['db_host'] = "us-cdbr-east-06.cleardb.net";
  $db['db_user'] = "be41329e6dea79";
  $db['db_pass'] = "3cc4a440";
  $db['db_name'] = "heroku_981847eb2ca20f2";

  if (getenv("CLEARDB_DATABASE_URL")) {
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    if ($url) {
      $db['db_host'] = $url["host"];
      $db['db_user'] = $url["user"];
      $db['db_pass'] = $url["pass"];
      $db['db_name'] = substr($url["path"], 1);
    } else {
      die("Unable to connect to site.");
    }
  }

  foreach($db as $key => $value){
    define(strtoupper($key), $value);
  }

  $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  $query = "SET NAMES utf8";
  mysqli_query($connection, $query);
?>