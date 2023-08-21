<?php ob_start();

  $db['db_host'] = "localhost";
  $db['db_user'] = "root";
  $db['db_pass'] = "";
  $db['db_name'] = "rockAltar";

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
// mysql://be41329e6dea79:3cc4a440@us-cdbr-east-06.cleardb.net/heroku_981847eb2ca20f2?reconnect=true

  $servername = $db['db_host'];
  $database = $db['db_name'];
  $username = $db['db_user'];
  $password = $db['db_pass'];
  $sql = "mysql:host=$servername;dbname=$database;";
  $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

  try {
    $my_Db_Connection = new PDO($sql, $username, $password, $dsn_Options);
    echo "Connected successfully";
   } catch (PDOException $error) {
    echo 'Connection error: ' . $error->getMessage();
   }

  // $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  // $connection = new mysqli($db['db_host'], $db['db_user'], $db['db_pass'], $db['db_name']);

  $query = "SET NAMES utf8";
  $my_Db_Connection->prepare($query);
  $my_Db_Connection->execute();
  // mysqli_query($my_Db_Connection, $query);
?>