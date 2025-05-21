<?php
  function validate_registration($firstname, $lastname, $username, $email, $password, $confirm_password) {
    $errors = ['firstname'       => '', 'lastname'        => '', 'username'        => '', 'email'           => '', 'password'        => '', 'confirm_password' => ''];

    if($firstname == '') { $errors['firstname'] = 'First name cannot be empty.'; }
    if($lastname == '') { $errors['lastname'] = 'Last name cannot be empty.'; }
    if(strlen($username) < 4) { $errors['username'] = 'Username must be 4 or more characters long.'; }
    if($username == ''){ $errors['username'] = 'Username cannot be empty.'; }
    if(username_exists($username)){ $errors['username'] = 'Username already exists. Please pick another one.'; }
    if($email =='') { $errors['email'] = 'Email cannot be empty.'; }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = 'Email not valid.'; }
    if(email_exists($email)) { $errors['email'] = 'Email already exists. Please login <a href="index.php">here</a>.'; }
    if($password == '') { $errors['password'] = 'Password cannot be empty.'; }
    if(strlen($password) < 4) { $errors['password'] = 'Password must be 4 or more characters long.'; }
    if($confirm_password == '') { $errors['confirm_password'] = 'Confirm password cannot be empty.'; }
    if(strlen($confirm_password) < 4) { $errors['confirm_password'] = 'Confirm password must be 4 or more characters long.'; }
    if($password != $confirm_password) { 
      $errors['password']        = 'Passwords do not match.';
      $errors['confirm_password'] = 'Passwords do not match.';
    }

    foreach ($errors as $key => $value) {     
      if(empty($value)){
        unset($errors[$key]);
      }
    } 

    if(empty($errors)){
      $image = "https://www.gravatar.com/avatar/" . hash('md4', strtolower($email)) . "?s=350&d=identicon&r=PG";
      register_user($firstname, $lastname, $username, $email, $password, $image);
      $data['message'] = $username;
      redirect('login.php');
    } else {
      return $errors;
    }
  }


  function login_user($username, $password) {
    global $connection;

    $username = mysqli_real_escape_string($connection, trim($username));
    $password = mysqli_real_escape_string($connection, trim($password));

    $select_user_query = confirm_query("SELECT * FROM users WHERE username = '{$username}'");
    
    if (!$select_user_query) {
      $_SESSION['error'] = 'User not found.';
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
        unset($_SESSION['error']);
        redirect("/admin/index.php");
      } else {
        $_SESSION['error'] = "Invalid password.";
        return false;
      }
    }
     return true;
  }
?>