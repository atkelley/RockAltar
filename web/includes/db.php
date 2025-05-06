<?php ob_start();


$servername = getenv('MYSQL_HOST'); 
$username = getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');
$dbname = getenv('MYSQL_DATABASE');

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";

  // $db['db_host'] = "localhost";
  // $db['db_user'] = "root";
  // $db['db_pass'] = "";
  // $db['db_name'] = "rockAltar";

  // if (getenv("MYSQL_HOST")) {
  //   $db['db_host'] = getenv('MYSQL_HOST');
  //   $db['db_user'] = getenv('MYSQL_USER');
  //   $db['db_pass'] = getenv('MYSQL_PASSWORD');
  //   $db['db_name'] = getenv('MYSQL_DATABASE');
  // }

  // foreach($db as $key => $value){
  //   define(strtoupper($key), $value);
  // }

  // $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  $query = "SET NAMES utf8";
  mysqli_query($conn, $query);
?>