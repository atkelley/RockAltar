<?php
  function is_admin($username) {
    $query = "SELECT role FROM users WHERE username = '$username'";
    $is_admin_query = confirm_query($query);
    $row = mysqli_fetch_array($is_admin_query);
    return ($row['role'] == 'admin') ? true : false;
  }


  function users_online() {
    $session = session_id();
    $time = time();
    $timeout_seconds = 5;
    $timeout = $time - $timeout_seconds;

    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $send_query = confirm_query($query);
    $count = mysqli_num_rows($send_query);

    if ($count == NULL) {
      confirm_query("INSERT INTO users_online(session, time) VALUES('$session', '$time')");
    } else {
      confirm_query("UPDATE users_online SET time = '$time' WHERE session = '$session'");
    }

    $users_online_query = confirm_query("SELECT * FROM users_online WHERE time > '$timeout'");
    return mysqli_num_rows($users_online_query);
  }


  function get_user_profile($id) {
    $query = "SELECT * FROM users WHERE id = $id";
    $get_user_profile_query = confirm_query($query);
    
    if (!$get_user_profile_query || mysqli_num_rows($get_user_profile_query) === 0) {
      return null; 
    }

    $row = mysqli_fetch_assoc($get_user_profile_query);

    return [
      'id'        => $row['id'],
      'username'  => $row['username'],
      'firstname' => $row['firstname'],
      'lastname'  => $row['lastname'],
      'password'  => $row['password'],
      'email'     => $row['email'],
      'image'     => $row['image'],
      'role'      => $row['role'],
    ];
  }
  

  function edit_user_profile($form_data, $id) {
    global $connection; 

    $fields = ['firstname', 'lastname', 'username', 'email', 'role']; 
    $selected_fields = [];

    foreach ($fields as $field) {
      if (isset($form_data[$field]) && $form_data[$field] !== '') {
        $value = mysqli_real_escape_string($connection, trim($form_data[$field]));
        $selected_fields[] = "$field = '$value'";
      }
    }

    $image = !empty($form_data['image']) ? escape($form_data['image']) : "https://www.gravatar.com/avatar/" . hash('md4', strtolower($form_data['email'])) . "?s=350&d=identicon&r=PG";
    $selected_fields[] = "image = '$image'";

    if (!empty($form_data['password']) && $form_data['password'] !== "") {
      $password = mysqli_real_escape_string($connection, trim($form_data['password']));
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $selected_fields[] = "password = '$hashed_password'";
    }    

    $query = "UPDATE users SET " . implode(', ', $selected_fields) . " WHERE id = $id";
    $edit_user_query = confirm_query($query);

    if (!$edit_user_query) {
      error_log("Query failed: " . mysqli_error($connection));
      return false;
    }

    return true;
  }


  function add_user_profile($form_data) {
    global $connection;

    $fields = ['username', 'firstname', 'lastname', 'email', 'role', 'password'];
    
    foreach ($fields as $field) {
      $form_data[$field] = escape($form_data[$field]);
    }

    $image = !empty($form_data['image']) ? escape($form_data['image']) : "https://www.gravatar.com/avatar/" . hash('md4', strtolower($form_data['email'])) . "?s=350&d=identicon&r=PG";
    $hashed_password = password_hash($form_data['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, firstname, lastname, email, image, role, password) VALUES (";
    $query .= "'{$form_data['username']}', '{$form_data['firstname']}', '{$form_data['lastname']}', '{$form_data['email']}', '{$image}', '{$form_data['role']}', '{$hashed_password}')"; 
    $add_user_query = confirm_query($query);

    if (!$add_user_query) {
      error_log("Query failed: " . mysqli_error($connection));
      return false;
    }

    return true;
  }
?>