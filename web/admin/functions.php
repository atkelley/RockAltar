<?php
  function confirm_query($result) {
    global $connection;

    if(!$result) { 
      die("Query failed: " . mysqli_error($connection)); 
    }
  }

  function check_method($method = null){
    return ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) ? true : false;
  }

  function logged_in(){
    return (isset($_SESSION['role'])) ? true : false;
  }

  function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
  }

  function is_admin($username) {
    global $connection; 
    $query = "SELECT role FROM users WHERE username = '$username'";
    confirm_query(mysqli_query($connection, $query));
    $row = mysqli_fetch_array(mysqli_query($connection, $query));
    return ($row['role'] == 'admin') ? true : false;
  }

  function get_rows_count($table) {
    global $connection;
    confirm_query(mysqli_query($connection, "SELECT * FROM " . $table));
    echo mysqli_num_rows(mysqli_query($connection, "SELECT * FROM " . $table));
  }




  function redirect($location){
    header("Location:" . $location);
    exit;
  }

  function logged_in_redirect($redirect_location = null){
    if(logged_in()){
      redirect($redirect_location);
    }
  }



  function set_message($msg){
    $_SESSION['message'] = (!$msg) ? $msg : "";
  }

  function display_message() {
    if(isset($_SESSION['message'])) {
      echo $_SESSION['message'];
      unset($_SESSION['message']);
    }
  }

  function users_online() {
    if(isset($_GET['onlineusers'])) {
      global $connection;

      if(!$connection) {
        session_start();
        include("../includes/db.php");
        $session = session_id();
        $time = time();
        $time_out_in_seconds = 05;
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);

        if($count == NULL) {
          mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
        } else {
          mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
        }

        $users_online_query =  mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        echo $count_user = mysqli_num_rows($users_online_query);
      }
    }
  }

  users_online();



  function insert_categories(){
    global $connection;

    if(isset($_POST['submit'])){
      $name = $_POST['name'];

      $stmt = mysqli_prepare($connection, "INSERT INTO categories(name) VALUES(?) ");
      mysqli_stmt_bind_param($stmt, 's', $name);
      mysqli_stmt_execute($stmt);

      if(!$stmt) {
        die('Query failed: '. mysqli_error($connection));
      }

      mysqli_stmt_close($stmt);
      header("Location: categories.php");
    }
  }

  function delete_categories(){
    global $connection;

    if(isset($_GET['delete'])){
      $query = "DELETE FROM categories WHERE id = {$_GET['delete']} ";
      $delete_query = mysqli_query($connection, $query);
      header("Location: categories.php");
    }
  }

  function findAllCategories() {
    global $connection;

    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);  

    while($row = mysqli_fetch_assoc($select_categories)) {
      $cat_id = $row['cat_id'];
      $cat_title = $row['cat_title'];
      echo "<tr>";
      echo "<td>{$cat_id}</td>";
      echo "<td>{$cat_title}</td>";
      echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
      echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
      echo "</tr>";
    }
  }

  function UnApprove() {
    global $connection;

    if(isset($_GET['unapprove'])){
      $the_comment_id = $_GET['unapprove'];
      $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id ";
      $unapprove_comment_query = mysqli_query($connection, $query);
      header("Location: comments.php");
    }
  }



  function username_exists($username){
    global $connection;

    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirm_query($result);

    if(mysqli_num_rows($result) > 0) {
      return true;
    } else {
      return false;
    }
  }

  function email_exists($email){
    global $connection;

    $query = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);
    confirm_query($result);

    return (mysqli_num_rows($result) > 0) ? true : false;
  }

  function register_user($firstname, $lastname, $username, $email, $password, $image){
    global $connection;

    $firstname = mysqli_real_escape_string($connection, $firstname);
    $lastname  = mysqli_real_escape_string($connection, $lastname);
    $username  = mysqli_real_escape_string($connection, $username);
    $email     = mysqli_real_escape_string($connection, $email);
    $image     = mysqli_real_escape_string($connection, $image);
    $password  = mysqli_real_escape_string($connection, $password);
    $password  = password_hash( $password, PASSWORD_BCRYPT, array('cost' => 12));
        
    $query = "INSERT INTO users (firstname, lastname, username, email, password, role, image) ";
    $query .= "VALUES('{$firstname}', '{$lastname}', '{$username}','{$email}', '{$password}', 'subscriber', '{$image}')";
    $register_user_query = mysqli_query($connection, $query);
    confirm_query($register_user_query);
  }

  function login_user($username, $password) {
    global $connection;

    $username = trim($username);
    $password = trim($password);
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    
    if (!$select_user_query) {
      die("Query failed: " . mysqli_error($connection));
    }

    while ($row = mysqli_fetch_array($select_user_query)) {
      $db_id        = $row['id'];
      $db_username  = $row['username'];
      $db_password  = $row['password'];
      $db_firstname = $row['firstname'];
      $db_lastname  = $row['lastname'];
      $db_email     = $row['email'];
      $db_role      = $row['role'];

      if (password_verify($password, $db_password)) {
        $_SESSION['id']        = $db_id;
        $_SESSION['username']  = $db_username;
        $_SESSION['firstname'] = $db_firstname;
        $_SESSION['lastname']  = $db_lastname;
        $_SESSION['email']     = $db_email;
        $_SESSION['role']      = $db_role;

        $url = getenv("CLEARDB_DATABASE_URL") ? "/admin" : "/RockAltar/web/admin";
        redirect($url);
      } else {
        return false;
      }
    }

     return true;
  }