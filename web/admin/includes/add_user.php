<?php
  if(isset($_POST['create_user'])) {
    $username  = escape($_POST['username']);
    $firstname = escape($_POST['firstname']);
    $lastname  = escape($_POST['lastname']);
    $email     = escape($_POST['email']);
    $image     = (!empty($_POST['image'])) ? escape($_POST['image']) : "https://www.gravatar.com/avatar/" . hash('md4', strtolower($email)) . "?s=350&d=identicon&r=PG";
    $role      = escape($_POST['role']);
    $password  = escape($_POST['password']);

    $hashed_password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));    

    $query = "INSERT INTO users(username, firstname, lastname, email, image, role, password) ";
    $query .= "VALUES('{$username}', '{$firstname}', '{$lastname}', '{$email}', '{$image}', '{$role}', '{$hashed_password}')"; 
    $create_user_query = mysqli_query($connection, $query);  
    confirm_query($create_user_query); 
    header("Location: users.php");
   }  
?>

<form method="post" enctype="multipart/form-data">    
  <h1 class='page-header edit-user-header'>Add User
    <span class="form-group pull-right edit-user-header-dropdown">
      <label for="role" class="edit-user-header-label">Role:</label>
      <select name="role" class="form-control">
        <option selected value="subscriber">subscriber</option>
        <option value="admin">admin</option>
      </select>
    </span>
  </h1>

  <div class="form-group">
    <label for="username">Username:</label>
    <input type="text" class="form-control" name="username" required>
  </div>

  <div class="form-group">
    <label for="firstname">First Name:</label>
    <input type="text" class="form-control" name="firstname" required>
  </div>

  <div class="form-group">
    <label for="lastname">Last Name:</label>
    <input type="text" class="form-control" name="lastname" required>
  </div>
      
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" name="email" required>
  </div>

  <div class="form-group">
    <label for="image">Image Link:</label><br>    
    <input type="text" class="form-control" name="image">
  </div>
      
  <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" class="form-control" name="password" required>
  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_user" value="Update">
    <a class='btn btn-default' href='users.php'>Cancel</a>
  </div>
</form>
    